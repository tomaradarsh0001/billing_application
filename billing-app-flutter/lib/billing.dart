import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:http/http.dart' as http;
import 'package:google_fonts/google_fonts.dart';
import 'dart:convert';
import 'package:shimmer/shimmer.dart';
import 'package:flutter/services.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'main.dart';
import 'dashboard.dart';

class BillingPage extends StatefulWidget {
  @override
  _BillingPageState createState() => _BillingPageState();

}

class _BillingPageState extends State<BillingPage> {
  bool _isAnimationComplete = false;
  bool _isLoading = true;
  bool _isLoadingConfirm = false;
  int _currentIndex = 0;
  double _scrollOffset = 0;
  List<dynamic> _billings = [];
  List<dynamic> _billingDetails = [];
  List<dynamic> _filteredbillings = [];
  TextEditingController _searchController = TextEditingController();
  ScrollController _scrollController = ScrollController();
  final TextEditingController _readingController = TextEditingController();
  List<dynamic> _filteredBillingDetails = [];
  bool _isSearchActive = false;
  List<dynamic> _filteredOccupants = [];
  Map<int, double> houseChargesMap = {};
  String svgString = '';
  String svgStringIcon = '';
  Color? primaryLight;
  Color? secondaryLight;
  Color? secondaryDark;
  Color? primaryDark;
  Color? svgLogin;
  Color? links;
  Color? textPrimary;
  final String baseUrl = "http://13.39.111.189:100/api/billing/occupants";
  bool? _isDarkMode;
  bool _showGeneratedContent = false;
  double _estCharges = 0.0;
  double? unitCharge;
  Set<int> _openIds = {};
  String? primaryFont;
  String? secondaryFont;
  String? appPurpose;
  String? _readingError;
  List<dynamic> _occupants = [];
  bool _isShimmer = true;

  @override
  void initState() {
    super.initState();

    // Load theme and other preferences
    _loadThemePreference();

    AppColors.loadColorsFromPrefs().then((_) {
      setState(() {
        secondaryLight = AppColors.secondaryLight;
        primaryLight = AppColors.primaryLight;
        primaryDark = AppColors.primaryDark;
        svgLogin = AppColors.svgLogin;
        secondaryDark = AppColors.secondaryDark;
        links = AppColors.links;
        textPrimary = AppColors.textPrimary;
        primaryFont = AppColors.primaryFont;
        secondaryFont = AppColors.secondaryFont;
        appPurpose = AppColors.appPurpose;
      });

      loadSvg();
      loadSvgIcon();
      fetchUnitRate();
      _fetchBillings(); // Fetch the billing data
      fetchBillingDetails();

      _searchController.addListener(_onSearchChanged); // Listener for search changes

      WidgetsBinding.instance.addPostFrameCallback((_) {
        _onSearchChanged(); // Trigger initial filtering
      });
    });
    setState(() {
      _isShimmer = true;
    });

    _fetchBillings().then((_) {
      setState(() {
        _isShimmer = false;
      });
    });


    // Fetch billing map (house_id to total charges)
    fetchLatestOutstandingDuesPerHouse().then((map) {
      setState(() {
        houseChargesMap = map;
      });
    });

    _scrollController.addListener(_scrollListener); // Scroll listener

    Future.delayed(Duration(milliseconds: 200), () {
      setState(() {
        _isAnimationComplete = true; // Animation complete logic
      });
    });
  }


  void _onSearchChanged() {
    final query = _searchController.text.toLowerCase();
    setState(() {
      if (query.isEmpty) {
        _filteredOccupants = List.from(_occupants); // Restore full list when search is empty
      } else {
        // Filter occupants based on first name, last name, or house number match
        _filteredOccupants = _occupants.where((item) =>
        (item['first_name'] != null && item['first_name'].toLowerCase().contains(query)) ||
            (item['last_name'] != null && item['last_name'].toLowerCase().contains(query)) ||
            (item['house'] != null && item['house']['hno'] != null && item['house']['hno'].toLowerCase().contains(query)) // Searching by hno
        ).toList();
      }
    });
  }


  // Method to fetch billing data
  Map<int, String> meterReadings = {};

  Future<void> _fetchBillings() async {
    const String apiUrl = 'http://13.39.111.189:100/api/billing/occupants';
    try {
      final response = await http.get(Uri.parse(apiUrl));
      print('Status Code: ${response.statusCode}');
      print('Response body: ${response.body}');

      if (response.statusCode == 200) {
        final decoded = json.decode(response.body);

        // Extract curr_meter_reading for each occupant
        for (var occupant in decoded) {
          int id = occupant['id'];
          var billing = occupant['latest_billing_detail'];

          if (billing != null && billing['curr_meter_reading'] != null) {
            meterReadings[id] = billing['curr_meter_reading'].toString();
          } else {
            meterReadings[id] = 'N/A'; // Or null, if preferred
          }
        }

        setState(() {
          _occupants = decoded;
          _filteredOccupants = List.from(_occupants);
          _isLoading = false;
        });

        print("Meter Readings Map: $meterReadings");
      } else {
        throw Exception('Failed to load customers');
      }
    } catch (e) {
      print('Error: $e');
      setState(() {
        _isLoading = false;
      });
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Error fetching customers: $e')),
      );
    }
  }


  @override
  void dispose() {
    _searchController.dispose(); // Always dispose controllers
    _scrollController.dispose(); // Dispose of scroll controller if used
    super.dispose();
  }

  Future<Map<int, double>> fetchLatestOutstandingDuesPerHouse() async {
    final url = Uri.parse('http://13.39.111.189:100/api/billing-details');
    final Map<int, List<Map<String, dynamic>>> recordsPerHouse = {};

    try {
      final response = await http.get(url);
      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        if (data['success'] == true) {
          final List<dynamic> billingData = data['data'];

          // Group records by house_id
          for (var record in billingData) {
            int houseId = record['house_id'];
            if (!recordsPerHouse.containsKey(houseId)) {
              recordsPerHouse[houseId] = [];
            }
            recordsPerHouse[houseId]!.add(record);
          }

          // Process each house_id
          Map<int, double> resultMap = {};
          recordsPerHouse.forEach((houseId, records) {
            if (records.length == 1) {
              var rec = records.first;
              int paymentStatus = rec['payment_status'] ?? 0;
              double dues = 0.0;
              double charges = 0.0;

              if (paymentStatus == 0) {
                dues = double.tryParse(rec['outstanding_dues']?.toString() ?? '0') ?? 0.0;
                charges = double.tryParse(rec['current_charges']?.toString() ?? '0') ?? 0.0;
              }

              resultMap[houseId] = dues + charges;
            } else {
              records.sort((a, b) =>
                  DateTime.parse(b['created_at']).compareTo(DateTime.parse(a['created_at'])));
              var latestRecord = records.first;
              int paymentStatus = latestRecord['payment_status'] ?? 0;
              double dues = 0.0;
              double charges = 0.0;

              if (paymentStatus == 0) {
                dues = double.tryParse(latestRecord['outstanding_dues']?.toString() ?? '0') ?? 0.0;
                charges = double.tryParse(latestRecord['current_charges']?.toString() ?? '0') ?? 0.0;
              }

              resultMap[houseId] = dues + charges;
            }
          });

          return resultMap;
        }
      } else {
        print('API error: ${response.statusCode}');
      }
    } catch (e) {
      print('Fetch error: $e');
    }

    return {}; // Return empty map on failure
  }


  Future<void> fetchUnitRate() async {
    final url = Uri.parse('http://13.39.111.189:100/api/per-unit-rate');

    try {
      final response = await http.get(url);

      if (response.statusCode == 200) {
        final List<dynamic> data = jsonDecode(response.body);

        if (data.isNotEmpty) {
          setState(() {
            unitCharge = double.tryParse(data[0]['unit_rate']);
          });
        }
      } else {
        print('Failed to fetch data. Status code: ${response.statusCode}');
      }
    } catch (e) {
      print('Error occurred: $e');
    }
  }
  Future<void> fetchBillingrecords() async {
    final url = Uri.parse('http://13.39.111.189:100/api/billing-details');

    try {
      final response = await http.get(url);

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);

        if (data['success'] == true) {
          final List<dynamic> billingDetails = data['data'];

          for (var detail in billingDetails) {
            print('Billing ID: ${detail['id']}');
            print('House No: ${detail['house']['hno']}');
            print('Occupant Name: ${detail['occupant']['first_name']} ${detail['occupant']['last_name']}');
            print('Current Reading: ${detail['current_reading']}');
            print('Current Charges: ${detail['current_charges']}');
          }
        } else {
          print('API call succeeded, but data is not marked as success.');
        }
      } else {
        print('Failed to load billing records. Status code: ${response.statusCode}');
      }
    } catch (e) {
      print('Error fetching billing records: $e');
    }
  }

  Future<void> fetchBillingDetails() async {
    try {
      final response = await http.get(Uri.parse(baseUrl));
      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        setState(() {
          _billingDetails = data;
          _isLoading = false;
        });
      } else {
        // Handle error
        setState(() {
          _isLoading = false;
        });
      }
    } catch (e) {
      print("Error fetching billing details: $e");
      setState(() {
        _isLoading = false;
      });
    }
  }

  Future<void> loadSvg() async {
    if (secondaryLight != null && primaryLight != null && primaryDark != null) {
      String svg = await rootBundle.loadString('assets/bg_uncut.svg');
      setState(() {
        svgString = svg.replaceAll(
          'PLACEHOLDER_COLOR_1', _isDarkMode == true ? '#666564' : _colorToHex(primaryLight ?? Colors.grey),
        ).replaceAll(
          'PLACEHOLDER_COLOR_2', _isDarkMode == true ? '#000000' : _colorToHex(primaryDark ?? Colors.black),
        );
      });
    }
  }

  Future<void> loadSvgIcon() async {
    if (secondaryLight != null && primaryLight != null && primaryDark != null) {
      String svg = await rootBundle.loadString('assets/billing_icon.svg');
      setState(() {
        svgStringIcon = svg.replaceAll(
          'PLACEHOLDER', _isDarkMode == true ? '#000000' : _colorToHex(primaryDark ?? Colors.black),
        );
      });
    }
  }

  Future<void> _loadThemePreference() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    bool isDark = prefs.getBool('isDarkMode') ?? false;
    setState(() {
      _isDarkMode = isDark;
    });
  }

  String _colorToHex(Color color) {
    return '#${color.value.toRadixString(16).substring(2).toUpperCase()}';
  }

  void _scrollListener() {
    setState(() {
      _scrollOffset = _scrollController.offset;
    });
  }

  Widget buildShimmerCard() {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 15, vertical: 8),
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: Colors.grey.shade300, width: 1.5),
      ),
      child: Shimmer.fromColors(
        baseColor: Colors.grey.shade300,
        highlightColor: Colors.grey.shade100,
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Container(height: 18, width: 250, color: Colors.white), // Title
            const SizedBox(height: 10),
            Container(height: 14, width: 180, color: Colors.white), // Bungalow No.
            const SizedBox(height: 10),
            Container(height: 14, width: 200, color: Colors.white), // Mobile
            const SizedBox(height: 16),
            Row(
              children: [
                Expanded(
                  child: Container(
                    height: 40,
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(10),
                    ),
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: Container(
                    height: 40,
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(10),
                    ),
                  ),
                ),
              ],
            )
          ],
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        color: Colors.white, // Set red background here
        child: CustomScrollView(
          controller: _scrollController,
          slivers: [

            SliverAppBar(
              backgroundColor: _scrollOffset <= 300
                  ? Colors.white
                  : primaryDark,
              expandedHeight: 300,
              automaticallyImplyLeading: false,
              floating: true,
              elevation: 0,
              shadowColor: Colors.transparent,
              pinned: true,
              flexibleSpace: FlexibleSpaceBar(
                background: Stack(
                  children: [
                    AnimatedPositioned(
                      duration: const Duration(milliseconds: 900),
                      curve: Curves.easeInOut,
                      top: _isAnimationComplete ? 0 : -300,
                      left: 0,
                      right: 0,
                      child: SvgPicture.string(
                        svgString,
                        semanticsLabel: 'Animated and Colored SVG',
                        fit: BoxFit.fill,
                        height: 530,
                      ),
                    ),
                    Column(
                      mainAxisAlignment: MainAxisAlignment.end,
                      children: [
                        const SizedBox(height: 100),
                        AnimatedOpacity(
                          opacity: _isAnimationComplete ? 1.0 : 0.0,
                          duration: const Duration(milliseconds: 700),
                          curve: Curves.easeIn,
                          child: CircleAvatar(
                            radius: 60,
                            child: ClipOval(
                              child: SvgPicture.string(
                                svgStringIcon,
                                semanticsLabel: 'Icon SVG',
                                width: 120,
                                height: 120,
                                fit: BoxFit.cover,
                              ),
                            ),
                          ),
                        ),
                        const SizedBox(height: 10),
                        Row(
                          children: [
                            const SizedBox(width: 20),
                            Text(
                              "Total: ${_billingDetails.length}",
                              style: GoogleFonts.getFont(
                                primaryFont ?? 'Signika',
                                color: Colors.grey.shade600,
                                fontSize: 14,
                              ),
                            ),
                            Center(
                              child: Row(
                                mainAxisSize: MainAxisSize.min,
                                children: [
                                  const SizedBox(width: 55),
                                  Text(
                                    appPurpose ?? 'Billing Details',
                                    style: GoogleFonts.getFont(
                                      primaryFont ?? 'Signika',
                                      color: const Color(0xFFAFB0B1),
                                      fontSize: 22,
                                      fontWeight: FontWeight.normal,
                                    ),
                                  ),
                                ],
                              ),
                            ),
                          ],
                        ),
                      ],
                    ),
                  ],
                ),
              ),
              title: Padding(
                padding: const EdgeInsets.all(0),
                child: Column(
                  children: [
                    if (_isSearchActive)
                      Padding(
                        padding: const EdgeInsets.all(0),
                        child: Row(
                          children: [
                            Expanded(
                              child: Padding(
                                padding: const EdgeInsets.all(10),
                                child: Stack(
                                  alignment: Alignment.centerRight,
                                  children: [
                                    TextField(
                                      controller: _searchController,
                                      autofocus: true,
                                      onChanged: (value) => _onSearchChanged(),
                                      decoration: InputDecoration(
                                        hintText: 'Search by name...',
                                        border: InputBorder.none,
                                        filled: true,
                                        fillColor: Colors.white,
                                        contentPadding: const EdgeInsets.symmetric(horizontal: 8),
                                        enabledBorder: OutlineInputBorder(
                                          borderRadius: BorderRadius.circular(25.0),
                                          borderSide: BorderSide.none,
                                        ),
                                        focusedBorder: OutlineInputBorder(
                                          borderRadius: BorderRadius.circular(25.0),
                                          borderSide: BorderSide.none,
                                        ),
                                      ),
                                    ),
                                    // Close Button inside search bar when search is active
                                    Positioned(
                                      right: 0,
                                      child: IconButton(
                                        icon: Icon(
                                          Icons.close,
                                          color: Colors.black,
                                        ),
                                        onPressed: () {
                                          setState(() {
                                            _isSearchActive = false;
                                            _searchController.clear(); // Clear the search text
                                            _onSearchChanged(); // Reset the filter
                                          });
                                        },
                                      ),
                                    ),
                                  ],
                                ),
                              ),
                            ),
                          ],
                        ),
                      ),
                    Row(
                      children: [
                        if (!_isSearchActive)
                          IconButton(
                            icon: SvgPicture.asset(
                              'assets/backarrow.svg',
                              width: 30,
                              height: 30,
                              color: _scrollOffset <= 270
                                  ? Colors.white
                                  : Colors.white,
                            ),
                            onPressed: () {
                              Navigator.pushReplacement(
                                context,
                                MaterialPageRoute(builder: (context) => DashboardPage()),
                              );
                            },
                          ),
                        if (!_isSearchActive)
                          Expanded(
                            child: Text(
                              "$appPurpose" ?? 'Billing Details',
                              style: GoogleFonts.getFont(
                                primaryFont ?? 'Signika',
                                color: _scrollOffset <= 270 ? Colors.white : Colors.white,
                                fontSize: 29,
                                fontWeight: FontWeight.normal,
                              ),
                              textAlign: TextAlign.left,
                            ),
                          ),
                        if (!_isSearchActive)
                          IconButton(
                            icon: SvgPicture.asset(
                              'assets/search.svg',
                              width: 28,
                              height: 28,
                              color: _scrollOffset <= 270
                                  ? Colors.white
                                  : Colors.white,
                            ),
                            onPressed: () {
                              setState(() {
                                _isSearchActive = true;
                              });
                            },
                          ),
                      ],
                    ),
                  ],
                ),
              ),
            ),
            SliverList(
              delegate: SliverChildBuilderDelegate(
                    (context, index) {
                  if (_isShimmer) {
                    return buildShimmerCard();
                  }
                  final occupant = _filteredOccupants[index];
                  final billing = _billingDetails[index];
                  final currReading = double.tryParse(billing['latest_billing_detail']?['curr_meter_reading']?.toString() ?? '0.0') ?? 0.0;

                  // Check billing date and calculate days remaining
                  final lastBillingDateStr = billing['latest_billing_detail']?['created_at'];
                  bool isDisabled = false;
                  int daysRemaining = 0;
                  if (lastBillingDateStr != null) {
                    final lastBillingDate = DateTime.parse(lastBillingDateStr);
                    final daysSinceLastBilling = DateTime.now().difference(lastBillingDate).inDays;
                    isDisabled = daysSinceLastBilling < 30;
                    daysRemaining = 30 - daysSinceLastBilling;
                  }

                  return GestureDetector(
                    onTap: isDisabled
                        ? () {
                      // Use the context from builder parameter, not from a nested widget
                      ScaffoldMessenger.of(context).removeCurrentSnackBar(); // Remove any existing snackbar
                      ScaffoldMessenger.of(context).showSnackBar(
                        SnackBar(
                          content: Text(
                            'Billing for this house was done recently. Next billing available in $daysRemaining days',
                            style: TextStyle(color: Colors.white),
                          ),
                          backgroundColor: Colors.red[700],
                          duration: Duration(seconds: 3),
                          behavior: SnackBarBehavior.floating,
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(10),
                          ),
                          margin: const EdgeInsets.fromLTRB(16, 0, 16, 20), // Left, Top, Right, Bottom
                        ),
                      );
                    }
                        : null,
                    child: AbsorbPointer(
                      absorbing: isDisabled,
                      child: Opacity(
                        opacity: isDisabled ? 0.6 : 1.0,
                        child: Container(
                          margin: EdgeInsets.only(
                            left: 15,
                            right: 15,
                            top: 10,
                            bottom: index == _filteredOccupants.length - 1 ? 60 : 10,
                          ),
                          padding: const EdgeInsets.all(12),
                          decoration: BoxDecoration(
                            color: Colors.white,
                            borderRadius: BorderRadius.circular(12),
                            border: Border.all(color: isDisabled ? Colors.grey : Colors.grey.shade300, width: 1.5),
                            boxShadow: const [
                              BoxShadow(color: Colors.black12, blurRadius: 4, offset: Offset(0, 2))
                            ],
                          ),
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              if (isDisabled) ...[
                                Align(
                                  alignment: Alignment.topRight,
                                  child: Row(
                                    mainAxisSize: MainAxisSize.min,
                                    children: [
                                      Container(
                                        padding: EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                                        decoration: BoxDecoration(
                                          color: Colors.orange.shade100,
                                          borderRadius: BorderRadius.circular(12),
                                        ),
                                        child: Text(
                                          "Billed recently",
                                          style: TextStyle(
                                            fontSize: 10,
                                            color: Colors.orange.shade800,
                                            fontWeight: FontWeight.bold,
                                          ),
                                        ),
                                      ),
                                      SizedBox(width: 6),
                                      Container(
                                        padding: EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                                        decoration: BoxDecoration(
                                          color: Colors.blue.shade100,
                                          borderRadius: BorderRadius.circular(12),
                                        ),
                                        child: Text(
                                          "Next bill in $daysRemaining days",
                                          style: TextStyle(
                                            fontSize: 10,
                                            color: Colors.blue.shade800,
                                            fontWeight: FontWeight.bold,
                                          ),
                                        ),
                                      ),
                                    ],

                                  ),
                                ),
                                SizedBox(height: 4),
                              ],
                              const SizedBox(height: 6),
                              Text(
                                "Occupant Name :- ${occupant['first_name'] ?? 'N/A'} ${occupant['last_name'] ?? ''}",
                                style: GoogleFonts.getFont(
                                  secondaryFont ?? 'Roboto',
                                  fontSize: 15,
                                  fontWeight: FontWeight.bold,
                                  color: isDisabled ? Colors.grey : Colors.black,
                                ),
                              ),
                        Text(
                          "Bungalow No. : #${occupant['house']['hno']  ?? 'N/A'}",
                          style: GoogleFonts.getFont(
                            secondaryFont ?? 'Roboto',
                            fontSize: 14,
                            color: isDisabled ? Colors.grey : Colors.black,
                          ),
                        ),
                        Text(
                          "Mobile :- ${occupant['mobile']  ?? 'N/A'} ",
                          style: GoogleFonts.getFont(
                            secondaryFont ?? 'Roboto',
                            fontSize: 14,
                            color: isDisabled ? Colors.grey : Colors.black,
                          ),
                        ),
                        const SizedBox(height: 2),
                        Padding(
                          padding: const EdgeInsets.all(8.0),
                          child: AnimatedCrossFade(
                            duration: const Duration(milliseconds: 300),
                            crossFadeState: _openIds.contains(occupant['id'])
                                ? CrossFadeState.showSecond
                                : CrossFadeState.showFirst,
                            firstChild: Row(
                              children: [
                                Expanded(
                                  child: ElevatedButton.icon(
                                    onPressed: () async {
                                      setState(() {
                                        _openIds.add(occupant['id']);
                                      });
                                      await fetchBillingDetails(); // Assuming you have a function that fetches the latest data.
                                      setState(() {
                                      });
                                    },
                                    icon: const Icon(Icons.read_more, color: Colors.indigo),
                                    label: Text(
                                      "Take Reading",
                                      style: GoogleFonts.getFont(
                                        secondaryFont ?? 'Roboto',
                                        fontSize: 13,
                                        fontWeight: FontWeight.w500,
                                      ),
                                    ),
                                    style: ElevatedButton.styleFrom(
                                      backgroundColor: Colors.indigo.shade50,
                                      elevation: 0,
                                      padding: const EdgeInsets.symmetric(vertical: 10),
                                      shape: RoundedRectangleBorder(
                                        borderRadius: BorderRadius.circular(10),
                                      ),
                                    ),
                                  ),
                                ),
                                const SizedBox(width: 10),
                                Expanded(
                                  child: ElevatedButton.icon(
                                    onPressed: () {
                                      showDialog(
                                        context: context,
                                        builder: (BuildContext context) {
                                          return AlertDialog(
                                            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                                            title: Row(
                                              children: const [
                                                Icon(Icons.receipt_long, color: Colors.teal),
                                                SizedBox(width: 8),
                                                Text("Billing Details"),
                                              ],
                                            ),
                                            content: Column(
                                              mainAxisSize: MainAxisSize.min,
                                              children: [
                                                ListTile(
                                                  dense: true,
                                                  leading: const Icon(Icons.home, color: Colors.blueGrey),
                                                  title: Text("Occupant Name"),
                                                  subtitle: Text(
                                                    "${occupant['first_name'] ?? 'N/A'} ${occupant['last_name'] ?? 'N/A'}",
                                                  ),
                                                ),
                                                const Divider(),
                                                ListTile(
                                                  dense: true,
                                                  leading: const Icon(Icons.person, color: Colors.deepPurple),
                                                  title: Text("Bunglaw Number"),
                                                  subtitle: Text(
                                                    "${occupant['house']?['hno'] ?? 'N/A'}",
                                                  ),
                                                ),
                                                const Divider(),
                                                ListTile(
                                                  dense: true,
                                                  leading: const Icon(Icons.speed, color: Colors.redAccent),
                                                  title: Text("Mobile"),
                                                  subtitle: Text(
                                                    "${occupant['mobile'] ?? 'N/A'}",
                                                  ),
                                                ),
                                              ],


                                            ),
                                            actions: [
                                              TextButton.icon(
                                                onPressed: () => Navigator.of(context).pop(),
                                                icon: const Icon(Icons.close, size: 12),
                                                label: const Text("Close"),
                                              ),
                                            ],
                                          );
                                        },
                                      );
                                    },
                                    icon: const Icon(Icons.visibility, color: Colors.teal),
                                    label: Text(
                                      "View Details",
                                      style: GoogleFonts.getFont(
                                        secondaryFont ?? 'Roboto',
                                        fontSize: 13,
                                        fontWeight: FontWeight.w500,
                                      ),
                                    ),
                                    style: ElevatedButton.styleFrom(
                                      backgroundColor: Colors.teal.shade50,
                                      elevation: 0,
                                      padding: const EdgeInsets.symmetric(vertical: 10),
                                      shape: RoundedRectangleBorder(
                                        borderRadius: BorderRadius.circular(10),
                                      ),
                                    ),
                                  ),
                                ),
                              ],
                            ),
                            secondChild: Padding(
                              padding: const EdgeInsets.symmetric(vertical: 6, horizontal: 2),
                              child: Row(
                                mainAxisAlignment: MainAxisAlignment.start,
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Column(
                                    children: [
                                      SizedBox(
                                        width: 80,
                                        child: TextField(
                                          controller: _readingController,
                                          onChanged: (value) {
                                            setState(() {
                                              double? reading = double.tryParse(value);

                                              if (reading == null) {
                                                _readingError = 'Enter Reading';
                                                _estCharges = 0;
                                              } else if (reading < 0) {
                                                _readingError = 'Cannot be negative';
                                                _estCharges = 0;
                                              } else if (reading > 99999) {
                                                _readingError = 'Max Limit Reached';
                                                _estCharges = 0;
                                              } else if (reading < currReading) {
                                                _readingError = 'Cannot be less than previous reading ($currReading)';
                                                _estCharges = 0;
                                              } else {
                                                _readingError = null;
                                                _estCharges = reading - currReading;
                                              }
                                            });
                                          },

                                          keyboardType: TextInputType.number,
                                          inputFormatters: [
                                            FilteringTextInputFormatter.digitsOnly,
                                          ],
                                          style: GoogleFonts.getFont(secondaryFont ?? 'Roboto', fontSize: 13),
                                          decoration: InputDecoration(
                                            hintText: "Reading",
                                            hintStyle: const TextStyle(fontSize: 12),
                                            errorText: _readingError,
                                            isDense: true,
                                            filled: true,
                                            fillColor: Colors.grey.shade100,
                                            contentPadding: const EdgeInsets.symmetric(horizontal: 10, vertical: 10),
                                            border: OutlineInputBorder(
                                              borderRadius: BorderRadius.circular(8),
                                              borderSide: BorderSide(color: Colors.grey.shade300),
                                            ),
                                          ),
                                        ),
                                      ),
                                      const SizedBox(height: 4),
                                      const Text(
                                        "New Reading",
                                        style: TextStyle(fontSize: 11, color: Colors.grey),
                                        textAlign: TextAlign.center,
                                      ),
                                    ],
                                  ),

                                  const SizedBox(width: 10),
                                  Column(
                                    children: [
                                      SizedBox(
                                        width: 80,
                                        child: TextField(
                                          enabled: false,
                                          controller: TextEditingController(text: _estCharges.toStringAsFixed(2)),
                                          style: GoogleFonts.getFont(secondaryFont ?? 'Roboto', fontSize: 13),
                                          decoration: InputDecoration(
                                            hintText: "0.00",
                                            hintStyle: const TextStyle(fontSize: 12),
                                            isDense: true,
                                            filled: true,
                                            fillColor: Colors.grey.shade200,
                                            contentPadding: const EdgeInsets.symmetric(horizontal: 10, vertical: 10),
                                            border: OutlineInputBorder(
                                              borderRadius: BorderRadius.circular(8),
                                              borderSide: BorderSide(color: Colors.grey.shade300),
                                            ),
                                          ),
                                        ),
                                      ),
                                      const SizedBox(height: 4),
                                      const Text("New Units", style: TextStyle(fontSize: 11, color: Colors.grey), textAlign: TextAlign.center),
                                    ],
                                  ),

                                  const SizedBox(width: 10),
                                  Column(
                                    children: [
                                      SizedBox(
                                        height: 40, // This aligns the button with the input fields vertically
                                        child: ElevatedButton(
                                          onPressed: () async {
                                            final double? currentReading = double.tryParse(_readingController.text);
                                            if (currentReading != null) {
                                              // double currentCharges = currentReading * unitCharge!;
                                              final newValue = houseChargesMap[occupant['h_id']] ?? 0.0;
                                              final outstandingAdv = newValue + _estCharges;
                                              // final outstandingDues = outstandingAdv - currentCharges;
                                              setState(() {
                                                _isLoadingConfirm = true;  // Set the flag to true when the request starts
                                              });

                                              final response = await http.post(
                                                Uri.parse("http://13.39.111.189:100/api/billing-details"),
                                                headers: {'Content-Type': 'application/json'},
                                                body: jsonEncode({
                                                  "house_id": occupant['h_id'],
                                                  "occupant_id": occupant['id'],
                                                  "curr_meter_reading": currentReading,
                                                  // "current_charges": currentCharges,
                                                }),
                                              );
                                              setState(() {
                                                _isLoadingConfirm = false;  // Reset the flag after the request is done
                                              });

                                              if (response.statusCode == 200 || response.statusCode == 201) {
                                                ScaffoldMessenger.of(context).showSnackBar(
                                                  const SnackBar(
                                                    content: Text("Meter Reading submitted successfully"),
                                                    backgroundColor: Colors.green,
                                                  ),
                                                );
                                                setState(() {
                                                  _openIds.remove(billing['id']);
                                                  _estCharges = 0;
                                                  _readingController.clear();
                                                });
                                              } else {
                                                ScaffoldMessenger.of(context).showSnackBar(
                                                  SnackBar(
                                                    content: Text("Technical Error : Failed to submit readings."),
                                                    backgroundColor: Colors.red,
                                                  ),
                                                );
                                              }
                                            } else {
                                              ScaffoldMessenger.of(context).showSnackBar(
                                                const SnackBar(
                                                  content: Text("Invalid reading value"),
                                                  backgroundColor: Colors.red,
                                                ),
                                              );
                                            }
                                          },
                                          style: ElevatedButton.styleFrom(
                                            backgroundColor: Colors.green.shade600,
                                            padding: const EdgeInsets.all(10),
                                            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                                            minimumSize: const Size(40, 40),
                                          ),
                                          child: _isLoadingConfirm
                                              ? SizedBox(
                                            height: 20, // Set the height of the spinner
                                            width: 20, // Set the width of the spinner
                                            child: CircularProgressIndicator(color: Colors.white),
                                          )  // Smaller spinner
                                              : const Icon(Icons.check, color: Colors.white, size: 20),  // Show check icon when not loading
                                        ),
                                      ),
                                      const SizedBox(height: 4),
                                      const Text("Confirm", style: TextStyle(fontSize: 11, color: Colors.grey), textAlign: TextAlign.center),
                                    ],
                                  ),
                                  const SizedBox(width: 6),
                                  Column(
                                    children: [
                                      SizedBox(
                                        height: 40,
                                        child: ElevatedButton(
                                          onPressed: () {
                                            setState(() {
                                              _openIds.remove(billing['id']);
                                              _estCharges = 0;
                                              _readingController.clear();
                                            });
                                          },
                                          style: ElevatedButton.styleFrom(
                                            backgroundColor: Colors.red.shade600,
                                            padding: const EdgeInsets.all(10),
                                            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                                            minimumSize: const Size(40, 40),
                                          ),
                                          child: const Icon(Icons.close, color: Colors.white, size: 18),
                                        ),
                                      ),
                                      const SizedBox(height: 4),
                                      const Text("Cancel", style: TextStyle(fontSize: 11, color: Colors.grey), textAlign: TextAlign.center),
                                    ],
                                  ),

                                ],
                              ),
                            ),

                          ),
                        ),
                        if (_openIds.contains(billing['id'])) ...[
                          const SizedBox(height: 8),

                          AnimatedSwitcher(
                            duration: const Duration(milliseconds: 300),
                            switchInCurve: Curves.easeIn,
                            switchOutCurve: Curves.easeOut,
                            transitionBuilder: (Widget child, Animation<double> animation) {
                              return FadeTransition(
                                opacity: animation,
                                child: SlideTransition(
                                  position: Tween<Offset>(
                                    begin: const Offset(0.0, 0.2),
                                    end: Offset.zero,
                                  ).animate(animation),
                                  child: child,
                                ),
                              );
                            },
                            child: _estCharges > 0
                                ? Builder(builder: (context) {
                              // Compute newValue from houseChargesMap using billing['h_id']
                              final newValue = houseChargesMap[billing['h_id']] ?? 0.0;
                              final total = newValue + _estCharges;
                              final double? currentReading = double.tryParse(_readingController.text);
                              final currReading = double.tryParse(billing['latest_billing_detail']?['curr_meter_reading']?.toString() ?? '0.0') ?? 0.0;
                              final unitTotals = (currentReading ?? 0.0) - currReading;
                              return GestureDetector(
                                onTap: () {
                                  ScaffoldMessenger.of(context).showSnackBar(
                                    SnackBar(
                                      content: Text(
                                        "Billing ID: ${billing['id']}, House ID: ${billing['h_id']}, Total: Rs. ${total.toStringAsFixed(2)}",
                                      ),
                                    ),
                                  );
                                },

                                child: Card(
                                  key: ValueKey("bill_info_${billing['id']}"),
                                  margin: const EdgeInsets.symmetric(horizontal: 0),
                                  shape: RoundedRectangleBorder(
                                    borderRadius: BorderRadius.circular(12),
                                  ),
                                  color: secondaryLight,
                                  elevation: 2,
                                  child: Padding(
                                    padding: const EdgeInsets.all(12.0),
                                    child: Text(
                                      "Last Reading was ${billing['latest_billing_detail']['curr_meter_reading']} & Current Reading is $currentReading, Total New Units $unitTotals",
                                      style: GoogleFonts.getFont(
                                        secondaryFont ?? 'Roboto',
                                        fontSize: 12,
                                        fontWeight: FontWeight.w400,
                                        color: Colors.brown.shade900,
                                      ),
                                      textAlign: TextAlign.center,
                                    ),
                                  ),
                                ),
                              );
                            })
                                : const SizedBox.shrink(),
                          ),
                        ],
                      ],
                    ),
                      ),
                      ),
                      ),
                  );
                },
                childCount: _isShimmer ? 6 : _filteredOccupants.length,
              ),
            ),
          ],
        ),
      ),
    );
  }
}
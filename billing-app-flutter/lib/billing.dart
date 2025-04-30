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
  List<dynamic> _billingDetails = [];
  bool _isLoading = true;
  int _currentIndex = 0;
  double _scrollOffset = 0;
  ScrollController _scrollController = ScrollController();
  TextEditingController _searchController = TextEditingController();
  final TextEditingController _readingController = TextEditingController();

  bool _isSearchActive = false;
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
  // double unitCharge = 10;
  double? unitCharge;
  Set<int> _openIds = {};
  String? primaryFont;
  String? secondaryFont;
  String? appPurpose;

  @override
  void initState() {
    super.initState();
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
    });
    _scrollController.addListener(_scrollListener);
    Future.delayed(Duration(milliseconds: 200), () {
      setState(() {
        _isAnimationComplete = true;
      });
    });
    fetchBillingDetails(); // Fetch billing data when the page loads
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
      String svg = await rootBundle.loadString('assets/billing_upper_shape.svg');
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
              expandedHeight: 280,
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
                        height: 300,
                      ),
                    ),
                    Column(
                      mainAxisAlignment: MainAxisAlignment.end,
                      // Align to the bottom
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
                                      decoration: InputDecoration(
                                        hintText: 'Search by name...',
                                        border: InputBorder.none,
                                        filled: true,
                                        fillColor: Colors.white,
                                        contentPadding: const EdgeInsets
                                            .symmetric(horizontal: 8),
                                        enabledBorder: OutlineInputBorder(
                                          borderRadius: BorderRadius.circular(
                                              25.0),
                                          borderSide: BorderSide.none,
                                        ),
                                        focusedBorder: OutlineInputBorder(
                                          borderRadius: BorderRadius.circular(
                                              25.0),
                                          borderSide: BorderSide.none,
                                        ),
                                      ),
                                    ),
                                    Positioned(
                                      right: 8,
                                      child: IconButton(
                                        icon: const Icon(
                                          Icons.close,
                                          size: 24,
                                          color: Colors.grey,
                                        ),
                                        onPressed: () {
                                          setState(() {
                                            _searchController.clear();
                                            _isSearchActive = false;
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
                                MaterialPageRoute(
                                    builder: (context) => DashboardPage()),
                              );
                            },
                          ),
                        if (!_isSearchActive)
                          Expanded(
                            child: Text(
                              "$appPurpose" ?? 'Billing Details',
                              style: GoogleFonts.getFont(
                                primaryFont ?? 'Signika',
                                color: _scrollOffset <= 270
                                    ? Colors.white
                                    : Colors.white,
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
                    (BuildContext context, int index) {
                  if (_isLoading) {
                    return Padding(
                      padding: EdgeInsets.only(top: 1),
                      child: Shimmer.fromColors(
                        baseColor: Colors.grey.shade300,
                        highlightColor: Colors.grey.shade100,
                        child: Card(
                          elevation: 5,
                          color: Colors.white,
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(12),
                          ),
                          child: Container(
                            height: 80,
                            decoration: BoxDecoration(
                              borderRadius: BorderRadius.circular(8),
                              color: Colors.white,
                            ),
                          ),
                        ),
                      ),
                    );
                  }
                  // State variable


                  final billing = _billingDetails[index];
                  return Container(
                    margin: const EdgeInsets.symmetric(horizontal: 15, vertical: 8),
                    padding: const EdgeInsets.all(12),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(12),
                      border: Border.all(
                        color: Colors.grey.shade300,
                        width: 1.5,
                      ),
                      boxShadow: const [
                        BoxShadow(
                          color: Colors.black12,
                          blurRadius: 4,
                          offset: Offset(0, 2),
                        )
                      ],
                    ),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        // Status and Index Number Row
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            // Index as badge
                            Container(
                              padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                              decoration: BoxDecoration(
                                color: secondaryDark,
                                borderRadius: BorderRadius.circular(20),
                                boxShadow: [
                                  BoxShadow(
                                    color: Colors.grey.withOpacity(0.2),
                                    blurRadius: 3,
                                    offset: const Offset(0, 2),
                                  ),
                                ],
                              ),
                              child: Row(
                                children: [
                                  Icon(
                                    Icons.receipt_long,
                                    size: 16,
                                    color: AppColors.background,
                                  ),
                                  const SizedBox(width: 4),
                                  Text(
                                    (index + 1).toString(),
                                    style: TextStyle(
                                      fontWeight: FontWeight.bold,
                                      color: AppColors.background,
                                      fontSize: 13,
                                    ),
                                  ),
                                ],
                              ),
                            ),
                          ],
                        ),
                        const SizedBox(height: 6),
                        // House and Locality Info
                        Text(
                          "Occupant Name :- ${billing['first_name']} ${billing['last_name']}",
                          style: GoogleFonts.getFont(
                            secondaryFont ?? 'Roboto',
                            fontSize: 15,
                            fontWeight: FontWeight.bold,
                            color: Colors.black,
                          ),
                        ),
                        Text(
                          "Bungalow No. :- #${billing['house']['hno']}",
                          style: GoogleFonts.getFont(
                            secondaryFont ?? 'Roboto',
                            fontSize: 14,
                            color: Colors.black87,
                          ),
                        ),
                        Text(
                          "Mobile :- ${billing['mobile']} ",
                          style: GoogleFonts.getFont(
                            secondaryFont ?? 'Roboto',
                            fontSize: 14,
                            color: Colors.black87,
                          ),
                        ),
                        const SizedBox(height: 2),
                        // Buttons Row
                        Padding(
                          padding: const EdgeInsets.all(8.0),
                          child: AnimatedCrossFade(
                            duration: const Duration(milliseconds: 300),
                            crossFadeState: _openIds.contains(billing['id'])
                                ? CrossFadeState.showSecond
                                : CrossFadeState.showFirst,
                            firstChild: Row(
                              children: [
                                Expanded(
                                  child: ElevatedButton.icon(
                                    onPressed: () {
                                      setState(() {
                                        _openIds.add(billing['id']);
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
                                                  subtitle: Text("${billing['first_name']} ${billing['last_name']}"),
                                                ),
                                                const Divider(),
                                                ListTile(
                                                  dense: true,
                                                  leading: const Icon(Icons.person, color: Colors.deepPurple),
                                                  title: Text("Bunglaw Number"),
                                                  subtitle: Text("${billing['house']['hno']}"),
                                                ),
                                                const Divider(),
                                                ListTile(
                                                  dense: true,
                                                  leading: const Icon(Icons.speed, color: Colors.redAccent),
                                                  title: Text("Mobile"),
                                                  subtitle: Text("${billing['mobile']}"),
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
                                  // 🔢 New Reading Input
                                  Column(
                                    children: [
                                      SizedBox(
                                        width: 80,
                                        child: TextField(
                                          controller: _readingController,
                                          onChanged: (value) {
                                            setState(() {
                                              double? reading = double.tryParse(value);
                                              _estCharges = (reading ?? 0) * unitCharge!;
                                            });
                                          },
                                          keyboardType: TextInputType.number,
                                          style: GoogleFonts.getFont(secondaryFont ?? 'Roboto', fontSize: 13),
                                          decoration: InputDecoration(
                                            hintText: "Reading",
                                            hintStyle: const TextStyle(fontSize: 12),
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
                                      const Text("New Reading", style: TextStyle(fontSize: 11, color: Colors.grey), textAlign: TextAlign.center),
                                    ],
                                  ),

                                  const SizedBox(width: 10),

                                  // 💸 Estimated Charges
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
                                      const Text("Est. Charges", style: TextStyle(fontSize: 11, color: Colors.grey), textAlign: TextAlign.center),
                                    ],
                                  ),

                                  const SizedBox(width: 10),

                                  // ✅ Confirm Button
                                  Column(
                                    children: [
                                      SizedBox(
                                        height: 40, // This aligns the button with the input fields vertically
                                        child: ElevatedButton(
                                          onPressed: () async {
                                            final double? currentReading = double.tryParse(_readingController.text);
                                            if (currentReading != null) {
                                              double currentCharges = currentReading * unitCharge!;

                                              final response = await http.post(
                                                Uri.parse("http://13.39.111.189:100/api/billing-details"),
                                                headers: {'Content-Type': 'application/json'},
                                                body: jsonEncode({
                                                  "house_id": billing['h_id'],
                                                  "occupant_id": billing['id'],
                                                  "current_reading": currentReading,
                                                  "current_charges": currentCharges,
                                                }),
                                              );

                                              if (response.statusCode == 200 || response.statusCode == 201) {
                                                ScaffoldMessenger.of(context).showSnackBar(
                                                  const SnackBar(
                                                    content: Text("Billing details submitted successfully"),
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
                                          child: const Icon(Icons.check, color: Colors.white, size: 20),
                                        ),
                                      ),
                                      const SizedBox(height: 4),
                                      const Text("Confirm", style: TextStyle(fontSize: 11, color: Colors.grey), textAlign: TextAlign.center),
                                    ],
                                  ),


                                  const SizedBox(width: 6),

                                  // ❌ Cancel Button
                                  // ❌ Cancel Button
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
                            // child: _estCharges > 0
                            //     ? Card(
                            //   key: ValueKey("bill_info_${billing['id']}"),
                            //   margin: const EdgeInsets.symmetric(horizontal: 0),
                            //   shape: RoundedRectangleBorder(
                            //     borderRadius: BorderRadius.circular(12),
                            //   ),
                            //   color: secondaryLight,
                            //   elevation: 2,
                            //   child: Padding(
                            //     padding: const EdgeInsets.all(12.0),
                            //     child: Text(
                            //       "Outstanding Dues + Current bill is = Rs.${billing['outstanding_dues']} + ${_estCharges.toStringAsFixed(2)} = Rs.${(double.parse(billing['outstanding_dues'].toString()) + _estCharges).toStringAsFixed(2)}/-",
                            //       style: GoogleFonts.getFont(
                            //         secondaryFont ?? 'Roboto',
                            //         fontSize: 12,
                            //         fontWeight: FontWeight.w400,
                            //         color: Colors.brown.shade900,
                            //       ),
                            //       textAlign: TextAlign.center,
                            //     ),
                            //   ),
                            // )
                            //     : const SizedBox.shrink(),
                          ),
                        ],
                      ],
                    ),
                  );
                },
                childCount: _billingDetails.length,
              ),
            ),
          ],
        ),
      ),
    );
  }
}

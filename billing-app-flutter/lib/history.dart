import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:http/http.dart' as http;
import 'package:google_fonts/google_fonts.dart';
import 'dart:convert';
import 'package:shimmer/shimmer.dart';
import 'package:flutter/services.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:timeago/timeago.dart' as timeago;
import 'main.dart';
import 'dashboard.dart';


class HistoryPage extends StatefulWidget {
  @override
  _HistoryPageState createState() => _HistoryPageState();

}

class _HistoryPageState extends State<HistoryPage> {
  bool _isAnimationComplete = false;
  List<dynamic> billingDetails = [];
  int currentPage = 1;
  bool isLoading = false;
  bool hasMore = true;
  bool _isLoading = true;
  int _currentIndex = 0;
  double _scrollOffset = 0;
  ScrollController _scrollController = ScrollController();
  TextEditingController _searchController = TextEditingController();
  final TextEditingController _readingController = TextEditingController();
  // final String apiUrl = 'http://13.39.111.189:100/api/billing-details';
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
      fetchBillingData(context);
    });
    _scrollController.addListener(_scrollListener);
    Future.delayed(Duration(milliseconds: 200), () {
      setState(() {
        _isAnimationComplete = true;
      });
    });
  }
  Future<void> fetchBillingData(BuildContext context) async {
    final String apiUrl = 'http://13.39.111.189:100/api/billing-details';

    try {
      final response = await http.get(Uri.parse(apiUrl));

      if (response.statusCode == 200) {
        final jsonResponse = json.decode(response.body);

        if (jsonResponse['success'] == true) {
          List<dynamic> data = jsonResponse['data'];

          // Sort the data by created_at in descending order
          data.sort((a, b) {
            DateTime aDate = DateTime.parse(a['created_at']);
            DateTime bDate = DateTime.parse(b['created_at']);
            return bDate.compareTo(aDate);  // descending order
          });

          setState(() {
            billingDetails = data;
            _isLoading = false;
          });
        } else {
          // Handle API error response
          setState(() {
            _isLoading = false;
          });
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text('Failed to load billing data.')),
          );
        }
      } else {
        setState(() {
          _isLoading = false;
        });
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Server Error: ${response.statusCode}')),
        );
      }
    } catch (e) {
      setState(() {
        _isLoading = false;
      });
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Error: ${e.toString()}')),
      );
    }
  }


  Future<void> loadSvg() async {
    if (secondaryLight != null && primaryLight != null && primaryDark != null) {
      String svg = await rootBundle.loadString(
          'assets/bg_uncut.svg');
      setState(() {
        svgString = svg.replaceAll(
          'PLACEHOLDER_COLOR_1', _isDarkMode == true ? '#666564' : _colorToHex(
            primaryLight ?? Colors.grey),
        ).replaceAll(
          'PLACEHOLDER_COLOR_2', _isDarkMode == true ? '#000000' : _colorToHex(
            primaryDark ?? Colors.black),
        );
      });
    }
  }

  Future<void> loadSvgIcon() async {
    if (secondaryLight != null && primaryLight != null && primaryDark != null) {
      String svg = await rootBundle.loadString('assets/billing_icon.svg');
      setState(() {
        svgStringIcon = svg.replaceAll(
          'PLACEHOLDER', _isDarkMode == true ? '#000000' : _colorToHex(
            primaryDark ?? Colors.black),
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
        color: Colors.white, // Background color
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
                        height: 530
                        ,
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
                              "Total: ${billingDetails.length}",
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
                                    'Billing History',
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
                                        hintText: 'Search...',
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
                              color: Colors.white,
                            ),
                            onPressed: () {
                              Navigator.pushReplacement(
                                context,
                                MaterialPageRoute(
                                  builder: (context) => DashboardPage(),
                                ),
                              );
                            },
                          ),
                        if (!_isSearchActive)
                          Expanded(
                            child: Text(
                              appPurpose ?? 'Billing Details',
                              style: GoogleFonts.getFont(
                                primaryFont ?? 'Signika',
                                color: Colors.white,
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
                              color: Colors.white,
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
                  if (_isLoading && billingDetails.isEmpty) {
                    return Padding(
                      padding: const EdgeInsets.only(top: 1),
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

                  final billing = billingDetails[index];

                  return Container(
                    margin: EdgeInsets.only(
                      left: 16,
                      right: 16,
                      top: 10,
                      bottom: index == billingDetails.length - 1 ? 60 : 10,
                    ),
                    // margin: const EdgeInsets.symmetric(horizontal: 16, vertical: 10),
                    padding: const EdgeInsets.all(16),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(16),
                      border: Border.all(
                        color: Colors.grey.shade300,
                        width: 1,
                      ),
                      boxShadow: const [
                        BoxShadow(
                          color: Colors.black12,
                          blurRadius: 6,
                          offset: Offset(0, 3),
                        ),
                      ],
                    ),
                    child: Stack(
                      children: [
                        Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Row(
                              crossAxisAlignment: CrossAxisAlignment.center,
                              children: [
                                Icon(Icons.bungalow, color: Colors.teal, size: 24),
                                const SizedBox(width: 10),
                                Expanded(
                                  child: Text(
                                    'Bungalow No: ${billing['house']['hno'] ?? 'N/A'}',
                                    style: const TextStyle(
                                      fontWeight: FontWeight.bold,
                                      fontSize: 14,
                                      color: Colors.black54,
                                    ),
                                  ),
                                ),
                              ],
                            ),
                            const SizedBox(height: 4),
                            Row(
                              children: [
                                Icon(Icons.supervised_user_circle, color: Colors.indigo, size: 22),
                                const SizedBox(width: 10),
                                Expanded(
                                  child: Text(
                                    'Occupant: ${billing['occupant']['first_name']} ${billing['occupant']['last_name']}',
                                    style: const TextStyle(fontSize: 15, color: Colors.black54),
                                  ),
                                ),
                              ],
                            ),
                            const SizedBox(height: 4),
                            Row(
                              children: [
                                // Conditionally render the icon and color based on the status
                                billing['status'] == 'New'
                                    ? Icon(Icons.new_releases, color: Colors.orange, size: 22)
                                    : Icon(Icons.verified, color: Colors.green, size: 22),
                                const SizedBox(width: 10),
                                Text(
                                  'Status: ${billing['status']}',
                                  style: const TextStyle(fontSize: 14, color: Colors.black54),
                                ),
                              ],
                            ),
                            const SizedBox(height: 4),
                            Row(
                              children: [
                                Icon(Icons.gas_meter, color: Colors.blue, size: 22),
                                const SizedBox(width: 10),
                                Text(
                                  'Current Reading: ${billing['current_reading']} Units',
                                  style: const TextStyle(fontSize: 14, color: Colors.black54),
                                ),
                              ],
                            ),
                            const SizedBox(height: 4),
                            Row(
                              children: [
                                Icon(Icons.currency_rupee, color: Colors.blue, size: 22),
                                const SizedBox(width: 10),
                                Text(
                                  'Current Charges: ₹${billing['current_charges']}',
                                  style: const TextStyle(fontSize: 14, color: Colors.black54),
                                ),
                              ],
                            ),
                          ],
                        ),
                        Positioned(
                          top: 0,
                          right: 0,
                          child: Container(
                            padding: const EdgeInsets.all(5),
                            decoration: BoxDecoration(
                              color: primaryDark,
                              borderRadius: BorderRadius.circular(5),
                            ),
                            child: Text(
                              '${index + 1}',  // Numbering from 1
                              style: const TextStyle(
                                fontSize: 10,
                                color: Colors.white,
                                fontWeight: FontWeight.bold,
                              ),
                            ),
                          ),
                        ),
                        Positioned(
                          top: 110,
                          right: 0,
                          child: Text(
                            timeago.format(DateTime.parse(billing['created_at'])),
                            style: const TextStyle(
                              fontSize: 10,
                              color: Colors.grey,
                              fontStyle: FontStyle.italic,
                            ),
                          ),
                        ),
                      ],
                    ),
                  );
                    },
                childCount: billingDetails.length,
              ),
            ),
          ],
        ),
      ),
    );
  }
}


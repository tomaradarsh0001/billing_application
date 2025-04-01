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
  final String baseUrl = "http://ec2-13-39-111-189.eu-west-3.compute.amazonaws.com:100/api/billing-details";
  bool? _isDarkMode;


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
      });
      loadSvg();
      loadSvgIcon();
    });
    _scrollController.addListener(_scrollListener);
    Future.delayed(Duration(milliseconds: 200), () {
      setState(() {
        _isAnimationComplete = true;
      });
    });
    fetchBillingDetails(); // Fetch billing data when the page loads
  }

  Future<void> fetchBillingDetails() async {
    try {
      final response = await http.get(Uri.parse(baseUrl));
      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        setState(() {
          _billingDetails = data['data'];
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
      backgroundColor: _isDarkMode! ? Colors.grey[700] : Colors.white,
      body: CustomScrollView(
        controller: _scrollController,
        slivers: [
          SliverAppBar(
            backgroundColor: _scrollOffset <= 300 ? Colors.transparent : primaryDark,
            expandedHeight: 350,
            automaticallyImplyLeading: false,
            floating: true,
            pinned: true,
            flexibleSpace: FlexibleSpaceBar(
              background: Stack(
                children: [
                  AnimatedPositioned(
                    duration: const Duration(milliseconds: 900),
                    curve: Curves.easeInOut,
                    top: _isAnimationComplete ? 0 : -400,
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
                    children: [
                      const SizedBox(height: 170),
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
                            style: GoogleFonts.signika(
                              color: Color(0xFFAFB0B1),
                              fontSize: 14,
                            ),
                          ),
                          const SizedBox(width: 65),
                          Text(
                            "Billing Details",
                            style: GoogleFonts.signika(
                              color: Color(0xFFAFB0B1),
                              fontSize: 22,
                              fontWeight: FontWeight.normal,
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
              padding: const EdgeInsets.symmetric(horizontal: 0),
              child: Column(
                children: [
                  // Search bar
                  if (_isSearchActive)
                    Padding(
                      padding: const EdgeInsets.symmetric(horizontal: 0),
                      child: Row(
                        children: [
                          Expanded(
                            child: Padding(
                              padding: const EdgeInsets.symmetric(horizontal: 0),
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
                                      contentPadding:
                                      const EdgeInsets.symmetric(horizontal: 16),
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
                            color: _scrollOffset <= 270 ? Colors.white : Colors.white,
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
                            "Billing",
                            style: GoogleFonts.signika(
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
                            color: _scrollOffset <= 270 ? Colors.white : Colors.white,
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
                  return Shimmer.fromColors(
                    baseColor: Colors.grey.shade300,
                    highlightColor: Colors.grey.shade100,
                    child: Card(
                      margin: const EdgeInsets.fromLTRB(15, 20, 15, 15),
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
                  );
                }

                final billing = _billingDetails[index];
                return Card(
                  margin: const EdgeInsets.fromLTRB(15, 0, 15, 15),
                  elevation: 2,
                  color: Colors.grey.shade800,

                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10),
                  ),
                  child: ListTile(
                    leading: Container(
                      width: 60,
                      height: 60,
                      decoration: BoxDecoration(
                        color: _isDarkMode == true ? Colors.grey.shade700 : (primaryLight ?? Colors.blue), // Dark Mode for leading circle
                        borderRadius: BorderRadius.circular(32),
                      ),
                      child: Center(
                        child: Text(
                          "${billing['occupant']['first_name'][0]}${billing['occupant']['last_name'][0]}",
                          style: GoogleFonts.signika(
                            fontWeight: FontWeight.normal,
                            color: _isDarkMode == true ? Colors.white : Colors.grey.shade800, // Dark Mode text color
                            fontSize: 34,
                          ),
                        ),
                      ),
                    ),
                    title: Text(
                      "Customer Name: ${billing['occupant']['first_name']} ${billing['occupant']['last_name']}",
                      style: TextStyle(
                        fontSize: 13,
                        fontWeight: FontWeight.bold,
                        color: _isDarkMode == true ? Colors.white : Colors.black, // Dark Mode text
                      ),
                    ),
                    subtitle: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          "House No: ${billing['house']['hno']}",
                          style: TextStyle(
                            color: _isDarkMode == true ? Colors.white : Colors.black87, // Dark Mode color for text
                            fontSize: 13,
                          ),
                        ),
                        Text(
                          "Outstanding Dues: ${billing['outstanding_dues']}",
                          style: TextStyle(
                            color: _isDarkMode == true ? Colors.white : Colors.black87, // Dark Mode color for text
                            fontSize: 13,
                          ),
                        ),
                        Text(
                          "Current Charges: ${billing['current_charges']}",
                          style: TextStyle(
                            color: _isDarkMode == true ? Colors.white : Colors.black87, // Dark Mode color for text
                            fontSize: 13,
                          ),
                        ),
                      ],
                    ),

                    trailing: Container(
                      width: 24,
                      height: 24,
                      decoration: BoxDecoration(
                        color: _isDarkMode == true ? Colors.white : (Colors.white ?? Colors.blue), // Dark Mode trailing button
                        borderRadius: BorderRadius.circular(50),
                      ),
                      child: IconButton(
                        icon: Icon(
                          Icons.arrow_forward_ios,
                          color: _isDarkMode == true ? Colors.black : Colors.white, // Dark Mode icon
                          size: 9,
                        ),
                        onPressed: () {
                          Navigator.push(
                            context,
                            MaterialPageRoute(
                              builder: (context) => DashboardPage(
                              ),
                            ),
                          );
                        },
                      ),
                    ),
                  ),
                );

                  },
              childCount: _billingDetails.length,
            ),
          ),
        ],
      ),
    );
  }
}

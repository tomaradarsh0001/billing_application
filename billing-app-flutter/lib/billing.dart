import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:http/http.dart' as http;
import 'package:google_fonts/google_fonts.dart';
import 'dart:convert';
import 'dashboard.dart';
import 'package:shimmer/shimmer.dart';
import 'colors.dart';
import 'package:flutter/services.dart';

class BillingPage extends StatefulWidget {
  @override
  _BillingPageState createState() => _BillingPageState();
}

class _BillingPageState extends State<BillingPage> {
  bool _isAnimationComplete = false;
  List<dynamic> _customers = [];
  List<dynamic> _filteredCustomers = [];
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
  final String baseUrl = "http://16.171.136.239/api/customers/";


  // Add a list to track selected customers
  List<int> _selectedItems = [];

  @override
  void initState() {
    super.initState();
    AppColors.fetchColors().then((_) {
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
  }
  Future<void> loadSvg() async {
    if (secondaryLight != null && primaryLight != null && primaryDark != null) {
      String svg = await rootBundle.loadString('assets/billing_upper_shape.svg');
      setState(() {
        // Replace placeholders with actual colors in hex format
        svgString = svg.replaceAll(
          'PLACEHOLDER_COLOR_1', _colorToHex(primaryLight!),
        ).replaceAll(
          'PLACEHOLDER_COLOR_2', _colorToHex(primaryDark!),
        );
      });
    }
  }

  Future<void> loadSvgIcon() async {
    if (secondaryLight != null && primaryLight != null && primaryDark != null) {
      String svg = await rootBundle.loadString('assets/billing_icon.svg');
      setState(() {
        // Replace placeholders with actual colors in hex format
        svgStringIcon = svg.replaceAll(
          'PLACEHOLDER', _colorToHex(primaryDark!),
        );
      });
    }
  }

  String _colorToHex(Color color) {
    return '#${color.value.toRadixString(16).substring(2).toUpperCase()}';
  }

  void _scrollListener() {
    setState(() {
      _scrollOffset = _scrollController.offset;
    });
  }

  void _onItemTapped(int index) {
    setState(() {
      _currentIndex = index;
    });

    // Navigate to DashboardPage when Home button is tapped (index 0)
    if (index == 0) {
      Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => DashboardPage()),
      );
    }
  }
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: CustomScrollView(
        controller: _scrollController,
        slivers: [
          // SliverAppBar for dynamic header with scroll effect
          SliverAppBar(
            backgroundColor: _scrollOffset <= 300 ? Colors.transparent : primaryDark,
            expandedHeight: 350,
            automaticallyImplyLeading: false, // Hides the back button
            floating: true,
            pinned: true,
            flexibleSpace: FlexibleSpaceBar(
              background: Stack(
                children: [
                  // Top Animated Background Shape
                  AnimatedPositioned(
                    duration: const Duration(milliseconds: 900),
                    curve: Curves.easeInOut,
                    top: _isAnimationComplete ? 0 : -400,
                    left: 0,
                    right: 0,
                    child: SvgPicture.string(
                      svgString,  // Render the modified SVG string with new colors
                      semanticsLabel: 'Animated and Colored SVG',
                      fit: BoxFit.fill,
                      height: 300,
                    ),
                  ),
                  Column(
                    children: [
                      const SizedBox(height: 170),
                      AnimatedOpacity(
                        opacity: _isAnimationComplete ? 1.0 : 0.0, // Control visibility
                        duration: const Duration(milliseconds: 700), // Duration of the fade-in
                        curve: Curves.easeIn, // Smooth fade-in effect
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
                        crossAxisAlignment: CrossAxisAlignment.center,
                        children: [
                          const SizedBox(width: 20),
                          Text(
                            "Total: ${_customers.length}",
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
              padding: const EdgeInsets.symmetric(horizontal: 0), // Adjusted padding
              child: Column(
                children: [
                  // Search bar - shows when _isSearchActive is true
                  _isSearchActive
                      ? Padding(
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
                                    border: InputBorder.none, // Remove the border
                                    filled: true,
                                    fillColor: Colors.white,
                                    contentPadding: EdgeInsets.symmetric(horizontal: 16),
                                    enabledBorder: OutlineInputBorder(
                                      borderRadius: BorderRadius.circular(25.0), // Rounded corners
                                      borderSide: BorderSide.none, // No border
                                    ),
                                    focusedBorder: OutlineInputBorder(
                                      borderRadius: BorderRadius.circular(25.0), // Rounded corners
                                      borderSide: BorderSide.none, // No border
                                    ),
                                  ),
                                ),
                                Positioned(
                                  right: 8, // Position the cross icon inside the text field
                                  child: IconButton(
                                    icon: Icon(
                                      Icons.close, // Use the built-in close icon for cross
                                      size: 24, // Size of the icon
                                      color: Colors.grey, // Color of the cross icon
                                    ),
                                    onPressed: () {
                                      setState(() {
                                        _searchController.clear(); // Clear the search field
                                        _isSearchActive = false; // Hide search bar and show the title
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
                  )
                      : Container(), // Empty container when search is not active
                  Row(
                    children: [
                      // Back Button - hidden when search is active
                      _isSearchActive
                          ? Container()
                          : IconButton(
                        icon: SvgPicture.asset(
                          'assets/backarrow.svg',
                          width: 30,
                          height: 30,
                          color: _scrollOffset <= 270 ? Colors.white : Colors.white,
                        ),
                        onPressed: () {
                          Navigator.pop(context); // Handle back button action
                        },
                      ),
                      // Title Text - hidden when search is active
                      _isSearchActive
                          ? Container()
                          : Expanded(
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
                      // Search Icon - shows when search is not active
                      _isSearchActive
                          ? Container()
                          : IconButton(
                        icon: SvgPicture.asset(
                          'assets/search.svg',
                          width: 28,
                          height: 28,
                          color: _scrollOffset <= 270 ? Colors.white : Colors.white,
                        ),
                        onPressed: () {
                          setState(() {
                            _isSearchActive = true; // Activate search bar
                          });
                        },
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ),

          // SliverList for displaying cards
          SliverList(
            delegate: SliverChildBuilderDelegate(
                  (BuildContext context, int index) {
                if (_isLoading) {
                  // Shimmer effect when data is loading
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

                if (_filteredCustomers.isEmpty) {
                  return Center(
                    child: Text(
                      "No customers found.",
                      style: GoogleFonts.signika(
                        fontSize: 18,
                        color: Color(0xFFAFB0B1),
                      ),
                    ),
                  );
                }
              },
              childCount: _filteredCustomers.length,
            ),
          )

        ],
      ),
      // Floating Action Button for delete

    );
  }
}

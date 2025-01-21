import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:google_fonts/google_fonts.dart';
import 'customerview.dart';
import 'colors.dart';
import 'package:flutter/services.dart';  // To load the SVG as a string
import 'billing.dart';
import 'settings.dart';

class DashboardPage extends StatefulWidget {
  @override
  _DashboardPageState createState() => _DashboardPageState();
}
class _DashboardPageState extends State<DashboardPage> {
  bool _isAnimationComplete = false;
  int _currentIndex = 0;
  String svgString = '';
  Color? primaryLight;
  Color? secondaryLight; // Assuming color2 is also a dynamic color
  Color? primaryDark; // Assuming color3 is also a dynamic color
  double _tileOpacity = 0; // Start opacity is 0.2
  double _avatarOpacity = 0;

  @override
  void initState() {
    super.initState();

    // Fetch colors and load SVG, then update opacity
    AppColors.fetchColors().then((_) {
      setState(() {
        secondaryLight = AppColors.secondaryLight;
        primaryLight = AppColors.primaryLight;
        primaryDark = AppColors.primaryDark;
      });

      // Load SVG after colors are fetched
      return loadSvg();
    }).then((_) {
      // Once SVG is loaded, start animation
      Future.delayed(Duration(milliseconds: 200), () {
        setState(() {
          _tileOpacity = 1.0; // Make tiles visible
          _avatarOpacity = 1.0; // Make avatar visible
          _isAnimationComplete = true; // Mark animation as complete
        });
      });
    });
  }

  void _onItemTapped(int index) {
    setState(() {
      _currentIndex = index;
    });

    // Navigate to DashboardPage when Home button is tapped (index 0)
    if (index == 0) {
      // Navigator.push(
      //   context,
      //   MaterialPageRoute(builder: (context) => DashboardPage()),
      // );
    }
  }
  // Function to load the SVG and replace placeholders
  Future<void> loadSvg() async {
    if (secondaryLight != null && primaryLight != null && primaryDark != null) {
      String svg = await rootBundle.loadString('assets/dashboard_upper_shape.svg');
      setState(() {
        // Replace placeholders with actual colors in hex format
        svgString = svg.replaceAll(
          'PLACEHOLDER_COLOR_1', _colorToHex(secondaryLight!),
        ).replaceAll(
          'PLACEHOLDER_COLOR_2', _colorToHex(primaryLight!),
        ).replaceAll(
          'PLACEHOLDER_COLOR_3', _colorToHex(primaryDark!),
        );
      });
    }
  }
  // Helper function to convert Color to Hex string
  String _colorToHex(Color color) {
    return '#${color.value.toRadixString(16).substring(2).toUpperCase()}';
  }


  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: Stack(
        children: [
          // Top Background Shape
          AnimatedPositioned(
              duration: const Duration(milliseconds: 1500),
              curve: Curves.easeInOut,
              top: _isAnimationComplete ? 0 : -400,
              left: 0,
              right: 0,
              child: SvgPicture.string(
                svgString,  // Render the modified SVG string with new colors
                semanticsLabel: 'Animated and Colored SVG',
                fit: BoxFit.fill,
                height: 300,  // Height of the SVG
              )
          ),

          // Main Content
          Padding(
            padding: const EdgeInsets.only(top: 90),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Welcome Message
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 20.0),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            "Welcome, Adarsh",
                            style: GoogleFonts.signika(
                              fontSize: 18,
                              fontWeight: FontWeight.w500,
                              color: Colors.white,
                            ),
                          ),
                          Text(
                            "Dashboard",
                            style: GoogleFonts.signika(
                              fontSize: 30,
                              fontWeight: FontWeight.bold,
                              color: Colors.white,
                            ),
                          ),
                          Text(
                            "Logged in with: tomaradarsh001@gmail.com",
                            style: GoogleFonts.signika(
                              fontSize: 10,
                              color: Colors.white.withOpacity(0.9),
                            ),
                          ),
                        ],
                      ),
                      AnimatedOpacity(
                        opacity: _avatarOpacity, // Use _avatarOpacity for CircleAvatar
                        duration: Duration(seconds: 1),
                        curve: Curves.easeInOut,
                        child: CircleAvatar(
                          radius: 30,
                          backgroundColor: Colors.transparent,
                          child: Image.asset(
                            'assets/dashboard_user.png', // Replace with actual path to your PNG file
                            width: 60,
                            height: 60,
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
                const SizedBox(height: 20),
                // Scrollable Grid of Dashboard Tiles
                Expanded(
                  child: Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 40.0),
                    child: SingleChildScrollView(
                      child: GridView.count(
                        shrinkWrap: true, // Makes sure the GridView does not take up more space than needed
                        physics: NeverScrollableScrollPhysics(), // Disables scrolling of GridView
                        crossAxisCount: 2,
                        mainAxisSpacing: 20,
                        crossAxisSpacing: 20,
                        children: [
                          _buildDashboardTile("Profile", Icons.person, CustomerViewPage()),
                          _buildDashboardTile("Customers", Icons.group, CustomerViewPage()),
                          _buildDashboardTile("Configurations", Icons.build, CustomerViewPage()),
                          _buildDashboardTile("History", Icons.history, CustomerViewPage()),
                          _buildDashboardTile("Bills", Icons.receipt_long, BillingPage()),
                          _buildDashboardTile("Settings", Icons.settings, SettingsPage()),
                        ],
                      ),
                    ),
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
      bottomNavigationBar: Container(
        decoration: BoxDecoration(
          border: Border(
            top: BorderSide(color: Color(0xFFDEDDDD), width: 1), // Upper black border
          ),
        ),
        child: BottomNavigationBar(
          backgroundColor: Colors.white,
          currentIndex: _currentIndex,
          onTap: _onItemTapped,
          type: BottomNavigationBarType.fixed,
          selectedFontSize: 0,
          unselectedFontSize: 0,
          items: [
            BottomNavigationBarItem(
              icon: SizedBox(
                height: kBottomNavigationBarHeight,
                child: Center(
                  child: SvgPicture.asset(
                    'assets/home.svg',
                    width: 24,
                    height: 24,
                    color: _currentIndex == 0 ? primaryDark : Colors.grey,
                  ),
                ),
              ),
              label: "",
            ),
            BottomNavigationBarItem(
              icon: SizedBox(
                height: kBottomNavigationBarHeight,
                child: Center(
                  child: SvgPicture.asset(
                    'assets/search.svg',
                    width: 24,
                    height: 24,
                    color: _currentIndex == 1 ? primaryDark : Colors.grey,
                  ),
                ),
              ),
              label: "",
            ),
            BottomNavigationBarItem(
              icon: SizedBox(
                height: kBottomNavigationBarHeight,
                child: Center(
                  child: SvgPicture.asset(
                    'assets/settings.svg',
                    width: 24,
                    height: 24,
                    color: _currentIndex == 2 ? primaryDark  : Colors.grey,
                  ),
                ),
              ),
              label: "",
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildDashboardTile(String title, IconData icon, Widget destinationPage) {
    Color _tileColor = Colors.white; // Initial background color

    return StatefulBuilder(
      builder: (context, setState) {
        return AnimatedOpacity(
          opacity: _tileOpacity, // Use _tileOpacity for visibility
          duration: Duration(milliseconds: 1800), // Adjust duration for smooth transition
          curve: Curves.easeInOut, // Optional: Add a curve for smoother effect
          child: Material(
            color: Colors.transparent,
            borderRadius: BorderRadius.circular(24),
            child: InkWell(
              borderRadius: BorderRadius.circular(24),
              onTap: () {
                setState(() {
                  _tileColor = Colors.grey.shade200; // Change to grey on tap
                });
                Future.delayed(Duration(milliseconds: 200), () {
                  setState(() {
                    _tileColor = Colors.white; // Revert to white after delay
                  });
                  Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (context) => destinationPage, // Navigate to the passed page
                    ),
                  );
                });
              },
              splashColor: Colors.transparent, // Remove ripple effect
              highlightColor: Colors.transparent, // Disable default highlight
              child: AnimatedContainer(
                duration: Duration(milliseconds: 200),
                decoration: BoxDecoration(
                  color: _tileColor,
                  borderRadius: BorderRadius.circular(24),
                  boxShadow: [
                    BoxShadow(
                      color: Colors.grey.withOpacity(0.4),
                      blurRadius: 15,
                      offset: Offset(2, 9),
                    ),
                  ],
                ),
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Icon(icon, size: 70, color: primaryDark),
                    SizedBox(height: 8),
                    Text(
                      title,
                      style: GoogleFonts.signika(
                        fontSize: 14,
                        fontWeight: FontWeight.w500,
                        color: Colors.grey,
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ),
        );
      },
    );
  }
}
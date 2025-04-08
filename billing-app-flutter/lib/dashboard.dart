import 'package:billing_application/house.dart';
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'customerview.dart';
import 'main.dart';
import 'package:flutter/services.dart';
import 'billing.dart';
import 'settings.dart';

class DashboardPage extends StatefulWidget {
  @override
  _DashboardPageState createState() => _DashboardPageState();
}

class _DashboardPageState extends State<DashboardPage>
    with TickerProviderStateMixin {
  bool _isAnimationComplete = false;
  int _currentIndex = 0;
  String svgString = '';
  Color? primaryLight;
  Color? secondaryLight;
  Color? primaryDark;
  double _tileOpacity = 0;
  double _avatarOpacity = 0;
  late AnimationController _navBarController;
  late Animation<double> _navBarAnimation;
  bool? _isDarkMode;
  late String svgString2;
  String name = '';
  String email = '';
  String? primaryFont;
  String? secondaryFont;
  String? appPurpose;

  @override
  void initState() {
    super.initState();
    _loadThemePreference();
    loadUserData();
    _navBarController = AnimationController(
      duration: Duration(milliseconds: 800),
      vsync: this,
    );
    _navBarAnimation = CurvedAnimation(
      parent: _navBarController,
      curve: Curves.easeIn,
    );

    AppColors.loadColorsFromPrefs().then((_) {
      setState(() {
        secondaryLight = AppColors.secondaryLight;
        primaryLight = AppColors.primaryLight;
        primaryDark = AppColors.primaryDark;
        primaryFont = AppColors.primaryFont;
        secondaryFont = AppColors.secondaryFont;
        appPurpose = AppColors.appPurpose;
      });

      return loadSvg();
    }).then((_) {
      Future.delayed(Duration(milliseconds: 200), () {
        setState(() {
          _tileOpacity = 1.0;
          _avatarOpacity = 1.0;
          _isAnimationComplete = true;
        });
        _navBarController.forward();
      });
    });
    AppColors.loadColorsFromPrefs().then((_) {
      setState(() {
        secondaryLight = AppColors.secondaryLight;
        primaryLight = AppColors.primaryLight;
        primaryDark = AppColors.primaryDark;
        primaryFont = AppColors.primaryFont;
        secondaryFont = AppColors.secondaryFont;
        appPurpose = AppColors.appPurpose;
      });

      return loadSvgMeter();
    }).then((_) {
      Future.delayed(Duration(milliseconds: 200), () {
        setState(() {
          _tileOpacity = 1.0;
          _avatarOpacity = 1.0;
          _isAnimationComplete = true;
        });
        _navBarController.forward();
      });
    });
  }
  Future<void> loadUserData() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    setState(() {
      name = prefs.getString('name') ?? '';
      email = prefs.getString('email') ?? '';
    });
  }
  Future<void> _loadThemePreference() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    bool isDark = prefs.getBool('isDarkMode') ?? false;
    setState(() {
      _isDarkMode = isDark;
    });
  }

  @override
  void dispose() {
    _navBarController.dispose();
    super.dispose();
  }


  Future<void> loadSvg() async {
    if (secondaryLight != null && primaryLight != null && primaryDark != null) {
      String svg = await rootBundle.loadString('assets/dashboard_upper_shape.svg');

      setState(() {
        svgString = svg.replaceAll(
          'PLACEHOLDER_COLOR_1', _isDarkMode == true ? '#000000' : _colorToHex(secondaryLight ?? Colors.grey), // Dark mode logic
        ).replaceAll(
          'PLACEHOLDER_COLOR_2', _isDarkMode == true ? '#666564' : _colorToHex(primaryLight ?? Colors.blue),
        ).replaceAll(
          'PLACEHOLDER_COLOR_3', _isDarkMode == true ? '#000000' : _colorToHex(primaryDark ?? Colors.black),
        );
      });
    }
  }


  Future<void> loadSvgMeter() async {
    if (secondaryLight != null && primaryLight != null && primaryDark != null) {
      String svg = await rootBundle.loadString('assets/electric_meter.svg');

      svgString2 = svg.replaceAll(
        'PLACEHOLDER_COLOR_1', _isDarkMode == true ? _colorToHex(Colors.grey[200]!) : _colorToHex(secondaryLight ?? Colors.grey),
      ).replaceAll(
        'PLACEHOLDER_COLOR_2', _isDarkMode == true ? '#666564' : _colorToHex(primaryLight ?? Colors.blue),
      ).replaceAll(
        'PLACEHOLDER_COLOR_3', _isDarkMode == true ? _colorToHex(Colors.grey[400]!) : _colorToHex(primaryDark ?? Colors.black),
      );

      setState(() {}); // ensure UI rebuild
    }
  }


  String _colorToHex(Color color) {
    return '#${color.value.toRadixString(16).substring(2).toUpperCase()}';
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: _isDarkMode! ? Colors.grey[700] : Colors.white,
      body: Stack(
        children: [
          AnimatedPositioned(
            duration: const Duration(milliseconds: 1500),
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
          Padding(
            padding: const EdgeInsets.only(top: 90),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 20.0),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            "Welcome, $name",
                            style: GoogleFonts.getFont(
                              primaryFont ?? 'Signika',
                              fontSize: 18,
                              fontWeight: FontWeight.w500,
                              color: Colors.white,
                            ),
                          ),
                          Text(
                            "Dashboard",
                            style: GoogleFonts.getFont(
                              primaryFont ?? 'Signika',
                              fontSize: 30,
                              fontWeight: FontWeight.bold,
                              color: Colors.white,
                            ),
                          ),
                          Text(
                            "Logged in with: $email",
                            style: GoogleFonts.getFont(
                              primaryFont ?? 'Signika',
                              fontSize: 10,
                              color: Colors.white.withOpacity(0.9),
                            ),
                          ),
                        ],
                      ),
                      AnimatedOpacity(
                        opacity: _avatarOpacity,
                        duration: Duration(seconds: 1),
                        curve: Curves.easeInOut,
                        child: CircleAvatar(
                          radius: 30,
                          backgroundColor: Colors.transparent,
                          child: Image.asset(
                            'assets/dashboard_user.png',
                            width: 60,
                            height: 60,
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
                const SizedBox(height: 20),
                Expanded(
                  child: Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 40.0),
                    child: SingleChildScrollView(
                      child: GridView.count(
                        shrinkWrap: true,
                        physics: NeverScrollableScrollPhysics(),
                        crossAxisCount: 2,
                        mainAxisSpacing: 20,
                        crossAxisSpacing: 20,
                        children: [
                          _buildDashboardTile("Profile", Icons.person, CustomerViewPage()),
                          _buildDashboardTile("Houses", Icons.house_rounded, HouseViewPage()),
                          _buildDashboardTile("Configurations", Icons.dashboard_customize_outlined, DashboardPage()),
                          _buildDashboardTile("History", Icons.history_rounded, DashboardPage()),
                          _buildDashboardTileWithSvg(appPurpose ?? "Meter Readings", svgString2, BillingPage()),
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
      bottomNavigationBar: FadeTransition(
        opacity: _navBarAnimation,
        child: Container(
          decoration: BoxDecoration(
            border: Border(
              top: BorderSide(
                color: _isDarkMode == true ? Colors.grey[800]! : Color(0xFFDEDDDD), // Dark Mode support
                width: 1,
              ),
            ),
          ),
          child: BottomNavigationBar(
            backgroundColor: _isDarkMode! ? Colors.grey[700] : Colors.white,
            currentIndex: _currentIndex,
            onTap: (index) {
              setState(() {
                _currentIndex = index;
              });
              // Navigate to the corresponding page
              if (index == 0) {

              } else if (index == 1) {
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (context) => DashboardPage()),
                );
              } else if (index == 2) {
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (context) => SettingsPage()),
                );
              }
            },
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
                      color: _currentIndex == 0
                          ? (_isDarkMode == true ? Colors.white : (primaryDark ?? Colors.blue)) // Dark Mode = White, Light Mode = primaryDark
                          : Colors.grey,
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
                      color: _currentIndex == 1
                          ? (_isDarkMode == true ? Colors.white : (primaryDark ?? Colors.blue)) // Dark Mode = White, Light Mode = primaryDark
                          : Colors.grey,

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
                      color: _currentIndex == 2
                          ? (_isDarkMode == true ? Colors.white : (primaryDark ?? Colors.blue)) // Dark Mode = White, Light Mode = primaryDark
                          : Colors.grey,

                    ),
                  ),
                ),
                label: "",
              ),
            ],
          ),
        ),
      ),
    );
  }
  Widget _buildDashboardTileWithSvg(String appPurpose, String svgData, Widget destinationPage) {
    return StatefulBuilder(
      builder: (context, setState) {
        Color tileColor = (_isDarkMode ?? false) ? Colors.grey[800]! : Colors.white;

        return AnimatedOpacity(
          opacity: _tileOpacity,
          duration: Duration(milliseconds: 1300),
          curve: Curves.easeInOut,
          child: Material(
            color: Colors.transparent,
            borderRadius: BorderRadius.circular(24),
            child: InkWell(
              borderRadius: BorderRadius.circular(24),
              onTap: () {
                setState(() {
                  tileColor = (_isDarkMode ?? false) ? Colors.grey[900]! : Colors.grey.shade200;
                });

                Future.delayed(Duration(milliseconds: 200), () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(builder: (context) => destinationPage),
                  );
                });
              },
              splashColor: Colors.transparent,
              highlightColor: Colors.transparent,
              child: AnimatedContainer(
                duration: Duration(milliseconds: 200),
                decoration: BoxDecoration(
                  color: tileColor,
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
                    SvgPicture.string(
                      svgData,
                      width: 67,
                      height: 67,
                    ),
                    SizedBox(height: 8),
                    Text(
                      appPurpose,
                      style: GoogleFonts.getFont(
                        primaryFont ?? 'Signika',
                        fontSize: 14,
                        fontWeight: FontWeight.w500,
                        color: _isDarkMode == true
                            ? Colors.white54
                            : (primaryDark ?? Colors.blue),
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


  Widget _buildDashboardTile(String title, IconData icon, Widget destinationPage) {
    Color _tileColor = (_isDarkMode ?? false) ? Colors.grey[800]! : Colors.white;
    return StatefulBuilder(
      builder: (context, setState) {
        return AnimatedOpacity(
          opacity: _tileOpacity,
          duration: Duration(milliseconds: 1300),
          curve: Curves.easeInOut,
          child: Material(
            color: Colors.transparent,
            borderRadius: BorderRadius.circular(24),
            child: InkWell(
              borderRadius: BorderRadius.circular(24),
              onTap: () {
                setState(() {
                  _tileColor = (_isDarkMode ?? false) ? Colors.grey[900]! : Colors.grey.shade200;
                });
                Future.delayed(Duration(milliseconds: 200), () {
                  setState(() {
                    _tileColor = Colors.white;
                  });
                  Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (context) => destinationPage,
                    ),
                  );
                });
              },
              splashColor: Colors.transparent,
              highlightColor: Colors.transparent,
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
                    Icon(icon, size: 70, color: _isDarkMode == true ? Colors.white70 : (primaryDark)),
                    SizedBox(height: 8),
                    Text(
                      title,
                      style: GoogleFonts.getFont(
                        primaryFont ?? 'Signika',
                        fontSize: 14,
                        fontWeight: FontWeight.w500,
                        color: _isDarkMode == true ? Colors.white54 : (primaryDark ?? Colors.blue),
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
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:google_fonts/google_fonts.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert';
import 'login.dart';
import 'dashboard.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await AppColors.fetchColorsAndSave();
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Billing Application',
      theme: ThemeData.light(),
      darkTheme: ThemeData.dark(),
      themeMode: ThemeMode.system,
      debugShowCheckedModeBanner: false,
      home: const SplashScreen(),
    );
  }
}

class SplashScreen extends StatefulWidget {
  const SplashScreen({super.key});

  @override
  State<SplashScreen> createState() => _SplashScreenState();
}

class _SplashScreenState extends State<SplashScreen> {
  late Future<Map<String, dynamic>> configurationData;
  bool _isDarkMode = false;

  @override
  void initState() {
    super.initState();
    _loadThemePreference();
    configurationData = fetchConfiguration();

    Future.delayed(const Duration(seconds: 3), () async {
      await AppColors.loadColorsFromPrefs();
      _checkLoginStatus();
    });
  }

  Future<void> _checkLoginStatus() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString('auth_token');

    if (token != null) {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (context) => DashboardPage()),
      );
    } else {
      Navigator.pushReplacement(
        context,
        PageRouteBuilder(
          pageBuilder: (context, animation, secondaryAnimation) => LoginPage(),
          transitionsBuilder: (context, animation, secondaryAnimation, child) {
            return FadeTransition(opacity: animation, child: child);
          },
        ),
      );
    }
  }

  Future<void> _loadThemePreference() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    setState(() {
      _isDarkMode = prefs.getBool('isDarkMode') ?? false;
    });
  }

  Future<Map<String, dynamic>> fetchConfiguration() async {
    final response = await http.get(Uri.parse(
        'http://13.39.111.189:100/api/configuration/1'));

    if (response.statusCode == 200) {
      return json.decode(response.body)['data'];
    } else {
      throw Exception('Failed to load configuration');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: _isDarkMode ? Colors.black : Colors.white,
      body: FutureBuilder<Map<String, dynamic>>(
        future: configurationData,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          } else if (snapshot.hasError) {
            return Center(child: Text('Error: ${snapshot.error}'));
          } else if (snapshot.hasData) {
            var data = snapshot.data!;
            return Stack(
              children: [
                Center(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: <Widget>[
                      ClipRRect(
                        borderRadius: BorderRadius.circular(12),
                        child: FittedBox(
                          fit: BoxFit.contain,
                          child: Image.asset(
                            'assets/dashboard_user.png',
                            height: 100.0,
                          ),
                        ),
                      ),
                      Column(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: <Widget>[
                          const SizedBox(height: 10),
                          Text(
                            data['app_name']?.toUpperCase() ?? 'Loading...',
                            style: GoogleFonts.getFont(
                              data['app_font_primary'] ?? 'Roboto',
                              fontSize: 43,
                              fontWeight: FontWeight.normal,
                              color: _isDarkMode ? Colors.white : Colors.grey,
                              height: 1.2,
                            ),
                          ),
                          Text(
                            data['app_tagline']?.toUpperCase() ?? 'Loading tagline...',
                            style: GoogleFonts.getFont(
                              data['app_font_secondary'] ?? 'Roboto',
                              fontSize: 13,
                              fontWeight: FontWeight.w400,
                              color: _isDarkMode ? Colors.white54 : Colors.grey,
                              height: 1.0,
                            ),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
                Positioned(
                  bottom: 18,
                  left: 0,
                  right: 0,
                  child: Center(
                    child: Text(
                      '${data['app_version'] ?? 'v1.01'}',
                      style: GoogleFonts.sacramento(
                        fontSize: 13,
                        fontWeight: FontWeight.w400,
                        color: _isDarkMode ? Colors.white54 : Colors.grey,
                      ),
                    ),
                  ),
                ),
              ],
            );
          } else {
            return const Center(child: Text('No data available'));
          }
        },
      ),
    );
  }
}

// AppColors Class for Theme Management
class AppColors {
  static Color? primaryLight;
  static Color? primaryDark;
  static Color? secondaryLight;
  static Color? secondaryDark;
  static Color? background;
  static Color? textPrimary;
  static Color? textSecondary;
  static Color? svgLogin;
  static Color? svgSignup;
  static Color? links;
  static String? primaryFont;
  static String? secondaryFont;
  static String? appPurpose;

  static Future<void> fetchColorsAndSave() async {
    final response = await http.get(Uri.parse(
        'http://13.39.111.189:100/api/configuration/1'));

    if (response.statusCode == 200) {
      Map<String, dynamic> data = json.decode(response.body)['data'];
      SharedPreferences prefs = await SharedPreferences.getInstance();

      data.forEach((key, value) {
        if ((key.contains('app_theme') ||
            key == 'app_font_primary' ||
            key == 'app_font_secondary' ||
            key == 'app_purpose') &&
            value != null) {
          prefs.setString(key, value.toString());
        }
      });
    } else {
      throw Exception('Failed to load colors');
    }
  }

  static Future<void> loadColorsFromPrefs() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();

    primaryLight = _getColorFromPrefs(prefs, 'app_theme_primary_light');
    primaryDark = _getColorFromPrefs(prefs, 'app_theme_primary_dark');
    secondaryLight = _getColorFromPrefs(prefs, 'app_theme_secondary_light');
    secondaryDark = _getColorFromPrefs(prefs, 'app_theme_secondary_dark');
    background = _getColorFromPrefs(prefs, 'app_theme_background');
    textPrimary = _getColorFromPrefs(prefs, 'app_theme_text_primary');
    textSecondary = _getColorFromPrefs(prefs, 'app_theme_text_secondary');
    svgLogin = _getColorFromPrefs(prefs, 'app_theme_svg_login');
    svgSignup = _getColorFromPrefs(prefs, 'app_theme_svg_signup');
    links = _getColorFromPrefs(prefs, 'app_theme_links');
    primaryFont = prefs.getString('app_font_primary');
    secondaryFont = prefs.getString('app_font_secondary');
    appPurpose = prefs.getString('app_purpose');
  }

  static Color? _getColorFromPrefs(SharedPreferences prefs, String key) {
    String? colorString = prefs.getString(key);
    if (colorString != null && colorString.startsWith('#')) {
      return Color(int.parse('0xFF${colorString.substring(1)}'));
    }
    return null;
  }
}

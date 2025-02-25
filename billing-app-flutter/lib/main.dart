// main.dart
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:google_fonts/google_fonts.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert';
import 'login.dart';


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
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: Colors.deepPurple),
        useMaterial3: true,
      ),
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

  Future<Map<String, dynamic>> fetchConfiguration() async {
    final response = await http.get(Uri.parse(
        'http://ec2-13-39-111-189.eu-west-3.compute.amazonaws.com:100/api/configuration/1'));

    if (response.statusCode == 200) {
      return json.decode(response.body)['data'];
    } else {
      throw Exception('Failed to load configuration');
    }
  }

  @override
  void initState() {
    super.initState();
    configurationData = fetchConfiguration();
    Future.delayed(const Duration(seconds: 3), () async {
      await AppColors.loadColorsFromPrefs();
      Navigator.pushReplacement(
        context,
        PageRouteBuilder(
          pageBuilder: (context, animation, secondaryAnimation) =>
              LoginPage(),
          transitionsBuilder:
              (context, animation, secondaryAnimation, child) {
            return FadeTransition(
              opacity: animation,
              child: child,
            );
          },
        ),
      );
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFFFFFFF),
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
                            style: GoogleFonts.telex(
                              fontSize: 43,
                              fontWeight: FontWeight.normal,
                              color: const Color(0xFF969696),
                              height: 1.2,
                            ),
                          ),
                          Text(
                            data['app_tagline']?.toUpperCase() ??
                                'Loading tagline...',
                            style: GoogleFonts.sarabun(
                              fontSize: 13,
                              fontWeight: FontWeight.w400,
                              color: const Color(0xFF969696),
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
                      style: GoogleFonts.sarabun(
                        fontSize: 13,
                        fontWeight: FontWeight.w400,
                        color: const Color(0xFF969696),
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

  static Future<void> fetchColorsAndSave() async {
    final response = await http.get(Uri.parse(
        'http://ec2-13-39-111-189.eu-west-3.compute.amazonaws.com:100/api/configuration/1'));

    if (response.statusCode == 200) {
      Map<String, dynamic> data = json.decode(response.body)['data'];
      SharedPreferences prefs = await SharedPreferences.getInstance();

      data.forEach((key, value) {
        if (key.contains('app_theme')) {
          prefs.setString(key, value);
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
  }

  static Color? _getColorFromPrefs(SharedPreferences prefs, String key) {
    String? colorString = prefs.getString(key);
    if (colorString != null && colorString.startsWith('#')) {
      return Color(int.parse('0xFF${colorString.substring(1)}'));
    }
    return null;
  }
}

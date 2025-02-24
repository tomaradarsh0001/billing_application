import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:google_fonts/google_fonts.dart';
import 'dart:convert'; // For parsing JSON
import 'dashboard.dart'; // Import the Dashboard page
import 'login.dart'; // Import the Login page
import 'colors.dart'; // Import the AppColors class

void main() {
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
      home: const SplashScreen(), // Set SplashScreen as the home
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
    final response =
    await http.get(Uri.parse('http://ec2-13-39-111-189.eu-west-3.compute.amazonaws.com:100/api/configuration/1'));

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
    Future.delayed(const Duration(seconds: 3), () {
      Navigator.pushReplacement(
        context,
        PageRouteBuilder(
          pageBuilder: (context, animation, secondaryAnimation) =>
           LoginPage(),
          transitionsBuilder: (context, animation, secondaryAnimation, child) {
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
      backgroundColor: const Color(0xFFFFFFFF), // Light gray background
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
                          // child: Image.network(
                          //   'http://ec2-13-39-111-189.eu-west-3.compute.amazonaws.com:100/storage/${data['app_logo']}',
                          //   height: 100.0,
                          // ),
                          child: Image.asset(
                            'assets/dashboard_user.png',
                            height: 100.0,
                          ),
                        ),
                      ),
                      Column(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: <Widget>[
                          const SizedBox(height: 10), // No additional spacing
                          Text(
                            data['app_name']?.toUpperCase() ?? 'Loading...',
                            style: GoogleFonts.telex(
                              fontSize: 43,
                              fontWeight: FontWeight.normal,
                              color: const Color(0xFF969696),
                              height: 1.2, // Adjust line height to minimize space
                            ),
                          ),
                          Text(
                            data['app_tagline']?.toUpperCase() ??
                                'Loading tagline...',
                            style: GoogleFonts.sarabun(
                              fontSize: 13,
                              fontWeight: FontWeight.w400,
                              color: const Color(0xFF969696),
                              height: 1.0, // Adjust line height to minimize space
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

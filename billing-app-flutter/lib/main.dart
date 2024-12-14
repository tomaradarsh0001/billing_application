import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert'; // For parsing JSON
import 'landing.dart'; // Import the landing page

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Flutter Demo',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: Colors.deepPurple),
        useMaterial3: true,
      ),
      debugShowCheckedModeBanner: false, // Disable the debug banner

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
  late Future<Map<String, dynamic>> configurationData; // Variable to store API data

  // Function to fetch configuration data
  Future<Map<String, dynamic>> fetchConfiguration() async {
    final response = await http.get(Uri.parse('http://172.232.108.54/api/configuration/3'));

    if (response.statusCode == 200) {
      // If the server returns a 200 OK response, parse the JSON
      return json.decode(response.body)['data'];
    } else {
      // If the server returns an error, throw an exception
      throw Exception('Failed to load configuration');
    }
  }

  @override
  void initState() {
    super.initState();
    configurationData = fetchConfiguration(); // Fetch the configuration data
    // Navigate to LandingPage after 1 second with animation
    Future.delayed(const Duration(seconds: 4), () {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (context) => const LandingPage()),
      );
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white, // White background for splash screen
      body: FutureBuilder<Map<String, dynamic>>(
        future: configurationData, // Use the fetched configuration data
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          } else if (snapshot.hasError) {
            return Center(child: Text('Error: ${snapshot.error}'));
          } else if (snapshot.hasData) {
            var data = snapshot.data!;
            return Center(
              child: AnimatedSwitcher(
                duration: const Duration(seconds: 1), // 1 second transition duration
                child: Column(
                  key: ValueKey<String>(data['app_name']), // Unique key to trigger animation
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: <Widget>[
                    // Display image fetched from the API
                    ClipRRect(
                      borderRadius: BorderRadius.circular(12),
                      child: FittedBox(
                        fit: BoxFit.contain, // Ensures the image fits without cropping
                        child: Image.network(
                          'http://172.232.108.54//storage/${data['app_logo']}',
                          height: 160.0, // Set only the height (width will adjust)
                        ),
                      ),
                    ),
                    const SizedBox(height: 20),
                    // Display tagline fetched from the API
                    Text(
                      data['app_tagline'] ?? 'Loading tagline...',
                      style: const TextStyle(
                        fontSize: 24,
                        fontWeight: FontWeight.bold,
                        color: Colors.black, // Text color black
                      ),
                    ),
                  ],
                ),
              ),
            );
          } else {
            return const Center(child: Text('No data available'));
          }
        },
      ),
    );
  }
}

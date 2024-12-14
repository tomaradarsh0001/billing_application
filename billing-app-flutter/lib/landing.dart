import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert'; // For parsing JSON

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false, // Disable the debug banner
      home: const LandingPage(),
    );
  }
}

class LandingPage extends StatefulWidget {
  const LandingPage({super.key});

  @override
  _LandingPageState createState() => _LandingPageState();
}

class _LandingPageState extends State<LandingPage> {
  late Future<Map<String, dynamic>> configurationData;
  int _selectedIndex = 0; // Index for the BottomNavigationBar

  // Function to fetch configuration data
  Future<Map<String, dynamic>> fetchConfiguration() async {

    final response = await http.get(Uri.parse('http://192.168.10.4:8000/api/configuration/2'));

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
  }

  void _onItemTapped(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: FutureBuilder<Map<String, dynamic>>(
        future: configurationData,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          } else if (snapshot.hasError) {
            return Center(child: Text('Error: ${snapshot.error}'));
          } else if (snapshot.hasData) {
            var data = snapshot.data!;
            // Dynamically set the app bar color based on the API response
            Color appBarColor = Color(int.parse(data['app_theme'].replaceAll('#', '0xff')));

            return Scaffold(
              appBar: AppBar(
                title: Text(
                  data['app_name'],
                  style: const TextStyle(color: Colors.white), // White text color for AppBar
                ),
                backgroundColor: appBarColor,
              ),
              body: Padding(
                padding: const EdgeInsets.all(16.0),
                child: Center(
                  child: SingleChildScrollView(
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      crossAxisAlignment: CrossAxisAlignment.center,
                      children: <Widget>[
                        // Single card containing App Name, App Tagline, App Theme, and Image
                        Card(
                          elevation: 40,
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(12),
                          ),
                          child: Padding(
                            padding: const EdgeInsets.all(16.0),
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: <Widget>[
                                // App Name
                                Text(
                                  'App Name: ${data['app_name']}',
                                  style: const TextStyle(
                                    fontSize: 24,
                                    fontWeight: FontWeight.bold,
                                    color: Colors.black87,
                                  ),
                                ),
                                const SizedBox(height: 10),
                                // App Tagline
                                Text(
                                  'App Tagline: ${data['app_tagline']}',
                                  style: const TextStyle(
                                    fontSize: 18,
                                    color: Colors.black54,
                                  ),
                                ),
                                const SizedBox(height: 10),
                                // App Theme as Color Dot
                                Row(
                                  children: <Widget>[
                                    const Text(
                                      'App Theme: ',
                                      style: TextStyle(
                                        fontSize: 18,
                                        color: Colors.black54,
                                      ),
                                    ),
                                    Container(
                                      width: 20,
                                      height: 20,
                                      decoration: BoxDecoration(
                                        shape: BoxShape.circle,
                                        color: appBarColor, // Set the color from API response
                                      ),
                                    ),
                                  ],
                                ),
                                const SizedBox(height: 20, width: 50),
                                // Image
                                Center(
                                  child: ClipRRect(
                                    borderRadius: BorderRadius.circular(12),
                                    child: Image.network(
                                      'http://192.168.10.4:8000/storage/${data['app_logo']}',
                                      height: 200.0,
                                      width: 200.0,
                                      fit: BoxFit.cover,
                                    ),
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
              ),
              bottomNavigationBar: BottomNavigationBar(
                currentIndex: _selectedIndex,
                onTap: _onItemTapped,
                selectedItemColor: appBarColor, // Use app theme color for selected icon
                items: const <BottomNavigationBarItem>[
                  BottomNavigationBarItem(
                    icon: Icon(Icons.home),
                    label: 'Home',
                  ),
                  BottomNavigationBarItem(
                    icon: Icon(Icons.search),
                    label: 'Search',
                  ),
                  BottomNavigationBarItem(
                    icon: Icon(Icons.account_circle),
                    label: 'Profile',
                  ),
                ],
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

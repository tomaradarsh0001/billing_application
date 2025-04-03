import 'package:billing_application/modal/faq.dart';
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'main.dart';
import 'dashboard.dart';
import 'login.dart';
import 'modal/privacy_policy.dart';
import 'modal/faq.dart';
import 'modal/help_support.dart';

class SettingsPage extends StatefulWidget {
  @override
  _SettingsPageState createState() => _SettingsPageState();
}

class _SettingsPageState extends State<SettingsPage> {
  bool? _isDarkMode; // Initially null to avoid incorrect UI state
  Color? primaryLight;
  Color? secondaryLight; // Assuming color2 is also a dynamic color
  Color? secondaryDark; // Assuming color2 is also a dynamic color
  Color? primaryDark;
  Color? svgLogin;
  Color? links;
  Color? textPrimary;

  @override
  void initState() {
    super.initState();
    AppColors.loadColorsFromPrefs().then((_) {
      setState(() {
        secondaryLight = AppColors.secondaryLight;
        primaryLight = AppColors.primaryLight; // Replace with actual dynamic color
        primaryDark = AppColors.primaryDark; // Replace with actual dynamic color
        svgLogin = AppColors.svgLogin; // Replace with actual dynamic color
        secondaryDark = AppColors.secondaryDark; // Replace with actual dynamic color
        links = AppColors.links; // Replace with actual dynamic color
        textPrimary = AppColors.textPrimary;
      });

    });
    _loadThemePreference();

  }

  // Load theme preference from SharedPreferences
  Future<void> _loadThemePreference() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    bool isDark = prefs.getBool('isDarkMode') ?? false;
    setState(() {
      _isDarkMode = isDark;
    });
  }
  void _showPrivacyPolicy(BuildContext context) {
    showDialog(
      context: context,
      builder: (context) => const PrivacyPolicyModal(),
    );
  }
  void _showHelpSupport(BuildContext context) {
    showDialog(
      context: context,
      builder: (context) => const HelpSupportModal(),
    );
  }
  void _showFAQ(BuildContext context) {
    showDialog(
      context: context,
      builder: (context) => const FAQModal(),
    );
  }

  void _confirmLogout() {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          title: Text("Logout"),
          content: Text("Are you sure you want to log out?"),
          actions: [
            TextButton(
              onPressed: () {
                Navigator.of(context).pop(); // Close the dialog
              },
              child: Text("Cancel"),
            ),
            TextButton(
              onPressed: () async {
                Navigator.of(context).pop(); // Close the dialog

                // Clear the auth token
                SharedPreferences prefs = await SharedPreferences.getInstance();
                await prefs.remove('auth_token');

                // Navigate to the login page
                Navigator.pushReplacement(
                  context,
                  MaterialPageRoute(builder: (context) => LoginPage()),
                );
              },
              child: Text("Logout", style: TextStyle(color: Colors.red)),
            ),
          ],
        );
      },
    );
  }


  Future<bool> _onWillPop() async {
    Navigator.pushReplacement(
      context,
      MaterialPageRoute(builder: (context) => DashboardPage()),
    );
    return false; // Prevents default back navigation
  }

  // Save theme preference and update UI
  Future<void> _toggleDarkMode(bool value) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    await prefs.setBool('isDarkMode', value);
    setState(() {
      _isDarkMode = value;
    });
  }

  @override
  Widget build(BuildContext context) {
    if (_isDarkMode == null) {
      return Scaffold(
        backgroundColor: Colors.white,
        body: Center(child: CircularProgressIndicator()), // Show loading while fetching data
      );
    }

    return WillPopScope(
      onWillPop: _onWillPop, // Handle phone's back button
      child: Scaffold(
        appBar: AppBar(
          iconTheme: IconThemeData(color: Colors.white),
          title: Text('Settings', style: TextStyle(color: Colors.white)),
          backgroundColor: _isDarkMode! ? Colors.black : primaryDark,
          leading: IconButton(
            icon: Icon(Icons.arrow_back, color: Colors.white),
            onPressed: _onWillPop, // Handle app bar back button
          ),
          actions: [
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 8.0),
              child: Switch(
                value: _isDarkMode!,
                onChanged: _toggleDarkMode,
                activeColor: Colors.white,
                inactiveThumbColor: Colors.white,
                inactiveTrackColor: Colors.white54,
                thumbIcon: MaterialStateProperty.resolveWith<Icon?>((states) {
                  if (states.contains(MaterialState.selected)) {
                    return Icon(Icons.nightlight_round, color: Colors.black);
                  } else {
                    return Icon(Icons.wb_sunny, color: Colors.orange);
                  }
                }),
              ),
            ),
          ],
        ),
        body: Container(
          color: _isDarkMode! ? Colors.black87 : Colors.white,
          child: ListView(
            children: [
              _buildListTile(Icons.person, 'Profile', () {
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (context) => DashboardPage()),
                );
              }),
              _buildListTile(Icons.settings, 'Configuration', () {}),
              _buildListTile(Icons.notifications, 'Notifications', () {}),
              _buildListTile(Icons.privacy_tip, 'Privacy Policy', () => _showPrivacyPolicy(context)),
              _buildListTile(Icons.help, 'Help & Support', () => _showHelpSupport(context)),
              _buildListTile(Icons.question_answer, 'FAQ', () => _showFAQ(context)),
              _buildListTile(Icons.logout, 'Logout', _confirmLogout),
            ],
          ),
        ),
      ),
    );
  }
  Widget _buildListTile(IconData icon, String title, VoidCallback onTap) {
    return Material(
      color: Colors.transparent, // Ensures default background stays the same
      child: InkWell(
        onTap: onTap,
        splashColor: Colors.grey.withOpacity(0.3), // Tap ripple effect
        highlightColor: Colors.grey.withOpacity(0.5), // Square hover effect
        child: Container(
          padding: const EdgeInsets.symmetric(vertical: 16, horizontal: 16), // Proper spacing
          child: Row(
            children: [
              Icon(icon, color: _isDarkMode! ? Colors.white : Colors.black),
              const SizedBox(width: 16),
              Expanded(
                child: Text(
                  title,
                  style: TextStyle(color: _isDarkMode! ? Colors.white : Colors.black),
                ),
              ),
              Icon(Icons.arrow_forward_ios, size: 16, color: _isDarkMode! ? Colors.white70 : Colors.black54),
            ],
          ),
        ),
      ),
    );
  }


}

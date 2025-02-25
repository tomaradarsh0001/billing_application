import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'main.dart';

class SettingsPage extends StatefulWidget {
  @override
  _SettingsPageState createState() => _SettingsPageState();
}

class _SettingsPageState extends State<SettingsPage> {
  bool _isDarkMode = false;
  Color? primaryDark;
  Color? secondaryDark;

  @override
  void initState() {
    super.initState();
    _loadThemePreference();
    AppColors.loadColorsFromPrefs().then((_) {
      setState(() {
        secondaryDark = AppColors.secondaryDark;
        primaryDark = AppColors.primaryDark;
      });
    });
  }

  Future<void> _loadThemePreference() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    setState(() {
      _isDarkMode = prefs.getBool('isDarkMode') ?? false;
    });
  }

  Future<void> _toggleDarkMode(bool value) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    setState(() {
      _isDarkMode = value;
    });
    await prefs.setBool('isDarkMode', value);
  }

  void _logout() {
    // Implement your logout logic here
    Navigator.pop(context);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        iconTheme: IconThemeData(color: Colors.white),
        title: Text('Settings', style: TextStyle(color: Colors.white)),
        backgroundColor: _isDarkMode ? Colors.black : primaryDark,
        actions: [
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 8.0),
            child: Switch(
              value: _isDarkMode,
              onChanged: _toggleDarkMode,
              activeColor: Colors.white,
              inactiveThumbColor: Colors.white70,
              inactiveTrackColor: Colors.transparent,
              activeThumbImage: null,
              inactiveThumbImage: null,
              thumbIcon: MaterialStateProperty.resolveWith<Icon?>((states) {
                if (states.contains(MaterialState.selected)) {
                  return Icon(Icons.nightlight_round, color: Colors.black54);
                } else {
                  return Icon(Icons.wb_sunny, color: Colors.orange);
                }
              }),
            ),
          ),
        ],
      ),
      body: ListView(
        children: [
          ListTile(
            leading: Icon(Icons.person),
            title: Text('Profile'),
            onTap: () {
              // Navigate to profile page
            },
          ),
          ListTile(
            leading: Icon(Icons.settings),
            title: Text('Account Settings'),
            onTap: () {
              // Navigate to account settings
            },
          ),
          ListTile(
            leading: Icon(Icons.notifications),
            title: Text('Notifications'),
            onTap: () {
              // Navigate to notifications settings
            },
          ),
          ListTile(
            leading: Icon(Icons.privacy_tip),
            title: Text('Privacy Policy'),
            onTap: () {
              // Navigate to privacy policy
            },
          ),
          ListTile(
            leading: Icon(Icons.help),
            title: Text('Help & Support'),
            onTap: () {
              // Navigate to help & support
            },
          ),
          ListTile(
            leading: Icon(Icons.logout),
            title: Text('Logout'),
            onTap: _logout,
          ),
        ],
      ),
      backgroundColor: _isDarkMode ? Colors.black87 : Colors.white,
    );
  }
}
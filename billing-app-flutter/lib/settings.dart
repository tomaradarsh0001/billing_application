import 'package:flutter/material.dart';

class SettingsPage extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.white,
        title: Text('Settings Page'),
      ),
      body: Center(
        child: Text('Welcome to the Settings Page'),
      ),
    );
  }
}

import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;

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

  // Function to fetch color data from the API
  static Future<void> fetchColors() async {
    final response = await http.get(Uri.parse('http://16.171.136.239/api/configuration/2'));

    if (response.statusCode == 200) {
      Map<String, dynamic> data = json.decode(response.body)['data'];

      primaryLight = Color(int.parse('0xFF${data['app_theme_primary_light'].substring(1)}'));
      primaryDark = Color(int.parse('0xFF${data['app_theme_primary_dark'].substring(1)}'));
      secondaryLight = Color(int.parse('0xFF${data['app_theme_secondary_light'].substring(1)}'));
      secondaryDark = Color(int.parse('0xFF${data['app_theme_secondary_dark'].substring(1)}'));
      background = Color(int.parse('0xFF${data['app_theme_background'].substring(1)}'));
      textPrimary = Color(int.parse('0xFF${data['app_theme_text_primary'].substring(1)}'));
      textSecondary = Color(int.parse('0xFF${data['app_theme_text_secondary'].substring(1)}'));
      svgLogin = Color(int.parse('0xFF${data['app_theme_svg_login'].substring(1)}'));
      svgSignup = Color(int.parse('0xFF${data['app_theme_svg_signup'].substring(1)}'));
      links = Color(int.parse('0xFF${data['app_theme_links'].substring(1)}'));
    } else {
      throw Exception('Failed to load colors');
    }
  }
}

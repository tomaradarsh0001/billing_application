import 'package:billing_application/dashboard.dart';
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:google_fonts/google_fonts.dart';
import 'signup.dart';
import 'resetPassword.dart';
import 'package:flutter/services.dart';  // To load the SVG as a string
import 'main.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:shared_preferences/shared_preferences.dart';

class LoginPage extends StatefulWidget {
  @override
  _LoginPageState createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  bool _isAnimationComplete = false;
  bool _obscureText = true;
  String svgString = '';
  String svgStringPass = '';
  String svgStringEmail = '';
  Color? primaryLight;
  Color? secondaryLight; // Assuming color2 is also a dynamic color
  Color? secondaryDark; // Assuming color2 is also a dynamic color
  Color? primaryDark;
  Color? svgLogin;
  Color? links;
  Color? textPrimary;
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  bool _isLoading = false;
  final ScrollController _scrollController = ScrollController();

  void _togglePasswordVisibility() {
    setState(() {
      _obscureText = !_obscureText;
    });
  }

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

      // Load SVG after colors are fetched
      loadSvgPasswordIcon();
      loadSvgEmailIcon();
      loadSvg();
      _checkLoginStatus();
    });
    // Start the animation after a delay
    Future.delayed(Duration(milliseconds: 200), () {
      setState(() {
        _isAnimationComplete = true;
      });
    });
    _scrollController.addListener(() {
      if (_scrollController.offset > 50) {
        _scrollController.jumpTo(50);
      }
    });
  }

  // Check if the user is already logged in
  Future<void> _checkLoginStatus() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString('auth_token');
    if (token != null) {
      Navigator.pushReplacement(
          context, MaterialPageRoute(builder: (context) => DashboardPage()));
    }
  }

  Future<void> loadSvg() async {
    if (secondaryLight != null && primaryLight != null && primaryDark != null) {
      String svg = await rootBundle.loadString('assets/login_upper_shape.svg');
      setState(() {
        // Replace placeholders with actual colors in hex format
        svgString = svg.replaceAll(
          'PLACEHOLDER_COLOR_1', _colorToHex(svgLogin!),
        ).replaceAll(
          'PLACEHOLDER_COLOR_4', _colorToHex(secondaryDark!),
        ).replaceAll(
          'PLACEHOLDER_COLOR_5', _colorToHex(primaryDark!),
        ).replaceAll(
          'PLACEHOLDER_COLOR_2', _colorToHex(secondaryLight!),
        ).replaceAll(
          'PLACEHOLDER_COLOR_3', _colorToHex(secondaryDark!),
        );
      });
    }
  }
  Future<void> loadSvgPasswordIcon() async {
    if (secondaryDark != null && links != null && primaryDark != null) {
      String svgpass = await rootBundle.loadString('assets/password_icon.svg');
      setState(() {
        // Replace placeholders with actual colors in hex format
        svgStringPass = svgpass.replaceAll(
          'ICON_COLOR_1', _colorToHex(links!),
        ).replaceAll(
          'ICON_COLOR_2', _colorToHex(textPrimary!),
        ).replaceAll(
          'ICON_COLOR_3', _colorToHex(primaryDark!),
        );
      });
    }
  }
  Future<void> loadSvgEmailIcon() async {
    if (secondaryDark != null && links != null && primaryDark != null) {
      String svgemail = await rootBundle.loadString('assets/email_icon.svg');
      setState(() {
        // Replace placeholders with actual colors in hex format
        svgStringEmail = svgemail.replaceAll(
          'ICON_COLOR_1', _colorToHex(links!),
        ).replaceAll(
          'ICON_COLOR_2', _colorToHex(textPrimary!),
        ).replaceAll(
          'ICON_COLOR_3', _colorToHex(primaryDark!),
        ).replaceAll(
          'ICON_COLOR_4', _colorToHex(links!),
        ).replaceAll(
          'ICON_COLOR_5', _colorToHex(textPrimary!),
        );
      });
    }
  }
  // Helper function to convert Color to Hex string
  String _colorToHex(Color color) {
    return '#${color.value.toRadixString(16).substring(2).toUpperCase()}';
  }

  Future<void> _login() async {
    String email = _emailController.text.trim();
    String password = _passwordController.text.trim();

    if (email.isEmpty || password.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text("Email and Password cannot be empty")),
      );
      return;
    }

    setState(() {
      _isLoading = true; // Show CircularProgressIndicator
    });

    var url = Uri.parse(
        "http://ec2-13-39-111-189.eu-west-3.compute.amazonaws.com:100/api/login");

    try {
      var response = await http.post(
        url,
        body: {"email": email, "password": password},
      );

      var responseData = json.decode(response.body);

      if (response.statusCode == 200) {
        String token = responseData['token'];

        SharedPreferences prefs = await SharedPreferences.getInstance();
        await prefs.setString('auth_token', token);

        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (context) => DashboardPage()),
        );
      } else {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text(responseData['message'] ?? "Login failed")),
        );
      }
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text("Error: $e")),
      );
    } finally {
      setState(() {
        _isLoading = false; // Hide CircularProgressIndicator after response
      });
    }
  }

  void signPage() {
    Navigator.push(
      context,
      MaterialPageRoute(builder: (context) => SignupPage()), // Replace with your signup page widget
    );
  }
  @override
  void dispose() {
    _scrollController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: () => FocusScope.of(context).unfocus(),
      child: Scaffold(
        backgroundColor: Colors.white,
        body: Stack(
          children: [
            // Animated SVG Background
            AnimatedPositioned(
              duration: Duration(milliseconds: 900),
              curve: Curves.easeInOut,
              top: _isAnimationComplete ? 0 : -300,
              left: 0,
              right: 0,
              child: SvgPicture.string(
                svgString,
                semanticsLabel: 'Animated Background SVG',
                width: MediaQuery.of(context).size.width,
                fit: BoxFit.fill,
              ),
            ),

            SafeArea(
              child: SingleChildScrollView(
                controller: _scrollController, // ✅ Added controller
                padding: const EdgeInsets.only(top: 260, bottom: 40),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // Welcome Text
                    Padding(
                      padding: const EdgeInsets.symmetric(horizontal: 40),
                      child: RichText(
                        textAlign: TextAlign.left,
                        text: TextSpan(
                          children: [
                            TextSpan(
                              text: 'Welcome\n',
                              style: GoogleFonts.signika(
                                fontSize: 42,
                                fontWeight: FontWeight.w500,
                                color: textPrimary,
                              ),
                            ),
                            TextSpan(
                              text: 'Back',
                              style: GoogleFonts.signika(
                                fontSize: 42,
                                fontWeight: FontWeight.w500,
                                color: textPrimary,
                              ),
                            ),
                          ],
                        ),
                      ),
                    ),

                    const SizedBox(height: 30),
                    Padding(
                      padding: const EdgeInsets.symmetric(horizontal: 40),
                      child: Column(
                        children: [
                          // Email
                          TextField(
                            controller: _emailController,
                            decoration: InputDecoration(
                              prefixIcon: Padding(
                                padding: const EdgeInsets.all(12),
                                child: SvgPicture.string(
                                  svgStringEmail,
                                  width: 30,
                                  height: 30,
                                ),
                              ),
                              labelText: 'Email',
                              labelStyle: GoogleFonts.signika(
                                fontSize: 20,
                                color: Colors.grey[700],
                              ),
                              border: UnderlineInputBorder(),
                            ),
                          ),
                          const SizedBox(height: 20),
                          TextField(
                            controller: _passwordController,
                            obscureText: _obscureText,
                            decoration: InputDecoration(
                              prefixIcon: Padding(
                                padding: const EdgeInsets.all(12),
                                child: SvgPicture.string(
                                  svgStringPass,
                                  width: 25,
                                  height: 25,
                                ),
                              ),
                              suffixIcon: IconButton(
                                icon: Icon(
                                  _obscureText ? Icons.visibility_off : Icons.visibility,
                                  color: Colors.grey,
                                ),
                                onPressed: _togglePasswordVisibility,
                              ),
                              labelText: 'Password',
                              labelStyle: GoogleFonts.signika(
                                fontSize: 20,
                                color: Colors.grey[700],
                              ),
                              border: UnderlineInputBorder(),
                            ),
                          ),
                          const SizedBox(height: 10),
                          Align(
                            alignment: Alignment.centerLeft,
                            child: TextButton(
                              onPressed: () {
                                Navigator.push(
                                  context,
                                  PageRouteBuilder(
                                    pageBuilder: (_, __, ___) => Resetpassword(),
                                    transitionsBuilder: (_, animation, __, child) {
                                      return SlideTransition(
                                        position: Tween<Offset>(
                                          begin: Offset(1.0, 0),
                                          end: Offset.zero,
                                        ).animate(CurvedAnimation(
                                          parent: animation,
                                          curve: Curves.easeInOut,
                                        )),
                                        child: child,
                                      );
                                    },
                                  ),
                                );
                              },
                              child: Text(
                                'Forgot Password?',
                                style: TextStyle(
                                  fontSize: 15,
                                  color: links,
                                  fontWeight: FontWeight.w500,
                                ),
                              ),
                            ),
                          ),
                          Column(
                            crossAxisAlignment: CrossAxisAlignment.stretch,
                            children: [
                              // Login Button
                              ElevatedButton(
                                onPressed: _isLoading ? null : _login,
                                style: ElevatedButton.styleFrom(
                                  backgroundColor: secondaryDark,
                                  disabledBackgroundColor: secondaryDark,
                                  padding: const EdgeInsets.symmetric(vertical: 16),
                                  shape: RoundedRectangleBorder(
                                    borderRadius: BorderRadius.circular(10),
                                  ),
                                ),
                                child: _isLoading
                                    ? SizedBox(
                                  width: 20,
                                  height: 20,
                                  child: CircularProgressIndicator(
                                    color: Colors.white,
                                    strokeWidth: 2,
                                  ),
                                )
                                    : Text(
                                  "Login",
                                  style: TextStyle(color: Colors.white, fontSize: 16),
                                ),
                              ),

                              const SizedBox(height: 12), // space between buttons
                              OutlinedButton(
                                onPressed: _isLoading ? null : signPage, // Call signPage() instead of _login
                                style: OutlinedButton.styleFrom(
                                  backgroundColor: Colors.white,
                                  side: BorderSide(color: Colors.black),
                                  padding: const EdgeInsets.symmetric(vertical: 16),
                                  shape: RoundedRectangleBorder(
                                    borderRadius: BorderRadius.circular(10),
                                  ),
                                ),
                                child: Text(
                                  "Signup",
                                  style: TextStyle(color: Colors.black, fontSize: 16),
                                ),
                              ),
                            ],
                          )
                        ],
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}

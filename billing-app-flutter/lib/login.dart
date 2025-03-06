import 'package:billing_application/dashboard.dart';
import 'package:billing_application/otp.dart';
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:google_fonts/google_fonts.dart';
import 'signup.dart';
import 'resetPassword.dart';
import 'otp.dart';
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

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: () {
        // Dismiss the keyboard and remove focus from input fields
        FocusScope.of(context).unfocus();
      },
      child: Scaffold(
        backgroundColor: Colors.white,
        body: Stack(
          children: [
            // Top SVG Image with Animation
            AnimatedPositioned(
              duration: Duration(milliseconds: 900),
              curve: Curves.easeInOut,
              top: _isAnimationComplete ? 0 : -300,
              left: 0,
              right: 0,
              child: SvgPicture.string(
                svgString,  // Render the modified SVG string with new colors
                semanticsLabel: 'Animated and Colored SVG',
                width: MediaQuery.of(context).size.width,
                fit: BoxFit.fill,
              )
            ),
            // Main Content
            Padding(
              padding: const EdgeInsets.only(top: 280),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 40),
                    child: RichText(
                      textAlign: TextAlign.left,
                      text: TextSpan(
                        children: [
                          TextSpan(
                            text: 'Welcome\n',
                            style: GoogleFonts.signika(
                              fontSize: 43,
                              fontWeight: FontWeight.normal,
                              color: textPrimary,
                              height: 1.2,
                            ),
                          ),
                          TextSpan(
                            text: 'Back',
                            style: GoogleFonts.signika(
                              fontSize: 43,
                              fontWeight: FontWeight.normal,
                              color: textPrimary,
                              height: 1.2,
                            ),
                          ),
                        ],
                      ),
                    ),
                  ),
                  const SizedBox(height: 30),
                  Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 48),
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        // Email Input Field
                        TextField(
                          controller: _emailController,
                          decoration: InputDecoration(
                            prefixIcon: Padding(
                              padding: const EdgeInsets.only(right: 14.0),
                              child: SvgPicture.string(
                                svgStringEmail, // Replace with your SVG icon
                                semanticsLabel: 'Email Icon',
                                width: 15,
                                height: 15,
                              ),
                            ),
                            labelText: 'Email',
                            labelStyle: GoogleFonts.signika(
                              fontSize: 20,
                              color: Color.fromRGBO(93, 98, 105, 0.7),
                            ),
                            filled: true,
                            fillColor: Colors.transparent,
                            border: UnderlineInputBorder(
                              borderSide: BorderSide(color: Colors.black),
                            ),
                          ),
                        ),
                        const SizedBox(height: 20),

                        // Password Input Field
                        TextField(
                          controller: _passwordController,
                          obscureText: _obscureText,
                          decoration: InputDecoration(
                            prefixIcon: Padding(
                              padding: const EdgeInsets.only(right: 18.0),
                              child: SvgPicture.string(
                                svgStringPass, // Replace with your SVG icon
                                semanticsLabel: 'Password Icon',
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
                              color: Color.fromRGBO(93, 98, 105, 0.7),
                            ),
                            border: UnderlineInputBorder(
                              borderSide: BorderSide(color: Colors.black),
                            ),
                          ),
                        ),
                        const SizedBox(height: 10),
                        Align(
                          alignment: Alignment.centerLeft,
                          child: GestureDetector(
                            onTap: () {
                              Navigator.push(
                                context,
                                PageRouteBuilder(
                                  pageBuilder: (context, animation,
                                      secondaryAnimation) =>
                                      Resetpassword(),
                                  transitionsBuilder: (context, animation,
                                      secondaryAnimation, child) {
                                    const begin = Offset(1.0, 0.0);
                                    const end = Offset.zero;
                                    const curve = Curves.easeInOut;
                                    var tween = Tween(begin: begin, end: end)
                                        .chain(CurveTween(curve: curve));
                                    var offsetAnimation =
                                    animation.drive(tween);

                                    return SlideTransition(
                                      position: offsetAnimation,
                                      child: child,
                                    );
                                  },
                                ),
                              );
                            },
                            child: Text(
                              'Forgot Password?',
                              style: TextStyle(
                                fontSize: 16,
                                color: links,
                                fontWeight: FontWeight.w500,
                              ),
                            ),
                          ),
                        ),
                        const SizedBox(height: 20),
                        // Submit Button
                        Align(
                          alignment: Alignment.centerRight,
                          child: ElevatedButton(
                            onPressed: _isLoading ? null : _login, // Disable button while loading
                            style: ElevatedButton.styleFrom(
                              shape: CircleBorder(),
                              backgroundColor: secondaryDark, // Normal state color
                              disabledBackgroundColor: secondaryDark, // Ensures color stays when disabled
                              padding: const EdgeInsets.all(18),
                            ),
                            child: _isLoading
                                ? SizedBox(
                              width: 30, // Make it smaller
                              height: 30,
                              child: CircularProgressIndicator(
                                color: Colors.white,
                                strokeWidth: 2, // Make it thinner
                              ),
                            )
                                : Icon(Icons.arrow_forward, color: Colors.white, size: 28),
                          ),
                        ),

                      ],
                    ),
                  ),
                  const SizedBox(height: 20),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      ElevatedButton.icon(
                        onPressed: () {},
                        style: ElevatedButton.styleFrom(
                          backgroundColor: Color(0xFF2B48AA),
                          side: const BorderSide(color: Color(0xFF2B48AA)),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(7),
                          ),
                          minimumSize: const Size(140, 48),
                        ),
                        label: const Text(
                          'Facebook',
                          style: TextStyle(fontSize: 19, color: Colors.white, fontWeight: FontWeight.w400),
                        ),
                        icon: SvgPicture.asset(
                          'assets/facebook.svg',
                          width: 28,
                          height: 28,
                        ),
                      ),
                      const SizedBox(width: 20),
                      ElevatedButton.icon(
                        onPressed: () {},
                        style: ElevatedButton.styleFrom(
                          backgroundColor: Colors.white,
                          side: const BorderSide(color: Color.fromRGBO(44, 49, 57, 0.5)),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(7),
                          ),
                          minimumSize: const Size(154, 48),
                        ),
                        label: const Text(
                          'Google',
                          style: TextStyle(fontSize: 19, fontWeight: FontWeight.w400),
                        ),
                        icon: SvgPicture.asset(
                          'assets/google.svg',
                          width: 24,
                          height: 24,
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 30),
                  Center(
                    child: GestureDetector(
                      onTap: () {
                        Navigator.push(
                          context,
                          PageRouteBuilder(
                            pageBuilder: (context, animation,
                                secondaryAnimation) =>
                                SignupPage(),
                            transitionsBuilder: (context, animation,
                                secondaryAnimation, child) {
                              const begin = Offset(1.0, 0.0);
                              const end = Offset.zero;
                              const curve = Curves.easeInOut;
                              var tween = Tween(begin: begin, end: end)
                                  .chain(CurveTween(curve: curve));
                              var offsetAnimation =
                              animation.drive(tween);

                              return SlideTransition(
                                position: offsetAnimation,
                                child: child,
                              );
                            },
                          ),
                        );
                      },
                      child:  Text(
                        'Are you a new User? Register',
                        style: TextStyle(
                          color: links, // Fallback color
                          fontSize: 16,
                          fontWeight: FontWeight.w500,
                        ),
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}

import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:google_fonts/google_fonts.dart';
import 'login.dart';
import 'colors.dart';
import 'package:flutter/services.dart';  // To load the SVG as a string

class SignupPage extends StatefulWidget {
  @override
  _SignupPageState createState() => _SignupPageState();
}

class _SignupPageState extends State<SignupPage> {
  bool _isAnimationComplete = false;
  bool _obscureText = true;
  String svgString = '';
  String svgStringName = '';
  String svgStringPass = '';
  String svgStringEmail = '';  Color? primaryLight;
  Color? secondaryLight; // Assuming color2 is also a dynamic color
  Color? secondaryDark; // Assuming color2 is also a dynamic color
  Color? primaryDark;
  Color? svgSignup;
  Color? links;
  Color? textPrimary;

  void _togglePasswordVisibility() {
    setState(() {
      _obscureText = !_obscureText;
    });
  }

  @override
  void initState() {
    super.initState();
    AppColors.fetchColors().then((_) {
      setState(() {
        secondaryLight = AppColors.secondaryLight;
        primaryLight = AppColors.primaryLight; // Replace with actual dynamic color
        primaryDark = AppColors.primaryDark; // Replace with actual dynamic color
        svgSignup = AppColors.svgSignup; // Replace with actual dynamic color
        secondaryDark = AppColors.secondaryDark; // Replace with actual dynamic color
        links = AppColors.links; // Replace with actual dynamic color
        textPrimary = AppColors.textPrimary;
      });

      // Load SVG after colors are fetched
      loadSvgNameIcon();
      loadSvgPasswordIcon();
      loadSvgEmailIcon();
      loadSvg();
    });
    // Start the animation after a delay
    Future.delayed(Duration(milliseconds: 200), () {
      setState(() {
        _isAnimationComplete = true;
      });
    });
  }
  Future<void> loadSvg() async {
    if (secondaryLight != null && primaryLight != null && primaryDark != null) {
      String svg = await rootBundle.loadString('assets/signup_upper_shape.svg');
      setState(() {
        // Replace placeholders with actual colors in hex format
        svgString = svg.replaceAll(
          'PLACEHOLDER_COLOR_1', _colorToHex(svgSignup!),
        ).replaceAll(
          'PLACEHOLDER_COLOR_2', _colorToHex(secondaryDark!),
        ).replaceAll(
          'PLACEHOLDER_COLOR_3', _colorToHex(primaryDark!),
        ).replaceAll(
          'PLACEHOLDER_COLOR_4', _colorToHex(secondaryLight!),
        ).replaceAll(
          'PLACEHOLDER_COLOR_5', _colorToHex(secondaryDark!),
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
  Future<void> loadSvgNameIcon() async {
    if (secondaryDark != null && links != null && primaryDark != null) {
      String svgname = await rootBundle.loadString('assets/name_icon.svg');
      setState(() {
        // Replace placeholders with actual colors in hex format
        svgStringName = svgname.replaceAll(
          'ICON_COLOR_1', _colorToHex(links!),
        );
      });
    }
  }
  String _colorToHex(Color color) {
    return '#${color.value.toRadixString(16).substring(2).toUpperCase()}';
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
          // Top SVG Image
          AnimatedPositioned(
            duration: Duration(milliseconds: 900),
            curve: Curves.easeInOut,
            top: _isAnimationComplete ? -50 : -400, // Animate from -200 to 0
            left: 0,
            right: 0,
            child: svgString.isNotEmpty
                ? SvgPicture.string(
              svgString,  // Render the modified SVG string with new colors
              semanticsLabel: 'Animated and Colored SVG',
              fit: BoxFit.fill,
              height: 300,  // Height of the SVG
            )
                : CircularProgressIndicator(), // Show loading indicator until the SVG is ready
          ),
          // Main Content
          Padding(
            padding: const EdgeInsets.only(top: 230),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // Title
                  Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 40),
                    child: RichText(
                      textAlign: TextAlign.left,
                      text: TextSpan(
                        children: [
                          TextSpan(
                            text: 'Create\n',
                            style: GoogleFonts.signika(
                              fontSize: 43,
                              fontWeight: FontWeight.normal,
                              color: textPrimary,
                              height: 1.2,
                            ),
                          ),
                          TextSpan(
                            text: 'Account',
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
                  const SizedBox(height: 20),
                  Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 48),
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        // Email Input Field
                        TextField(
                          decoration: InputDecoration(
                            prefixIcon: Padding(
                              padding: const EdgeInsets.only(right: 14.0),
                              child: svgStringName.isNotEmpty
                                  ? SvgPicture.string(
                                svgStringName, // Render the modified SVG string with new colors
                                semanticsLabel: 'Animated and Colored SVG',
                                width: 15,
                                height: 15,
                              )
                                  : const CircularProgressIndicator(), // Show loading indicator until the SVG is ready
                            ),
                            labelText: 'Name',
                            labelStyle: GoogleFonts.signika(
                              fontSize: 20,
                              fontWeight: FontWeight.normal,
                              color: Color.fromRGBO(93, 98, 105, 0.7),
                              height: 1.5,
                            ),
                            filled: true,
                            fillColor: Colors.transparent,
                            border: InputBorder.none,
                            enabledBorder: UnderlineInputBorder(
                              borderSide: BorderSide(color: Colors.black),
                            ),
                            focusedBorder: UnderlineInputBorder(
                              borderSide: BorderSide(color: Colors.blue),
                            ),
                            contentPadding: EdgeInsets.symmetric(vertical: 0.0),
                          ),
                        ),
                        const SizedBox(height: 20),
                        TextField(
                          decoration: InputDecoration(
                            prefixIcon: Padding(
                              padding: const EdgeInsets.only(right: 14.0),
                              child: svgStringEmail.isNotEmpty
                                  ? SvgPicture.string(
                                svgStringEmail, // Render the modified SVG string with new colors
                                semanticsLabel: 'Animated and Colored SVG',
                                width: 15,
                                height: 15,
                              )
                                  : const CircularProgressIndicator(), // Show loading indicator until the SVG is ready
                            ),
                            labelText: 'Email',
                            labelStyle: GoogleFonts.signika(
                              fontSize: 20,
                              fontWeight: FontWeight.normal,
                              color: Color.fromRGBO(93, 98, 105, 0.7),
                              height: 1.5,
                            ),
                            filled: true,
                            fillColor: Colors.transparent,
                            border: InputBorder.none,
                            enabledBorder: UnderlineInputBorder(
                              borderSide: BorderSide(color: Colors.black),
                            ),
                            focusedBorder: UnderlineInputBorder(
                              borderSide: BorderSide(color: Colors.blue),
                            ),
                            contentPadding: EdgeInsets.symmetric(vertical: 0.0),
                          ),
                        ),
                        const SizedBox(height: 20),
                        // Password Input Field
                        TextField(
                          obscureText: _obscureText,
                          decoration: InputDecoration(
                            prefixIcon: Padding(
                              padding: const EdgeInsets.only(right: 18.0),
                              child: svgStringPass.isNotEmpty
                                  ? SvgPicture.string(
                                svgStringPass, // Render the modified SVG string with new colors
                                semanticsLabel: 'Animated and Colored SVG',
                                width: 25,
                                height: 25,
                              )
                                  : const CircularProgressIndicator(), // Show loading indicator until the SVG is ready
                            ),
                            suffixIcon: IconButton(
                              icon: Icon(
                                _obscureText
                                    ? Icons.visibility_off
                                    : Icons.visibility,
                                color: Colors.grey,
                              ),
                              onPressed: _togglePasswordVisibility,
                            ),
                            labelText: 'Password',
                            labelStyle: GoogleFonts.signika(
                              fontSize: 20,
                              fontWeight: FontWeight.normal,
                              color: Color.fromRGBO(93, 98, 105, 0.7),
                              height: 1.2,
                            ),
                            filled: true,
                            fillColor: Colors.transparent,
                            border: InputBorder.none,
                            enabledBorder: UnderlineInputBorder(
                              borderSide: BorderSide(color: Colors.black),
                            ),
                            focusedBorder: UnderlineInputBorder(
                              borderSide: BorderSide(color: Colors.blue),
                            ),
                            contentPadding: EdgeInsets.symmetric(vertical: 0.0),
                          ),
                        ),
                        const SizedBox(height: 30),
                        // Submit Button
                        Align(
                          alignment: Alignment.centerRight,
                          child: ElevatedButton(
                            onPressed: () {},
                            style: ElevatedButton.styleFrom(
                              shape: const CircleBorder(),
                              backgroundColor: primaryDark,
                              padding: const EdgeInsets.all(18),
                            ),
                            child: const Icon(
                              Icons.arrow_forward,
                              color: Colors.white,
                              size: 28,
                            ),
                          ),
                        ),
                        const SizedBox(height: 5),
                        // Continue with Text
                        Center(
                          child: Text(
                            'or Continue with',
                            style: TextStyle(
                              fontSize: 16,
                              color: textPrimary,
                              fontWeight: FontWeight.w500,
                            ),
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
                            pageBuilder: (context, animation, secondaryAnimation) => LoginPage(),
                            transitionsBuilder: (context, animation, secondaryAnimation, child) {
                              const begin = Offset(1.0, 0.0);
                              const end = Offset.zero;
                              const curve = Curves.easeInOut;
                              var tween = Tween(begin: begin, end: end).chain(CurveTween(curve: curve));
                              var offsetAnimation = animation.drive(tween);

                              return SlideTransition(
                                position: offsetAnimation,
                                child: child,
                              );
                            },
                          ),
                        );
                      },
                      child: Text(
                        'Are you already a User? Login',
                        style: TextStyle(
                          color: textPrimary,
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
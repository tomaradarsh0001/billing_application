import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:google_fonts/google_fonts.dart';
import 'login.dart';
import 'package:flutter/services.dart';  // To load the SVG as a string
import 'main.dart';

class Resetpassword extends StatefulWidget {
  @override
  _ResetpasswordState createState() => _ResetpasswordState();
}

class _ResetpasswordState extends State<Resetpassword> {
  bool _isAnimationComplete = false;
  String svgString = '';
  String svgStringEmail = '';
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

      // Load SVG after colors are fetched
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
      String svg = await rootBundle.loadString('assets/password_upper_shape.svg');
      setState(() {
        // Replace placeholders with actual colors in hex format
        svgString = svg.replaceAll(
          'PLACEHOLDER_COLOR_1', _colorToHex(svgLogin!),
        ).replaceAll(
          'PLACEHOLDER_COLOR_2', _colorToHex(secondaryDark!),
        ).replaceAll(
          'PLACEHOLDER_COLOR_3', _colorToHex(primaryDark!),
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
              padding: const EdgeInsets.only(top: 200),
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
                            text: 'Reset\n',
                            style: GoogleFonts.signika(
                              fontSize: 43,
                              fontWeight: FontWeight.normal,
                              color: textPrimary,
                              height: 1.2,
                            ),
                          ),
                          TextSpan(
                            text: 'Password',
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
                          decoration: InputDecoration(
                            prefixIcon: Padding(
                              padding: const EdgeInsets.only(right: 14.0),
                              child: SvgPicture.string(
                                svgStringEmail, // Render the modified SVG string with new colors
                                semanticsLabel: 'Animated and Colored SVG',
                                width: 15,
                                height: 15,
                              )
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
                                      LoginPage(),
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
                              'Back to Login?',
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
                      ],
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

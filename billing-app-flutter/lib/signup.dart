import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:google_fonts/google_fonts.dart';
import 'login.dart';

class SignupPage extends StatefulWidget {
  @override
  _SignupPageState createState() => _SignupPageState();
}

class _SignupPageState extends State<SignupPage> {
  bool _isAnimationComplete = false;
  bool _obscureText = true;

  void _togglePasswordVisibility() {
    setState(() {
      _obscureText = !_obscureText;
    });
  }

  @override
  void initState() {
    super.initState();
    // Start the animation after a delay
    Future.delayed(Duration(milliseconds: 200), () {
      setState(() {
        _isAnimationComplete = true;
      });
    });
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
            top: _isAnimationComplete ? -20 : -400, // Animate from -200 to 0
            left: 0,
            right: 0,
            child: SvgPicture.asset(
              'assets/signup_upper_shape.svg',
              width: MediaQuery.of(context).size.width,
              fit: BoxFit.cover,
            ),
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
                              color: const Color(0xFF649AD9),
                              height: 1.2,
                            ),
                          ),
                          TextSpan(
                            text: 'Account',
                            style: GoogleFonts.signika(
                              fontSize: 43,
                              fontWeight: FontWeight.normal,
                              color: const Color(0xFF649AD9),
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
                              child: SvgPicture.asset(
                                'assets/name_icon.svg',
                                height: 15,
                                width: 15,
                              ),
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
                              child: SvgPicture.asset(
                                'assets/email_icon.svg',
                                height: 15,
                                width: 15,
                              ),
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
                              child: SvgPicture.asset(
                                'assets/password_icon.svg',
                                height: 25,
                                width: 25,
                              ),
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
                              backgroundColor: Color(0xFF649AD9),
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
                              color: Color(0xFF2B48AA),
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
                      child: const Text(
                        'Are you already a User? Login',
                        style: TextStyle(
                          color: Color(0xFF2B48AA),
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
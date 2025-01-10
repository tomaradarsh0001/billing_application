import 'package:billing_application/dashboard.dart';
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'dashboard.dart';
import 'colors.dart';
import 'package:flutter/services.dart';  // To load the SVG as a string
import 'CustomerAddedSuccessfullyPage.dart';
import 'CustomerDeletedSuccessfullyPage.dart';

class OtpPage extends StatefulWidget {
  @override
  _OtpPageState createState() => _OtpPageState();
}

class _OtpPageState extends State<OtpPage> {
  bool _isAnimationComplete = false;
  bool _canResendOtp = false;
  int _resendOtpTimer = 30;
  String svgString = '';
  Color? primaryLight;
  Color? secondaryLight; // Assuming color2 is also a dynamic color
  Color? secondaryDark; // Assuming color2 is also a dynamic color
  Color? primaryDark;
  Color? svgSignup;
  Color? links;
  Color? textPrimary;

  List<FocusNode> _focusNodes = List.generate(4, (_) => FocusNode());

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
      loadSvg();
    });
    Future.delayed(Duration(milliseconds: 200), () {
      setState(() {
        _isAnimationComplete = true;
      });
    });
    _startResendOtpTimer();
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
  @override
  void dispose() {
    for (var node in _focusNodes) {
      node.dispose();
    }
    super.dispose();
  }

  void _startResendOtpTimer() {
    Future.delayed(Duration(seconds: 1), () {
      if (_resendOtpTimer > 0) {
        setState(() {
          _resendOtpTimer--;
        });
        _startResendOtpTimer();
      } else {
        setState(() {
          _canResendOtp = true;
        });
      }
    });
  }

  void _resendOtp() {
    if (_canResendOtp) {
      setState(() {
        _resendOtpTimer = 30;
        _canResendOtp = false;
      });
      _startResendOtpTimer();

      // Show toast message
      Fluttertoast.showToast(
        msg: "OTP Sent Successfully",
        toastLength: Toast.LENGTH_SHORT,
        gravity: ToastGravity.BOTTOM,
        backgroundColor: Colors.green,
        textColor: Colors.white,
        fontSize: 16.0,
      );
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
        FocusScope.of(context).unfocus();
      },
      child: Scaffold(
        backgroundColor: Colors.white,
        body: Stack(
          children: [
            AnimatedPositioned(
              duration: Duration(milliseconds: 1200),
              curve: Curves.easeInOut,
              top: _isAnimationComplete ? -50 : -400,
              left: 0,
              right: 0,
              child:  SvgPicture.string(
                svgString,  // Render the modified SVG string with new colors
                semanticsLabel: 'Animated and Colored SVG',
                fit: BoxFit.fill,
                height: 300,  // Height of the SVG
              )
            ),
            Padding(
              padding: const EdgeInsets.only(top: 250),
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
                            text: 'Enter OTP\n',
                            style: GoogleFonts.signika(
                              fontSize: 43,
                              fontWeight: FontWeight.normal,
                              color: textPrimary,
                              height: 1.0,
                            ),
                          ),
                        ],
                      ),
                    ),
                  ),
                  const SizedBox(height: 0),
                  Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 40),
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          "Please enter the 4-digit OTP sent to your email\n to verify your email address.",
                          textAlign: TextAlign.center,
                          style: TextStyle(
                            fontSize: 14,
                            color: Colors.grey.shade600,
                          ),
                        ),
                        const SizedBox(height: 20),
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: List.generate(
                            4,
                                (index) => Container(
                              width: 50,
                              height: 50,
                              decoration: BoxDecoration(
                                border: Border.all(color: Colors.grey.shade400),
                                borderRadius: BorderRadius.circular(8),
                              ),
                              child: TextField(
                                focusNode: _focusNodes[index],
                                textAlign: TextAlign.center,
                                keyboardType: TextInputType.number,
                                maxLength: 1,
                                decoration: const InputDecoration(
                                  counterText: "",
                                  border: InputBorder.none,
                                ),
                                style: const TextStyle(fontSize: 20),
                                onChanged: (value) {
                                  if (value.isNotEmpty && index < 3) {
                                    FocusScope.of(context)
                                        .requestFocus(_focusNodes[index + 1]);
                                  } else if (value.isEmpty && index > 0) {
                                    FocusScope.of(context)
                                        .requestFocus(_focusNodes[index - 1]);
                                  }
                                },
                              ),
                            ),
                          ),
                        ),
                        const SizedBox(height: 20),
                        // Resend OTP Text/Button
                        GestureDetector(
                          onTap: _canResendOtp ? _resendOtp : null,
                          child: Text(
                            _canResendOtp
                                ? "Resend OTP"
                                : "Resend OTP in $_resendOtpTimer seconds",
                            style: TextStyle(
                              fontSize: 14,
                              color: _canResendOtp
                                  ? textPrimary
                                  : Colors.grey.shade600,
                            ),
                          ),
                        ),
                        const SizedBox(height: 30),
                        Align(
                          alignment: Alignment.centerRight,
                          child: ElevatedButton(
                            onPressed: () {
                              Navigator.push(
                                context,
                                PageRouteBuilder(
                                  pageBuilder: (context, animation,
                                      secondaryAnimation) =>
                                      // DashboardPage(),
                                  CustomerDeletedSuccessfullyPage(),
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

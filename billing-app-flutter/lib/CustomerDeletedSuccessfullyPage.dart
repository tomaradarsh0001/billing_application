import 'package:flutter/material.dart';
import 'package:lottie/lottie.dart';
import 'package:google_fonts/google_fonts.dart';
import 'customerview.dart';

class CustomerDeletedSuccessfullyPage extends StatefulWidget {
  @override
  _CustomerDeletedSuccessfullyPageState createState() =>
      _CustomerDeletedSuccessfullyPageState();
}

class _CustomerDeletedSuccessfullyPageState
    extends State<CustomerDeletedSuccessfullyPage> with TickerProviderStateMixin {
  late final AnimationController _controller;

  @override
  void initState() {
    super.initState();
    // Initialize the animation controller with a duration
    _controller = AnimationController(
      vsync: this,
      duration: const Duration(seconds: 3), // Set the duration of the animation
    );

    // Listen for when the animation ends to navigate
    _controller.addStatusListener((status) {
      if (status == AnimationStatus.completed) {
        // Redirect to CustomerDetailsPage after animation ends
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (context) => CustomerViewPage()),
        );
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      home: Scaffold(
        backgroundColor: Colors.red,
        body: Center( // Added Center to align the column in the middle
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              const SizedBox(height: 0), // Placeholder height, can be removed
              Lottie.asset(
                'assets/delete.json',
                width: 200,
                height: 200,
                controller: _controller,
                onLoaded: (composition) {
                  _controller.forward(); // Start the animation once it's loaded
                },
              ),
              const SizedBox(height: 0),
              Text(
                'SUCCESS',
                style: GoogleFonts.lunasima(
                  textStyle: const TextStyle(
                    color: Colors.white,
                    fontSize: 28,
                    fontWeight: FontWeight.bold,
                  ),
                ),
              ),
              const SizedBox(height: 5),
              Text(
                'Customer Deleted Successfully',
                style: GoogleFonts.sarabun(
                  textStyle: const TextStyle(
                    color: Colors.white,
                    fontSize: 15,
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
  @override
  void dispose() {
    _controller.dispose(); // Dispose the controller when no longer needed
    super.dispose();
  }
}

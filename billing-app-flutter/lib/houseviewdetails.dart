import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'dart:convert';
import 'package:intl/intl.dart';
import 'package:flutter/services.dart';
import 'main.dart';
import 'package:shimmer/shimmer.dart';
import 'package:shared_preferences/shared_preferences.dart';

class HouseViewDetails extends StatefulWidget {
  final int id;

  const HouseViewDetails({super.key, required this.id});

  @override
  State<HouseViewDetails> createState() => _HouseViewDetailsState();
}

class _HouseViewDetailsState extends State<HouseViewDetails> {
  Map<String, dynamic>? data;
  bool isLoading = true;
  String? error;
  String svgString = '';
  Color? primaryLight;
  Color? secondaryLight; // Assuming color2 is also a dynamic color
  Color? secondaryDark; // Assuming color2 is also a dynamic color
  Color? primaryDark;
  Color? svgLogin;
  Color? links;
  Color? textPrimary;
  String svgStringIcon = '';
  bool? _isDarkMode;
  bool _isLoading = true;
  bool _isAnimationComplete = false;
  Map<String, dynamic>? _customerDetails;

  @override
  void initState() {
    super.initState();
    fetchOccupantData();
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
      loadSvg();
      loadSvgIcon();

    });
    Future.delayed(Duration(milliseconds: 200), () {
      setState(() {
        _isAnimationComplete = true;
      });
    });
  }

  Future<void> fetchOccupantData() async {
    final url = Uri.parse(
        'http://ec2-13-39-111-189.eu-west-3.compute.amazonaws.com:100/api/billing/occupants/${widget.id}');
    try {
      final response = await http.get(url);

      if (response.statusCode == 200) {
        final result = json.decode(response.body);
        setState(() {
          data = result; // ✅ Direct assignment
          isLoading = false;
        });
      } else {
        setState(() {
          error = 'Failed to load data (Status ${response.statusCode})';
          isLoading = false;
        });
      }
    } catch (e) {
      setState(() {
        error = 'Error occurred: $e';
        isLoading = false;
      });
    }
  }
  Future<void> loadSvg() async {
    if (secondaryLight != null && primaryLight != null && primaryDark != null) {
      String svg = await rootBundle.loadString('assets/screen_upper_shape.svg');
      setState(() {
        // Replace placeholders with actual colors in hex format
        svgString = svg.replaceAll(
          'PLACEHOLDER_COLOR_1', _colorToHex(primaryLight!),
        ).replaceAll(
          'PLACEHOLDER_COLOR_2', _colorToHex(primaryDark!),
        );
      });
    }
  }

  String _colorToHex(Color color) {
    return '#${color.value.toRadixString(16).substring(2).toUpperCase()}';
  }

  Future<void> loadSvgIcon() async {
    if (secondaryLight != null && primaryLight != null && primaryDark != null) {
      String svg = await rootBundle.loadString('assets/customer_icon.svg');
      setState(() {
        svgStringIcon = svg.replaceAll(
          'PLACEHOLDER_1', _isDarkMode == true ? '#666564' : _colorToHex(secondaryLight ?? Colors.grey),
        ).replaceAll(
          'PLACEHOLDER_2', _isDarkMode == true ? '#000000' : _colorToHex(svgLogin ?? Colors.black),
        ).replaceAll(
          'PLACEHOLDER_3', _isDarkMode == true ? '#000000' : _colorToHex(svgLogin ?? Colors.black),
        ).replaceAll(
          'PLACEHOLDER_4', _isDarkMode == true ? '#000000' : _colorToHex(primaryDark ?? Colors.black),
        );
      });
    }
  }
  Future<void> _onRefresh() async {
    setState(() {
      _isLoading = true;  // Show loading indicator
    });
    await fetchOccupantData();  // Fetch the data again
  }
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: Stack(
        children: [
          // Animated Upper Shape
          AnimatedPositioned(
            duration: const Duration(milliseconds: 900),
            curve: Curves.easeInOut,
            top: _isAnimationComplete ? 0 : -400,
            left: 0,
            right: 0,
            child: SvgPicture.string(
              svgString,
              semanticsLabel: 'Animated and Colored SVG',
              fit: BoxFit.fill,
              height: 300,
            ),
          ),
          Column(
            children: [
              // Header Section with Back Button and Title
              Padding(
                padding: const EdgeInsets.fromLTRB(10.0, 10.0, 10.0, 0.0),
                child: Column(
                  children: [
                    const SizedBox(height: 50),
                    Row(
                      children: [
                        IconButton(
                          icon: SvgPicture.asset(
                            'assets/backarrow.svg',
                            width: 30,
                            height: 30,
                            color: Colors.white,
                          ),
                          onPressed: () {
                            Navigator.pop(context);
                          },
                        ),
                        Expanded(
                          child: Text(
                            "Houses",
                            style: GoogleFonts.signika(
                              color: Colors.white,
                              fontSize: 29,
                              fontWeight: FontWeight.normal,
                            ),
                            textAlign: TextAlign.left,
                          ),
                        ),
                      ],
                    ),
                    const SizedBox(height: 115),
                    AnimatedOpacity(
                      opacity: _isAnimationComplete ? 1.0 : 0.0,
                      duration: const Duration(milliseconds: 700),
                      curve: Curves.easeIn,
                      child: CircleAvatar(
                        radius: 60,
                        child: ClipOval(
                          child: SvgPicture.string(
                            svgStringIcon,
                            semanticsLabel: 'House Icon',
                            width: 120,
                            height: 120,
                            fit: BoxFit.cover,
                          ),
                        ),
                      ),
                    ),
                    const SizedBox(height: 5),
                    Row(
                      children: [
                        const SizedBox(width: 5),
                        Text(
                          "House Information",
                          style: GoogleFonts.signika(
                            color: Color(0xFFAFB0B1),
                            fontSize: 20,
                            fontWeight: FontWeight.normal,
                          ),
                        ),
                        const Spacer(),
                        IconButton(
                          padding: EdgeInsets.zero,
                          icon: SvgPicture.asset('assets/delete.svg', width: 21, height: 21),
                          onPressed: () {},
                        ),
                        IconButton(
                          padding: EdgeInsets.zero,
                          icon: SvgPicture.asset('assets/edit.svg', width: 21, height: 21),
                          onPressed: () {
                            Navigator.pop(context);
                          },
                        ),
                      ],
                    )
                  ],
                ),
              ),
              // Details Section with Scroll and Refresh
              Expanded(
                child: Container(
                  color: Colors.white,
                  child: isLoading
                      ? Column(
                    children: List.generate(10, (index) => _buildShimmerDetailField()),
                  )
                      : RefreshIndicator(
                    onRefresh: _onRefresh,
                    child: SingleChildScrollView(
                      padding: const EdgeInsets.fromLTRB(10.0, 0.0, 10.0, 0.0),
                      child: Column(
                        children: [
                          _buildDetailField("Name", "${data?["first_name"] ?? ""} ${data?["last_name"] ?? ""}"),
                          _buildDetailField("Mobile", "+${data?['phone_code']?["phonecode"] ?? ""} ${data?["mobile"] ?? ""}"),
                          _buildDetailField("Email", data?["email"] ?? ""),
                          _buildDetailField("House No", data?["house"]?["hno"] ?? ""),
                          _buildDetailField("Area", data?["house"]?["area"] ?? ""),
                          _buildDetailField("Landmark", data?["house"]?["landmark"] ?? ""),
                          _buildDetailField("City", data?["house"]?["city"] ?? ""),
                          _buildDetailField("State", data?["house"]?["state"] ?? ""),
                          _buildDetailField("Country", data?["house"]?["country"] ?? ""),
                          _buildDetailField("Pincode", data?["house"]?["pincode"] ?? ""),
                        ],
                      ),
                    ),
                  ),
                ),
              ),
            ],
          ),
          // Optional loading indicator in center
          if (isLoading)
            const Center(
              child: CircularProgressIndicator(),
            ),
        ],
      ),
    );
  }

// Reuse shimmer widget for loading
  Widget _buildShimmerDetailField() {
    return Padding(
      padding: const EdgeInsets.only(bottom: 0.0, left: 5),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Shimmer.fromColors(
            baseColor: Colors.grey[300]!,
            highlightColor: Colors.grey[100]!,
            child: Container(width: 120, height: 16, color: Colors.grey),
          ),
          const SizedBox(height: 4),
          Shimmer.fromColors(
            baseColor: Colors.grey[300]!,
            highlightColor: Colors.grey[100]!,
            child: Container(width: double.infinity, height: 20, color: Colors.grey),
          ),
          const Divider(color: Color(0xFFE0E0E0)),
        ],
      ),
    );
  }

// Reuse detail field widget
  Widget _buildDetailField(String label, String? value) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 0.0, left: 5),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            label,
            style: const TextStyle(
              fontSize: 12,
              fontWeight: FontWeight.bold,
              color: Color(0xFFAFB0B1),
            ),
          ),
          const SizedBox(height: 4),
          Text(
            value ?? "",
            style: const TextStyle(
              fontSize: 14,
              fontWeight: FontWeight.w400,
              color: Colors.black,
            ),
          ),
          const Divider(color: Color(0xFFE0E0E0)),
        ],
      ),
    );
  }

}

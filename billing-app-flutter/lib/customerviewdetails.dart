import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:flutter_svg/flutter_svg.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'dart:convert';
import 'package:intl/intl.dart';
import 'package:flutter/services.dart';
import 'main.dart';
import 'package:shimmer/shimmer.dart';

class CustomerDetailsPage extends StatefulWidget {
  final int customerId;

  CustomerDetailsPage({required this.customerId});

  @override
  _CustomerDetailsPageState createState() => _CustomerDetailsPageState();
}

class _CustomerDetailsPageState extends State<CustomerDetailsPage> {
  bool _isLoading = true;

  bool _isAnimationComplete = false;
  Map<String, dynamic>? _customerDetails;
  final String baseUrl = "http://ec2-13-39-111-189.eu-west-3.compute.amazonaws.com:100/api/customers/";
  String svgString = '';
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
      loadSvg();
      _fetchCustomerDetails();

    });
    Future.delayed(Duration(milliseconds: 200), () {
      setState(() {
        _isAnimationComplete = true;
      });
    });
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
  // Fetch customer details from the API
  Future<void> _fetchCustomerDetails() async {
    final String apiUrl = '$baseUrl${widget.customerId}';
    try {
      final response = await http.get(Uri.parse(apiUrl));
      if (response.statusCode == 200) {
        setState(() {
          _customerDetails = json.decode(response.body);
          _isLoading = false;
        });
      } else {
        throw Exception('Failed to load customer details');
      }
    } catch (e) {
      setState(() {
        _isLoading = false;
      });
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Error fetching customer details: $e')),
      );
    }
  }

  // Delete customer from the API
  Future<void> deleteCustomer(int customerId) async {
    final response = await http.delete(Uri.parse('$baseUrl$customerId'));

    if (response.statusCode == 200) {
      // Successfully deleted
      Fluttertoast.showToast(
        msg: "Customer deleted successfully",
        toastLength: Toast.LENGTH_SHORT,
        gravity: ToastGravity.BOTTOM,
        backgroundColor: Colors.red, // Custom red color for toast
        textColor: Colors.white,
        fontSize: 16.0,
      );

      // Navigate back to previous page
      Navigator.pop(context);
    } else {
      // If the server returns an error
      Fluttertoast.showToast(
        msg: "Failed to delete customer",
        toastLength: Toast.LENGTH_SHORT,
        gravity: ToastGravity.BOTTOM,
        backgroundColor: Colors.red, // Custom red color for toast
        textColor: Colors.white,
        fontSize: 16.0,
      );
    }
  }
  Future<void> showDeleteConfirmationDialog(BuildContext context) async {
    showDialog(
      context: context,
      barrierDismissible: false, // Prevent dismissing by tapping outside
      builder: (BuildContext context) {
        return Dialog(
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12), // Border radius set to 8
          ),
          child: Container(
            decoration: BoxDecoration(
              color: Colors.white, // Background color
              border: Border.all(color: Colors.red, width: 2), // Red border
              borderRadius: BorderRadius.circular(12), // Rounded corners
            ),
            width: MediaQuery.of(context).size.width * 0.9, // Dialog width (90% of screen width)
            padding: EdgeInsets.symmetric(horizontal: 20, vertical: 30),
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                // Confirmation message
                Text(
                  "Are you surely want to Delete?",
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                    color: Colors.black,
                  ),
                  textAlign: TextAlign.center,
                ),
                const SizedBox(height: 20),
                SvgPicture.asset(
                  'assets/delete_confirmation.svg', // Replace with the actual path to your SVG
                  height: 100,
                  width: 100,
                ),
                const SizedBox(height: 20),
                // Buttons
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                  children: [
                    // Cancel button
                    SizedBox(
                      width: 120,
                      height: 38,// Ensure both buttons have the same width
                      child: ElevatedButton.icon(
                        onPressed: () {
                          Navigator.of(context).pop(); // Close the dialog
                        },
                        icon: Icon(Icons.close, color: Colors.grey),
                        label: Text(
                          "CANCEL",
                          style: TextStyle(color: Colors.grey, fontSize: 13),
                        ),
                        style: ElevatedButton.styleFrom(
                          backgroundColor: Colors.white,
                          elevation: 0,
                          side: BorderSide(color: Colors.grey),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(8),
                          ),
                        ),
                      ),
                    ),
                    // Delete button
                    SizedBox(
                      width: 120,
                      height: 38,// Ensure both buttons have the same width
                      child: ElevatedButton.icon(
                        onPressed: () async {
                          Navigator.of(context).pop(); // Close the dialog
                          await deleteCustomer(widget.customerId); // Call delete function
                        },
                        icon: Icon(Icons.delete, color: Colors.white),
                        label: Text(
                          "DELETE",
                          style: TextStyle(color: Colors.white, fontSize: 13),
                        ),
                        style: ElevatedButton.styleFrom(
                          backgroundColor: Colors.red,
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(8),
                          ),
                        ),
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
        );
      },
    );
  }
  Future<void> _onRefresh() async {
    setState(() {
      _isLoading = true;  // Show loading indicator
    });
    await _fetchCustomerDetails();  // Fetch the data again
  }
  // Format date of birth
  String formattedDob(String? dob) {
    if (dob == null || dob.isEmpty) return "";
    try {
      final DateTime date = DateTime.parse(dob);
      final DateFormat formatter = DateFormat('dd MMM yyyy');
      return formatter.format(date);
    } catch (e) {
      return "Invalid Date";
    }
  }

  // Format Aadhar number
  String formatAadharNumber(String? aadhar) {
    if (aadhar == null || aadhar.isEmpty) return "";
    final regExp = RegExp(r'(\d{4})(\d{4})(\d{4})');
    final match = regExp.firstMatch(aadhar);
    if (match != null) {
      return '${match.group(1)} ${match.group(2)} ${match.group(3)}';
    } else {
      return "Invalid Aadhar Number";
    }
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
            top: _isAnimationComplete ? -0 : -400,
            left: 0,
            right: 0,
            child: SvgPicture.string(
              svgString,  // Render the modified SVG string with new colors
              semanticsLabel: 'Animated and Colored SVG',
              fit: BoxFit.fill,
              height: 300,
            )
          ),
          Column(
            children: [
              // Header Section with Avatar and Title
              Padding(
                padding: const EdgeInsets.fromLTRB(10.0, 10.0, 10.0, 0.0),
                child: Column(
                  children: [
                    const SizedBox(height: 50),
                    Row(
                      children: [
                        IconButton(
                          icon: SvgPicture.asset(
                            'assets/backarrow.svg',  // Path to your SVG file
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
                            "Customers",
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
                    const SizedBox(height: 90),
                    CircleAvatar(
                      radius: 60,
                      backgroundColor: Colors.white,
                      child: ClipOval(
                        child: Image.asset(
                          'assets/dashboard_user.png', // Replace with your PNG file path
                          width: 120,
                          height: 120,
                          fit: BoxFit.cover,
                        ),
                      ),
                    ),
                    const SizedBox(height: 5),
                    Row(
                      crossAxisAlignment: CrossAxisAlignment.center,
                      children: [
                        const SizedBox(width: 5),  // Space between the text and icons
                        Text(
                          "Customer Details",
                          style: GoogleFonts.signika(
                            color: Color(0xFFAFB0B1),
                            fontSize: 20,
                            fontWeight: FontWeight.normal,
                          ),
                        ),
                        Spacer(),
                        IconButton(
                          padding: EdgeInsets.zero,  // Set padding to zero for no space around the icon
                          icon: SvgPicture.asset(
                            'assets/delete.svg',  // Path to your delete SVG file
                            width: 21,
                            height: 21,
                          ),
                          onPressed: () {
                            showDeleteConfirmationDialog(context); // Show confirmation dialog
                          },
                        ),
                        IconButton(
                          padding: EdgeInsets.zero,  // Set padding to zero for no space around the icon
                          icon: SvgPicture.asset(
                            'assets/edit.svg',  // Path to your edit SVG file
                            width: 21,
                            height: 21,
                          ),
                          onPressed: () {
                            // Handle edit action (e.g., navigate to edit screen)
                            Navigator.pop(context);
                          },
                        ),
                      ],
                    )
                  ],
                ),
              ),
              // Customer Details Section with Scroll
              Expanded(
                child: Container(
                  color: Colors.white,
                    child: RefreshIndicator(
                      onRefresh: _onRefresh,
                        child: SingleChildScrollView(
                       padding: const EdgeInsets.fromLTRB(10.0, 0.0, 10.0, 0.0),
                     child: Column(
                      children: [
                        if (_isLoading)
                        // Show shimmer effect while loading
                          Column(
                            children: List.generate(10, (index) => _buildShimmerDetailField()),
                          )
                        else
                        // Show actual data when loading is complete
                        _buildDetailField("First Name", _customerDetails?['first_name']?.toString()),
                        _buildDetailField("Last Name", _customerDetails?['last_name']?.toString()),_buildDetailField("Gender", _customerDetails?['gender']?.toString()),
                        _buildDetailField("Date of Birth", formattedDob(_customerDetails?['dob']?.toString())),
                        _buildDetailField("Email Address", _customerDetails?['email']?.toString()),
                        _buildDetailField("Phone", _customerDetails?['phone_number']?.toString()),
                        _buildDetailField("Aadhar Number", formatAadharNumber(_customerDetails?['aadhar_number']?.toString())),
                        _buildDetailField("PAN Number", _customerDetails?['pan_number']?.toString()),
                        _buildDetailField("Permanent Address", _customerDetails?['service_address']?.toString()),
                        _buildDetailField(
                            "City/State/Province",
                            '${_customerDetails?['city']?['name']?.toString() ?? ''}, ${_customerDetails?['state']?['name']?.toString() ?? ''}'
                        ),
                        _buildDetailField("Country", _customerDetails?['country']?['name']?.toString()),
                        _buildDetailField("Pincode", _customerDetails?['pincode']?.toString()),
                      ],
                    ),
                  ),
                ),
              ),
              ),
            ],
          ),
          // Loading or Customer Details
          if (_isLoading)
            const Center(
              // child: CircularProgressIndicator(),
            ),
        ],
      ),
    );
  }

  Widget _buildShimmerDetailField() {
    return Padding(
      padding: const EdgeInsets.only(bottom: 0.0, left: 5),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Shimmer.fromColors(
            baseColor: Colors.grey[300]!,
            highlightColor: Colors.grey[100]!,
            child: Container(
              width: 120,
              height: 16,
              color: Colors.grey,
            ),
          ),
          const SizedBox(height: 4),
          Shimmer.fromColors(
            baseColor: Colors.grey[300]!,
            highlightColor: Colors.grey[100]!,
            child: Container(
              width: double.infinity,
              height: 20,
              color: Colors.grey,
            ),
          ),
          const Divider(color: Color(0xFFE0E0E0)),
        ],
      ),
    );
  }
  // Method to display customer details in fields
  Widget _buildDetailField(String label, String? value) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 0.0, left: 5),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            label,
            style: const TextStyle(
              fontSize: 14,
              fontWeight: FontWeight.bold,
              color: Color(0xFFAFB0B1),
            ),
          ),
          const SizedBox(height: 4),
          Text(
            value ?? "", // Fallback text for null values
            style: const TextStyle(
              fontSize: 16,
              fontWeight: FontWeight.w500,
              color: Colors.black,
            ),
          ),
          const Divider(color: Color(0xFFE0E0E0)),
        ],
      ),
    );
  }
}

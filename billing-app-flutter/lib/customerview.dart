import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:http/http.dart' as http;
import 'package:google_fonts/google_fonts.dart';
import 'dart:convert';
import 'dashboard.dart';
import 'customerviewdetails.dart';
import 'package:flutter/services.dart';
import 'colors.dart';
import 'package:shimmer/shimmer.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'CustomerDeletedSuccessfullyPage.dart';

class CustomerViewPage extends StatefulWidget {
  @override
  _CustomerViewPageState createState() => _CustomerViewPageState();
}

class _CustomerViewPageState extends State<CustomerViewPage> {
  bool _isAnimationComplete = false;
  List<dynamic> _customers = [];
  List<dynamic> _filteredCustomers = [];
  bool _isLoading = true;
  int _currentIndex = 0;
  double _scrollOffset = 0;
  ScrollController _scrollController = ScrollController();
  TextEditingController _searchController = TextEditingController();
  bool _isSearchActive = false;
  String svgString = '';
  String svgStringIcon = '';
  Color? primaryLight;
  Color? secondaryLight;
  Color? secondaryDark;
  Color? primaryDark;
  Color? svgLogin;
  Color? links;
  Color? textPrimary;
  final String baseUrl = "http://ec2-13-39-111-189.eu-west-3.compute.amazonaws.com:100/api/customers/";


  // Add a list to track selected customers
  List<int> _selectedItems = [];

  @override
  void initState() {
    super.initState();
    AppColors.fetchColors().then((_) {
      setState(() {
        secondaryLight = AppColors.secondaryLight;
        primaryLight = AppColors.primaryLight;
        primaryDark = AppColors.primaryDark;
        svgLogin = AppColors.svgLogin;
        secondaryDark = AppColors.secondaryDark;
        links = AppColors.links;
        textPrimary = AppColors.textPrimary;
      });
      loadSvg();
      _fetchCustomers();
      _searchController.addListener(_onSearchChanged);
    });
    _scrollController.addListener(_scrollListener);
    Future.delayed(Duration(milliseconds: 200), () {
      setState(() {
        _isAnimationComplete = true;
      });
    });
  }

  Future<void> loadSvg() async {
    if (secondaryLight != null && primaryLight != null && primaryDark != null) {
      String svg = await rootBundle.loadString('assets/billing_upper_shape.svg');
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

  void _scrollListener() {
    setState(() {
      _scrollOffset = _scrollController.offset;
    });
  }

  void _onItemTapped(int index) {
    setState(() {
      _currentIndex = index;
    });

    // Navigate to DashboardPage when Home button is tapped (index 0)
    if (index == 0) {
      Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => DashboardPage()),
      );
    }
  }

  Future<void> _fetchCustomers() async {
    const String apiUrl = 'http://ec2-13-39-111-189.eu-west-3.compute.amazonaws.com:100/api/customers'; // Replace with your API URL
    try {
      final response = await http.get(Uri.parse(apiUrl));
      if (response.statusCode == 200) {
        setState(() {
          _customers = json.decode(response.body);
          _filteredCustomers = _customers;
          _isLoading = false;
        });
      } else {
        throw Exception('Failed to load customers');
      }
    } catch (e) {
      setState(() {
        _isLoading = false;
      });
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Error fetching customers: $e')),
      );
    }
  }
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
  void _onSearchChanged() {
    setState(() {
      _filteredCustomers = _customers.where((customer) {
        return customer['first_name']
            .toLowerCase()
            .contains(_searchController.text.toLowerCase()) ||
            customer['last_name']
                .toLowerCase()
                .contains(_searchController.text.toLowerCase());
      }).toList();
    });
  }

  // Toggle selection of an item when long pressed
  void _onItemLongPressed(int customerId) {
    setState(() {
      if (_selectedItems.contains(customerId)) {
        _selectedItems.remove(customerId); // Deselect item
      } else {
        _selectedItems.add(customerId); // Select item
      }
    });
  }


  // Delete selected customers
  Future<void> _deleteSelectedItems() async {
    final deleteApiUrl = 'http://ec2-13-39-111-189.eu-west-3.compute.amazonaws.com:100/api/customers'; // Replace with your delete API URL

    try {
      // Navigate to the success page first
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(
          builder: (context) => CustomerDeletedSuccessfullyPage(),
        ),
      );

      // Perform the deletion after navigating
      for (int customerId in _selectedItems) {
        final response = await http.delete(
          Uri.parse('$deleteApiUrl/$customerId'), // Assuming DELETE request with customer ID
        );
        if (response.statusCode != 200) {
          throw Exception('Failed to delete customer with ID $customerId');
        }
      }

      // Remove the deleted customers from the list after navigation
      setState(() {
        _filteredCustomers.removeWhere((customer) =>
            _selectedItems.contains(customer['id'])); // Remove selected customers
        _selectedItems.clear(); // Clear the selection
      });

    } catch (e) {
      // Show an error if something goes wrong
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Error deleting customers: $e')),
      );
    }
  }
// Show confirmation dialog for deletion
  Future<void> showDeleteConfirmationDialog(BuildContext context) async {
    showDialog(
      context: context,
      barrierDismissible: false, // Prevent dismissing by tapping outside
      builder: (BuildContext context) {
        return Dialog(
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12), // Border radius set to 12
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
                  "Are you sure you want to delete the selected customers?",
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                    color: Colors.black,
                  ),
                  textAlign: TextAlign.center,
                ),
                const SizedBox(height: 30),
                SvgPicture.asset(
                  'assets/delete_confirmation.svg', // Replace with the actual path to your SVG
                  height: 80,
                  width: 80,
                ),
                const SizedBox(height: 30),
                // Buttons
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                  children: [
                    // Cancel button
                    SizedBox(
                      width: 120,
                      height: 38,
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
                      height: 38,
                      child: ElevatedButton.icon(
                        onPressed: () async {
                          Navigator.of(context).pop(); // Close the dialog
                          await _deleteSelectedItems(); // Call delete function
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


  @override
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: NestedScrollView(
        controller: _scrollController,
        headerSliverBuilder: (BuildContext context, bool innerBoxIsScrolled) {
          return [
            SliverAppBar(
              backgroundColor: _scrollOffset <= 280 ? Colors.transparent : primaryDark,
              expandedHeight: 280,
              automaticallyImplyLeading: false,
              floating: false,
              pinned: true,
              flexibleSpace: FlexibleSpaceBar(
                background: Stack(
                  children: [
                    // Top Animated Background Shape
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
                        const SizedBox(height: 160),
                        CircleAvatar(
                          radius: 60,
                          backgroundColor: Colors.white,
                          child: ClipOval(
                            child: Image.asset(
                              'assets/dashboard_user.png',
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
                            const SizedBox(width: 15),
                            Text(
                              "Total: ${_customers.length}",
                              style: GoogleFonts.signika(
                                color: const Color(0xFFAFB0B1),
                                fontSize: 14,
                              ),
                            ),
                            const SizedBox(width: 35),
                            Text(
                              "Available Customers",
                              style: GoogleFonts.signika(
                                color: const Color(0xFFAFB0B1),
                                fontSize: 22,
                                fontWeight: FontWeight.normal,
                              ),
                            ),
                          ],
                        ),
                      ],
                    ),
                  ],
                ),
              ),
              title: Padding(
                padding: const EdgeInsets.symmetric(horizontal: 0),
                child: Column(
                  children: [
                    // Search bar
                    if (_isSearchActive)
                      Padding(
                        padding: const EdgeInsets.symmetric(horizontal: 0),
                        child: Row(
                          children: [
                            Expanded(
                              child: Padding(
                                padding: const EdgeInsets.symmetric(horizontal: 0),
                                child: Stack(
                                  alignment: Alignment.centerRight,
                                  children: [
                                    TextField(
                                      controller: _searchController,
                                      autofocus: true,
                                      decoration: InputDecoration(
                                        hintText: 'Search by name...',
                                        border: InputBorder.none,
                                        filled: true,
                                        fillColor: Colors.white,
                                        contentPadding:
                                        const EdgeInsets.symmetric(horizontal: 16),
                                        enabledBorder: OutlineInputBorder(
                                          borderRadius: BorderRadius.circular(25.0),
                                          borderSide: BorderSide.none,
                                        ),
                                        focusedBorder: OutlineInputBorder(
                                          borderRadius: BorderRadius.circular(25.0),
                                          borderSide: BorderSide.none,
                                        ),
                                      ),
                                    ),
                                    Positioned(
                                      right: 8,
                                      child: IconButton(
                                        icon: const Icon(
                                          Icons.close,
                                          size: 24,
                                          color: Colors.grey,
                                        ),
                                        onPressed: () {
                                          setState(() {
                                            _searchController.clear();
                                            _isSearchActive = false;
                                          });
                                        },
                                      ),
                                    ),
                                  ],
                                ),
                              ),
                            ),
                          ],
                        ),
                      ),
                    Row(
                      children: [
                        if (!_isSearchActive)
                          IconButton(
                            icon: SvgPicture.asset(
                              'assets/backarrow.svg',
                              width: 30,
                              height: 30,
                              color: _scrollOffset <= 270 ? Colors.white : Colors.white,
                            ),
                            onPressed: () {
                              Navigator.pop(context);
                            },
                          ),
                        if (!_isSearchActive)
                          Expanded(
                            child: Text(
                              "Customers",
                              style: GoogleFonts.signika(
                                color: _scrollOffset <= 270 ? Colors.white : Colors.white,
                                fontSize: 29,
                                fontWeight: FontWeight.normal,
                              ),
                              textAlign: TextAlign.left,
                            ),
                          ),
                        if (!_isSearchActive)
                          IconButton(
                            icon: SvgPicture.asset(
                              'assets/search.svg',
                              width: 28,
                              height: 28,
                              color: _scrollOffset <= 270 ? Colors.white : Colors.white,
                            ),
                            onPressed: () {
                              setState(() {
                                _isSearchActive = true;
                              });
                            },
                          ),
                      ],
                    ),
                  ],
                ),
              ),
            ),
          ];
        },
        body: ListView.builder(
          itemCount: _filteredCustomers.length,
          itemBuilder: (BuildContext context, int index) {
            if (_isLoading) {
              return Shimmer.fromColors(
                baseColor: Colors.grey.shade300,
                highlightColor: Colors.grey.shade100,
                child: Card(
                  margin: const EdgeInsets.fromLTRB(15, 0, 15, 15),
                  elevation: 5,
                  color: Colors.white,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: Container(
                    height: 80,
                    decoration: BoxDecoration(
                      borderRadius: BorderRadius.circular(8),
                      color: Colors.white,
                    ),
                  ),
                ),
              );
            }

            if (_filteredCustomers.isEmpty) {
              return Center(
                child: Text(
                  "No customers found.",
                  style: GoogleFonts.signika(
                    fontSize: 18,
                    color: const Color(0xFFAFB0B1),
                  ),
                ),
              );
            }

            final customer = _filteredCustomers[index];
            bool isSelected = _selectedItems.contains(customer['id']);

            return GestureDetector(
              onLongPress: () {
                setState(() {
                  if (_selectedItems.contains(customer['id'])) {
                    _selectedItems.remove(customer['id']);
                  } else {
                    _selectedItems.add(customer['id']);
                  }
                });
              },
              child: Card(
                margin: const EdgeInsets.fromLTRB(15, 0, 15, 15),
                elevation: 2,
                color: isSelected ? Colors.grey.shade300 : Colors.white,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(10),
                ),
                child: ListTile(
                  leading: Container(
                    width: 60,
                    height: 60,
                    decoration: BoxDecoration(
                      color: primaryLight,
                      borderRadius: BorderRadius.circular(32),
                    ),
                    child: Center(
                      child: Text(
                        "${customer['first_name'][0]}${customer['last_name'][0]}",
                        style: GoogleFonts.signika(
                          fontWeight: FontWeight.normal,
                          color: Colors.grey.shade800,
                          fontSize: 34,
                        ),
                      ),
                    ),
                  ),
                  title: Text(
                    "Customer Name: ${customer['first_name']} ${customer['last_name']}",
                    style: const TextStyle(
                      fontSize: 13,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                  subtitle: Text(
                    "Customer ID: ${customer['aadhar_number']}\n"
                        "City: ${customer['city_id']}, ${customer['state_id']}",
                    style: const TextStyle(fontSize: 13),
                  ),
                  trailing: Container(
                    width: 24,
                    height: 24,
                    decoration: BoxDecoration(
                      color: primaryDark,
                      borderRadius: BorderRadius.circular(50),
                    ),
                    child: IconButton(
                      icon: const Icon(
                        Icons.arrow_forward_ios,
                        color: Colors.white,
                        size: 9,
                      ),
                      onPressed: () {
                        Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (context) => CustomerDetailsPage(
                              customerId: customer['id'],
                            ),
                          ),
                        );
                      },
                    ),
                  ),
                ),
              ),
            );
          },
        ),
      ),
      floatingActionButton: _selectedItems.isNotEmpty
          ? FloatingActionButton(
        onPressed: () {
          showDeleteConfirmationDialog(context);
        },
        backgroundColor: primaryLight,
        child: const Icon(Icons.delete),
        shape: const CircleBorder(),
      )
          : null,
    );
  }

}

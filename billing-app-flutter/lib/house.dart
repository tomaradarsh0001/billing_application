import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:http/http.dart' as http;
import 'package:google_fonts/google_fonts.dart';
import 'dart:convert';
import 'dashboard.dart';
import 'package:flutter/services.dart';
import 'main.dart';
import 'package:shimmer/shimmer.dart';
import 'houseviewdetails.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:shared_preferences/shared_preferences.dart';


class HouseViewPage extends StatefulWidget {
  @override
  _HouseViewPageState createState() => _HouseViewPageState();
}


class _HouseViewPageState extends State<HouseViewPage> {
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
  String svgStringIconCircle = '';
  String svgStringIcon = '';
  Color? primaryLight;
  Color? secondaryLight;
  Color? secondaryDark;
  Color? primaryDark;
  Color? svgLogin;
  Color? links;
  Color? textPrimary;
  final String baseUrl = "http://ec2-13-39-111-189.eu-west-3.compute.amazonaws.com:100/api/billing/occupants";
  bool? _isDarkMode;
  List<int> _selectedItems = [];


  @override
  void initState() {
    super.initState();
    _loadThemePreference();

    AppColors.loadColorsFromPrefs().then((_) {
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
      loadSvgIcon();
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

  Future<void> _loadThemePreference() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    bool isDark = prefs.getBool('isDarkMode') ?? false;
    setState(() {
      _isDarkMode = isDark;
    });
  }

  Future<bool> _onWillPop() async {
    Navigator.pushReplacement(
      context,
      MaterialPageRoute(builder: (context) => DashboardPage()),
    );
    return false; // Prevents default back navigation
  }

  Future<void> loadSvg() async {
    if (secondaryLight != null && primaryLight != null && primaryDark != null) {
      String svg = await rootBundle.loadString('assets/billing_upper_shape.svg');

      setState(() {
        // If Dark Mode is enabled, use white (#FFFFFF), otherwise use stored colors
        svgString = svg.replaceAll(
          'PLACEHOLDER_COLOR_1', _isDarkMode == true ? '#666564' : _colorToHex(primaryLight ?? Colors.grey),
        ).replaceAll(
          'PLACEHOLDER_COLOR_2', _isDarkMode == true ? '#000000' : _colorToHex(primaryDark ?? Colors.black),
        );
      });
    }
  }

  Future<void> loadSvgIcon() async {
    if (secondaryLight != null && primaryLight != null && primaryDark != null) {
      String svg = await rootBundle.loadString('assets/house.svg');
      setState(() {
        svgStringIcon = svg.replaceAll(
          'PLACEHOLDER_COLOR_1', _isDarkMode == true ? '#666564' : _colorToHex(primaryLight ?? Colors.grey),
        ).replaceAll(
          'PLACEHOLDER_COLOR_2', _isDarkMode == true ? '#000000' : _colorToHex(textPrimary ?? Colors.black),
        ).replaceAll(
          'PLACEHOLDER_COLOR_3', _isDarkMode == true ? '#000000' : _colorToHex(primaryDark ?? Colors.black),
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
    const String apiUrl = 'http://ec2-13-39-111-189.eu-west-3.compute.amazonaws.com:100/api/billing/occupants'; // Replace with your API URL
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
    final deleteApiUrl = 'http://ec2-13-39-111-189.eu-west-3.compute.amazonaws.com:100/api/billing/occupants'; // Replace with your delete API URL

    try {
      // Navigate to the success page first
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(
          builder: (context) => DashboardPage(),
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
                  "Are you sure you want to delete the selected House?",
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
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        color: Colors.white, // Set red background here
        child: CustomScrollView(
          controller: _scrollController,
          slivers: [
            SliverAppBar(
              backgroundColor: _scrollOffset <= 300
                  ? Colors.white
                  : primaryDark,
              expandedHeight: 280,
              automaticallyImplyLeading: false,
              floating: true,
              elevation: 0,
              shadowColor: Colors.transparent,
              pinned: true,
              flexibleSpace: FlexibleSpaceBar(
                background: Stack(
                  children: [
                    AnimatedPositioned(
                      duration: const Duration(milliseconds: 900),
                      curve: Curves.easeInOut,
                      top: _isAnimationComplete ? 0 : -300,
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
                      mainAxisAlignment: MainAxisAlignment.end,
                      // Align to the bottom
                      children: [
                        const SizedBox(height: 100),
                        AnimatedOpacity(
                          opacity: _isAnimationComplete ? 1.0 : 0.0,
                          duration: const Duration(milliseconds: 700),
                          curve: Curves.easeIn,
                          child: CircleAvatar(
                            radius: 60,
                            child: ClipOval(
                              child: SvgPicture.string(
                                svgStringIcon,
                                semanticsLabel: 'Icon SVG',
                                width: 120,
                                height: 120,
                                fit: BoxFit.cover,
                              ),
                            ),
                          ),
                        ),

                        const SizedBox(height: 10),
                        Row(
                          children: [
                            const SizedBox(width: 20),
                            Text(
                              "Total: ${_customers.length}",
                              style: GoogleFonts.signika(
                                color: Colors.grey.shade600,
                                fontSize: 14,
                              ),
                            ),
                            const SizedBox(width: 60),
                            Text(
                              "House Details",
                              style: GoogleFonts.signika(
                                color: Color(0xFFAFB0B1),
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
                padding: const EdgeInsets.all(0),
                child: Column(
                  children: [
                    if (_isSearchActive)
                      Padding(
                        padding: const EdgeInsets.all(0),
                        child: Row(
                          children: [
                            Expanded(
                              child: Padding(
                                padding: const EdgeInsets.all(10),
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
                                        contentPadding: const EdgeInsets
                                            .symmetric(horizontal: 8),
                                        enabledBorder: OutlineInputBorder(
                                          borderRadius: BorderRadius.circular(
                                              25.0),
                                          borderSide: BorderSide.none,
                                        ),
                                        focusedBorder: OutlineInputBorder(
                                          borderRadius: BorderRadius.circular(
                                              25.0),
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
                              color: _scrollOffset <= 270
                                  ? Colors.white
                                  : Colors.white,
                            ),
                            onPressed: () {
                              Navigator.pushReplacement(
                                context,
                                MaterialPageRoute(
                                    builder: (context) => DashboardPage()),
                              );
                            },
                          ),
                        if (!_isSearchActive)
                          Expanded(
                            child: Text(
                              "Houses",
                              style: GoogleFonts.signika(
                                color: _scrollOffset <= 270
                                    ? Colors.white
                                    : Colors.white,
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
                              color: _scrollOffset <= 270
                                  ? Colors.white
                                  : Colors.white,
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

            SliverList(
              delegate: SliverChildBuilderDelegate(
                    (BuildContext context, int index) {
                  // Show shimmer while loading
                  if (_isLoading) {
                    return Container(
                      color: Colors.white,
                      child: Shimmer.fromColors(
                        baseColor: Colors.grey.shade200,
                        highlightColor: Colors.grey.shade100,
                        child: Card(
                          margin: const EdgeInsets.fromLTRB(15, 10, 15, 15),
                          elevation: 5,
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
                      ),
                    );
                  }

                  // Show message when no customers found
                  if (_filteredCustomers.isEmpty) {
                    return Container(
                      color: Colors.white,
                      child: Center(
                        child: Padding(
                          padding: const EdgeInsets.all(24.0),
                          child: Text(
                            "No customers found.",
                            style: GoogleFonts.signika(
                              fontSize: 18,
                              color: const Color(0xFFAFB0B1),
                            ),
                          ),
                        ),
                      ),
                    );
                  }

                  // Render each customer item
                  final customer = _filteredCustomers[index];
                  bool isSelected = _selectedItems.contains(customer['id']);

                  return Container(
                    color: Colors.white,
                    child: GestureDetector(
                      onLongPress: () {
                        setState(() {
                          if (_selectedItems.contains(customer['id'])) {
                            _selectedItems.remove(customer['id']);
                          } else {
                            _selectedItems.add(customer['id']);
                          }
                        });
                      },
                      child: Stack(
                        children: [
                          Card(
                            margin: EdgeInsets.fromLTRB(15, index == 0 ? 10 : 0, 15, 10),
                            elevation: 2,
                            color: _isDarkMode == true
                                ? (isSelected ? Colors.grey.shade800 : Colors.white)
                                : (isSelected ? Colors.grey.shade300 : Colors.white),
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(15),
                            ),
                            child: Padding(
                              padding: const EdgeInsets.only(top: 10.0, right: 10.0),
                              child: ListTile(
                                contentPadding: const EdgeInsets.all(8),
                                leading: Container(
                                  width: 60,
                                  height: 60,
                                  decoration: BoxDecoration(
                                    color: _isDarkMode == true
                                        ? Colors.grey.shade700
                                        : (primaryLight ?? Colors.blue),
                                    borderRadius: BorderRadius.circular(32),
                                  ),
                                  child: Center(
                                    child: Icon(
                                      Icons.house,
                                      size: 28,
                                      color: _isDarkMode == true ? Colors.white : AppColors.background,
                                    ),
                                  ),
                                ),
                                title: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Text(
                                      "Occupant: ${customer['first_name']} ${customer['last_name']}",
                                      style: TextStyle(
                                        fontSize: 12,
                                        fontWeight: FontWeight.bold,
                                        color: _isDarkMode == true ? Colors.white : Colors.black,
                                      ),
                                    ),
                                    // Text(
                                    //   "Email: ${customer['email']}",
                                    //   style: TextStyle(
                                    //     fontSize: 13,
                                    //     color: _isDarkMode == true
                                    //         ? Colors.white70
                                    //         : Colors.black87,
                                    //   ),
                                    // ),
                                    Text(
                                      "Phone: +${customer['phone_code']['phonecode']} ${customer['mobile']}",
                                      style: TextStyle(
                                        fontSize: 12,
                                        color: _isDarkMode == true
                                            ? Colors.white70
                                            : Colors.black87,
                                      ),
                                    ),
                                    Text(
                                      "House: ${customer['house']['hno']}, ${customer['house']['area']}, ${customer['house']['city']}, ${customer['house']['state']}",
                                      style: TextStyle(
                                        fontSize: 12,
                                        color: _isDarkMode == true
                                            ? Colors.white70
                                            : Colors.black87,
                                      ),
                                    ),
                                  ],
                                ),
                                trailing: Container(
                                  width: 24,
                                  height: 24,
                                  decoration: BoxDecoration(
                                    color: _isDarkMode == true
                                        ? Colors.white
                                        : (primaryDark ?? Colors.blue),
                                    borderRadius: BorderRadius.circular(50),
                                  ),
                                  child: IconButton(
                                    padding: EdgeInsets.zero,
                                    icon: Icon(
                                      Icons.arrow_forward_ios,
                                      color: _isDarkMode == true ? Colors.black : Colors.white,
                                      size: 12,
                                    ),
                                    onPressed: () {
                                      Navigator.push(
                                        context,
                                        MaterialPageRoute(
                                          builder: (context) => HouseViewDetails(
                                            id: customer['id'], // ✅ Change `customerId` to `id`
                                          ),
                                        ),
                                      );
                                    },

                                  ),
                                ),
                              ),
                            ),
                          ),
                          // Top-right green badge with Unique ID
                          Positioned(
                            top: 15,
                            right: 20,
                            child: Container(
                              padding: EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                              decoration: BoxDecoration(
                                color: Colors.green.shade700,
                                borderRadius: BorderRadius.circular(20),
                              ),
                              child: Text(
                                customer['unique_id'],
                                style: TextStyle(
                                  color: Colors.white,
                                  fontSize: 9,
                                  fontWeight: FontWeight.bold,
                                ),
                              ),
                            ),
                          ),
                        ],
                      ),
                    ),
                  );


                    },
                childCount: _isLoading
                    ? 5 // number of shimmer placeholders
                    : (_filteredCustomers.isEmpty ? 1 : _filteredCustomers
                    .length),
              ),
            ),


          ],
        ),
      ),
      floatingActionButton: _selectedItems.isNotEmpty
          ? FloatingActionButton(
        onPressed: () {
          showDeleteConfirmationDialog(context);
        },
        backgroundColor: _isDarkMode == true
            ? Colors.grey.shade800
            : (primaryLight ?? Colors.blue),
        child: Icon(
          Icons.delete,
          color: _isDarkMode == true ? Colors.white : Colors.black,
        ),
        shape: const CircleBorder(),
      )
          : null,

    );
  }
}
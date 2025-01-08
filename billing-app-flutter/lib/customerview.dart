import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:http/http.dart' as http;
import 'package:google_fonts/google_fonts.dart';
import 'dart:convert';
import 'dashboard.dart';
import 'customerviewdetails.dart';

class CustomerViewPage extends StatefulWidget {
  @override
  _CustomerViewPageState createState() => _CustomerViewPageState();
}

class _CustomerViewPageState extends State<CustomerViewPage> {
  bool _isAnimationComplete = true;
  List<dynamic> _customers = [];
  List<dynamic> _filteredCustomers = [];
  bool _isLoading = true;
  int _currentIndex = 0;
  double _scrollOffset = 0;
  ScrollController _scrollController = ScrollController();
  TextEditingController _searchController = TextEditingController();
  bool _isSearchActive = false;

  @override
  void initState() {
    super.initState();
    _scrollController.addListener(_scrollListener);
    Future.delayed(Duration(milliseconds: 200), () {
      setState(() {
        _isAnimationComplete = true;
      });
    });
    _fetchCustomers();
    _searchController.addListener(_onSearchChanged);
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
    const String apiUrl = 'http://16.171.136.239/api/customers'; // Replace with your API URL
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


  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: CustomScrollView(
        controller: _scrollController,
        slivers: [
          // SliverAppBar for dynamic header with scroll effect
          SliverAppBar(
            backgroundColor: _scrollOffset <= 550 ? Colors.transparent : Colors.blue,
            expandedHeight: 350,
            automaticallyImplyLeading: false, // Hides the back button
            floating: true,
            pinned: true,
            flexibleSpace: FlexibleSpaceBar(
              background: Stack(
                children: [
                  // Top Animated Background Shape
                  AnimatedPositioned(
                    duration: const Duration(milliseconds: 900),
                    curve: Curves.easeInOut,
                    top: _isAnimationComplete ? 0 : -350,
                    left: 0,
                    right: 0,
                    child: SvgPicture.asset(
                      'assets/screen_upper_shape.svg', // Replace with your asset path
                      fit: BoxFit.fill,
                      height: 300,
                    ),
                  ),
                  Column(
                    children: [
                      const SizedBox(height: 220),
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
                      const SizedBox(height: 10),
                      Row(
                        crossAxisAlignment: CrossAxisAlignment.center,
                        children: [
                          const SizedBox(width: 10),
                          Text(
                            "Total: ${_customers.length}",
                            style: GoogleFonts.signika(
                              color: Color(0xFFAFB0B1),
                              fontSize: 14,
                            ),
                          ),
                          const SizedBox(width: 30),
                          Text(
                            "Available Customers",
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
              padding: const EdgeInsets.symmetric(horizontal: 0), // Adjusted padding
              child: Column(
                children: [
                  // Search bar - shows when _isSearchActive is true
                  _isSearchActive
                      ? Padding(
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
                                    border: InputBorder.none, // Remove the border
                                    filled: true,
                                    fillColor: Colors.white,
                                    contentPadding: EdgeInsets.symmetric(horizontal: 16),
                                    enabledBorder: OutlineInputBorder(
                                      borderRadius: BorderRadius.circular(25.0), // Rounded corners
                                      borderSide: BorderSide.none, // No border
                                    ),
                                    focusedBorder: OutlineInputBorder(
                                      borderRadius: BorderRadius.circular(25.0), // Rounded corners
                                      borderSide: BorderSide.none, // No border
                                    ),
                                  ),
                                ),
                                Positioned(
                                  right: 8, // Position the cross icon inside the text field
                                  child: IconButton(
                                    icon: Icon(
                                      Icons.close, // Use the built-in close icon for cross
                                      size: 24, // Size of the icon
                                      color: Colors.grey, // Color of the cross icon
                                    ),
                                    onPressed: () {
                                      setState(() {
                                        _searchController.clear(); // Clear the search field
                                        _isSearchActive = false; // Hide search bar and show the title
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
                  )
                      : Container(), // Empty container when search is not active
                  // Empty container when search is not active
                  Row(
                    children: [
                      // Back Button - hidden when search is active
                      _isSearchActive
                          ? Container()
                          : IconButton(
                        icon: SvgPicture.asset(
                          'assets/backarrow.svg',
                          width: 30,
                          height: 30,
                          color: _scrollOffset <= 270 ? Colors.white : Colors.white,
                        ),
                        onPressed: () {
                          Navigator.pop(context); // Handle back button action
                        },
                      ),
                      // Title Text - hidden when search is active
                      _isSearchActive
                          ? Container()
                          : Expanded(
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
                      // Search Icon - shows when search is not active
                      _isSearchActive
                          ? Container()
                          : IconButton(
                        icon: SvgPicture.asset(
                          'assets/search.svg',
                          width: 28,
                          height: 28,
                          color: _scrollOffset <= 270 ? Colors.white : Colors.white,
                        ),
                        onPressed: () {
                          setState(() {
                            _isSearchActive = true; // Activate search bar
                          });
                        },
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ),


          // SliverList for displaying cards
          SliverList(
            delegate: SliverChildBuilderDelegate(
                  (BuildContext context, int index) {
                if (_isLoading) {
                  return Center(child: CircularProgressIndicator());
                }

                if (_filteredCustomers.isEmpty) {
                  return Center(
                    child: Text(
                      "No customers found.",
                      style: GoogleFonts.signika(
                        fontSize: 18,
                        color: Color(0xFFAFB0B1),
                      ),
                    ),
                  );
                }

                final customer = _filteredCustomers[index];
                return Card(
                  margin: const EdgeInsets.fromLTRB(15, 0, 15, 15),
                  elevation: 5,
                  color: Colors.white,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: Container(
                    decoration: BoxDecoration(
                      borderRadius: BorderRadius.circular(8),
                      color: Colors.white,
                      boxShadow: [
                        BoxShadow(
                          color: Colors.black.withOpacity(0.1),
                          blurRadius: 2,
                          spreadRadius: 1,
                          offset: Offset(0, 1),
                        ),
                      ],
                    ),
                    child: ListTile(
                      leading: Container(
                        width: 60,
                        height: 60,
                        decoration: BoxDecoration(
                          color: Colors.blue.shade100,
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
                        style: TextStyle(
                          fontSize: 13,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                      subtitle: Text(
                        "Customer ID: ${customer['aadhar_number']}\n"
                            "City: ${customer['city_id']}, ${customer['state_id']}",
                        style: TextStyle(fontSize: 13),
                      ),
                      trailing: Container(
                        width: 24,
                        height: 24,
                        decoration: BoxDecoration(
                          color: Colors.blue,
                          borderRadius: BorderRadius.circular(50),
                        ),
                        child: IconButton(
                          icon: Icon(
                            Icons.arrow_forward_ios,
                            color: Colors.white,
                            size: 10,
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
              childCount: _filteredCustomers.length,
            ),
          ),
        ],
      ),
    );
  }
}

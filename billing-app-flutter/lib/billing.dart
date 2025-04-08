import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:http/http.dart' as http;
import 'package:google_fonts/google_fonts.dart';
import 'dart:convert';
import 'package:shimmer/shimmer.dart';
import 'package:flutter/services.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'main.dart';
import 'dashboard.dart';


class BillingPage extends StatefulWidget {
  @override
  _BillingPageState createState() => _BillingPageState();

}

class _BillingPageState extends State<BillingPage> {
  bool _isAnimationComplete = false;
  List<dynamic> _billingDetails = [];
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
  final String baseUrl = "http://ec2-13-39-111-189.eu-west-3.compute.amazonaws.com:100/api/billing-details";
  bool? _isDarkMode;
  bool _showGeneratedContent = false;
  double _estCharges = 0.0;
  double unitCharge = 9.5;
  Set<int> _openIds = {};
  String? primaryFont;
  String? secondaryFont;

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
        primaryFont = AppColors.primaryFont;
        secondaryFont = AppColors.secondaryFont;
      });
      loadSvg();
      loadSvgIcon();
    });
    _scrollController.addListener(_scrollListener);
    Future.delayed(Duration(milliseconds: 200), () {
      setState(() {
        _isAnimationComplete = true;
      });
    });
    fetchBillingDetails(); // Fetch billing data when the page loads
  }

  Future<void> fetchBillingDetails() async {
    try {
      final response = await http.get(Uri.parse(baseUrl));
      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        setState(() {
          _billingDetails = data['data'];
          _isLoading = false;
        });
      } else {
        // Handle error
        setState(() {
          _isLoading = false;
        });
      }
    } catch (e) {
      print("Error fetching billing details: $e");
      setState(() {
        _isLoading = false;
      });
    }
  }

  Future<void> loadSvg() async {
    if (secondaryLight != null && primaryLight != null && primaryDark != null) {
      String svg = await rootBundle.loadString('assets/billing_upper_shape.svg');
      setState(() {
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
      String svg = await rootBundle.loadString('assets/billing_icon.svg');
      setState(() {
        svgStringIcon = svg.replaceAll(
          'PLACEHOLDER', _isDarkMode == true ? '#000000' : _colorToHex(primaryDark ?? Colors.black),
        );
      });
    }
  }

  Future<void> _loadThemePreference() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    bool isDark = prefs.getBool('isDarkMode') ?? false;
    setState(() {
      _isDarkMode = isDark;
    });
  }

  String _colorToHex(Color color) {
    return '#${color.value.toRadixString(16).substring(2).toUpperCase()}';
  }

  void _scrollListener() {
    setState(() {
      _scrollOffset = _scrollController.offset;
    });
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
                            "Total: ${_billingDetails.length}",
                            style: GoogleFonts.getFont(
                              primaryFont ?? 'Signika',
                              color: Colors.grey.shade600,
                              fontSize: 14,
                            ),
                          ),
                          const SizedBox(width: 65),
                          Text(
                            "Billing Details",
                            style: GoogleFonts.getFont(
                              primaryFont ?? 'Signika',
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
                            "Billing Details",
                            style: GoogleFonts.getFont(
                              primaryFont ?? 'Signika',
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
                  if (_isLoading) {
                    return Padding(
                      padding: EdgeInsets.only(top: 1),
                      child: Shimmer.fromColors(
                        baseColor: Colors.grey.shade300,
                        highlightColor: Colors.grey.shade100,
                        child: Card(
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
                      ),
                    );
                  }
                  // State variable


                  final billing = _billingDetails[index];
                  return Container(
                    margin: const EdgeInsets.symmetric(horizontal: 15, vertical: 8),
                    padding: const EdgeInsets.all(12),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(12),
                      border: Border.all(
                        color: billing['status'] == "paid"
                            ? Colors.green // Green for Paid
                            : billing['status'] == "unpaid"
                            ? Colors.red // Red for Unpaid
                            : Colors.orange,
                        width: 1.5,
                      ),
                      boxShadow: const [
                        BoxShadow(
                          color: Colors.black12,
                          blurRadius: 4,
                          offset: Offset(0, 2),
                        )
                      ],
                    ),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        // Status and Index Number Row
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            // Index as badge
                            Container(
                              padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                              decoration: BoxDecoration(
                                color: billing['status'] == "paid"
                                    ? Colors.green.shade100
                                    : billing['status'] == "partially_paid"
                                    ? Colors.orange.shade100
                                    : Colors.red.shade100,
                                borderRadius: BorderRadius.circular(20),
                                boxShadow: [
                                  BoxShadow(
                                    color: Colors.grey.withOpacity(0.2),
                                    blurRadius: 3,
                                    offset: const Offset(0, 2),
                                  ),
                                ],
                              ),
                              child: Row(
                                children: [
                                  Icon(
                                    Icons.receipt_long,
                                    size: 16,
                                    color: billing['status'] == "paid"
                                        ? Colors.green.shade900
                                        : billing['status'] == "partially_paid"
                                        ? Colors.orange.shade900
                                        : Colors.red.shade900,
                                  ),
                                  const SizedBox(width: 4),
                                  Text(
                                    (index + 1).toString(),
                                    style: TextStyle(
                                      fontWeight: FontWeight.bold,
                                      color: billing['status'] == "paid"
                                          ? Colors.green.shade900
                                          : billing['status'] == "partially_paid"
                                          ? Colors.orange.shade900
                                          : Colors.red.shade900,
                                      fontSize: 13,
                                    ),
                                  ),
                                ],
                              ),
                            ),

                            // Status label
                            Container(
                              padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                              decoration: BoxDecoration(
                                color: billing['status'] == "paid"
                                    ? Colors.green.shade50
                                    : billing['status'] == "partially_paid"
                                    ? Colors.orange.shade50
                                    : Colors.red.shade50,
                                borderRadius: BorderRadius.circular(20),
                              ),
                              child: Row(
                                children: [
                                  Icon(
                                    billing['status'] == "paid"
                                        ? Icons.check_circle
                                        : billing['status'] == "partially_paid"
                                        ? Icons.hourglass_bottom
                                        : Icons.cancel,
                                    color: billing['status'] == "paid"
                                        ? Colors.green
                                        : billing['status'] == "partially_paid"
                                        ? Colors.orange
                                        : Colors.red,
                                    size: 16,
                                  ),
                                  const SizedBox(width: 4),
                                  Text(
                                    billing['status'] == "paid"
                                        ? "PAID"
                                        : billing['status'] == "partially_paid"
                                        ? "PARTIALLY PAID"
                                        : "UNPAID",
                                    style: TextStyle(
                                      color: billing['status'] == "paid"
                                          ? Colors.green
                                          : billing['status'] == "partially_paid"
                                          ? Colors.orange
                                          : Colors.red,
                                      fontWeight: FontWeight.w600,
                                      fontSize: 13,
                                    ),
                                  ),
                                ],
                              ),
                            ),
                          ],
                        ),


                        const SizedBox(height: 6),
                        // House and Locality Info
                        Text(
                          "Occupant Name :- ${billing['occupant']['first_name']} ${billing['occupant']['last_name']}",
                          style: GoogleFonts.getFont(
                            secondaryFont ?? 'Roboto',
                            fontSize: 15,
                            fontWeight: FontWeight.bold,
                            color: Colors.black,
                          ),
                        ),
                        Text(
                          "House/Locality :- ${billing['house']['hno']} ${billing['house']['area']}",
                          style: GoogleFonts.getFont(
                            secondaryFont ?? 'Roboto',
                            fontSize: 14,
                            color: Colors.black87,
                          ),
                        ),
                        Text(
                          "Total Dues :- Rs.${double.parse(billing['outstanding_dues']).toInt()}/-  (${double.parse(billing['last_reading']).toInt()} Units)",
                          style: GoogleFonts.getFont(
                            secondaryFont ?? 'Roboto',
                            fontSize: 14,
                            color: Colors.black,
                          ),
                        ),
                        // Text(
                        //   "Last Readings :- Rs.${billing['last_reading']}/-",
                        //   style: const TextStyle(
                        //     fontSize: 14,
                        //     color: Colors.black,
                        //   ),
                        // ),
                        const SizedBox(height: 2),
                        // Buttons Row
                        Padding(
                          padding: const EdgeInsets.all(8.0),
                          child: AnimatedCrossFade(
                            duration: const Duration(milliseconds: 300),
                            crossFadeState: _openIds.contains(billing['id'])
                                ? CrossFadeState.showSecond
                                : CrossFadeState.showFirst,
                            firstChild: Row(
                              children: [
                                Expanded(
                                  child: ElevatedButton.icon(
                                    onPressed: () {
                                      setState(() {
                                        _openIds.add(billing['id']);
                                      });
                                    },
                                    icon: const Icon(Icons.touch_app, color: Colors.indigo),
                                    label: Text(
                                      "Generate Bill",
                                      style: GoogleFonts.getFont(
                                        secondaryFont ?? 'Roboto',
                                        fontSize: 13,
                                        fontWeight: FontWeight.w500,
                                      ),
                                    ),

                                    style: ElevatedButton.styleFrom(
                                      backgroundColor: Colors.indigo.shade50,
                                      elevation: 0,
                                      padding: const EdgeInsets.symmetric(vertical: 10),
                                      shape: RoundedRectangleBorder(
                                        borderRadius: BorderRadius.circular(10),
                                      ),
                                    ),
                                  ),
                                ),
                                const SizedBox(width: 10),
                                Expanded(
                                  child: ElevatedButton.icon(
                                    onPressed: () {
                                      // View Details logic
                                    },
                                    icon: const Icon(Icons.visibility, color: Colors.teal),
                                    label: Text(
                                      "View Details",
                                      style: GoogleFonts.getFont(
                                        secondaryFont ?? 'Roboto',
                                        fontSize: 13,
                                        fontWeight: FontWeight.w500,
                                      ),
                                    ),
                                    style: ElevatedButton.styleFrom(
                                      backgroundColor: Colors.teal.shade50,
                                      elevation: 0,
                                      padding: const EdgeInsets.symmetric(vertical: 10),
                                      shape: RoundedRectangleBorder(
                                        borderRadius: BorderRadius.circular(10),
                                      ),
                                    ),
                                  ),
                                ),
                              ],
                            ),
                            secondChild: Row(
                              children: [
                                Expanded(
                                  child: TextField(
                                    onChanged: (value) {
                                      setState(() {
                                        double? reading = double.tryParse(value);
                                        _estCharges = (reading ?? 0) * unitCharge;
                                      });
                                    },
                                    keyboardType: TextInputType.number,
                                    decoration: InputDecoration(
                                      labelText: "New Reading",
                                      labelStyle: const TextStyle(fontSize: 13),
                                      contentPadding: const EdgeInsets.symmetric(horizontal: 10, vertical: 12),
                                      border: OutlineInputBorder(
                                        borderRadius: BorderRadius.circular(10),
                                      ),
                                      filled: true,
                                      fillColor: Colors.grey.shade50,
                                    ),
                                  ),
                                ),
                                const SizedBox(width: 10),
                                Expanded(
                                  child: TextField(
                                    enabled: false,
                                    controller: TextEditingController(text: _estCharges.toStringAsFixed(2)),
                                    decoration: InputDecoration(
                                      labelText: "Est. Charges",
                                      labelStyle: const TextStyle(fontSize: 13),
                                      contentPadding: const EdgeInsets.symmetric(horizontal: 10, vertical: 12),
                                      border: OutlineInputBorder(
                                        borderRadius: BorderRadius.circular(10),
                                      ),
                                      filled: true,
                                      fillColor: Colors.grey.shade200,
                                    ),
                                  ),
                                ),
                                const SizedBox(width: 10),
                                ElevatedButton(
                                  onPressed: () {
                                    // ✅ Confirm action
                                  },
                                  style: ElevatedButton.styleFrom(
                                    backgroundColor: Colors.green.shade600,
                                    padding: const EdgeInsets.all(10),
                                    shape: RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(10),
                                    ),
                                  ),
                                  child: const Icon(Icons.check, color: Colors.white, size: 20),
                                ),
                                const SizedBox(width: 6),
                                ElevatedButton(
                                  onPressed: () {
                                    setState(() {
                                      _openIds.remove(billing['id']);
                                      _estCharges = 0;
                                    });
                                  },
                                  style: ElevatedButton.styleFrom(
                                    backgroundColor: Colors.red.shade600,
                                    padding: const EdgeInsets.all(10),
                                    shape: RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(10),
                                    ),
                                  ),
                                  child: const Icon(Icons.close, color: Colors.white, size: 20),
                                ),
                              ],
                            ),
                          ),
                        ),
                        if (_estCharges > 0 && _openIds.contains(billing['id'])) ...[
                          const SizedBox(height: 8),
                          Text(
                            "Your current bill + outstanding dues sum is = Rs.${billing['outstanding_dues'].toString()} + ${_estCharges.toStringAsFixed(2)} = Rs.${(double.parse(billing['outstanding_dues'].toString()) + _estCharges).toStringAsFixed(2)}/-",
                            style: GoogleFonts.getFont(
                              secondaryFont ?? 'Roboto',
                              fontSize: 14,
                              color: Colors.black87,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                        ],
                      ],
                    ),
                  );
                },
            childCount: _billingDetails.length,
          ),
    ),
        ],
      ),
    ),
    );
  }
}

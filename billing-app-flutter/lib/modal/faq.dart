import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';

class FAQModal extends StatefulWidget {
  const FAQModal({super.key});

  @override
  _FAQModalState createState() => _FAQModalState();
}

class _FAQModalState extends State<FAQModal> {
  bool _isDarkMode = false;
  List<bool> _isExpanded = [];
  String _searchQuery = '';

  @override
  void initState() {
    super.initState();
    _loadThemePreference();
  }

  Future<void> _loadThemePreference() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    setState(() {
      _isDarkMode = prefs.getBool('isDarkMode') ?? false;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Dialog(
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(15),
      ),
      backgroundColor: _isDarkMode ? Colors.grey[850] : Colors.white,
      child: Container(
        width: MediaQuery.of(context).size.width * 0.99, // Wider modal
        height: MediaQuery.of(context).size.height * 0.8, // Taller modal
        padding: const EdgeInsets.all(16.0),
        child: SingleChildScrollView(
          child: Column(
            mainAxisSize: MainAxisSize.min,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Stack(
                children: [
                  Center(
                    child: Column(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        Icon(
                          Icons.question_answer,
                          size: 50,
                          color: _isDarkMode ? Colors.blueGrey : Colors.blueAccent,
                        ),
                        const SizedBox(height: 4), // Space between icon and text
                        Text(
                          'Frequently Asked Question',
                          style: TextStyle(
                            fontSize: 18,
                            fontWeight: FontWeight.w600,
                            color: _isDarkMode ? Colors.blueGrey : Colors.blueAccent,
                          ),
                        ),
                        SizedBox(height: 4),
                        Text(
                          'Welcome to the FAQ section, where we answer your most common questions.',
                          textAlign: TextAlign.center,
                          style: TextStyle(
                            fontSize: 12,
                            color: _isDarkMode ? Colors.grey[400] : Colors.grey[600],
                          ),
                        ),
                      ],
                    ),
                  ),
                  Positioned(
                    top: 0,
                    right: 0,
                    child: SizedBox(
                      width: 30, // Reduced size for the close button
                      height: 30,
                      child: IconButton(
                        icon: Icon(
                          Icons.close,
                          size: 18, // Smaller icon size
                          color: _isDarkMode ? Colors.white : Colors.grey,
                        ),
                        padding: EdgeInsets.zero, // Remove internal padding
                        constraints: BoxConstraints(), // Remove default IconButton constraints
                        onPressed: () => Navigator.of(context).pop(),
                      ),
                    ),
                  ),
                ],
              ),


              SizedBox(height: 8),
              TextField(
                onChanged: (value) {
                  setState(() {
                    _searchQuery = value.toLowerCase();
                  });
                },
                style: TextStyle(fontSize: 14),
                decoration: InputDecoration(
                  contentPadding: EdgeInsets.symmetric(vertical: 6, horizontal: 14),
                  hintText: 'Search questions...',
                  hintStyle: TextStyle(color: Colors.grey.shade600),
                  prefixIcon: Icon(Icons.search, size: 20, color: Colors.grey.shade700),
                  filled: true,
                  fillColor: Colors.transparent,
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(12),
                    borderSide: BorderSide(
                      color: Colors.black, // Grey color for the border
                      width: 0.5,           // Border width of 1
                    ),
                ),
                ),
              ),
              SizedBox(height: 8),
              ..._buildFAQList(),
            ],
          ),
        ),
      ),
    );
  }

  List<Widget> _buildFAQList() {
    List<String> questions = [
      'How can I reset my password?',
      'How do I change the theme?',
      'Can I use the app offline?',
      'How do I contact support?',
      'Sample lorem demo question?',
    ];
    List<String> answers = [
      'Go to settings, select "Account", and click on "Reset Password".',
      'Navigate to settings and select your preferred theme.',
      'Some features are available offline, but full functionality requires an internet connection.',
      'Please email support@example.com for assistance.',
      'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus consectetur, purus at aliquet luctus Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus consectetur, purus at aliquet luctus Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus consectetur, purus at aliquet luctus Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus consectetur, purus at aliquet luctus Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus consectetur, purus at aliquet luctus Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus consectetur, purus at aliquet luctus Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus consectetur, purus at aliquet luctus Vivamus consectetur, purus at aliquet luctus.',
    ];

    // Initialize _isExpanded to match the number of questions
    if (_isExpanded.length != questions.length) {
      _isExpanded = List.generate(questions.length, (_) => false);
    }

    List<Widget> filteredFAQs = [];
    for (int i = 0; i < questions.length; i++) {
      if (questions[i].toLowerCase().contains(_searchQuery) ||
          answers[i].toLowerCase().contains(_searchQuery)) {
        filteredFAQs.add(_buildFAQItem(i + 1, questions[i], answers[i], i));
      }
    }
    return filteredFAQs;
  }

  Widget _buildFAQItem(int number, String question, String answer, int index) {
    return GestureDetector(
      onTap: () {
        setState(() {
          _isExpanded[index] = !_isExpanded[index];
        });
      },
      child: AnimatedContainer(
        duration: Duration(milliseconds: 300),
        curve: Curves.easeInOut,
        margin: const EdgeInsets.symmetric(vertical: 5),
        padding: const EdgeInsets.all(12.0),
        decoration: BoxDecoration(
          color: _isDarkMode ? Colors.grey[800] : Colors.grey[200],
          borderRadius: BorderRadius.circular(8),
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              children: [
                Expanded(
                  child: Text(
                    "$number. $question",
                    style: TextStyle(
                      fontSize: 13,
                      fontWeight: FontWeight.bold,
                      color: _isDarkMode ? Colors.white : Colors.black,
                    ),
                  ),
                ),
                AnimatedRotation(
                  turns: _isExpanded[index] ? 0.5 : 0.0,
                  duration: Duration(milliseconds: 300),
                  child: Icon(
                    _isExpanded[index] ? Icons.keyboard_arrow_up : Icons.keyboard_arrow_down,
                    color: _isDarkMode ? Colors.white : Colors.black,
                  ),
                ),
              ],
            ),
            if (_isExpanded[index])
              Padding(
                padding: const EdgeInsets.only(top: 5),
                child: Text(
                  answer,
                  style: TextStyle(
                    fontSize: 12,
                    color: _isDarkMode ? Colors.white70 : Colors.black87,
                    height: 1.4,
                  ),
                ),
              ),
          ],
        ),
      ),
    );
  }
}

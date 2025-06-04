import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';

class PrivacyPolicyModal extends StatefulWidget {
  const PrivacyPolicyModal({super.key});

  @override
  _PrivacyPolicyModalState createState() => _PrivacyPolicyModalState();
}

class _PrivacyPolicyModalState extends State<PrivacyPolicyModal> {
  bool _isDarkMode = false;

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
        borderRadius: BorderRadius.circular(20),
      ),
      backgroundColor: _isDarkMode ? Colors.grey[900] : Colors.white,
      child: Stack(
        children: [
          Padding(
            padding: const EdgeInsets.all(20.0),
            child: SingleChildScrollView(
              child: Column(
                mainAxisSize: MainAxisSize.min,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Center(
                    child: Text(
                      'Privacy Policy',
                      style: TextStyle(
                        fontSize: 24,
                        fontWeight: FontWeight.bold,
                        color: _isDarkMode ? Colors.white : Colors.black,
                      ),
                    ),
                  ),
                  SizedBox(height: 0),
                  Center(
                    child: Text(
                      'Last updated: April 3, 2025',
                      style: TextStyle(
                        fontSize: 10,
                        fontWeight: FontWeight.w500,
                        color: _isDarkMode ? Colors.grey[400] : Colors.grey[700],
                      ),
                    ),
                  ),
                  SizedBox(height: 5),
                  _buildSectionTitle('Information We Collect'),
                  _buildSectionContent(
                      'We collect information that you provide directly to us, such as when you create an account, fill out a form, or interact with our services. This may include personal details like your name, email address, phone number, and any other information you choose to share. Additionally, we may automatically collect data about your device, browsing activities, and interactions with our platform to improve your experience and enhance our services.'),
                  _buildSectionTitle('How We Use Your Information'),
                  _buildSectionContent(
                      'We use your information to provide, maintain, and improve our services, ensuring a personalized and efficient experience. This includes processing your requests, managing your account, and communicating important updates. Additionally, we may analyze usage patterns to enhance features, address technical issues, and develop new offerings. Your information also helps us deliver relevant content and maintain the security of our platform.'),
                  _buildSectionTitle('Data Protection'),
                  _buildSectionContent(
                      'We are committed to safeguarding your data by implementing robust security measures to prevent unauthorized access, alteration, or disclosure. Your information is stored securely and is only accessible by authorized personnel who follow strict confidentiality protocols. We regularly update our security practices to ensure your data remains protected from potential threats and vulnerabilities.'),
                  _buildSectionTitle('Contact Us'),
                  _buildSectionContent(
                      'If you have any questions about our Privacy Policy, please contact us at billing@example.com.'),
                  SizedBox(height: 10),
                ],
              ),
            ),
          ),
          Positioned(
            top: 0,
            right: 0,
            child: IconButton(
              icon: Icon(
                Icons.close,
                size: 20,
                color: _isDarkMode ? Colors.white : Colors.grey,
              ),
              onPressed: () => Navigator.of(context).pop(),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildSectionTitle(String title) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 4.0),
      child: Text(
        title,
        style: TextStyle(
          fontSize: 15,
          fontWeight: FontWeight.bold,
          color: _isDarkMode ? Colors.white : Colors.black,
        ),
      ),
    );
  }

  Widget _buildSectionContent(String content) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 8.0),
      child: Text(
        content,
        style: TextStyle(
          fontSize: 12,
          color: _isDarkMode ? Colors.white70 : Colors.black87,
          height: 1.5,
        ),
      ),
    );
  }
}

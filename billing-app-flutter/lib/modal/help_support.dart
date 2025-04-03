import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';

class HelpSupportModal extends StatefulWidget {
  const HelpSupportModal({Key? key}) : super(key: key);

  @override
  _HelpSupportModalState createState() => _HelpSupportModalState();
}

class _HelpSupportModalState extends State<HelpSupportModal> {
  final _formKey = GlobalKey<FormState>();
  final TextEditingController _nameController = TextEditingController();
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _messageController = TextEditingController();
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
  void dispose() {
    _nameController.dispose();
    _emailController.dispose();
    _messageController.dispose();
    super.dispose();
  }

  void _submitForm() {
    if (_formKey.currentState!.validate()) {
      Navigator.pop(context);
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('Support request submitted successfully!'),
          backgroundColor: Colors.green,
        ),
      );
    }
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
                    child: Column(
                      children: [
                        Icon(
                          Icons.support_agent,
                          size: 50,
                          color: _isDarkMode ? Colors.blueGrey : Colors.blueAccent,
                        ),
                        SizedBox(height: 2),
                        Text(
                          'Help & Support',
                          style: TextStyle(
                            fontSize: 22,
                            fontWeight: FontWeight.bold,
                            color: _isDarkMode ? Colors.blueGrey : Colors.blueAccent,
                          ),
                        ),

                        SizedBox(height: 4),
                        Text(
                          'If you need assistance or have any questions about our application, feel free to reach out through our Help & Support form. Simply fill in your name, email, and message, and our support team will get back to you promptly. We are committed to resolving your issues and providing guidance to ensure a seamless experience. For urgent matters, you can also contact us directly at +1 800 123 4567. Your feedback and concerns are important to us, and we’re here to help!',
                          textAlign: TextAlign.center,
                          style: TextStyle(
                            fontSize: 12,
                            color: _isDarkMode ? Colors.grey[400] : Colors.grey[600],
                          ),
                        ),
                        SizedBox(height: 8),
                        Text(
                          'If you have any further queries, please share your concerns using this form. Our support team is dedicated to assisting you with helpful responses. Your feedback is valuable to us!',
                          textAlign: TextAlign.center,
                          style: TextStyle(
                            fontSize: 12,
                            color: _isDarkMode ? Colors.grey[400] : Colors.grey[600],
                          ),
                        ),
                      ],
                    ),
                  ),
                  SizedBox(height: 10),
                  Form(
                    key: _formKey,
                    child: Column(
                      children: [
                        _buildTextField(_nameController, 'Your Name', Icons.person),
                        SizedBox(height: 6),
                        _buildTextField(_emailController, 'Your Email', Icons.email),
                        SizedBox(height: 6),
                        _buildTextField(_messageController, 'Your Message', Icons.message, maxLines: 3),
                        SizedBox(height: 10),
                        ElevatedButton(
                          onPressed: _submitForm,
                          style: ElevatedButton.styleFrom(
                            backgroundColor: _isDarkMode ? Colors.blueGrey : Colors.blueAccent,
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(30),
                            ),
                            padding: EdgeInsets.symmetric(horizontal: 18, vertical: 2),
                          ),
                          child: Text('Submit', style: TextStyle(color: Colors.white, fontSize: 12)),
                        ),
                        SizedBox(height: 12),
                        Text(
                          'Need urgent help? Call us at +1 800 123 4567',
                          style: TextStyle(
                            fontSize: 12,
                            color: _isDarkMode ? Colors.grey[400] : Colors.grey[700],
                            fontStyle: FontStyle.italic,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),
          Positioned(
            right: 0,
            top: 0,
            child: IconButton(
              icon: Icon(Icons.close, color: _isDarkMode ? Colors.white : Colors.grey),
              onPressed: () => Navigator.of(context).pop(),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildTextField(TextEditingController controller, String label, IconData icon, {int maxLines = 1}) {
    return TextFormField(
      controller: controller,
      decoration: InputDecoration(
        labelText: label,
        prefixIcon: Icon(icon, size: 20,  color: _isDarkMode ? Colors.grey[400] : Colors.grey[700],),
        isDense: true,
        contentPadding: EdgeInsets.symmetric(vertical: 6, horizontal: 8),
        border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
      ),
      maxLines: maxLines,
      style: TextStyle(fontSize: 13, color: _isDarkMode ? Colors.white : Colors.black),
      validator: (value) => value == null || value.isEmpty ? 'Please enter $label' : null,
    );
  }
}

# ⚡ Electricity Billing Application
  <img src="Screenshots/banner.png"  alt="Dashboard"/>

A full-stack Electricity Billing Application built using **Flutter** for the frontend and **Laravel** for the backend.

## 📂 Project Structure

billing-backend (Laravel Backend with Blade Templates) <br>
billing-app-flutter (Flutter Mobile Application)
---

## 🖼️ Screenshots

Here are some previews of the app:

<b>Dashboard</b> :- 
  <img src="Screenshots/dashboard.png"  alt="Dashboard"/>

  <b>Mobile App Dynamic Configuration</b> :- 
  <img src="Screenshots/app configurations.png"  alt="app configuration"/>

<b>Occupant & Houses Tables</b> :- 
  <img src="Screenshots/occupants and houses.png"  alt="Occupants & Houses"/>

<b>Unit Slabs</b> :- 
<img src="Screenshots/unit slabs.png"  alt="Unit Slabs"/>

<b>Billing Details</b> :- 
<img src="Screenshots/billings.png"  alt="billings"/>

<b>Billing Detail Generation</b> :- 
<img src="Screenshots/bill generation.png"  alt="billing Generation"/>

<b>Generated Bill Email Message</b> :- 
<img src="Screenshots/email .png"  alt="Email Message"/>

<b>Razorpay Payment Gateway</b> :- 
<img src="Screenshots/razorpay payments.png"  alt="Payment gateway"/>

<b>Payment Success</b> :- 
<img src="Screenshots/payment success.png"  alt="Payment Success"/>

📱✨ Now the assigned person takes the reading using the mobile app! 🔋📊
✅ No paperwork
📷 Snap the meter
📤 Instantly upload
⚡ Fast, easy & accurate!
## 📲 App Screenshots

### 🔐 App Login Screen  
<img src="Screenshots/login screen.png" alt="Login Screen" width="400"/>

---

### 📊 Dashboard - Light Mode  
<img src="Screenshots/dashboard app.png" alt="Light Dashboard" width="400"/>

---

### 🌙 Dashboard - Dark Mode  
<img src="Screenshots/darkmode.png" alt="Dark Dashboard" width="400"/>

---

### 💧 Billing Submission *(Dynamic Water Billing)*  
<img src="Screenshots/water billing.png" alt="Billing" width="400"/>

---

### ✨ Shimmer Effect While Loading  
<img src="Screenshots/shimmer.png" alt="Shimmer" width="400"/>

---

### 🏠 Bungalow / Houses List  
<img src="Screenshots/bungalow.png" alt="Bungalow List" width="400"/>

---

### 🏡 Bungalow / House Details  
<img src="Screenshots/bungalow details.png" alt="Bungalow Details" width="400"/>

---

### 📜 Billing History  
<img src="Screenshots/history.png" alt="Billing History" width="400"/>

---

### ❓ FAQ  
<img src="Screenshots/faq.png" alt="FAQ" width="400"/>

---

### 🆘 Help  
<img src="Screenshots/help_.png" alt="Help" width="400"/>

---

### 🔒 Privacy Policy  
<img src="Screenshots/privacy policy.png" alt="Privacy Policy" width="400"/>

---


## 🚀 Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/billing_application.git

cd billing-backend

# Install dependencies
composer install

# Copy the example env file
cp .env.example .env

# Generate application key
php artisan key:generate

# Set up your database credentials in .env
# Run migrations
php artisan migrate

# (Optional) Seed initial data
php artisan db:seed

# Start Laravel development server
php artisan serve

cd billing-app-flutter

# Get all dependencies
flutter pub get

# Run the app on connected device
flutter run


DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=billing_db
DB_USERNAME=root
DB_PASSWORD=your_password

APP_URL=http://127.0.0.1:8000




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

<b>App Login Screen</b> :- 
<img src="Screenshots/login screen.png" height="300"  alt="Login Screen"/>

<b>Dashboard Light mode</b> :- 
<img src="Screenshots/dashboard app.png"  alt="Light Dashboard"/>

<b>Dashboard Dark mode</b> :- 
<img src="Screenshots/darkmode.png"  alt="Dark Dashboard"/>

<b>Billing Sumbission (Dynamically we are using Water Billing here)</b> :- 
<img src="Screenshots/water billing.png"  alt="Billing"/>

<b>Mobile App Shimmer Effect while Loading</b> :- 
<img src="Screenshots/shimmer.png"  alt="Shimmer"/>

<b>Bungalow or Houses List</b> :- 
<img src="Screenshots/bungalow.png"  alt="Bungalow list"/>

<b>Bungalow or Houses Details</b> :- 
<img src="Screenshots/bungalow details.png"  alt="Bungalow Details"/>

<b>Billing History</b> :- 
<img src="Screenshots/history.png"  alt="History"/>

<b>FAQ</b> :- 
<img src="Screenshots/faq.png"  alt="FAQ"/>

<b>Help</b> :- 
<img src="Screenshots/help_.png"  alt="Help"/>

<b>Privacy Policy</b> :- 
<img src="Screenshots/privacy policy.png"  alt="Privacy Policy"/>
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




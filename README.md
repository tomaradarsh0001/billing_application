# ⚡ Electricity Billing Application

A full-stack Electricity Billing Application built using **Flutter** for the frontend and **Laravel** for the backend.

## 📂 Project Structure



## 🖼️ Screenshots

Here are some previews of the app:

<p align="center">
  <img src="Screenshots/dashboard.png" width="300" alt="Login Screen"/>
</p>

---

## 🚀 Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/tomaradarsh0001/billing_application.git
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
DB_DATABASE=billing
DB_USERNAME=root
DB_PASSWORD=your_password

APP_URL=http://127.0.0.1:8000

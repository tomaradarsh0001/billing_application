# ⚡ Electricity Billing Application

A full-stack Electricity Billing Application built using **Flutter** for the frontend and **Laravel** for the backend.
  <img src="Screenshots/banner.png" alt="Login Screen"/>

## 📂 Project Structure

billing-backend (Laravel Backend with blade UI)
billing-app-flutter (Flutter Application Source Code)


## 🖼️ Screenshots
Here are the Dashboard of your Application:
  <img src="Screenshots/dashboard.png" alt="Login Screen"/>



## 🚀 Getting Started

### 1. Clone the Repository

git clone https://github.com/tomaradarsh0001/billing_application.git

cd billing-backend

composer install

cp .env.example .env

php artisan key:generate

# Set up your database credentials in .env
php artisan migrate

php artisan db:seed

php artisan serve

cd billing-app-flutter

flutter pub get

flutter run

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=billing
DB_USERNAME=root
DB_PASSWORD=your_password
APP_URL=http://127.0.0.1:8000

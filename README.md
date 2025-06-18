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

#### 2. Go to the Folder
cd billing-backend

#### 3. Install dependencies
composer install

#### 4. Copy the example env file
cp .env.example .env

#### 5. Generate application key
php artisan key:generate

# Set up your database credentials in .env
#### 6. Run migrations
php artisan migrate

#### 7. (Optional) Seed initial data
php artisan db:seed

#### 8. Start Laravel development server
php artisan serve

#### 9. Open Flutter App Code
cd billing-app-flutter

#### 10. Get all dependencies
flutter pub get

#### 11. Run the app on connected device
flutter run

#### 12. Fill Your DB Credentials
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=billing
DB_USERNAME=root
DB_PASSWORD=your_password
APP_URL=http://127.0.0.1:8000

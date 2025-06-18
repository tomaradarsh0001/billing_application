# ⚡ Electricity Billing Application

A full-stack Electricity Billing Application built using **Flutter** for the frontend and **Laravel** for the backend.
  <img src="Screenshots/banner.png" alt="Login Screen"/>

## 📂 Project Structure

billing-backend (Laravel Backend with blade UI) <br>
billing-app-flutter (Flutter Application Source Code)


## 🖼️ Screenshots
Here are the Dashboard of your Application:
  <img src="Screenshots/dashboard.png" alt="Login Screen"/>

## 🚀 Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/tomaradarsh0001/billing_application.git

2. Go to the Backend Folder
cd billing-backend

3. Install Dependencies
composer install

4. Copy the Example .env File
cp .env.example .env

5. Generate Application Key
php artisan key:generate

6. Set Up Database Credentials in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=billing
DB_USERNAME=root
DB_PASSWORD=your_password
APP_URL=http://127.0.0.1:8000

7. Run Migrations
php artisan migrate

8. (Optional) Seed Initial Data
php artisan db:seed

9. Start Laravel Development Server
php artisan serve

10. Open the Flutter App Folder
cd ../billing-app-flutter

11. Get All Dependencies
flutter pub get

12. Run the App on Connected Device
flutter run





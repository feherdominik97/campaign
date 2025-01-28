
# Campaigns Installation Guide

Follow these steps to set up the Campaigns project locally:

## 1. Clone the Repository

Clone the repository to your local machine:
```bash
git clone https://github.com/feherdominik97/campaign.git
cd campaign
```

## 2. Install Dependencies

Install the project dependencies using Composer:
```bash
composer install
```

## 3. Set Up Environment File

Copy the `.env.example` file to `.env`:
```bash
cp .env.example .env
cp .env.testing.example .env.testing
```

## 4. Generate Application Key

Generate the Laravel application key:
```bash
php artisan key:generate
```
Copy the key into .env.testing.

## 5. Set Up the Database

Run the migrations to set up the database schema:
```bash
php artisan migrate
```

Optionally, you can seed the database with sample data:
```bash
php artisan db:seed
```

## 6. Serve the Application

Start the Laravel development server:
```bash
php artisan serve
```

## 7. Run tests

Start the Laravel development server:
```bash
php artisan test --env=testing
```

The application should now be accessible at `http://localhost:8000`.
Documentation: `http://localhost:8000/api/documentation`.

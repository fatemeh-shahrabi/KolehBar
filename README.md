# Kolehbar – AI-powered Travel Planner

Kolehbar is an intelligent web application that provides personalized travel plans based on users' personality, conditions, and budget using artificial intelligence.

---

## Project Overview

Travel planning can often be confusing and scattered. Kolehbar solves this problem by offering tailored local events, destinations, and travel itineraries customized for each user.

---

## Technologies Used

[![Laravel](https://img.shields.io/badge/-Laravel-%23FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/-Livewire-%2322C55E?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel-livewire.com)
[![Tailwind CSS](https://img.shields.io/badge/-Tailwind_CSS-%2306B6D4?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![OpenAI](https://img.shields.io/badge/-OpenAI-%23000000?style=for-the-badge&logo=openai&logoColor=white)](https://openai.com)
[![SQLite](https://img.shields.io/badge/-SQLite-%230073a6?style=for-the-badge&logo=sqlite&logoColor=white)](https://sqlite.org)

---

## Features

- Destination selection and local event suggestions  
- Personalized travel itinerary generation  
- Responsive and user-friendly design  

---

## My Role

Full-stack development using Laravel and mobile-first UI design.

---

## Project Status

Currently in development and at MVP stage.

---

## Screenshots

All screenshots are in the [`screenshots`](./screenshots) folder:

| ![kolakai](./screenshots/kolakai.png) | ![homepage](./screenshots/homepage.png) | ![admin-dashboard-events](./screenshots/admin-dashboard-events.png) |
|---------------------------------------|-----------------------------------------|--------------------------------------------------------------------|

---

## Getting Started

Follow these steps to run the project locally:

```bash
# 1. Clone the repository
git clone https://github.com/fatemeh-shahrabi/Kolehbar.git
cd Kolehbar

# 2. Install PHP dependencies with composer
composer install

# 3. Install JavaScript dependencies with npm
npm install

# 4. Copy the environment file
copy .env.example .env   # Windows
# or
cp .env.example .env     # Linux/macOS

# 5. Generate the application key
php artisan key:generate

# 6. Create an empty SQLite database file
type nul > database/database.sqlite  # Windows
# or
touch database/database.sqlite       # Linux/macOS

# 7. Update your .env file to use SQLite:
# DB_CONNECTION=sqlite
# DB_DATABASE=/full/path/to/database/database.sqlite

# 8. Run database migrations
php artisan migrate

# 9. Compile assets (CSS/JS)
npm run dev

# 10. Run the Laravel development server
php artisan serve

# The app will be accessible at: http://127.0.0.1:8000
```
Environment Variables

Make sure to add your API keys in the .env file:

```env
OPENAI_API_KEY="your_openai_api_key_here"
PINECONE_API_KEY="your_pinecone_api_key_here"
PINECONE_HOST="your_pinecone_host_here"
```

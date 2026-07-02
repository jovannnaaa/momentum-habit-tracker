# 🔥 Momentum — Habit Tracker

Momentum is a habit-tracking web app built with **Laravel 11**. Create habits, check in
daily, and watch your streaks grow. It includes authentication, categories, streak/
completion-rate calculations, and a clean Tailwind UI — all server-rendered with Blade,
no JS build step required.

## Features

- 🔐 Authentication (register / login / logout) using Laravel's built-in auth
- ✅ One-tap daily check-ins per habit
- 🔥 Current streak, longest streak, and 30-day completion rate calculations
- 🗂️ Custom categories with color coding
- 📊 Dashboard overview with aggregate stats
- 🧪 PHPUnit feature & unit tests (auth, habit CRUD, streak logic, authorization)
- 🎨 Tailwind CSS via CDN — zero front-end build tooling needed

## Tech stack

| Layer      | Choice                                   |
|------------|-------------------------------------------|
| Backend    | Laravel 11 (PHP 8.2+)                     |
| Database   | SQLite by default (MySQL/Postgres ready)  |
| Frontend   | Blade + Tailwind CSS (CDN)                |
| Auth       | Laravel session-based auth                |
| Testing    | PHPUnit + Laravel's testing helpers       |

## Getting started

### Requirements

- PHP >= 8.2 with the usual extensions (mbstring, pdo_sqlite, etc.)
- Composer
- SQLite (bundled with PHP) — or MySQL/Postgres if you prefer

### Installation

```bash
git clone https://github.com/<your-username>/momentum.git
cd momentum

composer install

cp .env.example .env
php artisan key:generate

# create the SQLite database file (default driver)
touch database/database.sqlite

php artisan migrate --seed

php artisan serve
```

Visit `http://localhost:8000` and log in with the seeded demo account:

```
email:    demo@momentum.test
password: password
```

### Using MySQL/Postgres instead of SQLite

Uncomment and fill in the relevant `DB_*` variables in `.env`, then re-run
`php artisan migrate --seed`.

### Running tests

```bash
php artisan test
```

## Project structure highlights

```
app/Models/Habit.php          Streak & completion-rate calculations live here
app/Http/Controllers/         HabitController, CheckInController, CategoryController, DashboardController
app/Http/Middleware/          EnsureUserOwnsHabit — authorization guard for habit routes
database/migrations/          users, categories, habits, check_ins
database/seeders/             Demo user with realistic 21-day check-in history
resources/views/              Blade templates (layouts, auth, dashboard, habits, categories)
tests/Feature/                Auth + habit CRUD/authorization tests
tests/Unit/                   Streak calculation tests
```

## Roadmap ideas

- Weekly/monthly analytics charts
- Reminder notifications (email or push)
- Public habit-sharing / accountability partners
- API + mobile client via Sanctum

## License

MIT — see [LICENSE](LICENSE).

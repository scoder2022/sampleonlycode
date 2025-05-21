# Laravel Project

This is a Laravel 9.x project requiring PHP 8.0.2 or higher. It includes essential packages like Sanctum, Socialite, Livewire, Spatie Permissions, and Yajra DataTables.

---

## Requirements

- PHP >= 8.0.2  
- Composer  
- MySQL or compatible database  
- Required PHP extensions: pdo, mbstring, openssl, tokenizer, xml, ctype, json, bcmath

---

## Installation

1. Clone the repo:

   ```bash
   git clone https://github.com/scoder2022/sampleonlycode.git
   cd sampleonlycode
   ```

2. Install dependencies:

   ```bash
   composer install
   ```

3. Copy and configure environment variables:

   ```bash
   cp .env.example .env
   ```

   Update `.env` with your database and other configurations.

4. Generate app key:

   ```bash
   php artisan key:generate
   ```

5. Run migrations and seeders:

   ```bash
   php artisan migrate --seed
   ```

6. Start the development server:

   ```bash
   php artisan serve
   ```

---

## Key Packages

- **laravel/sanctum** – API authentication  
- **laravel/socialite** – Social login  
- **livewire/livewire** – Reactive components  
- **spatie/laravel-permission** – Role & permission management  
- **yajra/laravel-datatables** – Server-side datatables  

---

## Development Tools

- **barryvdh/laravel-debugbar** – Debugging  
- **fakerphp/faker** – Test data generation  
- **phpunit/phpunit** – Testing framework  

---

## Autoload

- PSR-4 autoloading for `App\`, `Database\Factories\`, and `Database\Seeders\`  
- Additional helpers loaded from `app/HelperClass/sitehelpers.php`

---

## Additional Notes

- Run `composer update` to update dependencies.  
- Ensure required PHP extensions are installed and enabled.  
- Use Laravel Debugbar for debugging during development.

---

## License

MIT License

---

*Happy coding!*

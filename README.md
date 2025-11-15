# BookingSystem

Laravel 10 + Filament admin panel that manages bookings, users, and supporting resources. The project is now configured to run without Docker, relying on your local PHP / Node toolchain.

## Project Structure
- `app/Models`, `app/Http`, `app/Policies`, `app/Providers`: core Laravel domain, HTTP layer, authorization, service providers.
- `app/Filament`: Filament resources (forms, tables, widgets) that power the back-office UI.
- `database/migrations`, `database/seeders`, `database/factories`: schema definition, demo data, and test data factories.
- `resources/css|js`, `vite.config.js`: frontend assets compiled through Vite.
- `routes/web.php`, `routes/api.php`: HTTP entrypoints (web + API).

## Running the Project Locally
1. **Install PHP dependencies**
   ```bash
   composer install
   ```
2. **Install JS dependencies**
   ```bash
   npm install
   ```
3. **Environment file**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. **Configure database**
   - Update `.env` with your preferred connection.
   - By default the migrations expect MySQL (`DB_CONNECTION=mysql`). You may also point to `database/database.sqlite` if you prefer SQLite.
5. **Migrate & seed**
   ```bash
   php artisan migrate --seed
   ```
6. **Run the backend**
   ```bash
   php artisan serve
   ```
7. **Run Vite for assets (optional for hot reload)**
   ```bash
   npm run dev
   ```

## Postman Collection
- The `postman_collection.json` file in the project root contains predefined API requests. Import it into Postman to explore and test the endpoints quickly.

## Default Accounts After Seeder
- Admin: email `admin@booking-system.test`, password `password`.
- Staff: email `staff@booking-system.test`, password `password`.

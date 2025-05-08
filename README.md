# Simple CRUD Karyawan

A simple employee (karyawan) management system built with Laravel and Filament.

## Prerequisites

-   PHP >= 8.0
-   Composer
-   MySQL or compatible database
-   Node.js and NPM (for asset compilation)

## Installation

1. Clone the repository:

    ```bash
    git clone <repository-url>
    cd simple-crud-karyawan
    ```

2. Install PHP dependencies:

    ```bash
    composer install
    ```

3. Create and configure the environment file:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. Configure your database connection in the `.env` file:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
    ```

5. Run database migrations:

    ```bash
    php artisan migrate
    ```

6. Create an admin user for Filament admin panel:

    ```bash
    php artisan make:filament-user
    ```

7. Start the development server:
    ```bash
    php artisan serve
    ```

The application will be available at `http://localhost:8000` and the admin panel at `http://localhost:8000/admin`.

## Usage

1. Log in to the admin panel with the credentials you created.
2. Manage employee data through the Filament admin interface.

## License

[MIT](LICENSE)

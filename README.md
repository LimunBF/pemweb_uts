# pemweb_uts

## Project Overview

This project (pemweb_uts) is a web application built using PHP and JavaScript, leveraging the Laravel framework with Tailwind CSS for styling and Node.js for development. It includes backend logic for handling tasks, user management, and data models for items and loans.

## Key Features & Benefits

-   **Task Management:** Efficiently manage tasks with dedicated controllers and models.
-   **User Authentication:** User model included for potential authentication features.
-   **Data Modeling:** Data models for items (`Item.php`) and loans (`Peminjaman.php`) facilitate data management.
-   **Modern Development:** Utilizes Laravel, Tailwind CSS, and Node.js for a modern development experience.
-   **Flexible Frontend:** Built with JavaScript, allowing for dynamic and responsive user interfaces.

## Prerequisites & Dependencies

Before you begin, ensure you have met the following requirements:

-   **PHP:** Version 8.0 or higher
-   **Composer:** PHP dependency manager
-   **Node.js:** Version 16 or higher
-   **NPM:** Node Package Manager (usually installed with Node.js)
-   **MySQL/MariaDB:** Database server

## Installation & Setup Instructions

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/LimunBF/pemweb_uts.git
    cd pemweb_uts
    ```

2.  **Install PHP dependencies using Composer:**

    ```bash
    composer install
    ```

3.  **Install Node.js dependencies using NPM:**

    ```bash
    npm install
    ```

4.  **Copy the `.env.example` file to `.env` and configure your environment variables:**

    ```bash
    cp .env.example .env
    ```

    Edit the `.env` file to configure your database connection and other settings:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```

5.  **Generate an application key:**

    ```bash
    php artisan key:generate
    ```

6.  **Run database migrations:**

    ```bash
    php artisan migrate
    ```

7.  **Start the development server:**

    ```bash
    php artisan serve
    ```

    or using vite

    ```bash
    npm run dev
    ```

## Usage Examples & API Documentation

### Task Controller

The `TaskController` handles the logic for managing tasks. It includes methods for creating, reading, updating, and deleting tasks. Example usage:

```php
// Example in TaskController.php
public function index()
{
    // Retrieve all tasks
    $tasks = Task::all();
    return view('tasks.index', ['tasks' => $tasks]);
}
```

### Models

The `Item.php` and `Peminjaman.php` models are used to interact with the database. Example:

```php
// Example in Item.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'description'];
}
```

## Configuration Options

### Environment Variables

The `.env` file contains the following configurable settings:

| Variable        | Description                                    | Default Value |
| --------------- | ---------------------------------------------- | ------------- |
| `APP_NAME`      | The name of your application                   | `Laravel`     |
| `APP_ENV`       | The environment your application is running in | `local`       |
| `APP_DEBUG`     | Enable or disable debugging mode              | `true`        |
| `APP_URL`       | The URL of your application                    | `http://localhost`     |
| `DB_CONNECTION` | The database connection to use                  | `mysql`       |
| `DB_HOST`       | The database host                                | `127.0.0.1`   |
| `DB_PORT`       | The database port                                | `3306`        |
| `DB_DATABASE`   | The database name                              |               |
| `DB_USERNAME`   | The database username                            |               |
| `DB_PASSWORD`   | The database password                            |               |

### `package.json` Scripts

The `package.json` file contains the following scripts for development:

| Script  | Description                               |
| ------- | ----------------------------------------- |
| `build` | Builds the assets for production         |
| `dev`   | Starts the Vite development server       |

## Contributing Guidelines

Contributions are welcome! Please follow these steps:

1.  Fork the repository.
2.  Create a new branch for your feature or bug fix.
3.  Make your changes and commit them with clear, descriptive messages.
4.  Submit a pull request.

## License Information

This project is open-source and available under the [MIT License](LICENSE.md).
*(Note: A license file (LICENSE.md) should be created and populated for this to be accurate.)*

## Acknowledgments

-   Laravel: [https://laravel.com](https://laravel.com)
-   Tailwind CSS: [https://tailwindcss.com](https://tailwindcss.com)
-   Vite: [https://vitejs.dev/](https://vitejs.dev/)
# Expense Manager

A simple expense tracking web application with a Laravel REST API backend and a plain HTML/CSS/JavaScript frontend. Built as a university assignment demonstrating RESTful API design, framework usage, automated testing, and basic frontend/backend integration.

## Features

- Store expenses with date, cost, description, and expense type (travel / food / other)
- View a list of all expenses
- View individual expense details
- Update and delete existing expenses
- Full RESTful JSON API (`/api/expenses`)
- Server-side validation with clear error responses
- Automated feature tests covering all API endpoints

## Tech Stack

| Layer | Technology |
|---|---|
| Backend framework | Laravel 11 (PHP) |
| Database | MySQL |
| API style | RESTful JSON API |
| Frontend | Plain HTML, CSS, and vanilla JavaScript (`fetch` API) |
| Testing | PHPUnit (Laravel's built-in test framework) |
| Local dev environment | Laragon (Windows) |

## Project Structure

```
expense-manager/
├── app/
│   ├── Http/
│   │   ├── Controllers/ExpenseController.php   # API logic (CRUD)
│   │   ├── Requests/StoreExpenseRequest.php     # validation for creating
│   │   ├── Requests/UpdateExpenseRequest.php    # validation for updating
│   │   └── Resources/ExpenseResource.php        # JSON response shaping
│   └── Models/Expense.php                        # Eloquent model
├── database/
│   ├── migrations/..._create_expenses_table.php  # table schema
│   └── factories/ExpenseFactory.php              # test data factory
├── public/
│   ├── index.html                                # frontend page
│   ├── style.css                                 # frontend styling
│   └── app.js                                    # frontend logic (calls the API)
├── routes/
│   ├── api.php                                   # API routes (RESTful)
│   └── web.php                                   # serves the frontend at "/"
├── tests/
│   └── Feature/ExpenseApiTest.php                # automated API tests
└── openapi.json                                   # API specification (see below)
```

## API Endpoints

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/expenses` | List all expenses |
| POST | `/api/expenses` | Create a new expense |
| GET | `/api/expenses/{id}` | View a single expense |
| PUT/PATCH | `/api/expenses/{id}` | Update an existing expense |
| DELETE | `/api/expenses/{id}` | Delete an expense |

### Expense object shape

```json
{
  "id": 1,
  "date": "2026-09-06",
  "cost": 1500.50,
  "description": "Taxi to airport",
  "expense_type": "travel",
  "created_at": "2026-09-06T10:00:00.000000Z",
  "updated_at": "2026-09-06T10:00:00.000000Z"
}
```

`expense_type` must be one of: `travel`, `food`, `other`.

Costs are recorded in **LKR (Sri Lankan Rupees)**.

## Getting Started (Local Setup)

### Prerequisites

- [Laragon](https://laragon.org/download/) (Full version — includes PHP, MySQL, and Composer)
- [Composer](https://getcomposer.org/) (bundled with Laragon)
- A code editor such as [VS Code](https://code.visualstudio.com/)

### Installation

1. Clone the repository into Laragon's `www` folder:
   ```bash
   cd C:\laragon\www
   git clone <your-repo-url> expense-manager
   cd expense-manager
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Copy the example environment file and generate an app key:
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

4. Create a MySQL database (via HeidiSQL, Laragon's bundled DB tool, or the CLI):
   ```bash
   mysql -u root -e "CREATE DATABASE expense_manager;"
   ```

5. Update `.env` with your database settings:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=expense_manager
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. Register the API routes (required for Laravel 11+) and run migrations:
   ```bash
   php artisan install:api
   php artisan migrate
   ```

7. Start the server:
   ```bash
   php artisan serve
   ```

8. Open the app in your browser:
   ```
   http://127.0.0.1:8000
   ```
   (Or `http://expense-manager.test` if Laragon's virtual host / Auto Virtual Hosts feature is set up correctly for this folder.)

## Running Tests

This project includes automated feature tests covering every API endpoint (create, list, view, validate, delete).

1. Create a separate test database so your real data isn't affected:
   ```bash
   mysql -u root -e "CREATE DATABASE expense_manager_test;"
   ```

2. Ensure `phpunit.xml` points to it:
   ```xml
   <env name="DB_DATABASE" value="expense_manager_test"/>
   ```

3. Run the test suite:
   ```bash
   php artisan test
   ```

## Testing the API Manually (Postman)

1. Import the included Postman collection (`expense-manager.postman_collection.json`, if provided), or create requests manually against `http://127.0.0.1:8000/api/expenses`.
2. Example: create an expense with `POST /api/expenses` and a JSON body:
   ```json
   {
     "date": "2026-09-06",
     "cost": 1500.50,
     "description": "Taxi to airport",
     "expense_type": "travel"
   }
   ```
3. See the [API Endpoints](#api-endpoints) table above for the full set of requests.

## API Specification

A full OpenAPI 3.0.0 specification describing all endpoints, request/response schemas, and validation rules is included in [`openapi.json`](./openapi.json). Any changes made beyond the original assignment specification are documented and marked up in the project report's appendix.


## Author

Built as part of a university web application development assignment.
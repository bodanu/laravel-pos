## Laravel POS API
Simple, in development, POS app built with Laravel

## Features
* Cashier authentication
* Discount applications
* Easy to use

## Requirements
* PHP 8+
* Laravel 9

## Running locally
Clone the repository
```bash
  git clone https://github.com/bodanu/laravel-pos.git
```


Open the project folder in a terminal
```bash
  cd [my-project]
```

Create a .env file in the project root folder and copy the contents from the .env.example file
Or copy below command
```bash
  cp .env.example .env
```
Generate app key
```bash
  php artisan key:generate
```

Create a "db.sqlite" file inside /database folder
```bash
  touch database/db.sqlite
```

Install dependencies
```bash
  composer install
```

(Optional)
```bash
  npm install 
```

Populate database
```bash
  php artisan migrate
```
```bash
  php artisan db:seed
```

Run the local server and visit http://localhost:8000
```bash
  php artisan serve
```

## API Reference

#### Authentication

```http
  POST /api/auth/register
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string` | **Required** |
| `email` | `string` | **Required** |
| `password` | `string` | **Required** |

Returns a user object and new access token

```http
  POST /api/auth/login
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `email` | `string` | **Required** |
| `password` | `string` | **Required** |

Returns logged in status and access token

```http
  POST /api/auth/signout
```

Signs out, does not destroy current order

```http
  GET /api/user
```

Returns authenticated user object.

#### Get all products

```http
  GET /api/products
```

Returns all products.

#### Get all order data

```http
  GET /api/collect
```

Returns active order object (including total price).

#### Get order total

```http
  GET /api/total
```

Returns total price (subtotal, taxes, total) for the active order.



#### "Scan" a product

```http
  POST /api/scan
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `code` | `string` | **Required**, the product code |

Adds product to the order and returns order object

#### Clear all items

```http
  POST /api/clear
```

Removes all items from the order

## Usage/Examples

Use the Terminal service in your class constructors

```php
use App\Services\Terminal;

    public $terminal;

    public function __construct(Terminal $terminal)
    {
        $this->terminal = $terminal;
        ....
    }
    ....
```
Access the available methods

```php
$this->terminal->scan(string)
```
Scans product code and adds to the order

```php
$this->terminal->setPricing()
```
Calculates order line price for each item

```php
$this->terminal->total()
```
Returns total price (subtotal, tax, total)


## Running Tests

To run tests, run the following commands
```bash
  php artisan serve
```
```bash
  php artisan test
```



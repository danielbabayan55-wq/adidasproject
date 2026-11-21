# Adidas Store

An online store built with PHP, JavaScript and MySQL.

I built this project while studying Full-Stack Web Development at DiGi School in Yerevan.

## Features

- Product catalog with search and category filter
- Shopping cart and order checkout
- User registration, login and logout
- JSON API in PHP (`api/cart.php`) called by JavaScript for cart actions
- SQL file with the database tables and 10 test products

## Tech stack

- **Backend:** PHP (PDO), MySQL
- **Frontend:** HTML5, CSS3, JavaScript
- **Tools:** Git, GitHub, VS Code

## Project structure

```
adidasproject/
├── api/cart.php     JSON API for the cart
├── assets/          css, js, images
├── includes/        header, footer, helper functions
├── index.php        home page (hero and new products)
├── products.php     catalog, search and category filter
├── cart.php         cart and checkout
├── login.php        login
├── register.php     registration
├── logout.php       logout
├── config.php       database settings
└── database.sql     tables and 10 test products
```

## How to run locally

1. Install a local server with PHP and MySQL (for example XAMPP or OSPanel) and start Apache and MySQL.
2. Copy the project folder into the server’s web directory (for XAMPP: `C:\xampp\htdocs\`).
3. Open phpMyAdmin, go to the Import tab and import `database.sql`.
4. Check the database host, user and password in `config.php`.
5. Open the project in the browser (for XAMPP: `http://localhost/adidasproject/`).

## Product images

Put image files into `assets/img/products/` and write the file name into the `image` column of the `products` table. A grey placeholder is shown until an image is added.

## Author

Daniel, junior PHP developer from Yerevan, Armenia.

GitHub: [danielbabayan55-wq](https://github.com/danielbabayan55-wq)

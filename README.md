Stationery E-Commerce Web App:

A simple web application for buying and managing stationery products (pens, sharpeners, etc.) built in PHP and MySQL.
This project includes user and admin logins, product management, shopping cart, and checkout functionality.

Features:
User Authentication:
Register, login, and logout functionality for users and an admin.

Product Management (Admin Only):
Add, edit, and delete products.
Manage product images, names, prices, and descriptions.

Shopping Cart:
Add products to cart.
Change product quantities.
Remove products from cart.

Checkout:
Place an order and view order confirmation.

Admin Dashboard: 
Easily manage all products via an admin panel.

TECH STACK:
Backend: PHP, PDO, MySQL
Frontend: HTML, CSS (custom styles)
Database: MySQL

File Structure:
index.php – Displays all products to users.
login.php / register.php – User & admin authentication.
dashboard.php – Admin dashboard (add/manage products).
add_product.php, edit_product.php, delete_product.php, update_product.php – Product management (admin only).
style.css – Styling for layout and UI.
cart.php – Shopping cart functionality.
checkout.php – Place orders.
thank_you.php – Order confirmation.
db.php – Database connection.
/images – Product and icon images.

Database:
Make sure to create a MySQL database and the following tables:
users (id, email, password, role)
products (id, name, price, description, image)
cart (user_id, product_id, quantity)
orders (as needed)
Check and customize the SQL statements as per your need (refer to the PHP files).

Setup Instructions:
Clone the repository:
git clone https://github.com/yourusername/your-repo.git
cd your-repo

Database Setup:
Create a MySQL database.
Create required tables matching the fields in the PHP files.
Update your database credentials in db.php.
Run Locally
Place files in your Apache server's htdocs/public directory.
Start Apache and MySQL.
Open http://localhost/your-repo/index.php in your browser.

Admin Login:
Use login.php and sign in with an admin account (make sure one exists in your users table with role = admin).
Manage products from dashboard.php.

Notes:
This is a sample educational project; not intended for production without security hardening.
Passwords are stored securely using password hashing.
Images are referenced as file names (add them to the /images/ directory).
Check all file paths and database credentials before running.

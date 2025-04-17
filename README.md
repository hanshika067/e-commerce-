# e-commerce-
🛍️ E-Commerce Product Catalog
A basic Amazon/Flipkart-like front-facing e-commerce website built using PHP, MySQL, HTML, and CSS. This project demonstrates product categorization, search, filtering, sorting, supplier linkage, cart functionality, and real-time availability.

🔧 Features
✅ Product Listings with Categories (Clothing, Electronics, Footwear)

🔍 Search & Sort by name, price, and rating

💼 Add to Cart with View and Remove options

📦 Product Availability shown in real time

🔄 Filter by Category

⭐ Ratings with 2.0 to 4.6 range

🧾 Suppliers Table for managing supplier info

🧠 Amazon/Flipkart-inspired design

🧩 Tech Stack
Frontend: HTML, CSS (custom + responsive)

Backend: PHP

Database: MySQL

🗃️ Database Structure
📁 categories Table

Column	Type	Description
id	INT	Primary Key
name	VARCHAR(100)	Category name
📁 products Table

Column	Type	Description
id	INT	Primary Key
name	VARCHAR(255)	Product Name
category_id	INT	FK to Categories
supplier_id	INT	FK to Suppliers
price	DECIMAL(10,2)	Price (₹)
rating	FLOAT	Product rating
image	VARCHAR(255)	Image file name
description	TEXT	Description
availability	INT	In stock?
📁 suppliers Table

Column	Type	Description
id	INT	Primary Key
name	VARCHAR(255)	Supplier Name
contact_info	TEXT	Email/Phone etc
🖼️ Image Naming
Ensure your images are stored inside a folder called images/ and match the image field in your products table.

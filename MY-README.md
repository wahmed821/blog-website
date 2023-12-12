# Project Name: Blog Website

# Command to crate migration

php artisan make:migration create_categories_table --create=categories
php artisan make:migration create_blogs_table --create=blogs
php artisan make:migration create_blog_categories_table --create=blog_categories
php artisan make:migration create_blog_comments_table --create=blog_comments

# Auth Installation

composer require laravel/ui
php artisan ui vue --auth

# To install the UI on auth pages (optional)

npm install
npm run dev

# Category routes functionality

# Blog routes functionality

# Change Password

# Website functionality

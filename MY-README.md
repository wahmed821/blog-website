# Project Name: Blog Website

# Database migration

php artisan make:migration create_categories_table --create=categories
php artisan make:migration create_blogs_table --create=blogs
php artisan make:migration create_blog_categories_table --create=blog_categories
php artisan make:migration create_blog_comments_table --create=blog_comments
php artisan make:migration create_roles_table --create=roles
php artisan make:migration create_verification_codes_table --create=verification_codes

php artisan migrate

# Auth Installation

composer require laravel/ui
php artisan ui vue --auth

# To install the UI on auth pages (optional)

npm install
npm run dev

## Admin Panel

    # Category routes functionality
    # Blog routes functionality
    # Change Password

# Website functionality

    # Home Page
    # Category Page
    # Blog Detail Page
    # Related Posts
    # Comment Posting

## Multi - Auth with Role ID

1. Step 1 - Create New table 'roles' with migration & model and a new column 'role_id' added in users table.

2. Step 2 - Create two new middlewares for Admin & Staff and register them in Kernel

    - Command to create middleware
        > > > php artisan make:middleware AdminMiddleware
        > > > php artisan make:middleware StaffMiddlware

3. Step 3 - Create custom login & logout functionality

4. Step 4 - Staff Registration

5. Step 5 - Staff Login & Logout

## Email Verification & Reset Password

1. Understand Onboarding process
2. Onboarding Routes setup
3. Create the mail class with following command (optional)
    > > > php artisan make:mail SendEmail
4. Signup functionality + Sending verification email
5. Verify Email
6. Forgot Password
7. Reset Password
8. Login & Logout

# Booksie - Online Library System

Web application for managing an online library collection, built with PHP and MySQL.

## Features

- Book management (add/edit/delete)
- Author management 
- User role system (SuperAdmin, Admin, Author, Reader)
- Book filtering and search functionality
- ISBN and metadata tracking
- Image upload for book covers

## User Roles

### SuperAdmin
- Complete system administration
- User management including role assignment
- Full book and author management

### Admin  
- Book management (add/edit/delete)
- Author management
- Basic user management

### Author
- Manage own books
- Browse library database
- Manage own profile

### Reader
- Browse library database
- Search and filter books
- View book details

## Tech Stack

- PHP
- MySQL
- Bootstrap 5
- HTML/CSS
- JavaScript

## Installation

1. Clone the repository
2. Set up MySQL database using install.sql
3. Configure database connection in settings.inc.php
4. Place project in web server directory
5. Access through web browser

## Database Structure

- Users (id, name, email, password, role)
- Books (id, title, author_id, year, ISBN, pages, genre_id, description, cover_image)
- Authors (id, first_name, last_name) 
- Genres (id, name)

## Security Features

- Password hashing
- XSS protection
- SQL injection prevention 
- Role-based access control

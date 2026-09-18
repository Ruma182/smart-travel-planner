
# Smart Travel Planner & Assistant

### Web-Based Travel Planning and Management System

![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![AJAX](https://img.shields.io/badge/AJAX-007ACC?style=for-the-badge)
![MVC](https://img.shields.io/badge/Architecture-MVC-6A5ACD?style=for-the-badge)

> A smart web-based platform for travel planning, destination discovery, booking, and local exploration.
## 🌍 Overview
Smart Travel Planner & Assistant is a web-based travel management system designed to make travel planning, destination exploration, service booking, and travel management easier and more organized.

The system provides different functionalities for four types of users: Traveler, Service Provider, Local Explorer, and Admin.
## ✨ Key Features
| Feature | Description |
|---|---|
| 🔐 User Authentication | Registration and login system with role-based access |
| 🔍 Destination Search | Search and explore available travel destinations |
| 🗺️ Trip Planning | Create and manage personalized trip plans |
| 🏨 Hotel & Transport Booking | Book available services from Service Providers |
| ⭐ Review & Rating | Travelers can review destinations and services |
| ❤️ Favorite Destinations | Save favorite destinations for later |
| 🌤️ Weather Information | Check weather information for destinations |
| 💱 Currency Converter | Convert currencies using the built-in converter |
| 📍 Local Destinations | Local Explorers can add and manage destinations |
| 💡 Travel Tips | Local Explorers can share useful travel tips |
| 🎉 Local Events | Local Explorers can add and manage local events |
| 👨‍💼 Admin Dashboard | Admin can manage major system activities |
| 🔄 AJAX/JSON | Dynamic destination search, weather, and currency conversion |
| ✅ Form Validation | JavaScript and PHP validation |
| 🏗️ MVC Architecture | Separate Models, Views, and Controllers |
## 🛠️ Technology Stack

### Frontend

- HTML5
- CSS3
- JavaScript

### Backend

- PHP
- MySQL/MariaDB

### Other Technologies

- PHP Session
- Cookie
- AJAX
- JSON
- MVC Architecture

### Development Tools

- XAMPP
- Git
- GitHub
## 🚀 Quick Start

### Prerequisites

- XAMPP
- Apache
- MySQL/MariaDB
- Modern Web Browser
- Git

### Installation

1. Clone the repository.
2. Place the project inside the XAMPP `htdocs` directory.
3. Start Apache and MySQL from XAMPP.
4. Create/import the project database.
5. Configure the database connection in `config/database.php`.
6. Open the project in the browser.
http://localhost:8081/web-technology/smart-travel-planner/
## 👥 Development Team

## Development Team

| Role                                                | Member                     | Responsibilities                                                                                                                                                                                                                                                                                                                                                                                                                                     |
| --------------------------------------------------- | -------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Project Developer & Team Lead (Admin Module Developer)** |  RUMA AKTER   | Overall project development, MVC architecture, backend PHP development, database integration, authentication & authorization, session and cookie management, AJAX integration, validation, security, system integration, Development and management of the Admin module, including admin dashboard, user management, role management, destination management, service management, monitoring system activities, and administrative controls  
|**Traveler Module**                          |  JANNATUL FERDOUS |    development of the Traveler module including destination search, personalized trip planning, hotel/transport booking, budget calculator, weather and currency tools, favorites, travel history, and ratings/reviews |                                                                                                                                                                                                                            |
| **Service Provider Module Developer**               |  TONMOY KUMAR SAHA | Development and management of the Service Provider module, including service provider dashboard, adding and managing services, updating service information, viewing bookings, and managing service-related data                                                                                                                                                                                                                                 |
| **Local Explorer Module Developer** | TAHSIN AHMED TOMAL | Development and management of the Local Explorer module, including local explorer dashboard, adding and managing local destinations, creating travel tips, managing travel tips, and providing local travel information                                                                                                                                                                                                                          |

## 📁 Project Structure
smart-travel-planner/
│
├── config/
├── controllers/
├── models/
├── views/
├── js/
│
├── admin_mvc.php
├── booking_mvc.php
├── currency_mvc.php
├── destination_mvc.php
├── favorite_mvc.php
├── local_event_mvc.php
├── review_mvc.php
├── service_provider_mvc.php
├── travel_tip_mvc.php
├── trip_mvc.php
├── weather_mvc.php
│
├── login.php
├── register.php
├── logout.php
├── style.css
└── README.md
## 🔧 System Architecture
User / Browser
      ↓
HTML / CSS / JavaScript
      ↓
PHP Controller
      ↓
PHP Model
      ↓
MySQL / MariaDB
      ↓
Model Result
      ↓
Controller
      ↓
View
      ↓
User / Browser
### Model
Handles database operations.

### View
Displays the user interface.

### Controller
Handles application logic and connects the Model with the View.
## 🔄 CRUD Operations

CRUD operations are implemented in several modules.

### Destinations
- Create
- Read
- Update
- Delete

### Travel Tips
- Create
- Read
- Update
- Delete

### Local Events
- Create
- Read
- Update
- Delete

### Services
- Create
- Read
- Update
- Delete
## 🔐 Authentication & Security

The system uses PHP Session for authentication and role-based access control.

The system checks:
- User login status
- User ID
- User role
- Authorized access to role-specific pages

### Password Security

Passwords are handled using:

- `password_hash()`
- `password_verify()`

### Remember Me

Cookies are used for the Remember Me functionality.
## ✅ Validation

### JavaScript Validation

Client-side JavaScript validation is implemented in:

- Add Local Destination
- Add Travel Service
- Create Trip Plan

### PHP Validation

Server-side validation is implemented in the Controllers before data is stored in the database.

Examples:

- DestinationController
- ServiceProviderController
- TripPlanController
- ReviewController
- TravelTipController
- LocalEventController
## 🔄 AJAX & JSON

AJAX is used to exchange data with the server without reloading the complete webpage.

### Destination Search
AJAX is used for dynamic destination searching.

### Weather
AJAX is used to retrieve weather information.

### Currency Converter
AJAX is used to perform currency conversion dynamically.

The AJAX responses are handled using JSON.
## 💡 Core Functionalities

### 🧳 Traveler

- Destination Search
- Trip Planning
- Hotel/Transport Booking
- Booking Tracking
- Weather
- Currency Converter
- Favorites
- Review & Rating

### 🏨 Service Provider

- Service Creation
- Service Management
- Booking Management
- Booking Approval/Rejection
- Customer Feedback

### 📍 Local Explorer

- Local Destination Management
- Travel Tips Management
- Local Event Management

### 👨‍💼 Administrator

- User Management
- Destination Management
- Service Management
- Booking Management
- Review Management
- Reports
## 📊 Database

The system uses MySQL/MariaDB for persistent data storage.

Major database tables include:

- users
- destinations
- services
- bookings
- trip_plans
- favorites
- reviews
- travel_tips
- events
## 🤝 Git Contribution

Git is used for version control and GitHub is used to maintain the project repository.

Development work is maintained through meaningful commits representing actual project development.

Examples:

- Initial project setup
- Implemented authentication
- Added Traveler features
- Added Local Explorer features
- Added Service Provider features
- Added Admin module
- Implemented MVC architecture
- Added AJAX and JSON functionality
- Added JavaScript validation
- Final project updates
## 🎯 Key Benefits

1. Centralized travel planning and management
2. Multiple user roles with role-based access
3. Easy trip planning and budget management
4. Local destination and event discovery
5. Travel service and booking management
6. Dynamic AJAX-based features
7. Organized MVC architecture
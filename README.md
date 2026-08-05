# To do List 📝✨

A modern, full-stack monolithic MVC web application for managing tasks, daily productivity, and personal workflows. Built with PHP 8.2, MySQL 8.0, Apache, FastRoute, Bootstrap 5.3, Flatpickr, and Docker.

---

## 🚀 Features

- **Personalized Workspace Dashboard**:
  - Hero banner with custom gradient styling and user workspace context.
  - Real-time productivity metric stat cards (Total Tasks, Pending, In Progress, Completed).
- **2-Column Responsive Task Cards**:
  - Tasks arranged in a clean 2-column responsive grid layout (`col-md-6`) with elevated shadow cards (`bg-white`) and hover animations.
- **Dynamic Task Filtering**:
  - Status filter dropdown (All Tasks, Pending, In Progress, Completed) with characteristic dynamic color styling.
- **Priority Visual Coding**:
  - High (Red), Medium (Yellow), and Low (Gray) priority flags and badges with dynamic background colors.
- **Modern Date Picker (Flatpickr)**:
  - Custom Indigo-themed Flatpickr calendar popover for due dates.
- **Header User Dropdown Menu**:
  - Quick access user avatar dropdown with Profile modal, Help modal, and direct Logout.
- **Full Async CRUD Operations**:
  - Create, read, update status, edit, and delete tasks asynchronously via Vanilla JavaScript `fetch()` API.
- **User Authentication**:
  - Secure session-based authentication with password hashing (`password_hash` / `password_verify`).

---

## 🛠️ Technology Stack

### Backend
- **Language & Runtime**: PHP 8.2 with Apache (`mod_rewrite` enabled)
- **Architecture**: Monolithic MVC (Model-View-Controller)
- **Routing**: `nikic/fast-route` (`^1.3`)
- **Database**: MySQL 8.0 with `PDO` prepared statements
- **Package Management**: Composer

### Frontend
- **Structure**: HTML5 Semantic Elements
- **Styling**: Bootstrap 5.3 (CDN) + Custom CSS (`public/assets/css/style.css`)
- **Icons**: Bootstrap Icons (CDN)
- **Date Picker**: Flatpickr (`^4.6`)
- **Client Logic**: Vanilla JavaScript (ES6+), AJAX `fetch()` API

### Infrastructure & Deployment
- **Containerization**: Docker & Docker Compose (`docker-compose.yml`)

---

## 📁 Directory Structure

```text
To Do List/
├── Dockerfile                # Docker PHP 8.2 + Apache image definition
├── docker-compose.yml        # Orchestration for PHP Web app and MySQL database
├── composer.json             # PSR-4 autoloading rules and dependencies
├── config/
│   └── database.php          # Database configuration from environment variables
├── database/
│   └── schema.sql            # MySQL table schemas & initial setup script
├── public/                   # Web Server Document Root
│   ├── .htaccess             # Apache rewrite rules for FastRoute front controller
│   ├── index.php             # Front controller entry point
│   └── assets/
│       ├── css/
│       │   └── style.css     # Custom styles & design tokens
│       ├── js/
│       │   └── tasks.js      # AJAX task operations and dynamic filter UI
│       └── images/           # App screenshots and media
├── routes/
│   └── web.php               # Endpoint route definitions
├── src/                      # Source Core (`App\` namespace via PSR-4)
│   ├── Core/
│   │   └── Database.php      # PDO database connection manager
│   ├── Controllers/          # Controllers (Auth, Dashboard, Home, Task)
│   ├── Models/               # Database models (User, Task)
│   └── Views/                # HTML/PHP view templates and layouts
└── README.md                 # Project documentation
```

---

## 🐳 Getting Started with Docker

### Prerequisites
- [Docker Desktop](https://www.docker.com/products/docker-desktop/) installed and running.

### 1. Run the Application
From the project root directory, launch the containers:
```bash
docker compose up --build -d
```

### 2. Access the Application
- **Web App URL**: [http://localhost:8000](http://localhost:8000)
- **MySQL Database**: `localhost:3306`
  - **Database Name**: `todo_list_db`
  - **Username**: `root`
  - **Password**: `root_password`

### 3. Stop the Application
```bash
docker compose down
```

---

## 🔒 Security Practices

- **SQL Injection Prevention**: All SQL queries utilize PHP `PDO` prepared statements with parameterized inputs.
- **XSS Prevention**: All dynamic View outputs are escaped using `htmlspecialchars()`.
- **Password Security**: Passwords are securely hashed using standard PHP `password_hash()` (Bcrypt / Argon2id).
- **Front Controller Isolation**: All direct requests pass through Apache `mod_rewrite` to `public/index.php`.

---

## 📝 License

This project is open-source and available under the MIT License.

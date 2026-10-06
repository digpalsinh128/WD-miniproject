# 🎓 Basic College Event Registration Portal

A simple, clean, and easy-to-explain Web Development mini-project built using basic **HTML**, **CSS**, **JavaScript**, and **PHP**.

---

## 📁 Files Included

```
WD-miniproject/
│
├── index.php                 # Home page listing upcoming college events
├── register.php              # Form page & PHP script to handle registration
├── view_registrations.php    # Admin page to view registered students in a table
├── style.css                 # Simple, clean CSS for layout, forms, and tables
├── script.js                 # JavaScript function for basic form validation
└── data.json                 # Simple JSON file storing student registrations
```

---

## 🌟 How the Project Works (Basic Concepts)

1. **HTML5 (`index.php`, `register.php`, `view_registrations.php`)**:
   - Standard HTML structure: `<header>`, `<nav>`, `<main>`, `<footer>`, `<form>`, `<input>`, `<select>`, and `<table>`.

2. **CSS3 (`style.css`)**:
   - Clean styling with basic Flexbox (`display: flex`), CSS Grid (`display: grid`), margins, padding, form inputs, and custom table borders.

3. **JavaScript (`script.js`)**:
   - A single simple function `validateForm()` that runs when the form is submitted (`onsubmit="return validateForm()"`).
   - Validates that fields like Full Name, Roll Number, Email, Department, and Event are filled in before sending to PHP.

4. **PHP (`register.php`, `view_registrations.php`)**:
   - **`register.php`**: Receives form data via HTTP `POST` method (`$_POST['student_name']`), checks if fields are not empty, and appends the registration into `data.json`.
   - **`view_registrations.php`**: Reads `data.json` using `file_get_contents()`, decodes it into a PHP array using `json_decode()`, and loops through it with a `foreach` loop to display rows in an HTML `<table>`.

---

## 🗣️ Viva & Faculty Presentation Guide (Quick Answers)

### Question 1: What is your project about?
> *"Sir, my project is a College Event Registration Portal. Students can view upcoming events on the homepage, fill out a registration form, and faculty can view all registered student records in a table."*

### Question 2: How does the form submit data to PHP?
> *"The form in `register.php` uses `method="POST"`. When submitted, PHP receives the values in the `$_POST` superglobal array, converts them into JSON format, and saves them to a file named `data.json`."*

### Question 3: How does `view_registrations.php` display the data?
> *"PHP reads `data.json` using `file_get_contents()`, parses it into an array using `json_decode()`, and renders each student record in an HTML `<table>` using a standard `foreach` loop."*

---

## 🚀 How to Run the Project

1. Copy the `WD-miniproject` folder into `C:\xampp\htdocs\`.
2. Start **Apache** in XAMPP Control Panel.
3. Open your browser and go to: `http://localhost/WD-miniproject/index.php`
   *(OR run `C:\xampp\php\php.exe -S localhost:8000` in terminal and visit `http://localhost:8000`)*.

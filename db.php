<?php
$conn = mysqli_connect("localhost", "root", "", "employee_system");

if (!$conn) {
    die("Database connection failed. Check your database settings.");
}

<?php

/*
<!--
Tyler Costa
27th August 2023

Admin login processing page

ā ē ī ō ū
Ā, Ē, Ī, Ō, Ū

© United Māori Artists | downHEAD | Sinep Industries

-->

*/

require_once 'config/config.php';

$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connection Successful";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE name = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password']; // Retrieve plain text password from the database

        // Compare the provided password with the stored plain text password
        if ($password == $storedPassword) {
            //echo "Login successful!";

            header("Location: another_page.php");
            exit();

        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "Username not found!";
    }

}

$conn->close();


?>

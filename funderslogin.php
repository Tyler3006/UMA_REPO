<?php

/*

<!--
Tyler Costa
27th August 2023

Funders login processing page

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
    $loginPin = $_POST['loginPin'];

    $query = "SELECT * FROM funders WHERE funder_login_pin = '$loginPin'";
    $result = $conn->query($query);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $storedPin = $row['funder_login_pin']; // Retrieve plain text password from the database

        // Compare the provided password with the stored plain text password
        if ($loginPin == $storedPin) {
            echo "Login successful!<br>";
            echo "You are: " . $row['funder_name'] . "<br><br>";


            changeLoginCount($loginPin, $conn);
            displayContent();

        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "Username not found!";
    }

}

function changeLoginCount($loginPin, $conn){
    $query = "SELECT login_count FROM funders WHERE funder_login_pin = '$loginPin'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    $loginCount = $row['login_count'];
    // if ($result->num_rows === 1) {
    //     echo "The login count is: " . $loginCount; // Corrected line
    // }


    $loginCount++;

    echo "The login count is: " . $loginCount; // Corrected line

    $query = "UPDATE funders SET login_count = '$loginCount' WHERE funder_login_pin = '$loginPin';";

    if ($conn->query($query) === TRUE) {
        echo "New record inserted successfully!;";
    } else {
        echo "Error: " . $conn->error;
    }    

}

function displayContent(){
    echo "<br><br><br> *** CONTENT GOES HERE ***";
}

$conn->close();


?>

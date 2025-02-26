<?php
// Create connection to the database
$conn = new mysqli('localhost', 'root', '', 'group_1_shareride_db.');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the POST request
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepare SQL statement to insert data into the database
    $stmt = $conn->prepare("INSERT INTO tbl_users (fname, lname, gender, email, password) VALUES (?, ?, ?, ?, ?)");
    
    // Bind parameters
    $stmt->bind_param("sssss", $firstname, $lastname, $gender, $email, $password);
    
    // Execute the prepared statement
    if ($stmt->execute()) {
        // Redirect to login page after successful registration
        header("Location: login.php");
        exit();
    } else {
        // Show error if something goes wrong
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
}

$conn->close();
?>

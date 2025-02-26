<?php
// Start the session to track user login status
session_start();

// Create a connection to the database
$conn = new mysqli('localhost', 'root', '', 'group_1_shareride_db.');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the POST request
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement to fetch the user's hashed password based on the email
    $stmt = $conn->prepare("SELECT id, fname, lname, password FROM tbl_users WHERE email = ?");
    $stmt->bind_param("s", $email); // Bind the email parameter to the query
    $stmt->execute();
    
    // Store the result
    $stmt->store_result();
    
    // Check if the user exists
    if ($stmt->num_rows > 0) {
        // Bind result variables
        $stmt->bind_result($id, $firstname, $lastname, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;

            // Redirect to the user's dashboard or home page
            header("Location: dashboard.php"); // Replace with the appropriate page
            exit();
        } else {
            // Incorrect password
            echo "Invalid email or password.";
        }
    } else {
        // User not found
        echo "Invalid email or password.";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

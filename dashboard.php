<?php
// Start the session
session_start();

// Check if the user is logged in (check if 'user_id' session variable is set)
if (!isset($_SESSION['user_id'])) {
    header("Location: home.php"); // Redirect to the login page if not logged in
    exit();
}

// Fetch user information from the session
$userFirstName = isset($_SESSION['fname']) ? $_SESSION['fname'] : 'Guest'; // Default to 'Guest' if fname is not set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($userFirstName); ?>!</h2>
    <p>This is your dashboard.</p>
</body>
</html>

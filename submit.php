<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $services = $_POST['services'];
    $price = $_POST['price'];
    $notes = $_POST['notes'];

    // Database credentials
    $servername = "localhost";  // Change if hosted elsewhere
    $username = "root";         // Your database username
    $password = "";             // Your database password
    $dbname = "projectDB";      // The database name

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use a prepared statement to insert data securely
    $stmt = $conn->prepare("INSERT INTO Requests (Name, Phone, Address, AdditionalNotes, EstimatorPrice, Services) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssis", $name, $phone, $address, $notes, $price, $services);

    // Execute the statement
    if ($stmt->execute()) {
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Submission Successful</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    text-align: center;
                    margin: 0;
                    padding: 0;
                    background-color: #F2EED7;
                }
                .container {
                    margin-top: 50px;
                }
                h1 {
                    color: #526E48;
                }
                button {
                    background-color: #526E48;
                    color: white;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 16px;
                }
                button:hover {
                    background-color: #45a049;
                }
                a {
                    text-decoration: none;
                    color: white;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Request Submitted Successfully!</h1>
                <p>Thank you for your submission. We will contact you soon.</p>
                <button><a href="projectWebsite.html">Go to Homepage</a></button>
            </div>
        </body>
        </html>';
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>

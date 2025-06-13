<?php
include 'db.php';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $Full_name = $_POST['Fullname'];
    $Email = $_POST['Email'];
    $Message_Content = $_POST['Message_Content'];
    $Date_posted = date("Y-m-d"); // Automatically use today’s date

    // Use prepared statements for security
    $stmt = $conn->prepare("INSERT INTO message_tbl (Full_Name, Email, Message_Content, Date_Posted) 
                            VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $Full_name, $Email, $Message_Content, $Date_posted);

    // Execute and redirect or show error
    if ($stmt->execute()) {
        header("Location: ../FILES/contact.html"); // Change this to the page you want after submitting
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
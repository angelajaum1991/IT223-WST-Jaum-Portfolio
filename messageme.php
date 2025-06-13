<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "message_board_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    if (!empty($fullname) && !empty($email) && !empty($message)) {
        $sql = "INSERT INTO message_tbl (Full_Name, Email, Message_Content, Date_posted) 
                VALUES ('$fullname', '$email', '$message', CURDATE())";
        $conn->query($sql);
    }
}

// Fetch messages
$messages = $conn->query("SELECT * FROM message_tbl ORDER BY Date_posted DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Message Board</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #e9fef3; /* light mint background */
      padding: 20px;
      color: #2d4039;
    }

    .container {
      max-width: 800px;
      margin: auto;
      background: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    h1, h2 {
      text-align: center;
      color: #2d5948;
    }

    .message-form {
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin-top: 20px;
    }

    .message-form input,
    .message-form textarea {
      padding: 12px;
      border: 1px solid #b2d8cc;
      border-radius: 6px;
      font-size: 16px;
    }

    .message-form button {
      padding: 12px;
      background: #78d5b3; /* mint green */
      color: white;
      font-weight: bold;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .message-form button:hover {
      background: #66c4a3;
    }

    .messages {
      margin-top: 40px;
    }

    .message {
      border-bottom: 1px solid #d6f2e8;
      padding: 15px 0;
    }

    .message strong {
      color: #2d5948;
    }

    .message small {
      display: block;
      color: #555;
      margin-bottom: 5px;
    }

    .message p {
      margin: 0;
      color: #333;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Message Board</h1>
    <form class="message-form" method="POST" action="">
      <input type="text" name="fullname" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <textarea name="message" placeholder="Your message..." rows="5" required></textarea>
      <button type="submit">Post Message</button>
    </form>

    <div class="messages">
      <h2>Recent Messages</h2>
      <?php while ($row = $messages->fetch_assoc()): ?>
        <div class="message">
          <strong><?= htmlspecialchars($row['Full_Name']) ?></strong>
          <small><?= htmlspecialchars($row['Email']) ?> | <?= $row['Date_posted'] ?></small>
          <p><?= nl2br(htmlspecialchars($row['Message_Content'])) ?></p>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</body>
</html>

<?php
include 'db_connection.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute
    $stmt = $conn->prepare("SELECT password FROM userdata WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_password);
        $stmt->fetch();

        if ($password === $db_password) {
            $message = "Login successful";
            // Start the session and redirect to the dashboard or home page
            session_start();
            $_SESSION['username'] = $username;
            header("Location: ../habits.php");
            exit();
        } else {
            $message = "Incorrect password";
        }
    } else {
        $message = "Username not found";
    }

    $stmt->close();
    $conn->close();
    echo "<script>console.log('Debug Objects: " . $message . "' );</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <form method="post" class="form-control">
      <div>
        <label for="username">User Name:</label>
        <input type="text" name="username" id="username" class="form-control" required>
      </div>
      <div>
        <label for="password">Password:</label>
        <input type="text" name="password" id="password" class="form-control" required>
      </div>
      <div>
        <button type="submit" name="register">Submit</button>
      </div>
    </form>
  </body>
</html>

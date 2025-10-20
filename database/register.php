<?php
include 'db_connection.php';

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Check if username already exists
  $checkEmailStmt = $conn->prepare("SELECT username FROM userdata where username = ?");
  $checkEmailStmt->bind_param("s",$username);
  $checkEmailStmt->execute();
  $checkEmailStmt->store_result();

  if ($checkEmailStmt->num_rows > 0){
    $message = "Email ID already exists";
  } else {
    $stmt = $conn->prepare("INSERT INTO userdata (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss",$username,$password);

    if($stmt->execute()){
      $message = "Account created successfully";
    } else {
      $message = "Error: ".$stmt->error;
    }
    $stmt->close();
  }
  $checkEmailStmt->close();
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

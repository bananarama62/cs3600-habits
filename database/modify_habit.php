<?php
session_start();
// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['username'])) {
  header("Location: database/login.php");
  exit();
}

function write_to_console($data) {
 $console = $data;
 if (is_array($console))
 $console = implode(',', $console);

 echo "<script>console.log('Console: " . $console . "' );</script>";
}

include 'data_connection.php';

$id = $_GET['id'];
$type = $_GET['type'];
$invalid_combination = false;
write_to_console($id);
write_to_console($type);
if(isset($id) && isset($type)){
  $stmt = $conn->prepare("SELECT text from userdata where username=? and type=? and id=?");
  $stmt->bind_param("ssi",$_SESSION['username'],$type,$id);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();
  $data = $result->fetch_assoc();
  if($result->num_rows == 0){
    $invalid = true;
  } else {
    $text = $data['text'];
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if(isset($_POST['modify_habit'])){
    if(isset($id) && isset($type) && !$invalid){
      $text = $_POST['text-content']; 
      $stmt = $conn->prepare("UPDATE userdata SET text = ? WHERE username=? and id=? and type=?");
      $stmt->bind_param("ssis",$text,$_SESSION['username'],$id,$type);

      $message = "";
      if($stmt->execute()){
        $message = "Modified habit successfully";
      } else {
        $message = "Error: ".$stmt->error;
      }
      $stmt->close();
      write_to_console($message);
    }
  }
  $conn->close();
}
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Modify Habit</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../CSS/style.css">
    <script src="../JS/title.js"></script>
  </head>
  <body>
    <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <div>
      <div class="navigation-head">
        <div class="site-logo">
          <a href="../index.php">
            <h1>Habits</h1>
          </a>
        </div>
        <ul class="navigation-menu">
          <?php
          // Check if user is logged in, if not redirect to login page
          if (!isset($_SESSION['username'])) {
            echo '<a href="./login.php" class="menu-item active">';
              echo '<li class="underline-hover-effect">Login</li>';
            echo '</a>';
            echo '<a href="./register.php" class="menu-item">';
              echo '<li class="underline-hover-effect">Register</li>';
            echo '</a>';
          } else {
            echo '<a href="../habits.php" class="menu-item">';
              echo '<li class="underline-hover-effect">Habits</li>';
            echo '</a>';
            echo '<a href="./logout.php" class="menu-item">';
              echo '<li class="underline-hover-effect">Logout</li>';
            echo '</a>';
          }
          ?>
        </ul>
      </div>
      <hr id="head-rule">
    </div>
    <div class="breadcrumbs">
      <a href="../index.php">home</a>
      <p>></p>
      <p>modify_habit</p>
    </div>
    <div class="content">
    <?php
    if(!isset($id) || !isset($type)){
      write_to_console("Id or type not set");
      echo '<p>Invalid referral link. Click <a href="../habits.php">here</a> to return to the habits dashboard</p>';
    } else if($invalid){
      write_to_console("Habit not found for type: ".$type." with id: ".$id);
      echo '<p>Invalid referral link. Click <a href="../habits.php">here</a> to return to the habits dashboard</p>';
    } else {
      echo '<h1>Modify habit</h1>';
      echo '<p>Original: <span>'.$text.'</span></p>';
        echo '<form method="post">';
          echo '<div>';
            echo '<label for="text-content">New: </label>';
            echo '<input type="text" name="text-content" id="text-content" required placeholder="This habit is to..." maxlength="255"/>';
          echo '</div>';
          echo '<div>';
            echo '<button type="submit" name="modify_habit">Modify</button>';
          echo '</div>';
        echo '</form>';
    echo '</div>';
    }
    ?>
    <script src="" async defer></script>
    <hr id="foot-rule">
  </body>
  <footer>
    <div class="split-items">
      <p>Last updated: <span>20 October 2025</span></p>
      <p>Author: Josh Gillum</p>
    </div>
    <div class="split-items">
      <a href="../cookies.html">cookies</a>
      <a href="../privacy.html">privacy policy</a>
      <a href="../terms.html">terms and conditions</a>
    </div>
  </footer>
</html>

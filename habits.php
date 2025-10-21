<?php

function write_to_console($data) {
 $console = $data;
 if (is_array($console))
 $console = implode(',', $console);

 echo "<script>console.log('Console: " . $console . "' );</script>";
}
session_start();
// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['username'])) {
  header("Location: database/login.php");
  exit();
}

include './database/data_connection.php';

$daily = [];
$weekly = [];
$monthly = [];
$yearly = [];
$onetime = [];
$stmt = $conn->prepare("SELECT type,id,text FROM userdata WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);
write_to_console("Tasks retrieved:");
foreach($data as $row){
  write_to_console($row);
  if($row['type'] === 'daily'){
    $daily[] = $row;
  } else if($row['type'] === 'weekly'){
    $weekly[] = $row;
  } else if($row['type'] === 'monthly'){
    $monthly[] = $row;
  } else if($row['type'] === 'yearly'){
    $yearly[] = $row;
  } else if($row['type'] === 'onetime'){
    $onetime[] = $row;
  }
}

$stmt->close();
$conn->close();
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
    <title>Habit Tracker</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./CSS/style.css">
    <script src="./JS/title.js"></script>
    <script src="./JS/tabs.js"></script>
  </head>
  <body>
    <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <div>
      <div class="navigation-head">
        <div class="site-logo">
          <a href="./index.php">
            <?php
              echo "<h1>";
              echo "Habits ~ ".ucfirst(strtolower($_SESSION['username']));
              echo "</h1>";
            ?>
          </a>
        </div>
        <ul class="navigation-menu">
          <a href="./habits.php" class="menu-item active">
            <li class="underline-hover-effect">Habits</li>
          </a>
          <a href="./database/logout.php" class="menu-item">
            <li class="underline-hover-effect">Logout</li>
          </a>
        </ul>
      </div>
      <hr id="head-rule">
    </div>
    <div class="breadcrumbs">
      <a href="./index.php">home</a>
      <p>></p>
      <p>habits</p>
    </div>
    <div class="content">
      <div class="tab">
        <div class="tab-buttons">
          <button class="tablinks" id="defaultOpen" onclick="openTab(event, 'Daily')">Daily</button>
          <button class="tablinks" onclick="openTab(event, 'Weekly')">Weekly</button>
          <button class="tablinks" onclick="openTab(event, 'Monthly')">Monthly</button>
          <button class="tablinks" onclick="openTab(event, 'Yearly')">Yearly</button>
          <button class="tablinks" onclick="openTab(event, 'One-time')">One Time</button>
        </div>
        <!-- Tab content -->
        <div id="Daily" class="tabcontent">
          <h3>Daily</h3>
          <div class="habit-content" id="daily-content">
            <?php
              if ($daily){
                foreach($daily as $row){
                echo '<div class="flex">';
                  echo '<label class="habit">';
                    echo '<input type="checkbox" class="toggle-habit" id="daily-'.$row['id'].'" name="daily-'.$row['id'].'">';
                    echo $row['text'];
                  echo '</label>';
                  echo '<div class="habit-modification-buttons flex">';
                    echo '<button>Modify</button>';
                    echo '<button onclick="removeHabit(\'daily-'.$row['id'].'\')">Delete</button>';
                  echo '</div>';
                echo '</div>';
                }
              }
            ?>
          </div>
          <div class="modification-buttons">
            <button class="add-new-habit" onclick="addHabit('daily-content')">Add New Habit</button>
            <button class="submit-habits">Submit Changes</button>
          </div>
        </div>
        <div id="Weekly" class="tabcontent">
          <h3>Weekly</h3>
          <div class="habit-content" id="weekly-content">
            <?php
              if ($weekly){
                foreach($weekly as $row){
                echo '<div class="flex">';
                  echo '<label class="habit">';
                    echo '<input type="checkbox" class="toggle-habit" id="weekly-'.$row['id'].'" name="weekly-'.$row['id'].'">';
                    echo $row['text'];
                  echo '</label>';
                  echo '<div class="habit-modification-buttons flex">';
                    echo '<button>Modify</button>';
                    echo '<button onclick="removeHabit(\'weekly-'.$row['id'].'\')">Delete</button>';
                  echo '</div>';
                echo '</div>';
                }
              }
            ?>
          </div>
          <div class="modification-buttons">
            <button class="add-new-habit" onclick="addHabit('weekly-content')">Add New Habit</button>
            <button class="submit-habits">Submit Changes</button>
          </div>
        </div>
        <div id="Monthly" class="tabcontent">
          <h3>Monthly</h3>
          <div class="habit-content" id="monthly-content">
            <?php
              if ($monthly){
                foreach($monthly as $row){
                echo '<div class="flex">';
                  echo '<label class="habit">';
                    echo '<input type="checkbox" class="toggle-habit" id="monthly-'.$row['id'].'" name="monthly-'.$row['id'].'">';
                    echo $row['text'];
                  echo '</label>';
                  echo '<div class="habit-modification-buttons flex">';
                    echo '<button>Modify</button>';
                    echo '<button onclick="removeHabit(\'monthly-'.$row['id'].'\')">Delete</button>';
                  echo '</div>';
                echo '</div>';
                }
              }
            ?>
          </div>
          <div class="modification-buttons">
            <button class="add-new-habit" onclick="addHabit('monthly-content')">Add New Habit</button>
            <button class="submit-habits">Submit Changes</button>
          </div>
        </div>
        <div id="Yearly" class="tabcontent">
          <h3>Yearly</h3>
          <div class="habit-content" id="yearly-content">
            <?php
              if ($yearly){
                foreach($yearly as $row){
                echo '<div class="flex">';
                  echo '<label class="habit">';
                    echo '<input type="checkbox" class="toggle-habit" id="yearly-'.$row['id'].'" name="yearly-'.$row['id'].'">';
                    echo $row['text'];
                  echo '</label>';
                  echo '<div class="habit-modification-buttons flex">';
                    echo '<button>Modify</button>';
                    echo '<button onclick="removeHabit(\'yearly-'.$row['id'].'\')">Delete</button>';
                  echo '</div>';
                echo '</div>';
                }
              }
            ?>
          </div>
          <div class="modification-buttons">
            <button class="add-new-habit" onclick="addHabit('yearly-content')">Add New Habit</button>
            <button class="submit-habits">Submit Changes</button>
          </div>
        </div>
        <div id="One-time" class="tabcontent">
          <h3>One Time</h3>
          <div class="habit-content" id="onetime-content">
            <?php
              if ($onetime){
                foreach($onetime as $row){
                echo '<div class="flex">';
                  echo '<label class="habit">';
                    echo '<input type="checkbox" class="toggle-habit" id="onetime-'.$row['id'].'" name="onetime-'.$row['id'].'">';
                    echo $row['text'];
                  echo '</label>';
                  echo '<div class="habit-modification-buttons flex">';
                    echo '<button>Modify</button>';
                    echo '<button onclick="removeHabit(\'onetime-'.$row['id'].'\')">Delete</button>';
                  echo '</div>';
                echo '</div>';
                }
              }
            ?>
          </div>
          <div class="modification-buttons">
            <button class="add-new-habit" onclick="addHabit('onetime-content')">Add New Habit</button>
            <button class="submit-habits">Submit Changes</button>
          </div>
        </div>
        <script>
          // Get the element with id="defaultOpen" and click on it
          document.getElementById("defaultOpen").click();
        </script>
      </div>
    </div>
    <script src="" async defer></script>
    <hr id="foot-rule">
  </body>
  <footer>
    <div class="split-items">
      <p>Last updated: <span>20 October 2025</span></p>
      <p>Author: Josh Gillum</p>
    </div>
    <div class="split-items">
      <a href="./cookies.html">cookies</a>
      <a href="./privacy.html">privacy policy</a>
      <a href="./terms.html">terms and conditions</a>
    </div>
  </footer>
</html>

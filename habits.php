<?php
session_start();
// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}
echo "<script>console.log('user: " . $_SESSION['username'] . "' );</script>";
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
          <a href="./index.html">
            <?php
              echo "<h1>";
              echo "Habits ~ ".ucfirst(strtolower($_SESSION['username']));
              echo "</h1>";
            ?>
          </a>
        </div>
        <ul class="navigation-menu">
          <a href="./habits.php" class="menu-item">
            <li class="underline-hover-effect">Habits</li>
          </a>
          <a href="./database/logout.php" class="menu-item">
            <li class="underline-hover-effect">Logout</li>
          </a>
        </ul>
      </div>
      <hr id="head-rule">
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
            <div class="flex">
              <label class="habit">
                <input type="checkbox" class="toggle-habit" id="daily-0" name="daily-0">
                This habit is to do... 
              </label>
              <div class="habit-modification-buttons flex">
                <button>Modify</button>
                <button onclick="removeHabit('daily-0')">Delete</button>
              </div>
            </div>
          </div>
          <div class="modification-buttons">
            <button class="add-new-habit" onclick="addHabit('daily-content')">Add New Habit</button>
            <button class="submit-habits">Submit Changes</button>
          </div>
        </div>
        <div id="Weekly" class="tabcontent">
          <h3>Weekly</h3>
          <div class="habit-content" id="weekly-content">
            <div class="flex">
              <label class="habit">
                <input type="checkbox" class="toggle-habit" id="weekly-0" name="weekly-0">
                This habit is to do... 
              </label>
              <div class="habit-modification-buttons flex">
                <button>Modify</button>
                <button onclick="removeHabit('weekly-0')">Delete</button>
              </div>
            </div>
          </div>
          <div class="modification-buttons">
            <button class="add-new-habit" onclick="addHabit('weekly-content')">Add New Habit</button>
            <button class="submit-habits">Submit Changes</button>
          </div>
        </div>
        <div id="Monthly" class="tabcontent">
          <h3>Monthly</h3>
          <div class="habit-content" id="monthly-content">
            <div class="flex">
              <label class="habit">
                <input type="checkbox" class="toggle-habit" id="monthly-0" name="monthly-0">
                This habit is to do... 
              </label>
              <div class="habit-modification-buttons flex">
                <button>Modify</button>
                <button onclick="removeHabit('monthly-0')">Delete</button>
              </div>
            </div>
          </div>
          <div class="modification-buttons">
            <button class="add-new-habit" onclick="addHabit('monthly-content')">Add New Habit</button>
            <button class="submit-habits">Submit Changes</button>
          </div>
        </div>
        <div id="Yearly" class="tabcontent">
          <h3>Yearly</h3>
          <div class="habit-content" id="yearly-content">
            <div class="flex">
              <label class="habit">
                <input type="checkbox" class="toggle-habit" id="yearly-0" name="yearly-0">
                This habit is to do... 
              </label>
              <div class="habit-modification-buttons flex">
                <button>Modify</button>
                <button onclick="removeHabit('yearly-0')">Delete</button>
              </div>
            </div>
          </div>
          <div class="modification-buttons">
            <button class="add-new-habit" onclick="addHabit('yearly-content')">Add New Habit</button>
            <button class="submit-habits">Submit Changes</button>
          </div>
        </div>
        <div id="One-time" class="tabcontent">
          <h3>One Time</h3>
          <div class="habit-content" id="onetime-content">
            <div class="flex">
              <label class="habit">
                <input type="checkbox" class="toggle-habit" id="onetime-0" name="onetime-0">
                This habit is to do... 
              </label>
              <div class="habit-modification-buttons flex">
                <button>Modify</button>
                <button onclick="removeHabit('onetime-0')">Delete</button>
              </div>
            </div>
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

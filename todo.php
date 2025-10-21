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

$tab = $_GET["type"];

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
    <title>Task Tracker</title>
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
              echo "Tasks ~ ".ucfirst(strtolower($_SESSION['username']));
              echo "</h1>";
            ?>
          </a>
        </div>
        <ul class="navigation-menu">
          <a href="./todo.php" class="menu-item active">
            <li class="underline-hover-effect">Tasks</li>
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
      <p>tasks</p>
    </div>
    <div class="content">
      <div class="tab">
        <div class="tab-buttons">
          <?php
          $names = array(
            array("Daily","Daily","daily",$daily),
            array("Weekly","Weekly","weekly",$weekly),
            array("Monthly","Monthly","monthly",$monthly),
            array("Yearly","Yearly","yearly",$yearly),
            array("One-time","One Time","onetime",$onetime)
          ); 
              if(!isset($tab)){
                $tab="daily";
              }

              foreach($names as $item){
                $prefix = '<button class="tablinks"';
                $middle = '';
                $suffix = ' onclick="openTab(event,\''.$item[0].'\')">'.$item[1].'</button>';
                if($tab == $item[2]){
                  $middle = ' id="defaultOpen"';
                }
                echo $prefix.$middle.$suffix;
          }
        echo '</div>';
        echo '<!-- Tab content -->';
        


        foreach($names as $item){
          echo '<div id="'.$item[0].'" class="tabcontent">';
          echo '<h3>'.$item[1].'</h3>';
          echo '<div class="task-content" id="'.$item[2].'-content">';
          if ($item[3]){
            foreach($item[3] as $row){
              echo '<div class="flex">';
              echo '<label class="task">';
              echo '<input type="checkbox" class="toggle-task" id="'.$item[2].'-'.$row['id'].'" name="'.$item[2].'-'.$row['id'].'">';
              echo $row['text'];
              echo '</label>';
              echo '<div class="task-modification-buttons flex">';
              echo '<a href="database/modify_task.php?type='.$item[2].'&id='.$row['id'].'">Modify</a>';
              echo '</div>';
              echo '</div>';
            }
          }
          echo '<a href="./database/add_task.php?selected='.$item[2].'">Add Task</a>';
          echo '</div>';
          echo '</div>';
        }

        ?>
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

<?php
require("connect-db.php");
require("review-db.php");
require("user-db.php");
require("playlist-db.php");
require("songs-db.php");



if (isset($_COOKIE['user'])) {

  ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">  
  <title>Get started with DB programming</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
</head>

<body>
<?php include("header.html"); ?>  
<div class="container">
  <h1>Welcome back, <td><?php echo $_COOKIE['user'] ?> </td> </h1> 
  <h5>Browse through popular releases! </h5>
  <?php
  $list_of_most_added = getMostAddedToSongs();
  $list_of_top_rated = getTopRatedSongs();
  foreach ($list_of_most_added as $added): 
    echo $added['song_name']. " ";
    echo $added['stage_name'];
    echo "</br >";
   endforeach;
  echo "</br >";
  foreach ($list_of_top_rated as $rated): 
    echo $rated['song_name']. " ";
    echo $rated['stage_name']. " ";
    echo round($rated['average'], 2);
    echo "</br >";
   endforeach;
  ?> 
</div>

 <?php 

}

else 
  header('Location: login.php');   // force login
?>
</table> 
</body>
</html>
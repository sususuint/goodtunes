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
  <title>GoodTunes Home Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
  <style>
      .vertical-center {
         margin: 0;
         position: absolute;
         top: 50%;
         -ms-transform: translateY(-50%);
         transform: translateY(-50%);
         }
      .horizontal-center {
         margin: 0;
         position: absolute;
         left: 50%;
         -ms-transform: translateX(-50%);
         transform: translateX(-50%);
      }
  </style>
</head>

<body style="background-color:pink;">
<?php include("header.html"); ?>  
<div class="container mt-5">
  <h1 class="text-center mt-1">Welcome back, <td><?php echo $_COOKIE['user'] ?>!</td> </h1> 
  <h4 class="text-center">See the most popular releases! </h4>
  <h4 class="text-center">Search for them on the song search tab for more info!</h4>

  <?php
  $list_of_most_added = getMostAddedToSongs();
  $list_of_top_rated = getTopRatedSongs();
  $list_of_random_countries = getRandomCountries();
  echo "</br >";
  echo "Songs most added to playlists:" . "</br >";
  foreach ($list_of_most_added as $added): 
    echo $added['song_name']. " ";
    echo $added['stage_name'];
    echo "</br >";
   endforeach;
  echo "</br >";
  echo "Top Rated Songs: " . "</br >";
  foreach ($list_of_top_rated as $rated): 
    echo $rated['song_name']. " ";
    echo $rated['stage_name']. " ";
    echo round($rated['average'], 2);
    echo "</br >";
   endforeach;
  echo "</br >";
  echo "Countries and their top genres and songs: " . "</br >";
  foreach ($list_of_random_countries as $country): 
    echo $country['country_name']. " ";
    echo $country['popular_genre']. " ";
    echo $country['popular_song']. " ";
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
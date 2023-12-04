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
<div class="container">
  <div class="row">
    <div class="col-sm">
      <?php echo "</br >" ?>
      <img src="https://storage.googleapis.com/imagegoodtunesbucket/musicnotescolor2.png" alt="Music Notes"  width="200" height="125"> 
    </div>
    <div class="col-sm">
      <h2 class="text-center mt-1"><td><?php echo "</br >" ?> Welcome back, <td><?php echo $_COOKIE['user'] ?>!</td> </h2> 
      <h5 class="text-center">See the most popular releases! View the most popular songs and genres in different
      countries. Search for them on the song search tab for more info!</h5>
    </div>
  </div>
</div>
<div class="container mt-5">
  
  

  <?php
  $list_of_most_added = getMostAddedToSongs();
  $list_of_top_rated = getTopRatedSongs();
  $list_of_random_countries = getRandomCountries();
//  echo "</br >";
//  echo "Songs most added to playlists:" . "</br >";
  ?>
  <div class="container">
  <div class="row">
    <div class="col-sm">
      <?php echo "</br >"; ?>
      <h5 class="text-center text-decoration-underline">Most Added Songs</h5>
      <?php
      foreach ($list_of_most_added as $added): ?>
      <h6 class="text-center mt-1"><td><?php echo $added['song_name'] ?> by <?php echo $added['stage_name'] ?></td> </h6> <?php
      endforeach;
      echo "</br >"; ?>
    </div>
    <div class="col-sm">
      <h5 class="text-center"><img src="https://storage.googleapis.com/imagegoodtunesbucket/playlist.webp" alt="Music Notes Playlist"  class="w3-circle" width="250" height="150"> </h5>
    </div>
    <div class="col-sm">
      <?php echo "</br >"; ?>
      <h5 class="text-center text-decoration-underline">Top Rated Songs</h5>
      <?php
      foreach ($list_of_top_rated as $rated): ?>
      <h6 class="text-center mt-1"><td><?php echo $rated['song_name'] ?> by <?php echo $rated['stage_name'] ?> - Average Rating: <?php echo round($rated['average'], 2) ?></td> </h6> <?php
      endforeach;
      echo "</br >"; ?>
    </div>
  </div>
</div>
<div class="container mt-5">
  

  <div class="container">
  <div class="row">
    <div class="col-sm">
      <h5 class="text-center text-decoration-underline">Countries, Top Genres, and Top Songs </h5> 
      <?php
      foreach ($list_of_random_countries as $country): ?>
        <h6 class="text-center mt-1"><td><?php echo $country['country_name'] ?> - Popular Genre: <?php echo $country['popular_genre'] ?> Popular Song: <?php echo $country['popular_song'] ?></td> </h6> <?php
      endforeach;
      echo "</br >";
    ?>  
    </div>
    <div class="col-sm">
      <h5 class="text-center"><img src="https://storage.googleapis.com/imagegoodtunesbucket/musicnotescolor2.png" alt="Music Notes"  width="200" height="125"> </h5>
    </div>
  </div>
  </div>
  <div class="container mt-5">

</div>

 <?php 

}

else 
  header('Location: login.php');   // force login
?>
</table> 
</body>
</html>
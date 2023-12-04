<?php
require("connect-db.php");
require("review-db.php");
require("user-db.php");
require("playlist-db.php");
require("songs-db.php");

# Only display site if user has passed verification and is logged in
if (isset($_COOKIE['user']))
{ 
$list_of_songs = getAllSongs(); # Default this list is all songs
if ($_SERVER['REQUEST_METHOD'] == 'POST') # If any buttons are pressed
{
    if (!empty($_POST['songBtn'])){ # If View Song is pressed then get all this info from DB
        $song_info = getSongInfo($_POST['song_name'], $_POST['release_date']);
        $song_genres = getGenres($_POST['song_name'], $_POST['release_date']);
        $list_of_artists = getArtists($_POST['song_name'], $_POST['release_date']);
        $all_reviews = getAllUserReviews($_POST['song_name'], $_POST['release_date']);
        $avg_rating = getAvgRating($_POST['song_name'], $_POST['release_date']);
    }
    if (!empty($_POST['search'])) # If search is pressed find similar song names
    {
        $list_of_songs = songSearch($_POST['song_name']);
      }
    if (!empty($_POST['addBtn'])) # If add to playlist is pressed, get user's playlists
    {
        $list_of_playlists = getAllPlaylists($_COOKIE['user']);
      }
    if (!empty($_POST['add2Btn'])) # if select playlist is pressed, add song to added_to table in DB (adds song to playlist)
    {
        addToPlaylist($_POST['song_name_to_add'], $_POST['release_date_to_add'], $_COOKIE['user'], $_POST['playlist_num_to_add']);
      }
    if (!empty($_POST['reviewBtn'])) # If write review is pressed, set song info in cookies and redirect to reviews page
    {
      setcookie('reviewSongName', $_POST['song_name'], Time()+60);
      setcookie('reviewRD', $_POST['release_date'], Time()+60);
      header('Location: reviews.php');
      }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">  
  <title>Search Songs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
</head>

<body style="background-color:pink;">
<?php include("header.html"); ?>  
<div class="container">
  <!--Search for songs form that always displays on this page -->
  <h1>Search for songs</h1>  
  <form name="mainForm" action="songs.php" method="post">   
      <div class="row mb-3 mx-3">
        Song:
        <input type="text" class="form-control" name="song_name" required 
            value=""/>        
      </div>  
      <div class="row mb-3 mx-3">
        <input type="submit" value="Search For Songs" name="search" 
                class="btn" style="background-color: #AA336A; color:white" title="Find similar songs" />
      </div>  
    </form>
       

<hr/>
<!-- if Similar Song isn't found and other buttons weren't pressed display message -->
<?php if(empty($list_of_songs) && $_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST['songBtn']) && empty($_POST['addBtn']) && empty($_POST['add2Btn'])){
  echo "A song match wasn't found, please enter another search query!";
} ?>
<!-- if view song, add to playlist, and write review buttons aren't pressed display default page ui-->
<?php if(empty($_POST['songBtn']) && empty($_POST['addBtn']) && empty($_POST['add2Btn'])){ ?>
<h3>Songs:</h3>

<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:90%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="50%">Name     
    <th width="20%">Release Date
    <th width="70%">Artists
    <th width="15%"> 
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  </thead>


<?php 
# Displays all songs or similar songs after song search and brief info as well as some interaction buttons.
foreach ($list_of_songs as $song): ?>
  <tr>
     <td><?php echo $song['song_name'] ?> </td> 
     <td><?php echo $song['release_date']; ?></td>
     <td><?php # Displays all Artists who performed the song
     $list_of_artists = getArtists($song['song_name'], $song['release_date']);
     foreach ($list_of_artists as $artist): 
      echo $artist['stage_name'];
      echo "</br >";
     endforeach;
     ?></td>
     <td> <!-- View Song Button -->
     <form action="songs.php" method="post"> 
            <input type="submit" value="View Song" name="songBtn" class="btn btn-secondary" />
            <input type="hidden" name="song_name"
                    value="<?php echo $song['song_name']; ?>"
            />
            <input type="hidden" name="release_date"
                    value="<?php echo $song['release_date']; ?>"
            />
            <input type="hidden" name="view_song_true"
                    value="<?php echo "True"; ?>"
            />
        </form>
    </td>
    <td> <!-- Add to Playlist Button -->
     <form action="songs.php" method="post"> 
            <input type="submit" value="Add to Playlist" name="addBtn" class="btn btn-secondary" />
            <input type="hidden" name="song_name"
                    value="<?php echo $song['song_name']; ?>"
            />
            <input type="hidden" name="release_date"
                    value="<?php echo $song['release_date']; ?>"
            />
        </form></td>
      <td> <!-- Write Review Button -->
     <form action="songs.php" method="post"> 
            <input type="submit" value="Write Review" name="reviewBtn" class="btn btn-secondary" />
            <input type="hidden" name="song_name"
                    value="<?php echo $song['song_name']; ?>"
            />
            <input type="hidden" name="release_date"
                    value="<?php echo $song['release_date']; ?>"
            />
        </form></td>
  </tr>

<?php endforeach; 
  }

  # Displays a version of the page when view song button is pressed
  if (!empty($_POST['songBtn'])){
    # shows all song information for a particular song that was selected
    foreach ($song_info as $info): ?>
      <div  class= "container row justify-content-center">
        <h2 class="text-center text-decoration-underline" style="background-color: rgba(255,0,0,0.1)"> <?php echo $info['song_name'] . "</br >"; ?> </h2>
          <div class="container">
            <div class="row">
              <div class="col-sm">
                <table class="w3-table w3-bordered w3-card-4 center" style="width:100%">
                  <tr >
                    <th style="background-color:#AA336A; color:white" width="40%"> Release Date: </th>
                    <td width="50%"> <?php echo $info['release_date'] . "</br >"; ?> </td>
                  </tr>
                  <tr >
                    <th style="background-color:#AA336A; color:white" width="40%"> Duration: </th>
                    <td width="50%"> <?php echo $info['duration'] . "</br >"; ?> </td>
                  </tr>
                  <tr >
                    <th style="background-color:#AA336A; color:white" width="40%"> Energy: </th>
                    <td width="50%"> <?php echo $info['energy'] . "</br >"; ?> </td>
                  </tr>
                </table>
              </div>
              
              <div class="col-sm">
                <table class="w3-table w3-bordered w3-card-4 center" style="width:100%">
                  <tr >
                    <th style="background-color:#AA336A; color:white" width="40%"> Artists: </th>
                    <td width="50%"> <?php  foreach ($list_of_artists as $artist): 
                                            echo $artist['stage_name'] . "</br >";
                                            endforeach; ?> </td>
                  </tr>
                  <tr >
                    <th style="background-color:#AA336A; color:white" width="40%"> Genre: </th>
                    <td> <?php  foreach ($song_genres as $genre): 
                                            echo $genre['genre'] . "</br >";
                                            endforeach; ?> </td>
                  </tr>
                  <tr >
                    <th style="background-color:#AA336A; color:white" width="40%"> Average Rating: </th>
                    <td> <?php if (!empty($avg_rating)){
                               $rounded_avg = round($avg_rating['avg_rating'], 2);
                               echo $rounded_avg;}
                               else { echo "N/A";} ?> 
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
      </div>
     <?php endforeach;
     # displays all the reviews for the song
     if(!empty($all_reviews)) { ?>
          <div  class= "container row justify-content-center">
          <h4 class="text-center text-decoration-underline mt-5" style="background-color: rgba(255,0,0,0.1)"> Reviews: </h4>
            <table class="w3-table w3-bordered w3-card-4 center" style="width:100%">
            <thead>
              <tr >
                <th style="background-color:#AA336A; color:white" width="20%"> User: </th>
                <th style="background-color:#AA336A; color:white" width="10%"> Rating (0-5): </th>
                <th style="background-color:#AA336A; color:white" width="40%"> Review: </th>
                <th style="background-color:#AA336A; color:white" width="40%"> User's Avg. Rating Across Various Songs: </th>

              </tr>
            </thead>
            <?php foreach ($all_reviews as $review): ?>
              <tr >
                <td> <?php $username = getUserName($review['user_id']);
                            echo $username['name'] . "</br >"; ?> </td>
                <td> <?php echo $review['rating'] . "</br >"; ?> </td>
                <td> <?php echo $review['review_text'] . "</br >"; ?> </td>
                <?php  $ratings = getUsersAvg($review['user_id']) ?>
                <td> <?php echo round($ratings['@avgRating'], 2) . "</br >"; ?> </td>
              </tr>
            <?php endforeach; } ?>
            </table>
            </div>
    <?php   
  }

  # This button displays a version of the page where user can select the playlist they want to add the song too
  if (!empty($_POST['addBtn'])){
    # If they don't have playlists a message displays
    if (empty($list_of_playlists)){ ?>
      <h3 class="text-center" style="color:#AA336A"> <?php echo "You don't have any playlists. Go to the playlists tab to create one!"; ?> </h3>
    <?php } ?>
    <!-- Else they see a table of playlist options -->
    <table class="w3-table w3-bordered w3-card-4 center" style="width:100%">
    <thead>
      <tr >
        <th style="background-color:#AA336A; color:white" width="20%"> Playlist: </th>
        <th style="background-color:#AA336A; color:white" width="40%"> Description: </th>
        <th style="background-color:#AA336A; color:white">&nbsp;</th>
      </tr>
    </thead>
    <?php foreach ($list_of_playlists as $playlist): ?> 
      <tr >
        <td> <?php echo $playlist['name']. ": "; ?> </td>
        <td> <?php echo $playlist['description'] . "</br >"; ?> </td>
        <td>
        <form action="songs.php" method="post"> 
            <input type="submit" value="Select Playlist" name="add2Btn" class="btn btn-secondary" />
            <input type="hidden" name="song_name_to_add"
                    value="<?php echo $_POST['song_name']; ?>"
            />
            <input type="hidden" name="playlist_num_to_add"
                    value="<?php echo $playlist['playlist_num']; ?>"
            />
            <input type="hidden" name="release_date_to_add"
                    value="<?php echo $_POST['release_date']; ?>"
            />
        </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </table>
<?php
  }
}
# This redirects to the login page if timedout or user isn't verified/logged in
else 
  header('Location: login.php');   // force login
?>
</table> 
</body>
</html>

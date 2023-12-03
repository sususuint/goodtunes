<?php
require("connect-db.php");
require("review-db.php");
require("user-db.php");
require("playlist-db.php");
require("songs-db.php");



if (isset($_COOKIE['user']))
{ 
$list_of_songs = getAllSongs();
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['songBtn'])){
        $song_info = getSongInfo($_POST['song_name'], $_POST['release_date']);
        $song_genres = getGenres($_POST['song_name'], $_POST['release_date']);
        $list_of_artists = getArtists($_POST['song_name'], $_POST['release_date']);
        $all_reviews = getAllUserReviews($_POST['song_name'], $_POST['release_date']);
        $avg_rating = getAvgRating($_POST['song_name'], $_POST['release_date']);
    }
    if (!empty($_POST['search']))
    {
        $list_of_songs = songSearch($_POST['song_name']);
      }
    if (!empty($_POST['addBtn']))
    {
        $list_of_playlists = getAllPlaylists($_COOKIE['user']);
      }
    if (!empty($_POST['add2Btn']))
    {
        addToPlaylist($_POST['song_name_to_add'], $_POST['release_date_to_add'], $_COOKIE['user'], $_POST['playlist_num_to_add']);
      }
    if (!empty($_POST['reviewBtn']))
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
  <h1>Search for songs</h1>  
  <form name="mainForm" action="songs.php" method="post">   
      <div class="row mb-3 mx-3">
        Song:
        <input type="text" class="form-control" name="song_name" required 
            value=""/>        
      </div>  
      <div class="row mb-3 mx-3">
        <input type="submit" value="Search For Songs" name="search" 
                class="btn btn-dark" title="Find similar songs" />
      </div>  
    </form>
       

<hr/>

<?php if(empty($list_of_songs) && $_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST['songBtn']) && empty($_POST['addBtn']) && empty($_POST['add2Btn'])){
  echo "A song match wasn't found, please enter another search query!";
} ?>
<?php if(empty($_POST['songBtn']) && empty($_POST['addBtn']) && empty($_POST['add2Btn'])){ ?>
<h3>Songs:</h3>

<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:90%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="50%">Name     
    <th width="20%">release date
    <th width="70%">artists
    <th width="15%"> 
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  </thead>


<?php 
foreach ($list_of_songs as $song): ?>
  <tr>
     <td><?php echo $song['song_name'] ?> </td> 
     <td><?php echo $song['release_date']; ?></td>
     <td><?php 
     $list_of_artists = getArtists($song['song_name'], $song['release_date']);
     foreach ($list_of_artists as $artist): 
      echo $artist['stage_name'];
      echo "</br >";
     endforeach;
     ?></td>
     <td>
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
    <td>
     <form action="songs.php" method="post"> 
            <input type="submit" value="Add to Playlist" name="addBtn" class="btn btn-secondary" />
            <input type="hidden" name="song_name"
                    value="<?php echo $song['song_name']; ?>"
            />
            <input type="hidden" name="release_date"
                    value="<?php echo $song['release_date']; ?>"
            />
        </form></td>
      <td>
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
  if (!empty($_POST['songBtn'])){
    # shows all song data
    foreach ($song_info as $info): 
      echo $info['song_name'] . "</br >";
      echo $info['release_date'] . "</br >";
      echo $info['duration'] . "</br >";
      echo $info['energy'] . "</br >";
      foreach ($song_genres as $genre):
        echo $genre['genre'] . "</br>";
      endforeach;
      foreach ($list_of_artists as $artist): 
        echo $artist['stage_name'] . "</br >";
      endforeach;
     endforeach;

     # show all reviews for the song?
     if (!empty($all_reviews)){
     foreach ($all_reviews as $reivew): 
      echo $reivew['user_id'] . "</br >";
      echo $reivew['rating'] . "</br >";
      echo $reivew['review_text'] . "</br >";
      $ratings = getUsersAvg($reivew['user_id']);
      echo round($ratings['@avgRating'], 2) . "</br >";
     endforeach;
    }

     # show overall avg rating for song
     if (!empty($avg_rating)){
      $rounded_avg = round($avg_rating['avg_rating'], 2);
      echo $rounded_avg;
     }
     

  }
  if (!empty($_POST['addBtn'])){
    foreach ($list_of_playlists as $playlist): ?> 
      <tr>
      <td><?php echo $playlist['name']. ": "; ?></td>  
      <td><?php echo $playlist['description'] . "</br >"; ?></td>  
      <td>
        <form action="songs.php" method="post"> 
            <input type="submit" value="Add" name="add2Btn" class="btn btn-secondary" />
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
     <?php endforeach;
    

  }

}
else 
  header('Location: login.php');   // force login
?>
</table> 
</body>
</html>

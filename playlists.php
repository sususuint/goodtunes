<?php
require("connect-db.php");
require("review-db.php");
require("user-db.php");
require("playlist-db.php");



if (isset($_COOKIE['user']))
{ 
$list_of_playlists = getAllPlaylists($_COOKIE['user']);
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['confirmUpdateBtn']))
    {
        updatePlaylistByUIDandNum($_COOKIE['user'], $_POST['playlist_num'], $_POST['playlist_name'], $_POST['playlist_description']);
        $list_of_playlists = getAllPlaylists($_COOKIE['user']);
    }
    else if (!empty($_POST['deleteBtn']))
    {
        deletePlaylist($_COOKIE['user'], $_POST['playlist_num_to_delete']);
        $list_of_playlists = getAllPlaylists($_COOKIE['user']);
      }
    else if (!empty($_POST['addPlBtn']))
    {
        addPlaylist($_COOKIE['user'], $_POST['playlist_num'],$_POST['playlist_name'], $_POST['playlist_description']);
        $list_of_playlists = getAllPlaylists($_COOKIE['user']);
      }
    else if (!empty($_POST['delete2Btn']))
    {
        deleteSongFromPlaylist($_POST['song_name_to_delete'], $_POST['release_date_to_delete'], $_COOKIE['user'], $_POST['playlist_num_to_delete']);
        $list_of_playlists = getAllPlaylists($_COOKIE['user']);
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
  <title>Get started with DB programming</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
</head>

<body style="background-color:pink;">
<?php include("header.html"); ?>  
<div class="container">
  <h1>Add A Playlist</h1>  
  <form name="mainForm" action="playlists.php" method="post">   
      <div class="row mb-3 mx-3">
        Playlist Name:
        <input type="text" class="form-control" name="playlist_name" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            { 
              if (!empty($_POST['updateBtn']))  // if the update button has been clicked
                echo $_POST['playlist_name_to_update']; // access the $_POST['param_name'] 
            }
            ?>"
        />        
      </div>  
      <div class="row mb-3 mx-3">
        Playlist Description:
        <input type="text" class="form-control" name="playlist_description" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            { 
              if (!empty($_POST['updateBtn']))  // if the update button has been clicked
                echo $_POST['playlist_description_to_update']; // access the $_POST['param_name'] 
            }
            ?>"
        />        
      </div>
      <div class="row mb-3 mx-3">
        <!-- Playlist ID (DO NOT CHANGE): -->
        <input type="hidden" class="form-control" name="playlist_num" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            { 
              if (!empty($_POST['updateBtn']))
                echo $_POST['playlist_num_to_update'];
                else{
                  $array = getPlaylistNum($_COOKIE['user']);
                  foreach ($array as $item):
                    echo $item['max_num'] + 1;
                  endforeach;
                }
            }
            else{
              $no_plays = True;
              $array = getPlaylistNum($_COOKIE['user']);
              foreach ($array as $item):
                $no_plays = False;
                echo $item['max_num'] + 1;
              endforeach;
              if ($no_plays){
                echo 1;
              }
            }
            ?>"
        />        
      </div>     
      <div class="row mb-3 mx-3">
        <input type="submit" value="Add Playlist" name="addPlBtn" 
                class="btn" style="background-color: #AA336A; color:white" title="Insert a playlist into a playlist table" />
      </div>  
      <div class="row mb-3 mx-3">
        <input type="submit" value="Confirm update" name="confirmUpdateBtn" 
                class="btn" style="background-color: #AA336A; color:white" title="Update a playlist in playlist table" />
      </div>  
    </form>     

<hr/>
<h3>Your Playlists:</h3>
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <!-- <th width="30%">Playlist Number      -->
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th width="30%">Name     
    <th width="50%">Description
    <th width="50%">Songs
    <th>&nbsp;</th>
  </tr>
  </thead>


<?php foreach ($list_of_playlists as $playlist): ?>

  <tr>
     <td>
        <form action="playlists.php" method="post"> 
            <input type="submit" value="Update" name="updateBtn" class="btn btn-secondary" />
            <input type="hidden" name="playlist_name_to_update"
                    value="<?php echo $playlist['name']; ?>"
            />
            <input type="hidden" name="playlist_description_to_update"
                    value="<?php echo $playlist['description']; ?>"
            />
            <input type="hidden" name="playlist_num_to_update"
                    value="<?php echo $playlist['playlist_num']; ?>"
            />
        </form>
     </td>
     <td>
        <form action="playlists.php" method="post"> 
            <input type="submit" value="Delete" name="deleteBtn" class="btn btn-danger"  />
            <input type="hidden" name="name_to_delete"
                    value="<?php echo $playlist['name']; ?>"
            />
            <input type="hidden" name="playlist_num_to_delete"
                    value="<?php echo $playlist['playlist_num']; ?>"
            />
            <input type="hidden" name="user_id_to_delete"
                    value="<?php echo $playist['user_id']; ?>"
            />
            <input type="hidden" name="playlist_description_to_delete"
                    value="<?php echo $playlist['description']; ?>"
            />
     </form>
    </td>
     <td><?php echo $playlist['name']; ?></td>
     <td><?php echo $playlist['description']; ?></td>
     <td><?php 
       $songs = getSongs($playlist['user_id'], $playlist['playlist_num']);
       foreach ($songs as $song):
        echo $song['song_name'];
        echo "</br >";
        ?>
        <form action="playlists.php" method="post"> 
            <input type="submit" value="Delete song" name="delete2Btn" class="btn btn-danger"  />
            <input type="hidden" name="song_name_to_delete"
                    value="<?php echo $song['song_name']; ?>"
            />
            <input type="hidden" name="release_date_to_delete"
                    value="<?php echo $song['release_date']; ?>"
            />
            <input type="hidden" name="playlist_num_to_delete"
                    value="<?php echo $playlist['playlist_num']; ?>"
            />
     </form>
         <?php
    echo "</br >";
       endforeach;
       
     ?></td>
  </tr>
<?php endforeach; } 
else 
  header('Location: login.php');   // force login
?>
</table> 
</body>
</html>

<?php
require("connect-db.php");
require("review-db.php");
require("user-db.php");
require("playlist-db.php");
require("songs-db.php");
require("artists-db.php");



if (isset($_COOKIE['user']))
{ 
$list_of_artists = getAllArtists();
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['artistBtn'])){
        $artist_info = getArtistInfo($_POST['stage_name']);
        $fun_facts = getArtistFunFacts($_POST['stage_name']);
        $where_from = getArtistWhereFrom($_POST['stage_name']);
    }
    if (!empty($_POST['search']))
    {
        $list_of_artists = artistSearch($_POST['stage_name']);
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
  <title>Search Artists</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
</head>

<body style="background-color:pink;">
<?php include("header.html"); ?>  
<div class="container">
  <h1>Search for artists</h1>  
  <form name="mainForm" action="artists.php" method="post">   
      <div class="row mb-3 mx-3">
        Artist:
        <input type="text" class="form-control" name="stage_name" required 
            value=""/>        
      </div>  
      <div class="row mb-3 mx-3">
        <input type="submit" value="Search For Artists" name="search" 
                class="btn btn-dark" title="Find similar artists" />
      </div>  
    </form>
       

<hr/>

<?php if(empty($list_of_artists) && $_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST['artistBtn']) && empty($_POST['addBtn']) && empty($_POST['add2Btn'])){
  echo "An artist match wasn't found, please enter another search query!";
} ?>
<?php if(empty($_POST['artistBtn'])){ ?>
<h3>Artists:</h3>

<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:90%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="50%">Stage Name    
    <th width="20%">Age
    <th width="70%">Artist Type
    <th width="15%"> 
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  </thead>


<?php 
foreach ($list_of_artists as $artist): ?>
  <tr>
     <td><?php echo $artist['stage_name'] ?> </td> 
     <td><?php echo $artist['age']; ?></td>
     <td><?php echo $artist['artist_type']; ?></td>
     <td><?php 
     ?></td>
     <td>
     <form action="artists.php" method="post"> 
            <input type="submit" value="View Artist" name="artistBtn" class="btn btn-secondary" />
            <input type="hidden" name="stage_name"
                    value="<?php echo $artist['stage_name']; ?>"
            />
            <input type="hidden" name="age"
                    value="<?php echo $artist['age']; ?>"
            />
            <input type="hidden" name="view_artist_true"
                    value="<?php echo "True"; ?>"
            />
        </form>
    </td>
  </tr>

<?php endforeach; 
  }
  if (!empty($_POST['artistBtn'])){
    # shows all artist data
    foreach ($artist_info as $info): 
      echo "Stage Name: " . $info['stage_name'] . "</br >";
      echo "Age " . $info['age'] . "</br >";
      echo "Artist Type: " . $info['artist_type'] . "</br >";
      foreach ($fun_facts as $fact):
        echo $fact['fun_fact'] . "</br>";
      endforeach;
      foreach ($where_from as $from):
        echo "From " . $from['country_name'] . "</br>";
      endforeach;
     endforeach;
     

  }

}
else 
  header('Location: login.php');   // force login
?>
</table> 
</body>
</html>

<?php
require("connect-db.php");
// include("connect-db.php");
require("review-db.php");
require("user-db.php");



if (isset($_COOKIE['user']))
{ 
$list_of_reviews = getAllReviews($_COOKIE['user']);
$validRating = True;
$songExists = True;
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['confirmUpdateBtn']))
    {
      $validRating = False;
        if ($_POST['rating'] <= 5 && $_POST['rating'] >= 0){
          $validRating = True;
        } 
        $songExists = False;
        $list_of_songs= getAllSongs();
        foreach ($list_of_songs as $song):
          if ($_POST['song_name'] == $song['song_name'] && $_POST['release_date'] == $song['release_date']){
            $songExists = True;
          } 
        endforeach;
        if ($validRating && $songExists){
          updateReviewByName($_POST['song_name'], $_POST['release_date'], $_COOKIE['user'], $_POST['review_number'], $_POST['rating'], $_POST['review_text']);
          $list_of_reviews = getAllReviews($_COOKIE['user']);}
    }
    else if (!empty($_POST['deleteBtn']))
    {
        deleteReview($_POST['song_name_to_delete'], $_POST['release_date_to_delete'], $_COOKIE['user'], $_POST['review_number_to_delete']);
        $list_of_reviews = getAllReviews($_COOKIE['user']);  
    }
    else if (!empty($_POST['addBtn']))
    {
        $validRating = False;
        if ($_POST['rating'] <= 5 && $_POST['rating'] >= 0){
          $validRating = True;
        } 
        $songExists = False;
        $list_of_songs= getAllSongs();
        foreach ($list_of_songs as $song):
          if ($_POST['song_name'] == $song['song_name'] && $_POST['release_date'] == $song['release_date']){
            $songExists = True;
          } 
        endforeach;
        if ($validRating && $songExists){
          addReview($_POST['song_name'], $_POST['release_date'], $_COOKIE['user'], $_POST['review_number'], $_POST['rating'], $_POST['review_text']);
          $list_of_reviews = getAllReviews($_COOKIE['user']);}
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
  <title>My Reviews</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
</head>

<body style="background-color:pink;">
<?php include("header.html"); ?>  
<div class="container">
  <h1>Add Review</h1>  
  <form name="mainForm" action="reviews.php" method="post">   
      <div class="row mb-3 mx-3">
        Song name:
        <input type="text" class="form-control" name="song_name" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            { 
              if (!empty($_POST['updateBtn']))  // if the update button has been clicked
                echo $_POST['song_name_to_update']; // access the $_POST['param_name'] 
            }
            if (!empty($_COOKIE['reviewSongName']))
              echo $_COOKIE['reviewSongName'];
            ?>"
        />        
      </div>  
      <div class="row mb-3 mx-3">
        Release date:
        <input type="text" class="form-control" name="release_date" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            { 
              if (!empty($_POST['updateBtn'])) 
                echo $_POST['release_date_to_update'];  
            }
            if (!empty($_COOKIE['reviewRD']))
              echo $_COOKIE['reviewRD'];
            ?>"
        />        
      </div>
      <div class="row mb-3 mx-3">
        <input type="hidden" class="form-control" name="review_number" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            { 
              if (!empty($_POST['updateBtn']))  // if the update button has been clicked
                echo $_POST['review_number_to_update']; // access the $_POST['param_name'] 
                else{
                  $array = getReviewNum($_COOKIE['user']);
                  foreach ($array as $item):
                    echo $item['max_num'] + 1;
                  endforeach;
                }
            }
            else{
              $no_plays = True;
              $array = getReviewNum($_COOKIE['user']);
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
        Rating (0-5):
        <input type="text" class="form-control" name="rating" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            { 
              if (!empty($_POST['updateBtn']))  // if the update button has been clicked
                echo $_POST['rating_to_update']; // access the $_POST['param_name'] 
            }
            ?>"
        />        
      </div>   
      <div class="row mb-3 mx-3">
        Review text:
        <input type="text" class="form-control" name="review_text" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            { 
              if (!empty($_POST['updateBtn']))  // if the update button has been clicked
                echo $_POST['review_text_to_update']; // access the $_POST['param_name'] 
            }
            ?>"
        />        
      </div>    
      <div class="row mb-3 mx-3">
        <input type="submit" value="Add review" name="addBtn" 
              class="btn" style="background-color: #AA336A; color:white" title="Insert a review into a review table" />
      </div>  
      <div class="row mb-3 mx-3">
        <input type="submit" value="Confirm update" name="confirmUpdateBtn" 
              class="btn" style="background-color: #AA336A; color:white" title="Update a review in a review table" />
      </div>  
    </form>     

<hr/>
<?php 
  if (!$validRating){
    echo "The rating was out of range please rate the song between 0 and 5!" . "</br>";}
  if (!$songExists){
    echo "The song doesn't exist, please add a review by searching for song in navbar song search tab! You can also find song names and release dates there!";}
?>

<h3>List of your reviews</h3>
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:80%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="30%">Song       
    <th width="30%">Release Date
    <th width="10%">Rating
    <th width="50%">Review
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  </thead>


<?php foreach ($list_of_reviews as $review): ?>
  <tr>
     <td><?php echo $review['song_name']; ?></td> 
     <td><?php echo $review['release_date']; ?></td>
     <td><?php echo $review['rating']; ?></td>        
     <td><?php echo $review['review_text']; ?></td> 
     <td>
        <form action="reviews.php" method="post"> 
            <input type="submit" value="Update" name="updateBtn" class="btn btn-secondary" />

            <input type="hidden" name="song_name_to_update"
                    value="<?php echo $review['song_name']; ?>"
            />
            <input type="hidden" name="release_date_to_update"
                    value="<?php echo $review['release_date']; ?>"
            />
            <input type="hidden" name="review_number_to_update"
                    value="<?php echo $review['review_number']; ?>"
            />
            <input type="hidden" name="rating_to_update"
                    value="<?php echo $review['rating']; ?>"
            />
            <input type="hidden" name="review_text_to_update"
                    value="<?php echo $review['review_text']; ?>"
            />
        </form>
     </td>
     <td>
        <form action="reviews.php" method="post"> 
            <input type="submit" value="Delete" name="deleteBtn" class="btn btn-danger"  />
            <input type="hidden" name="song_name_to_delete"
                    value="<?php echo $review['song_name']; ?>"
            />
            <input type="hidden" name="release_date_to_delete"
                    value="<?php echo $review['release_date']; ?>"
            />
            <input type="hidden" name="user_id_to_delete"
                    value="<?php echo $review['user_id']; ?>"
            />
            <input type="hidden" name="review_number_to_delete"
                    value="<?php echo $review['review_number']; ?>"
            />
     </form>
    </td>
  </tr>
<?php endforeach; } 
else 
  header('Location: login.php');   // force login
?>
</table>
</div>  



  <!-- CDN for JS bootstrap -->
  <!-- you may also use JS bootstrap to make the page dynamic -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
  
  <!-- for local -->
  <!-- <script src="your-js-file.js"></script> -->  
  
</div>    
</body>
</html>

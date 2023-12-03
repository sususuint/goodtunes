<?php
require("connect-db.php");
// include("connect-db.php");
require("review-db.php");
require("user-db.php");



if (isset($_COOKIE['user']))
{ 
$list_of_reviews = getAllReviews($_COOKIE['user']);
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['confirmUpdateBtn']))
    {
        updateReviewByName($_POST['song_name'], $_POST['release_date'], $_POST['user_id'], $_POST['review_number'], $_POST['rating'], $_POST['review_text']);
        $list_of_reviews = getAllReviews($_COOKIE['user']);    // name, major, year
    }
    else if (!empty($_POST['deleteBtn']))
    {
        deleteReview($_POST['song_name_to_delete'], $_POST['release_date_to_delete'], $_POST['user_id_to_delete'], $_POST['review_number_to_delete']);
        $list_of_reviews = getAllReviews($_COOKIE['user']);    // name, major, year
    }
    else if (!empty($_POST['addBtn']))
    {
        addReview($_POST['song_name'], $_POST['release_date'], $_POST['user_id'], $_POST['review_number'], $_POST['rating'], $_POST['review_text']);
        $list_of_reviews = getAllReviews($_COOKIE['user']);    // name, major, year
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

<body>
<?php include("header.html"); ?>  
<div class="container">
  <h1>Add Review</h1>  
  <form name="mainForm" action="reviews.php" method="post">   
      <div class="row mb-3 mx-3">
        Your user id:
        <input type="text" class="form-control" name="user_id" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            { 
              if (!empty($_POST['updateBtn']))  // if the update button has been clicked
                echo $_POST['user_id_to_update']; // access the $_POST['param_name'] 
            }
            // echo $_POST['year_to_update']; 
            ?>"  
        />  
      </div>  
      <div class="row mb-3 mx-3">
        Song name:
        <input type="text" class="form-control" name="song_name" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            { 
              if (!empty($_POST['updateBtn']))  // if the update button has been clicked
                echo $_POST['song_name_to_update']; // access the $_POST['param_name'] 
            }
            // echo $_POST['year_to_update']; 
            ?>"
        />        
      </div>  
      <div class="row mb-3 mx-3">
        Release date:
        <input type="text" class="form-control" name="release_date" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            { 
              if (!empty($_POST['updateBtn']))  // if the update button has been clicked
                echo $_POST['release_date_to_update']; // access the $_POST['param_name'] 
            }
            // echo $_POST['year_to_update']; 
            ?>"
        />        
      </div>
      <div class="row mb-3 mx-3">
        Review Number:
        <input type="text" class="form-control" name="review_number" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            { 
              if (!empty($_POST['updateBtn']))  // if the update button has been clicked
                echo $_POST['review_number_to_update']; // access the $_POST['param_name'] 
            }
            else{
              $array = getreviewNum($_COOKIE['user']);
              foreach ($array as $item):
                echo $item['count'] + 1;
              endforeach;
            }
            ?>"
        />        
      </div> 
      <div class="row mb-3 mx-3">
        Rating:
        <input type="text" class="form-control" name="rating" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            { 
              if (!empty($_POST['updateBtn']))  // if the update button has been clicked
                echo $_POST['rating_to_update']; // access the $_POST['param_name'] 
            }
            // echo $_POST['year_to_update']; 
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
            // echo $_POST['year_to_update']; 
            ?>"
        />        
      </div>    
      <div class="row mb-3 mx-3">
        <input type="submit" value="Add review" name="addBtn" 
                class="btn btn-primary" title="Insert a review into a review table" />
      </div>  
      <div class="row mb-3 mx-3">
        <input type="submit" value="Confirm update" name="confirmUpdateBtn" 
                class="btn btn-primary" title="Update a review in a review table" />
      </div>  
    </form>     

<hr/>
<h3>List of your reviews</h3>
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="30%">Review Number      
    <th width="30%">Song       
    <th width="30%">Release Date
    <th width="30%">Rating
    <th width="30%">Review
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  </thead>


<?php foreach ($list_of_reviews as $review): ?>
  <tr>
     <!-- <td><?php echo $review['user_id']; ?></td>  -->
     <td><?php echo $review['review_number']; ?></td>         
     <td><?php echo $review['song_name']; ?></td> 
     <td><?php echo $review['release_date']; ?></td>
     <td><?php echo $review['rating']; ?></td>        
     <td><?php echo $review['review_text']; ?></td> 
     <td>
        <form action="reviews.php" method="post"> 
            <input type="submit" value="Update" name="updateBtn" class="btn btn-secondary" />
            <input type="hidden" name="user_id_to_update"
                    value="<?php echo $review['user_id']; ?>"
            />
            <input type="hidden" name="song_name_to_update"
                    value="<?php echo $review['song_name']; ?>"
            />
            <input type="hidden" name="release_date_to_update"
                    value="<?php echo $review['release_date']; ?>"
            />
            <input type="hidden" name="review_number_to_update"
                    value="<?php echo $review['review_number']; ?>"
            />
            <input type="hidden" name="user_id_to_update"
                    value="<?php echo $review['user_id']; ?>"
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
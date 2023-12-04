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

<body style="background-color:pink;" >
<?php include("header.html"); ?>  
<?php 
require("connect-db.php");
require("review-db.php");
require("user-db.php");
$user = getUserPass($_COOKIE['user']); ?>
<div class="container">
  <h1>Update your account info!</h1>   
  <form name="mainForm" action="User-account.php" method="post">   
      <div class="row mb-3 mx-3">
        <input type="hidden" class="form-control" name="user_id" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
               echo $_COOKIE['user']; 
            else
               echo $_COOKIE['user'];
            ?>"  
        />  
      </div>  
      <div class="row mb-3 mx-3">
        <input type="hidden" class="form-control" name="pass_word" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST') 
              echo $user['pass_word'];
            else
              echo $user['pass_word'];
            ?>"
        />        
      </div>  
      <div class="row mb-3 mx-3">
        Email:
        <input type="text" class="form-control" name="email" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
               echo $_POST['email']; 
            else
               echo $user['email'];
            ?>"
        />        
      </div>
      <div class="row mb-3 mx-3">
        Name:
        <input type="text" class="form-control" name="name" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
               echo $_POST['name']; 
            else
               echo $user['name'];
            ?>"
        />        
      </div> 
      <div class="row mb-3 mx-3">
        Age:
        <input type="text" class="form-control" name="age" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
               echo $_POST['age']; 
            else
               echo $user['age'];
            ?>"
        />        
      </div>   
      <div class="row mb-3 mx-3">
        <input type="submit" value="Update Account Info" name="accountBtn" 
                class="btn btn-primary" title="Update GoodTunes Account" />
      </div>  
    </form>
</table>  
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['accountBtn']))
    {
        # constraint integrity checks
        $underage = False;
        if ($_POST['age'] < 18)
          $underage = True;

        # if pass constraint checks add to database
        if (!$underage){
          updateAccountById($_COOKIE['user'], $_POST['pass_word'], $_POST['email'], $_POST['name'], $_POST['age']);
          header('Location: User-account.php');
        }
        # if doesn't pass let user know why
        else{
          if ($underage)
            echo "You must be 18 or older to create an account on GoodTunes" . "</br>";
        }
    }
}
?>


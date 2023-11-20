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
  <h1>Create An Account</h1>   
  <form name="mainForm" action="create-login.php" method="post">   
      <div class="row mb-3 mx-3">
        Username:
        <input type="text" class="form-control" name="user_id" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
               echo $_POST['user_id']; 
            ?>"  
        />  
      </div>  
      <div class="row mb-3 mx-3">
        Password:
        <input type="text" class="form-control" name="pass_word" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST') 
               echo $_POST['pass_word'];
               if (isset($_POST['pass_word'])){
                  $pass = htmlspecialchars(trim($_POST['pass_word']));
                  $hash = password_hash($pass, PASSWORD_DEFAULT);
               }
            ?>"
        />        
      </div>  
      <div class="row mb-3 mx-3">
        Email:
        <input type="text" class="form-control" name="email" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
               echo $_POST['email']; 
            ?>"
        />        
      </div>
      <div class="row mb-3 mx-3">
        Name:
        <input type="text" class="form-control" name="name" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
               echo $_POST['name']; 
            ?>"
        />        
      </div> 
      <div class="row mb-3 mx-3">
        Age:
        <input type="text" class="form-control" name="age" required 
            value="<?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
               echo $_POST['age']; 
            ?>"
        />        
      </div>   
      <div class="row mb-3 mx-3">
        <input type="submit" value="Create Account" name="accountBtn" 
                class="btn btn-primary" title="Create a GoodTunes Account" />
      </div>  
    </form>
</table>  
</body>
</html>

<?php
require("connect-db.php");
require("review-db.php");
require("user-db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['accountBtn']))
    {
        addUser($_POST['user_id'], $hash, $_POST['email'], $_POST['name'], $_POST['age']);
        header('Location: login.php');
    }
}
?>


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
<header>  
      <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">            
          <a class="navbar-brand" href="#">GoodTunes</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar" aria-controls="collapsibleNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a class="nav-link" href="login.php">Back to Login</a>
            </ul>
          </div>
        </div>
      </nav>
    </header>
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
        # constraint integrity checks
        $exists = False;
        $list_of_users= getAllUsers();
        foreach ($list_of_users as $user):
          if ($_POST['user_id'] == $user['user_id']){
            $exists = True;
          } 
        endforeach;
        $underage = False;
        if ($_POST['age'] < 18)
          $underage = True;

        # if pass constraint checks add to database
        if (!$exists && !$underage){
          addUser($_POST['user_id'], $hash, $_POST['email'], $_POST['name'], $_POST['age']);
          header('Location: login.php');
        }
        # if doesn't pass let user know why
        else{
          if ($exists)
            echo "Please enter another username, this one already exists <br /> ";
          if ($underage)
            echo "You must be 18 or older to create an account on GoodTunes";
        }
    }
}
?>


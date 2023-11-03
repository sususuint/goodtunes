<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  
  <title>PHP State Maintenance (Cookies)</title>      
</head>
<body>
  
  <div class="container">
    <h1>Welcome to GoodTunes</h1>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
      Name: <input type="text" name="username" class="form-control" autofocus required /> <br/>
      Password: <input type="password" name="pwd" class="form-control" required /> <br/>
      <input type="submit" value="Sign in" class="btn btn-light"  />   
    </form>
  </div>

<?php
// if ($_SERVER['REQUEST_METHOD'] == "POST")
// {	   
//    if (strlen($_POST['username']) > 0)
//    {
//       header('Location: survey-instruction.php');
//    }
// }
?>

<?php
// When an HTML form is submitted to the server using the post method,
// its field data are automatically assigned to the implicit $_POST global array variable.
// PHP script can check for the presence of individual submission fields using
// a built-in isset() function to seek an element of a specified HTML field name.
// When this confirms the field is present, its name and value can usually be
// stored in a cookie. This might be used to stored username and password details
// to be used across a website

require("connect-db.php");
// include("connect-db.php");
require("review-db.php");
require("user-db.php");

// Define a function to handle failed validation attempts
function reject($entry)
{
    echo "Reject $entry <br/>";	
//   echo 'provide message why the user cannot proceed <br/>';
//   exit();    // exit the current script, no value is returned
}



// Handle form submission.
// If username and passwasd have been entered, perform authentication.
// (for this activity, assume that we just check whether the data are entered, no sophisticated authentication is performed. 
if ($_SERVER['REQUEST_METHOD'] == "POST" && strlen($_POST['username']) > 0)
{
	
   // If username contains only alphanumeric data, proceed to verify the password;
   // otherwise, reject the username and force re-login.
   $user = trim($_POST['username']);
   if (!ctype_alnum($user))   // ctype_alnum() check if the values contain only alphanumeric data
      reject('User Name');
		
   // If pwd is entered and contains only alphanumeric data, set cookies and redirect the user to survey instruction page;
   // otherwise, reject the password and force re-login.
   if (isset($_POST['pwd']))
   {
      $pwd = trim($_POST['pwd']);
      $pass = getUserPass($user);
      if (!ctype_alnum($pwd))
         reject('Password');
      elseif ($pass['pass_word'] != $pwd)
         reject('Password');
      else
      {
         // setcookie(name, value, expiery-time)
         // setcookie() function stores the submitted fields' name/value pair
         setcookie('user', $user, time()+3600);
         
//       setcookie('pwd', md5($pwd), time()+3600);  // create a hash conversion of password values using md5() function  
         setcookie('pwd', password_hash($pwd, PASSWORD_DEFAULT), time()+3600);    // password_hash() requires at least PHP5.5
//       setcookie('pwd', password_hash($pwd, PASSWORD_BCRYPT), time()+3600);    
					
         // Redirect the browser to another page using the header() function to specify the target URL
         header('Location: simpleform.php');
      }
   }
}
?>


</body>
</html>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <style>
      .vertical-center {
         margin: 0;
         position: absolute;
         top: 40%;
         -ms-transform: translateY(-50%);
         transform: translateY(-50%);
         }
      .horizontal-center {
         margin: 0;
         position: absolute;
         left: 50%;
         -ms-transform: translateX(-50%);
         transform: translateX(-50%);
      }
</style>
  <title>PHP State Maintenance (Cookies)</title>    
</head>
<body style="background-color:pink;">
  
  <div class="container vertical-center horizontal-center">
    <h1 class="text-center">GoodTunes</h1>
    <h3 class="text-center"> You have successfully logged out! </h3>
    <h3 class="text-center"> Thank you for checking out GoodTunes! </h3>

  </div>

<?php
if (count($_COOKIE) > 0)
{
   foreach ($_COOKIE as $key => $value)
   {
      // Deletes the variable (array element) where the value is stored in this PHP.
      // However, the original cookie still remains intact in the browser.   	
      unset($_COOKIE[$key]);   
		
      // To completely remove cookies from the client, 
      // set the expiration time to be in the past
      setcookie($key, '', time() - 3600);
   }
	
   // redirect to the login page immediately
   //    header('Location: login.php');
	
   // redirect with 2 seconds delay
   header('refresh:2; url=login.php');
}
?>

</body>
</html>

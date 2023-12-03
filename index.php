<?php
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
   case '/':                   // URL (without file name) to a default screen
      require 'home.php';
      break; 
   case '/home.php':     // if you plan to also allow a URL with the file name 
      require 'home.php';
      break;              
   case '/create-login.php':
      require 'create-login.php';
      break;
    case '/login.php':
      require 'login.php';
      break;
    case '/logout.php':
      require 'logout.php';
      break;   
    case '/playlists.php':
      require 'playlists.php';
      break; 
    case '/reviews.php':
      require 'reviews.php';
      break;
    case '/songs.php':
      require 'songs.php';
      break;    
    case '/artists.php':
      require 'artists.php';
      break;     
   default:
      http_response_code(404);
      exit('Not Found');
}  
?>
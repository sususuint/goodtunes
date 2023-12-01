<?php
function addPlaylist($user_id, $playlist_num, $name, $description) 
{
  global $db; 
  $query = "insert into playlist values (:user_id, :playlist_num, :name, :description) ";

  $statement = $db->prepare($query); 
  $statement->bindValue(':user_id', $user_id);
  $statement->bindValue(':playlist_num', $playlist_num);
  $statement->bindValue(':name', $name);
  $statement->bindValue(':description', $description);
  $statement->execute();
  $statement->closeCursor();
}

function getAllPlaylists($user_id)
{
  global $db;
  $query = "select * from playlist where user_id=:user_id";
  $statement = $db->prepare($query); 
  $statement->bindValue(':user_id', $user_id);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closeCursor();
  return $results;
}

function updatePlaylistByUIDandNum($user_id, $playlist_num, $name, $description)
{
  global $db;
  $query = "update playlist set name=:name, description=:description where user_id=:user_id and playlist_num=:playlist_num";

  $statement = $db->prepare($query); 
  $statement->bindValue(':user_id', $user_id);
  $statement->bindValue(':playlist_num', $playlist_num);
  $statement->bindValue(':name', $name);
  $statement->bindValue(':description', $description);
  $statement->execute();
  $statement->closeCursor();
}

function deletePlaylist($user_id, $playlist_num)
{
  global $db;
  $query = "delete from playlist where user_id=:user_id and playlist_num=:playlist_num";

  $statement = $db->prepare($query); 
  $statement->bindValue(':user_id', $user_id);
  $statement->bindValue(':playlist_num', $playlist_num);
  $statement->execute();
  $statement->closeCursor();
}

function getPlaylistNum($user_id)
{
  global $db;
  $query = "Select max(playlist_num) as max_num from playlist where user_id=:user_id group by user_id";
  $statement = $db->prepare($query); 
  $statement->bindValue(':user_id', $user_id);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closeCursor();
  return $results;
}

function getSongs($user_id, $playlist_num)
{
  global $db;
  $query = "Select song_name from added_to where user_id=:user_id and playlist_num=:playlist_num";
  $statement = $db->prepare($query); 
  $statement->bindValue(':user_id', $user_id);
  $statement->bindValue(':playlist_num', $playlist_num);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closeCursor();
  return $results;
}

?>
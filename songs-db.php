<?php
function songSearch($searchString)
{
  global $db;
  $query = "Select DISTINCT song_name, release_date from song natural join performs natural join song_genre where song_name like ?";
  $statement = $db->prepare($query); 
  $statement->execute(array('%'.$searchString.'%'));
  $results = $statement->fetchAll();
  $statement->closeCursor();
  return $results;
}

function getArtists($song_name, $release_date)
{
  global $db;
  $query = "Select stage_name from song natural join performs where song_name=:song_name and release_date=:release_date";
  $statement = $db->prepare($query); 
  $statement->bindValue(':song_name', $song_name);
  $statement->bindValue(':release_date', $release_date);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closeCursor();
  return $results;
}

function getGenres($song_name, $release_date)
{
  global $db;
  $query = "Select genre from song natural join song_genre where song_name=:song_name and release_date=:release_date";
  $statement = $db->prepare($query); 
  $statement->bindValue(':song_name', $song_name);
  $statement->bindValue(':release_date', $release_date);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closeCursor();
  return $results;
}

function getSongInfo($song_name, $release_date)
{
  global $db;
  $query = "Select distinct song_name, release_date, energy, duration from song natural join performs natural join song_genre where song_name=:song_name and release_date=:release_date";
  $statement = $db->prepare($query); 
  $statement->bindValue(':song_name', $song_name);
  $statement->bindValue(':release_date', $release_date);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closeCursor();
  return $results;
}

function getAllUserReviews($song_name, $release_date)
{
  global $db;
  $query = "Select * from review where song_name=:song_name and release_date=:release_date";
  $statement = $db->prepare($query); 
  $statement->bindValue(':song_name', $song_name);
  $statement->bindValue(':release_date', $release_date);
  $statement->execute();
  $results = $statement->fetchAll();   // fetch()
  $statement->closeCursor();
  return $results;
}

function getAvgRating($song_name, $release_date)
{
  global $db;
  $query = "Select AVG(rating) as avg_rating from review where song_name=:song_name and release_date=:release_date group by song_name, release_date";
  $statement = $db->prepare($query); 
  $statement->bindValue(':song_name', $song_name);
  $statement->bindValue(':release_date', $release_date);
  $statement->execute();
  $results = $statement->fetch();   // fetch()
  $statement->closeCursor();
  return $results;
}

function getMostAddedToSongs()
{
  global $db;
  $query = "SELECT song_name, stage_name FROM `song` NATURAL JOIN `added_to` NATURAL JOIN performs GROUP BY song_name, release_date ORDER BY COUNT(song_name) DESC LIMIT 3;";
  $statement = $db->prepare($query); 
  $statement->execute();
  $results = $statement->fetchAll();   // fetch()
  $statement->closeCursor();
  return $results;
}

function getTopRatedSongs()
{
  global $db;
  $query = "SELECT song_name, stage_name, avg(rating) as average FROM `song` NATURAL JOIN `review`NATURAL JOIN performs GROUP BY song_name, release_date HAVING AVG(rating) ORDER BY AVG(rating) DESC LIMIT 3;";
  $statement = $db->prepare($query); 
  $statement->execute();
  $results = $statement->fetchAll();   // fetch()
  $statement->closeCursor();
  return $results;
}

function addToPlaylist($song_name, $release_date, $user_id, $playlist_number)
{
  global $db;
  $query = "INSERT INTO added_to VALUES(:song_name, :release_date, :user_id, :playlist_number)";
  $statement = $db->prepare($query); 
  $statement->bindValue(':song_name', $song_name);
  $statement->bindValue(':release_date', $release_date);
  $statement->bindValue(':user_id', $user_id);
  $statement->bindValue(':playlist_number', $playlist_number);
  $statement->execute();
  $statement->closeCursor();
}

?>
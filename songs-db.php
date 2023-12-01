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

?>
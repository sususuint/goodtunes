<?php
function artistSearch($searchString)
{
  global $db;
  $query = "Select DISTINCT stage_name, age, artist_type from artist where stage_name like ?";
  $statement = $db->prepare($query); 
  $statement->execute(array('%'.$searchString.'%'));
  $results = $statement->fetchAll();
  $statement->closeCursor();
  return $results;
}

function getArtistFunFacts($stage_name)
{
  global $db;
  $query = "Select fun_fact from artist_fun_facts where stage_name=:stage_name";
  $statement = $db->prepare($query); 
  $statement->bindValue(':stage_name', $stage_name);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closeCursor();
  return $results;
}

function getArtistWhereFrom($stage_name)
{
  global $db;
  $query = "Select country_name from artist natural join where_from where stage_name=:stage_name";
  $statement = $db->prepare($query); 
  $statement->bindValue(':stage_name', $stage_name);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closeCursor();
  return $results;
}

function getAllArtists()
{
  global $db;
  $query = "select stage_name, age, artist_type from artist";
  $statement = $db->prepare($query); 
  $statement->execute();
  $results = $statement->fetchAll();   // fetch()
  $statement->closeCursor();
  return $results;
}

function getArtistInfo($stage_name)
{
  global $db;
  $query = "Select distinct stage_name, age, artist_type from artist where stage_name=:stage_name";
  $statement = $db->prepare($query); 
  $statement->bindValue(':stage_name', $stage_name);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closeCursor();
  return $results;
}


?>
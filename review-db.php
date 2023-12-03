<?php
function addReview($song_name, $release_date, $user_id, $review_number, $rating, $review_text) 
{
  global $db; 
  // bad way
  // $query = "insert into friends values ('" . $friendname . "', '" . $major . "'," . $year .") ";
  // $db->query($query);  // compile + exe

  // good way
  $query = "insert into review values (:song_name, :release_date, :user_id, :review_number, :rating, :review_text) ";
  // prepare: 
  // 1. prepare (compile) 
  // 2. bindValue + exe

  $statement = $db->prepare($query); 
  $statement->bindValue(':song_name', $song_name);
  $statement->bindValue(':release_date', $release_date);
  $statement->bindValue(':user_id', $user_id);
  $statement->bindValue(':review_number', $review_number);
  $statement->bindValue(':rating', $rating);
  $statement->bindValue(':review_text', $review_text);
  $statement->execute();
  $statement->closeCursor();
}

function getAllReviews($user_id)
{
  global $db;
  $query = "select * from review where user_id=:user_id";
  $statement = $db->prepare($query); 
  $statement->bindValue(':user_id', $user_id);
  $statement->execute();
  $results = $statement->fetchAll();   // fetch()
  $statement->closeCursor();
  return $results;
}

function updateReviewByName($song_name, $release_date, $user_id, $review_number, $rating, $review_text)
{
  global $db;
  $query = "update review set rating=:rating, review_text=:review_text where song_name=:song_name and release_date=:release_date and user_id=:user_id and review_number=:review_number";

  $statement = $db->prepare($query); 
  $statement->bindValue(':song_name', $song_name);
  $statement->bindValue(':release_date', $release_date);
  $statement->bindValue(':user_id', $user_id);
  $statement->bindValue(':review_number', $review_number);
  $statement->bindValue(':rating', $rating);
  $statement->bindValue(':review_text', $review_text);
  $statement->execute();
  $statement->closeCursor();
}

function deleteReview($song_name, $release_date, $user_id, $review_number)
{
  global $db;
  $query = "delete from review where song_name=:song_name and release_date=:release_date and user_id=:user_id and review_number=:review_number";

  $statement = $db->prepare($query); 
  $statement->bindValue(':song_name', $song_name);
  $statement->bindValue(':release_date', $release_date);
  $statement->bindValue(':user_id', $user_id);
  $statement->bindValue(':review_number', $review_number);
  $statement->execute();
  $statement->closeCursor();
}

function getReviewNum($user_id)
{
  global $db;
  $query = "Select max(review_number) as max_num from review where user_id=:user_id group by user_id";
  $statement = $db->prepare($query); 
  $statement->bindValue(':user_id', $user_id);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closeCursor();
  return $results;
}

function getAllSongs()
{
  global $db;
  $query = "select song_name, release_date from song ";
  $statement = $db->prepare($query); 
  $statement->execute();
  $results = $statement->fetchAll();   // fetch()
  $statement->closeCursor();
  return $results;
}

#ADVANCED SQL STORED PROCEDURE
function getUsersAvg($user_id)
{
  global $db;
  $query = "CALL findUserAvg(?, @avgRating)";
  $statement = $db->prepare($query); 
  $statement->bindParam(1, $user_id);
  $statement->execute();
  $select = $db->query("select @avgRating");
  $result = $select->fetch(PDO::FETCH_ASSOC);
  $statement->closeCursor();
  return $result;
}

?>
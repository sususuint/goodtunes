<?php
function addUser($user_id, $pass_word, $email, $name, $age) 
{
  global $db; 
  // bad way
  // $query = "insert into friends values ('" . $friendname . "', '" . $major . "'," . $year .") ";
  // $db->query($query);  // compile + exe

  // good way
  $query = "insert into site_user values (:user_id, :pass_word, :email, :name, :age) ";
  // prepare: 
  // 1. prepare (compile) 
  // 2. bindValue + exe

  $statement = $db->prepare($query); 
  $statement->bindValue(':user_id', $user_id);
  $statement->bindValue(':pass_word', $pass_word);
  $statement->bindValue(':email', $email);
  $statement->bindValue(':name', $name);
  $statement->bindValue(':age', $age);
  $statement->execute();
  $statement->closeCursor();
}

function getUserPass($user_id)
{
  global $db;
  $query = "select * from site_user where user_id=:user_id";
  $statement = $db->prepare($query);
  $statement->bindValue(':user_id', $user_id); 
  $statement->execute();
  $results = $statement->fetch();   // fetch()
  $statement->closeCursor();
  return $results;
}

// function updateReviewByName($song_name, $release_date, $user_id, $review_number, $rating, $review_text)
// {
//   global $db;
//   $query = "update review set rating=:rating, review_text=:review_text where song_name=:song_name and release_date=:release_date and user_id=:user_id and review_number=:review_number";

//   $statement = $db->prepare($query); 
//   $statement->bindValue(':song_name', $song_name);
//   $statement->bindValue(':release_date', $release_date);
//   $statement->bindValue(':user_id', $user_id);
//   $statement->bindValue(':review_number', $review_number);
//   $statement->bindValue(':rating', $rating);
//   $statement->bindValue(':review_text', $review_text);
//   $statement->execute();
//   $statement->closeCursor();
// }

// function deleteReview($song_name, $release_date, $user_id, $review_number)
// {
//   global $db;
//   $query = "delete from review where song_name=:song_name and release_date=:release_date and user_id=:user_id and review_number=:review_number";

//   $statement = $db->prepare($query); 
//   $statement->bindValue(':song_name', $song_name);
//   $statement->bindValue(':release_date', $release_date);
//   $statement->bindValue(':user_id', $user_id);
//   $statement->bindValue(':review_number', $review_number);
//   $statement->execute();
//   $statement->closeCursor();
// }

?>
<?php
function addUser($user_id, $pass_word, $email, $name, $age) 
{
  global $db; 
  $query = "insert into site_user values (:user_id, :pass_word, :email, :name, :age) ";
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

function getAllUsers()
{
  global $db;
  $query = "select user_id from site_user";
  $statement = $db->prepare($query); 
  // $statement->bindValue(':user_id', $user_id);
  $statement->execute();
  $results = $statement->fetchAll();   // fetch()
  $statement->closeCursor();
  return $results;
}

function updateAccountById($user_id, $pass_word, $email, $name, $age)
{
  global $db;
  $query = "update site_user set pass_word=:pass_word, email=:email, name=:name, age=:age where user_id=:user_id";

  $statement = $db->prepare($query); 
  $statement->bindValue(':pass_word', $pass_word);
  $statement->bindValue(':email', $email);
  $statement->bindValue(':name', $name);
  $statement->bindValue(':age', $age);
  $statement->bindValue(':user_id', $user_id);
  $statement->execute();
  $statement->closeCursor();
}

?>
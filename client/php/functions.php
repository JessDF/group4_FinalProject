<?php

function findwords($message){
  $count = 0;
  $find = "o";
  $positions = array();
  for($i = 0; $i<strlen($message); $i++)
  {
       $pos = strpos($message, $find, $count);
       if($pos == $count){
             $positions[] = $pos;
       }
       $count++;
  }
  foreach ($positions as $value) {
      echo '<br/>' .  $value . "<br />";
  }
}

function words(){
  $lines = file("../extra/swearWords.txt");
  foreach($lines as $line){
    echo($line);
  }
}
?>

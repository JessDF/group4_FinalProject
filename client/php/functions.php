<?php

// WORKING FUNCTIONS
function censorship($swearWord){
    $censor = "";
    for($i = 0; $i < strlen($swearWord); $i++){
        $censor = $censor."*";
    }
    return $censor;
}

function findSwearwords($message){
    $lines = explode("\n", file_get_contents('../extra/word.txt'));
    foreach($lines as $find){
        $censor = censorship($find);
        
        $index = 0;
        $size = strlen($find);
        $positions = array();
        for($i = 0; $i<strlen($message); $i++){
            $pos = strpos($message, $find, $index);
            if($pos == $index){
                $positions[] = $pos;
            }
            if($pos != 0){
                $word = substr($message, $pos, $size);
                $newWord = str_replace($word, $censor, $message);
                $message = $newWord;
            }
                $index++;
        }   
    }      
    echo $message;
}










// FUNCTIONS THAT DO NOT WORK
function FIND($message,$find){
  $count = 0;
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
      echo $value."<br>";
  }
}

function findwords($message){
    // $find = "bitch";
    
    echo "|".$message."|<br>";
    $lines = explode("\n", file_get_contents('../extra/word.txt'));
    
    foreach($lines as $find){
        $censor = "";
        for($i = 0; $i < strlen($find)-1; $i++){
            $censor = $censor."*";
        }
        echo $find."<br>";
        echo $censor."<br>";
        
        $count = 0;
        $positions = array();
        for($i = 0; $i<strlen($message); $i++)
        {
            echo $count."<br>";
            $pos = strpos($message, $find, $count);
            if($pos == $count){
                 $positions[] = $pos;
                //  echo "T<br>";
            }
            $count++;
            }
        
        // foreach ($positions as $value) {
        //     echo $value."<br>";
        // }
    }
}

function findword($message, $find){
    // $index = 0;
    $size = strlen($find)-1; // minus 1 because of the /n counts as a length
    // $positions = array();
    for($i = 0; $i<strlen($message); $i++){
        
        $censor = "";
        for($i = 0; $i < strlen($find)-1; $i++){
            $censor = $censor."*";
        }
        
        $pos = strpos($message, $find);
        
        $word = substr($message, $pos, $size);
        $newWord = str_replace($word, $censor, $message);
        $message = $newWord;

        // echo $pos."<br>";
        // echo $find."".$size."<br>";
        // if($pos == $index){
            // $positions[] = $pos;
            // echo $pos."<br>";
            // echo $find.$size." ".$pos."<br>";
        // }
        // $index++;
    }
    // $word = substr($message, $positions[0], $size);
    // $newWord = str_replace($word, "****", $message);
    echo $message."<br>";
    
    // $message = $newWord;
    
    // echo $newWord."<br>"."<br>";
    // return $newWord;
}
function words1(){
  $lines = explode("\n", file_get_contents('../extra/word.txt'));
  foreach($lines as $line){
      echo $line."<br>";
    // FIND($message, $line);
  }
}
?>

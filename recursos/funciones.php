<?php 

function recogerVar($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  function length80($data) {
    if (strlen($data)>80){
      return true; 
    }
  } 
    
  function length255($data){
    if (strlen($data)>255){
      return true; 
    }
  }
  
  function length269($data){
    if (strlen($data)>269){
      return true; 
    }
  }
  
  function espaciosEnblanco($data){
    if(strlen(trim($data)) == 0){
      return true;
    }
  }

  
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

function generate_token($input, $strength = 16) {
  $input_length = strlen($input);
  $random_string = '';
  for($i = 0; $i < $strength; $i++) {
    $random_character = $input[mt_rand(0, $input_length - 1)];
    $random_string .= $random_character;
    }
  return $random_string;
  }

?>
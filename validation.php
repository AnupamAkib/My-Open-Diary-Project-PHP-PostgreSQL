<?php
function check_password($pwd){ //can not countain ' and $ (minimun length 6)
  if(strlen($pwd)<6){
    return false;
  }
  for($i=0; $i<strlen($pwd); $i++){
    if($pwd[$i]=='\'' || $pwd[$i]=='$'){
      return false;
    }
  }
  return true;
}

 ?>

<?php 
define('MAIN_URL' , 'http://localhost/motors/');
function base_url($var =null) {
  return MAIN_URL . $var;
};

function redirect($var =null){
  echo "
  <script>
  location.replace('http://localhost/motors/$var')
  </script>
  ";
};


function auth(){
    if(!$_COOKIE['auth_user']){
      redirect('login.php');
    };
};


    if(isset($_COOKIE['auth_user'])){
      $jsonArrayCookie=json_decode($_COOKIE['auth_user'],true);
    }else{
      $jsonArrayCookie='';
    };


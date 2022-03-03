<?php
    define( 'DB_HOST', 'localhost' );
    define( 'DB_USER', 'root' );
    define( 'DB_PASS', '' );
    define( 'DB_NAME', 'aron_loldesign');
    define( 'DISPLAY_DEBUG', false );


    $database = new DB('localhost','root','','aron_loldesign');
    date_default_timezone_set('America/Sao_Paulo');
      
    use App\Classes\Url;
    
?>
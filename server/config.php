<?php
   // Database configuration
   define('HOST', 'localhost:3306');
   define('USER', 'dtadmin');
   define('PASSWORD', 'tjYjuUQEZr');
   define('DATABASE', 'dtadmin');

   // General configuration options
   date_default_timezone_set('Etc/Greenwich'); // Set this to your timezone

   // Miscellaneous configuration options
   $devmode = true; // Whether DTAdmin is in developer mode. This option does nothing in public releases.
   $release = "1.3.2"; // DTAdmin release number. Don't touch!

   // Don't touch the code below!
   $mysqli = mysqli_connect(HOST,USER,PASSWORD,DATABASE);
?>

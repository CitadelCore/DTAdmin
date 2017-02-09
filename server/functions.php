<?php
include_once "config.php";

// Library includes

include_once "include/session.inc.php";                     // Session functions
include_once "include/utility.inc.php";                     // Utility functions
include_once "include/user.inc.php";                        // User functions
include_once "include/dbquery.inc.php";                     // Server management functions
include_once "include/permission.inc.php";                  // Permission functions
include_once "include/mail.inc.php";                        // Mail sending functions

// Third party libraries

include_once "thirdparty/phpmailer/PHPMailerAutoload.php";  // PHPMailer
use thirdparty\otphp\TOTP;                                  // OTPHP TOTP
use thirdparty\otphp\HOTP;                                  // OTPHP HOTP
use thirdparty\otphp\Factory;                               // OTPHP Factory
use thirdparty\base32\base32;                               // Base32

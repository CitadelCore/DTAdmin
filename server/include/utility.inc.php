<?php
function getRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
}

function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        return '';
    } else {
        return $url;
    }
}

function test_data($data) {
  $originaldata = $data;
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  if ($data !== $originaldata) {
    return false;
  } else {
    return true;
  }
}

function fetchRows($statement) {
          echo $statement->num_rows;
          while($row = $statement->fetch())
        {
          echo $statement->num_rows; //incrementing by one each time
        }
          echo $statement->num_rows; // Finally the total count
}

function ifEchoSql($col, $var) {
  if(isset($var)) {
    echo "$col='$var' ";
  } else {
    echo "";
  }
}
 ?>

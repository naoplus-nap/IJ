<?php
/*
  MixJuice Program Upload Sample | MixJuice / IchigoJam BASIC 1.1.1-
  Copyright (c) 2016 Keiichi SHIGA (BALLOON a.k.a. Fu-sen.)
  The MIT License (MIT) - https://gist.github.com/fu-sen/0dc11ac111b48f7aaaf8

  Display of how to use:
  ?"MJ GET <server.name>/upload.php

  Upload program:
  ?"MJ POST START <server.name>/upload.php":LIST:?"MJ POST END

  Get the program:
  ?"MJ GET <server.name>/<file name>
*/

// Server Name/URI (Except "/upload.php")
$url = "server.name.dom";

// Output in the non-MixJuice
$ua = $_SERVER['HTTP_USER_AGENT'];

if (strpos($ua, 'MixJuice') === false)
{
  print <<<EOT
<html>
<body>
what?
</body>
</html>

EOT;

  exit;
}

// Output of the GET method
if ( $_SERVER["REQUEST_METHOD"] != "POST" )
{
  print <<<EOT
'Use the command:
'?"MJ POST START {$url}/upload.php":LIST:?"MJ POST END"

EOT;

  exit;
}

$program = file_get_contents('php://input');
$filename = date("YmdHis");

if ( is_file ( $filename ) )
{
  print <<<EOT
'File Write Error
'Run the command again.
'?"MJ POST START {$url}/upload.php":LIST:?"MJ POST END"

EOT;

  exit;
}

$header = <<<EOT
CLS
NEW


EOT;

file_put_contents($filename, $header, FILE_APPEND | LOCK_EX);
file_put_contents($filename, $program, FILE_APPEND | LOCK_EX);

$footer = <<<EOT

'OK

EOT;

file_put_contents($filename, $footer, FILE_APPEND | LOCK_EX);

print <<<EOT
'Program file was generated.
'?"MJ GET {$url}/{$filename}"

EOT;

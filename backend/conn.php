<?php

if ($_SERVER['HTTP_HOST'] == "localhost") {
  $user = "root";
  $password = "";
} else {
  $user = "";
  $password = "";
}
$host = "localhost";
$db = "police_records";

try {
  $conn = new mysqli($host, $user, $password, $db);
} catch (Exception $e) {
  echo "<script>alert('" . ($e->getMessage()) . "')</script>";
}

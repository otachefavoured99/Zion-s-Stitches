<?php
$conn = new mysqli("localhost", "root", "", "zion_stitches");
if ($conn->connect_error) { die("DB Failed: " . $conn->connect_error); }
session_start();
?>
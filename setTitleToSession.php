<?php
session_start();

$currentFormTitle = $_GET["title"];

$_SESSION["currentForm"] = $currentFormTitle;

?>
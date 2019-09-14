<?php

session_start();
require_once '../controllers/Controller.php';
require_once '../dominio/Usuario.php';
$q = $_REQUEST['q'];

$c = new Controller();
$u = new Usuario();


echo 'OK';
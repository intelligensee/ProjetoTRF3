<?php

session_start();

if (!isset($_SESSION['erro']) || $_SESSION['erro'] === null) {
    $msg = 'Erro não identificado!';
} else {
    $msg = $_SESSION['erro'];
    $_SESSION['erro'] = null;
}

echo $msg;

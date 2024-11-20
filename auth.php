<?php
//Función de validación
session_start();

function verificarSesion() {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: login.php");
        exit;
    }
}
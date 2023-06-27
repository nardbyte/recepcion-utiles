<?php
require 'config.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo DESCRIPTION; ?>">
    <title><?php echo SITENAME; ?> - <?php echo DESCRIPTION; ?></title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png" sizes="32x32">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="progress" style="height: 10px; border-radius: 0; background-color: #302878;">
        <div class="progress-bar" style="background: linear-gradient(#990000, 20%, #ff8181, 85%, #990000);" id="progress-bar" role="progressbar" style="width: 0%;" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container main">
        <div class="text-center">
            <img class="mt-4" src="assets/images/logo.svg" alt="<?php echo SITENAME; ?>" width="350px">
        </div>

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                Menú
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <li><a class="dropdown-item" href="<?php echo URL; ?>">Principal</a></li>
                <li><a class="dropdown-item" href="<?php echo URL; ?>registro_utiles.php">Lista de utiles</a></li>
                <li><a class="dropdown-item" type="button">Something else here</a></li>
            </ul>
        </div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
use App\Kipedreiro\Core\Flash;
$flash = Flash::get();
if ($flash):
    $alertType = $flash['type'] === 'success' ? 'alert-success' : 'alert-danger';
    echo "<div class='alert {$alertType}' role='alert'>{$flash['message']}</div>";
endif;
?>
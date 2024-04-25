<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto&display=swap">

</head>

<body>
    <?php

    $links = [
        "Home" => "https://catalogo.yoobe.co/suporte/levoratech/view/home.php",
        "Financeiro" => "https://catalogo.yoobe.co/suporte/levoratech/view/financeiro.php",
        "Suporte" => "https://catalogo.yoobe.co/suporte/levoratech/view/suporte.php",
        "Pedidos" => "https://catalogo.yoobe.co/suporte/levoratech/view/pedidos.php",
        "Envios" => "https://catalogo.yoobe.co/suporte/levoratech/view/envios.php"
    ];


    gerarHeader(name_Format("Levoratech - yoobe"), $links, 800,'#E886C5');
    ?>

    <main>
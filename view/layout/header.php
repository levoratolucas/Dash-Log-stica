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
        "Controle fretes" => "https://catalogo.yoobe.co/suporte/levoratech/view/controlefretes.php",
        "Financeiro" => "https://catalogo.yoobe.co/suporte/levoratech/view/financeiro.php",
        "Suporte" => "https://catalogo.yoobe.co/suporte/levoratech/view/suporte.php",
        "Pedidos" => "https://catalogo.yoobe.co/suporte/levoratech/view/pedidos.php",
        "Envios" => "https://catalogo.yoobe.co/suporte/levoratech/view/envios.php"
    ];


    gerarHeader(name_Format("../imag/logoLevoratech.png"), $links, 800, 'black','white');
    ?>
    <style>
        main,
        .dados_full,
        .lateral,
        .menu,
        body {
            background-color: <?php echo $color; ?>;
        }

        .logon {
            width: 200px;
            height: 100%;
            background-image: url(../imag/logoLevoratech.png);
            background-position: center;
            background-size: 100%;
            background-repeat: no-repeat;
        }
    </style>
    <main>
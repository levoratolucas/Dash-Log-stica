<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>LEVORATECH - YOOBE</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {

            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }


        .container {
            width: 90%;
            max-width: 400px;
            position: absolute;
            top: 50%;
            left: 75%;
            transform: translate(-50%, -50%);

        }

        .container15 {

            /* border: solid black; */
            height: 700px;
            width: 600px;
            position: absolute;
            top: 45%;
            left: 30%;
            transform: translate(-50%, -50%);
            background-size: 100%;
            background-repeat: no-repeat;
            <?php


            $lojas = [
                431 => ['cor' => '#86E0E8', 'url_imagem' => './imag/camiseta\ mockup\ RD.png'],
                511 => ['cor' => 'purple', 'url_imagem' => './imag/camiseta_mockup_yp.png'],
                455 => ['cor' => 'red', 'url_imagem' => './imag/camiseta_mockup_bt.png']
            ];

            if (isset($_GET['loja'])) {
                $loja = $_GET['loja'];
                if (isset($lojas[$loja])) {
                    $levoratech = '';
                    $cor_fundo = $lojas[$loja]['cor'];
                    $url_imagem = $lojas[$loja]['url_imagem'];
                    echo "background-image: url(" . $url_imagem . "); }body { background-color: $cor_fundo; ";
                } else {
                    echo "  background-image: url(./imag/tag.png); 
                        background-size:180%;
                        background-position:30% 30%;

                        height: 500px;
                    }
                    body {
                        background-color:black; ";
                    $levoratech = '.logo{
                            width: 150px;
                            height: 60px;
                            background-image: url(./imag/logoLevoratech.png);
                            margin: auto;
                            margin-bottom: 30px;
                            background-size: 100%;
                            /* background-size: cover; */
                            background-position: center;
                            background-repeat: no-repeat;
                        }';
                }
            } else {
                echo "  background-image: url(./imag/tag.png); 
                        background-size:180%;
                        background-position:30% 30%;

                        height: 500px;
                    }
                    body {
                        background-color:black; ";
                $levoratech = '.logo{
                            width: 150px;
                            height: 60px;
                            background-image: url(./imag/logoLevoratech.png);
                            margin: auto;
                            margin-bottom: 30px;
                            background-size: 100%;
                            /* background-size: cover; */
                            background-position: center;
                            background-repeat: no-repeat;
                        }';
            }
            ?>
        }

        .container1 {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        form {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: black;
            color: #fff;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .logo {
            width: 150px;
            height: 60px;
            background-image: url(./imag/yoobe\ logo\ 23.png);
            margin: auto;
            margin-bottom: 30px;
            background-size: 100%;
            /* background-size: cover;
            background-position: top; */
        }

        <?= $levoratech ?>@media screen and (max-width: 800px) {
            body {

                background-size: 20%;
                background-repeat: no-repeat;
                background-position: top;
            }

            .container15 {
                display: none;
            }

            .container {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);

            }
        }
    </style>
</head>

<body>
    <div class="container15"></div><br>
    <div class="container">
        <div class="logo"></div>
        <div class="container1">
            <h2>Custumer Dashboard</h2>
            <form action="config/auth.php" method="POST">
                <?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] > 0) {
                        echo '<p style="color: red;">Usuário ou senha incorretos.</p>';
                    }
                }
                ?>
                <label for="username">Usuário:</label>
                <input type="email" id="username" name="username" required><br>
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required><br>
                <input type="password" id="loja" name="loja" style="display: none;"><br>
                <input type="submit" value="Entrar">
                <div style="display: flex;">
                    <div style="margin: auto;" >
                        <input type="radio" id="dark" name="theme" value="dark">
                        <label for="dark">Dark</label>
                    </div>
                    <div style="margin: auto;" >

                        <input type="radio" id="light" name="theme" value="light">
                        <label for="light">Light</label>
                    </div>

                </div>

            </form>

        </div>
    </div>
</body>

</html>
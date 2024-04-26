<?php
// session_start();
if ($_SESSION['loja'] != 999) {
    header('Location: pedidos.php');
    exit();
}
// include '../controler/biblioteca.php';
// include '../config/config.php';
?>
<?php
$message2 = '';
$search_condition2 = '';
$show_insert_button2 = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['search_button2'])) {

        $search_condition2 = $_POST['search_condition2'];


        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


        if ($conn->connect_error) {
            die("Erro na conexão com o banco de dados: " . $conn->connect_error);
        }


        $sql_select = "SELECT cartao, plp, dt_envio, dt_previsao, status, objeto, destinatario, cep, endereco, bairro, numero, complemento, cidade, uf, departamento, vlrdecla, valor, peso, codservico, conteudo, entregue, url_rastreio, nf, store_id, is_workspace, email,order_number FROM tb_csv_plp WHERE objeto = '$search_condition2'";


        $result = $conn->query($sql_select);


        if ($result->num_rows > 0) {


            // $message2 .= "<table class='tableUser'>";



            // while ($row = $result->fetch_assoc()) {
            //     $message2 .= "<tr>";
            //     $message2 .= "<td>" . $row['order_number'] . "</td>";
            //     $message2 .= "<td>" . $row['destinatario'] . "</td>";
            //     $message2 .= "<td>" . $row['objeto'] . "</td>";
            //     $message2 .= "<td>" . $row['email'] . "</td>";
            //     $message2 .= "<td>" . $row['conteudo'] . "</td>";
            //     $message2 .= "</tr>";
            //     $_SESSION['row'] = $row;
            // }
            // $message2 .= "</table>";
            $show_insert_button2 = true;
        } else {
            $message2 = "<p>Nenhum resultado encontrado na busca.</p>";
            $show_insert_button2 = false;
        }

        $conn->close();
    } elseif (isset($_POST['insert_button'])) {


        $objeto = isset($_POST['objeto']) ? $_POST['objeto'] : '';
        $dt_envio = isset($_POST['dt_envio']) ? $_POST['dt_envio'] : '';
        $dt_previsao = isset($_POST['dt_previsao']) ? $_POST['dt_previsao'] : '';
        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        $nome = name_Format($nome);


        if (isset($_SESSION['row'])) {
            $row = $_SESSION['row'];

            $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


            if ($conn->connect_error) {
                die("Erro na conexão com o banco de dados: " . $conn->connect_error);
            }

            // Query de inserção
            $sql_insert = "INSERT INTO tb_csv_plp (cartao, plp, dt_envio, dt_previsao, status, objeto, destinatario, cep, endereco, bairro, numero, complemento, cidade, uf, departamento, vlrdecla, valor, peso, codservico, conteudo, entregue, url_rastreio, nf, store_id, is_workspace, email, order_number, eventos, hist_concluido) 
                VALUES ('" . $row['cartao'] . "', '" . $row['plp'] . "', '" . $dt_envio . "', '" . $dt_previsao . "', '" . $status . "', '" . $objeto . "', '" . mb_convert_case($nome, MB_CASE_TITLE) . "', '" . $row['cep'] . "', '" . $row['endereco'] . "', '" . $row['bairro'] . "', '" . $row['numero'] . "', '" . $row['complemento'] . "', '" . $row['cidade'] . "', '" . $row['uf'] . "', '" . $row['departamento'] . "', '" . $row['vlrdecla'] . "', '" . $row['valor'] . "', '" . $row['peso'] . "', '" . $row['codservico'] . "', '" . $row['conteudo'] . "', 0, 'https://rastreamento.correios.com.br/app/index.php?objetos=" . $objeto . "', '" . $row['nf'] . "', '" . $row['store_id'] . "', '" . $row['is_workspace'] . "', '" . $email . "', '0', '0', 0)";

            echo "'" . $row['order_number'] . "--" . $row['destinatario'] . "--" . $objeto . "--PLP inserida com sucesso";

            if ($conn->query($sql_insert) === TRUE) {
                $message2 .= "<p>Dados inseridos com sucesso!</p>";
            } else {
                $message2 .= "<p>Erro ao inserir dados: " . $conn->error . "</p>";
            }

            $conn->close();

            unset($_SESSION['row']);
        }
    }
}
?>
<div class="container">
    <?php
    if ($show_insert_button2) {
    ?>

        <hr>
        <h3>Inserir Novo Rastreamento</h3>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="dt_envio">Data de Envio:</label>
            <input type="date" id="dt_envio" name="dt_envio">
            <label for="dt_previsao">Data de Previsão:</label>
            <input type="date" id="dt_previsao" name="dt_previsao">
            <input type="text" id="objeto" name="objeto" required placeholder="Rastreio">
            <input type="text" id="nome" name="nome" required placeholder="Destinatario">
            <input type="text" id="email" name="email" required placeholder="E-mail">
            <input type="text" id="status" name="status" required placeholder="Status do rastreio">
            <input type="submit" name="insert_button" value="Inserir">
        </form>
        <hr>
        <h3>Nova busca</h3>
    <?php

    } ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" id="search_condition2" name="search_condition2" required placeholder="Rastreio referencia">
        <input type="submit" name="search_button2" value="Buscar">
    </form>
</div>
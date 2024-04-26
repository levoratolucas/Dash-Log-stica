<?php
// session_start();
// include '../config/check_auth.php';
if ($_SESSION['loja'] != 999) {
    header('Location: pedidos.php');
    exit();
}
// include "../config/config.php";
$message = '';
$search_condition = '';
$show_insert_button = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['search_button'])) {

        $search_condition = $_POST['search_condition'];

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($conn->connect_error) {
            die("Erro na conexão com o banco de dados: " . $conn->connect_error);
        }

        $sql_select = "SELECT cartao, plp, dt_envio, dt_previsao, status, objeto, destinatario, cep, endereco, bairro, numero, complemento, cidade, uf, departamento, vlrdecla, valor, peso, codservico, conteudo, entregue, url_rastreio, nf, store_id, is_workspace, email,order_number FROM tb_csv_plp WHERE objeto = '$search_condition'";

        $result = $conn->query($sql_select);

        if ($result->num_rows > 0) {

            // $message .= "<table class='tableUser'>";

            // while ($row = $result->fetch_assoc()) {
            //     $message .= "<tr>";
            //     $message .= "<td>" . $row['order_number'] . "</td>";
            //     $message .= "<td>" . $row['destinatario'] . "</td>";
            //     $message .= "<td>" . $row['objeto'] . "</td>";
            //     $message .= "<td>" . $row['email'] . "</td>";
            //     $message .= "</tr>";
            //     $_SESSION['row'] = $row;
            // }
            // $message .= "</table>";

            $show_insert_button = true;
        } else {
            $message = "<p>Nenhum resultado encontrado na busca.</p>";
            $show_insert_button = false;
        }
    } elseif (isset($_POST['insert_button'])) {
        $objeto = isset($_POST['objeto']) ? $_POST['objeto'] : '';
        $dt_envio = isset($_POST['dt_envio']) ? $_POST['dt_envio'] : '';
        $dt_previsao = isset($_POST['dt_previsao']) ? $_POST['dt_previsao'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        if (isset($_SESSION['row'])) {

            $row = $_SESSION['row'];


            if ($conn->connect_error) {
                die("Erro na conexão com o banco de dados: " . $conn->connect_error);
            }

            $sql_insert = "INSERT INTO tb_csv_plp (cartao, plp, dt_envio, dt_previsao, status, objeto, destinatario, cep, endereco, bairro, numero, complemento, cidade, uf, departamento, vlrdecla, valor, peso, codservico, conteudo, entregue, url_rastreio, nf, store_id, is_workspace, email,order_number,eventos,hist_concluido) 
                    VALUES ('" . $row['cartao'] . "', '" . $row['plp'] . "', '" . $dt_envio . "', '" . $dt_previsao . "', '" . $status . "', '" . $objeto . "', '" . $row['destinatario'] . "', '" . $row['cep'] . "', '" . $row['endereco'] . "', '" . $row['bairro'] . "', '" . $row['numero'] . "', '" . $row['complemento'] . "', '" . $row['cidade'] . "', '" . $row['uf'] . "', '" . $row['departamento'] . "', '" . $row['vlrdecla'] . "', '" . $row['valor'] . "', '" . $row['peso'] . "', '" . $row['codservico'] . "', '" . $row['conteudo'] . "', '" . $row['entregue'] . "', 'https://rastreamento.correios.com.br/app/index.php?objetos=" . $objeto . "', '" . $row['nf'] . "', '" . $row['store_id'] . "', '" . $row['is_workspace'] . "', '" . $row['email'] . "', '" . $row['order_number'] . "','0',0)";
            if ($conn->query($sql_insert) === TRUE) {
                echo "Dados inseridos com sucesso!";
            } else {
                echo "Erro ao inserir dados: " . $conn->error;
            }

            $conn->close();

            unset($_SESSION['row']);
        }
    } else {
    }
}
?>



<?php echo $message; ?>
<?php
if ($show_insert_button) {
?>
    <hr>
    <h3>Inserir novo</h3>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <input type="text" id="objeto" name="objeto" placeholder="Novo rastreio">
        <input type="text" id="status" name="status" placeholder="Status do rastreio"><br>
        <label for="dt_envio">Data de Envio:</label>
        <input type="date" id="dt_envio" name="dt_envio" placeholder="Digite a sua busca"><br>
        <label for="dt_previsao">Data de Previsão:</label>
        <input type="date" id="dt_previsao" name="dt_previsao" placeholder="Digite a sua busca">
        <input type="submit" name="insert_button" value="Inserir">
    </form>
    <hr>
    <h3>Nova busca</h3>
<?php
}
?>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="text" id="search_condition" name="search_condition" placeholder="Digite rastreio antigo">
    <input type="submit" name="search_button" value="Buscar">
</form>
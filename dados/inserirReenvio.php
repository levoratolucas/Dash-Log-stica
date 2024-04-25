<?php

$selectValues = array(1, 3, 4, 5, 6); 
$selectTexts = array('SEM TRATAMENTO','AGUARDANDO RETORNO', 'VOLTAR ESTOQUE', 'FALAR GESTOR', 'DANIFICADO'); 
include '../view/layout/formPlp.php';
$message = '';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}
if ($_SESSION['username'] == 'rdstation@yoobe.co') {
    header('Location: pedidos.php');
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['insert_button'])) {
    
        $rastreio = isset($_POST['rastreio']) ? $_POST['rastreio'] : '';
        $obs = isset($_POST['obs']) ? $_POST['obs'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';

    
        $sql_insert = "INSERT INTO spree_reenvios (rastreio, status, obs) VALUES ('$rastreio', '$status', '$obs')";
        if ($conn->query($sql_insert) === TRUE) {
            $message = "Dados inseridos com sucesso!";
        } else {
            $message = "Erro ao inserir dados: " . $conn->error;
        }
    }
}
$conn->close();
?>
    <?php if (!empty($message)) { ?>
        <div class="alert"><?php echo $message; ?></div>
    <?php } ?>
    <!-- Formulário de inserção -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="rastreio">Rastreio:</label>
        <input type="text" id="rastreio" name="rastreio" required placeholder="Digite o código de rastreamento">
        <label for="obs">Observação:</label>
        <input type="text" id="obs" name="obs" placeholder="Digite uma observação">
        <label for="status">Status:</label>
        <select id="status" name="status">
            <?php for ($i = 0; $i < count($selectValues); $i++) { ?>
                <option value="<?php echo $selectValues[$i]; ?>"><?php echo $selectTexts[$i]; ?></option>
            <?php } ?>
        </select>
        <input type="submit" name="insert_button" value="Inserir">
    </form>

<style>
  .reenvio {
    background-color: white;
    width: 100%;
  }
  
</style>
<?php
// include '../config/check_auth.php';
if ($_SESSION['username'] == 'rdstation@yoobe.co') {
  header('Location: pedidos.php');
  exit();
}
include '../controler/biblioteca.php';
// include '../config/config.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$busca = '';
$busca = isset($_POST['busca']);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Verificando se o campo de busca foi enviado
  if (isset($_POST['busca'])) {
    $busca = $_POST['busca'];
    $page = 1;
  }
}
$query = "SELECT `destinatario`,`order_number`,objeto,date_format(data_criacao,'%d/%m/%Y') as dt_Criacao,date_format(dt_envio,'%d/%m/%Y')  as dt_envio,`email`,`status`,`conteudo`,`plp` FROM `tb_csv_plp`
WHERE destinatario LIKE '%" . $busca . "%'
OR  email LIKE '%" . $busca . "%'
OR  order_number LIKE '%" . $busca . "%'
OR  objeto LIKE '%" . $busca . "%'
ORDER BY id DESC 
";

?>
<div class="search2" style="margin: auto;">
  <form id="searchForm2" method="post" action="">
    <input type="text" name="busca" placeholder="Digite a sua busca">
  </form>
</div>
  <?php
  try {
    renderTablePags('plpTable', $query, $page,20);
  } catch (InvalidArgumentException $e) {
    echo "Erro: " . $e->getMessage();
  } catch (PDOException $e) {
    echo "Erro na consulta: " . $e->getMessage();
  }

  // Fechar conexão
  $conn->close();
  ?>
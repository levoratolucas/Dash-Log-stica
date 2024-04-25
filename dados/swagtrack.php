<?php
include '../config/check_auth.php';
include '../view/layout/formPlp.php';

$lojas = $_SESSION['loja'];


$loja = 'and plp.store_id = ' . $lojas;
$loja2 = 'and store_id = ' . $lojas;
$loja1 = $lojas;
if ($lojas == 999) {
  $loja = '';
  $loja2 = '';
  $loja1 = '';
}
include '../controler/biblioteca.php';
include '../config/config.php';


$busca = '';
$busca = isset($_GET['busca']);
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  // Verificando se o campo de busca foi enviado
  if (isset($_GET['busca'])) {

    $mes = $_GET['mes'];
    $busca = $_GET['busca'];
    $page = 1;
  }
  if (isset($_GET['page'])) {
    $mes = $_GET['mes'];
    $busca = $_GET['busca'];
    $page = $_GET['page'];
  }
}
$mes1="date_format(plp.dt_envio,'%y-%m') = '" . $mes . "' and ";
if($mes == 1){
  $mes1='';
}
// echo 'loja'.$loja.' mes busca'.$mes;
$query2 = "SELECT 
date_format(plp.dt_envio,'%d-%m-%y') as  data,
plp.destinatario,
plp.plp,
plp.objeto,
plp.conteudo,
plp.order_number,
ss.code 
FROM tb_csv_plp plp
JOIN spree_stores_on ss on 
ss.store_id = plp.store_id
where  ".$mes1."
(
    plp.destinatario like '%" . $busca . "%' or
    plp.plp like '%" . $busca . "%' or
    plp.objeto like '%" . $busca . "%' or
    plp.conteudo like '%" . $busca . "%' or
    plp.order_number like '%" . $busca . "%' 
) ".$loja."
order by plp.id desc 
";
$query = "select date_format(dt_envio,'%y-%m') as data ,count(objeto)
from tb_csv_plp 
where 1=1 ".$loja2."
GROUP by date_format(dt_envio,'%y-%m')
order by date_format(dt_envio,'%y-%m') desc ";
$meses = queryArray($db_apisup, $query, 'data');
?>
<style>
  .search2 {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .searchForm2 form {
    display: flex;
    justify-content: center;
    align-items: center;
  }
</style>
<div class="search2">
  <form id="searchForm2" method="get" action="" style="margin-bottom: 10px; display:flex;">
    <select name="mes" id="">
      <?php
      echo '<option value="1">RESET</option>';
      foreach ($meses as $i) {
        echo '<option value="' . $i . '">' . $i . '</option>';
      }
      ?>
    </select>
    <div class="search2">
      <input type="text" name="busca" placeholder="Digite a sua busca">
    </div>
    <button type="submit" >enviar</button>

  </form>
</div>
<style>
  body {
    background-color: white;
  }
</style>
<?php
try {
  renderTablePags('plpTable', $query2,$loja1, $mes, $busca, $page, 15);
} catch (InvalidArgumentException $e) {
  echo "Erro: " . $e->getMessage();
} catch (PDOException $e) {
  echo "Erro na consulta: " . $e->getMessage();
}

// Fechar conexão
$conn->close();
?>
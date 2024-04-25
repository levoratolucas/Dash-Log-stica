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
$mes1=" and date_format(plp.dt_envio,'%y-%m') = '" . $mes . "'";
if($mes == 1){
  $mes1='';
}
// echo 'loja'.$loja.' mes busca'.$mes;
$query = "select count(plp.objeto) as envios,date_format(plp.dt_envio,'%y-%m') as data 
from tb_csv_plp as plp
JOIN spree_stores_on ss on 
ss.store_id = plp.store_id
where 1=1 ".$loja."
GROUP by date_format(plp.dt_envio,'%y-%m')
order by date_format(plp.dt_envio,'%y-%m') desc ";

$query2 = "select plp.conteudo as Campanha,count(plp.objeto) as Envios,date_format(plp.dt_envio,'%y-%m') as Data 
from tb_csv_plp as plp
JOIN spree_stores_on ss on 
ss.store_id = plp.store_id
where 1=1 ".$loja." ".$mes1." and (
  plp.destinatario like '%" . $busca . "%' or
  plp.conteudo like '%" . $busca . "%' or
  plp.objeto like '%" . $busca . "%' or
  plp.conteudo like '%" . $busca . "%' or
  plp.order_number like '%" . $busca . "%' 
)
GROUP by date_format(plp.dt_envio,'%y-%m'),plp.conteudo
order by count(plp.objeto) desc ";

$meses = queryArray($db_apisup, $query, 'data');
$queryTag = "select plp.conteudo
from tb_csv_plp as plp
JOIN spree_stores_on ss on 
ss.store_id = plp.store_id
where 1=1 ".$loja."
GROUP by plp.conteudo
order by plp.conteudo desc ";
$campanhas =  queryArray($db_apisup, $queryTag, 'conteudo');
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
      <select name="busca" id="">
      <?php
      echo '<option value="1">RESET</option>';
      foreach ($campanhas as $tag) {
        echo '<option value="' . $tag . '">' . $tag . '</option>';
      }
      ?>

      </select>
      <!-- <input type="text" name="busca" placeholder="Digite a sua busca"> -->
    </div>
    <button type="submit">enviar</button>

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
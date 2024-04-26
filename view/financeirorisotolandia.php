<!-- index.php  -->
<?php
include '../config/check_auth.php';
if ($_SESSION['loja'] != 999) {
  header('Location: pedidos.php');
  exit();
}
$wmes = '';
$mes = '';
if (isset($_GET['mes'])) {
  $mes = $_GET['mes'];
  $mes = $mes . "/";
  $wmes = 'f.mes = ' . $mes . ' and ';
}
include '../controler/biblioteca.php';
include '../config/config.php';
require './layout/header.php';
include '../dados/lojasadicionais.php';
?>
</div>
<div class="menu">
  <div class="dados_full" style="max-height: 600px; margin-top:10px; overflow:auto;">
    <div class="dados95">
      <?php
      $meses = queryArray($db_apisup, 'select mes from financas where ano = 24 group by mes order by mes desc', "mes");
      foreach ($meses as $mes) {
        echo "<h3>" . $mes . "/24 </h3>";
        $sql_spree = "SELECT
        'Risotolandia' as loja , 
        CONCAT('R$ ', FORMAT(count(plp.objeto) * 10.9 + sum(f.valor * 1.3), 2)) as Valor_cobrar,
        CONCAT('R$ ', FORMAT(count(plp.objeto) * 10.9, 2)) as valorCampanha,
        CONCAT('R$ ', FORMAT(sum(f.valor * 1.3), 2)) as valorEnvios,
        CONCAT('R$ ', FORMAT(sum(f.valor), 2)) as custoEnvios,
        count(plp.objeto) as quantidade
        FROM 
            tb_csv_plp plp
        RIGHT JOIN 
            financas f ON f.rastreio = plp.objeto
        JOIN 
            spree_stores_on st ON plp.store_id = st.store_id
        WHERE 
            f.mes = ".$mes." and st.code like '%risoto%';
        ";
        renderTableFromQuery("table","Nenhum dado encontrado", $db_apisup, $sql_spree, true);
      
      }
      ?>


    </div>
  </div>
</div>

</main>


<?php
gerarFooter('LEVORATECH')
?>
</body>

</html>
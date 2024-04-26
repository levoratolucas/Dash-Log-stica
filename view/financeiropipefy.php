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
              plp.conteudo,
              CONCAT('R$ ', FORMAT(CASE 
                                  WHEN plp.conteudo = 'Onboarding' THEN COUNT(f.valor) * 10.9 + SUM(f.valor * 1.3)
                                  WHEN plp.conteudo LIKE '%IDtag%' THEN COUNT(f.valor) * 11.8 + SUM(f.valor * 1.3)
                                  ELSE 0 + SUM(f.valor * 1.3) 
                              END, 2)) AS Valor_Cobrar,
              CONCAT('R$ ', FORMAT(CASE 
                                  WHEN plp.conteudo = 'Onboarding' THEN COUNT(f.valor) * 10.9
                                  WHEN plp.conteudo LIKE '%IDtag%' THEN COUNT(f.valor) * 11.8
                                  ELSE 0 
                              END, 2)) AS Custos_extras,
              CONCAT('R$ ', FORMAT(SUM(f.valor * 1.3), 2)) AS valorEnvios,
              CONCAT('R$ ', FORMAT(SUM(f.valor), 2)) AS CustoEnvios,
              count(plp.conteudo) as envios
              FROM 
                  tb_csv_plp plp
              RIGHT JOIN 
                  financas f ON f.rastreio = plp.objeto
              JOIN 
                  spree_stores_on st ON plp.store_id = st.store_id
              WHERE 
              f.mes = " . $mes . " and  plp.store_id = 471
              GROUP BY 
                  plp.conteudo
              order by   count(plp.conteudo) desc;";
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
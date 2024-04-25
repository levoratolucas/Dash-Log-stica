<!-- index.php  -->
<?php
include '../config/check_auth.php';
if ($_SESSION['loja'] != 999) {
    header('Location: pedidos.php');
    exit();
}
include '../controler/biblioteca.php';
include '../config/config.php';
require './layout/header.php';

?>

<div class="lateral">
    <a href="https://app.stokki.com.br/pt-br/login" target="_blank">STOKKI</a>
    <a href="https://app.pipefy.com/open-cards/860737223" target="_blank">PIPEFY</a>
    <a href="http://swag.yoobe.app" target="_blank" id="linkLoja">LOJAS SWAG</a>
    <a href="https://admin.yoobe.io/admin/orders" target="_blank">SPREE</a>
    <a href="https://yoobe.zendesk.com/auth/v2/login" target="_blank">ZENDESK</a>
    <a href="https://account.postmarkapp.com/login" target="_blank">POSTMARK</a>
    <a href="https://erp.tiny.com.br" target="_blank">TINY</a>
    <?php

    ?>
</div>
<div class="menu">
    <div class="dados_full" style="max-height: 600px; margin-top:10px; overflow:auto;">


        <?php
        $lojas = queryArray($db_apisup, 'select mes from financas group by mes order by mes', "mes");


        foreach ($lojas as $loja) {
            echo '<div class="dados">';
            echo "<h3>mes ".$loja." </h3>";
            $sql_spree = "SELECT 
            FORMAT(SUM(f.valor), 2, 'de_DE') AS despesa,
            FORMAT(SUM(f.valor * 1.3), 2, 'de_DE') AS faturamento,
            st.code 
            FROM financas f 
            JOIN tb_csv_plp p ON f.rastreio = p.objeto 
            JOIN spree_stores_on st on st.store_id = p.store_id
            WHERE f.mes = ".$loja."
            GROUP BY st.code 
            order by SUM(f.valor) desc";
            renderTableFromQuery("table", $db_apisup, $sql_spree);            
            echo '</div>';
        }
        ?>
    </div>

</div>

</main>


<?php
gerarFooter('LEVORATECH')
?>
</body>

</html>
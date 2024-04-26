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
include '../dados/lojasadicionais.php';
?>
</div>
<div class="menu">
    <div class="dados_full" style="max-height: 600px; margin-top:10px; overflow:auto;">
    


        <?php
        $meses = queryArray($db_apisup, 'select mes from financas where ano = 24 group by mes order by mes', "mes");
        

        foreach ($meses as $mes) {
            echo '<div class="dados30">';
            echo "<h3>".$mes."/24 </h3>";
            $sql_spree = "SELECT 
            st.code AS loja,
            CONCAT('R$ ', FORMAT(SUM(f.valor*1.3), 2)) AS Cobrar,
            CONCAT('R$ ', FORMAT(SUM(f.valor), 2)) AS despesa
            FROM 
                financas f 
            JOIN 
                tb_csv_plp p ON f.rastreio = p.objeto 
            JOIN 
                spree_stores_on st ON st.store_id = p.store_id
            WHERE 
                f.mes = ".$mes." AND f.ano = 24 AND p.store_id NOT IN (431, 471, 511, 442, 505)
            GROUP BY 
                st.code 
            ORDER BY 
                SUM(f.valor) DESC;
            ";
            renderTableFromQuery("table","Nenhum dado encontrado", $db_apisup, $sql_spree,true);            
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
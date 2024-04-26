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
<form class="form" method="post">
    <select name="mes" id="">
        <option value="null">Mes</option>
        <?php
        $meses = queryArray($db_apisup, 'select mes from financas where ano = 24 group by mes order by mes', "mes");
        foreach ($meses as $mes) {
            echo '<option name="mes" value="' . $mes . '">' . $mes . '</option>';
        }
        if (isset($_POST['mes']) && $_POST['mes'] != 'null') {
            $meses = [$_POST['mes']];
        }
        ?>
    </select>
    <button type="submit">DATA</button>
</form>
</div>
<div class="menu">
    <div class="dados_full" style="max-height: 600px; margin-top:10px; overflow:auto;">
        <?php
        foreach ($meses as $mes) {
            echo '<div class="dados30">';
            echo "<h3>Sem swag track no periode de " . $mes . "/24 </h3>";
            $sql_spree = "SELECT 
           f.rastreio , f.destinatario, f.valor , f.postagem
       FROM 
           financas f
       left JOIN 
           `tb_csv_plp` plp ON f.rastreio = plp.objeto
       WHERE 
           plp.objeto IS NULL and f.mes = " . $mes . " and f.ano > 23";
            renderTableFromQuery("table", "Todos envios do mes " . $mes . " tem PLP", $db_apisup, $sql_spree, true);
            echo '</div>';
        }
        foreach ($meses as $mes) {
            echo '<div class="dados30">';
            echo "<h3>Sem valores " . $mes . "/24 </h3>";
            $sql_spree = "SELECT 
            st.code,
            plp.destinatario,
            plp.objeto,
            plp.order_number 
        FROM 
            `tb_csv_plp` plp
        LEFT JOIN 
            financas f ON f.rastreio = plp.objeto
        JOIN 
            spree_stores_on st ON plp.store_id = st.store_id
        WHERE 
            DATE_FORMAT(plp.dt_envio, '%y') > 23 AND f.rastreio IS NULL and f.mes = " . $mes . "
        ORDER BY 
            plp.data_criacao,st.code;";
            renderTableFromQuery("table", "tudo ok , parabéns", $db_apisup, $sql_spree, true);
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
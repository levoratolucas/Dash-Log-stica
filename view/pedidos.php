<!-- index.php  -->
<?php
include '../config/check_auth.php';
include '../controler/biblioteca.php';
include '../config/config.php';
include '../view/layout/formPlp.php';
$loja = $_SESSION['loja'];
$meses = '';
$mes = '';
$meses = '';
$mes = '';
if (isset($_GET['busca']) || isset($_GET['mes'])) {

    $mes = $_GET['mes'];
    if ($mes == '') {
        $mes = '';
    } else {
        $meses = "and date_format(dt_envio,'%Y-%m') = '" . $mes . "' ";
    }
}
$css = 'table table-striped-columns';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto&display=swap">

</head>

<body>
<?php 
    include '../config/seletorLoja.php';
    if($loja == 999){
        $loja = 484;
    }
    ?>
    <main>
        <div class="lateral"><!-- for preenchendo as  lojas -->
            <form class="form" role="search" method="get">
                <select name="mes" id="">
                    <?php
                    $query = "select count(plp.objeto) as envios,date_format(plp.dt_envio,'%y-%m') as data 
                    from tb_csv_plp as plp
                    JOIN spree_stores_on ss on 
                    ss.store_id = plp.store_id
                    where 1=1 and plp.store_id = " . $loja . "
                    GROUP by date_format(plp.dt_envio,'%y-%m')
                    order by date_format(plp.dt_envio,'%y-%m') desc ";
                    $meses = queryArray($db_apisup, $query, 'data');
                    echo '<option value="1">RESET</option>';
                    foreach ($meses as $i) {
                        echo '<option value="' . $i . '">' . $i . '</option>';
                    }
                    ?>
                </select>
                <input type="search" name="busca" placeholder="pesquisa"><br>
                <button type="submit">pesquisar</button>
            </form>
        </div>
        <div class="menu">
            <div class="dados_full">
                <div class="dados">

                    <?php
                    $query = "select count(number) PEDIDOS,to_char(completed_at,'YYYY-MM') x
            from spree_orders 
            where state='complete' 
            and store_id = " . $loja . " and to_char(completed_at,'YYYY-MM') is not null 
            GROUP BY to_char(completed_at,'YYYY-MM')
            ORDER BY to_char(completed_at,'YYYY-MM')";
                    $x = queryArray($db_pg, $query, 'x');
                    $query = "SELECT code as x FROM spree_stores WHERE id = " . $loja;
                    $datasets = queryArray($db_pg, $query, 'x');
                    $datasetValues = [];
                    $i = 0;
                    foreach ($datasets as $value) {
                        $query = "select count(number) as x,to_char(completed_at,'YYYY-MM') PERIODO
                from spree_orders 
                where state='complete' 
                and store_id = " . $loja . "
                GROUP BY to_char(completed_at,'YYYY-MM')
                ORDER BY to_char(completed_at,'YYYY-MM')";
                        $datasetValues[$i] = queryArray($db_pg, $query, 'x');
                        $i++;
                    }
                    renderLineChart('teste', 6, 'ENVIOS POR TAG', $x, $datasets, $datasetValues);

                    ?>
                </div>

                <div class="dados">
                    <?php
                    $query = "select count(sp.name) AS QTD,sp.name PRODUTO from spree_line_items sli 
            join spree_orders so on so.id = sli.order_id
            join spree_variants sv on sli.variant_id=sv.id 
            join spree_products sp on sv.product_id = sp.id
            join spree_stores st on so.store_id = st.id
            where  st.id <>414 and so.state <> 'cart' and so.store_id =" . $loja . "
            group by sp.name
            order by count(sp.name) desc";

                    $data = executeQuery($db_pg, $query);
                    renderTable($data, 'table');
                    ?>
                </div>
                <div class="dados">
                    <?php
                    $query = "select count(number) AS QTD,to_char(completed_at,'YYYY') ANO
           from spree_orders 
           where state='complete' 
           and store_id = " . $loja . " and to_char(completed_at,'YYYY') is not null
           GROUP BY to_char(completed_at,'YYYY')
           ORDER BY to_char(completed_at,'YYYY')";
                    $css = 'table';
                    $data = executeQuery($db_pg, $query);
                    renderTable($data, 'table');
                    ?>
                </div>
                <div class="dados">
                    <?php
                    $query = "select count(number) AS QTD,to_char(completed_at,'YYYY-MM') PERIODO
            from spree_orders 
            where state='complete' 
            and store_id = " . $loja . " and to_char(completed_at,'YYYY-MM') is not null
            GROUP BY to_char(completed_at,'YYYY-MM')
            ORDER BY to_char(completed_at,'YYYY-MM')";
                    $css = 'table';
                    $data = executeQuery($db_pg, $query);
                    renderTable($data, 'table');
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
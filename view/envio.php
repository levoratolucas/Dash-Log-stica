<!-- index.php  -->
<?php
$loja = 484;
include '../config/check_auth.php';
include '../controler/biblioteca.php';
include '../config/config.php';
if ($_SESSION['username'] == 'rdstation@yoobe.co') {
    $loja = 431;
}
$busca = '';
$meses = '';
if (isset($_GET['busca']) || isset($_GET['mes'])) {
    $busca = trim($_GET['busca']);
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

    if ($_SESSION['username'] == 'rdstation@yoobe.co') {
        $links = [
            "Pedidos" => "https://catalogo.yoobe.co/suporte/levoratech/view/pedidos.php",
            "Envios" => "https://catalogo.yoobe.co/suporte/levoratech/view/envios.php"
        ];
        gerarHeader(name_Format("RD Station - yoobe"), $links, 800);
    ?>
        <style>
            main,
            header,
            .dados_full,
            .lateral,
            body {
                background-color: <?php echo '#86E0E8'; ?>;
            }
        </style>
    <?php
    } else {
        $links = [
            "Home" => "https://catalogo.yoobe.co/suporte/levoratech/view/home.php",
            "Financeiro" => "https://catalogo.yoobe.co/suporte/levoratech/view/financeiro.php",
            "Suporte" => "https://catalogo.yoobe.co/suporte/levoratech/view/suporte.php",
            "Pedidos" => "https://catalogo.yoobe.co/suporte/levoratech/view/pedidos.php",
            "Envios" => "https://catalogo.yoobe.co/suporte/levoratech/view/envios.php"
        ];
        gerarHeader(name_Format(""), $links, 800);
    }

    ?>
    <main>
        <div class="lateral">
            <form class="form" role="search" method="get">
                <input type="month" name="mes">
                <input type="search" name="busca" placeholder="pesquisa"><br>
                <button type="submit">pesquisar</button>
            </form>
        </div>
        <div class="menu">
            <div class="dados_full">
                <div class="dados">
                    <iframe src="https://catalogo.yoobe.co/suporte/levoratech/dados/enviosMes.php?page=1&mes=01&busca=" frameborder="0"></iframe>
                </div>
                <div class="dados">

                    <?php

                    $query = "SELECT IFNULL(COUNT(plp), 0) AS total_plp, months.mes as x
            FROM (
                     SELECT '2024-02' AS mes UNION ALL
                     SELECT '2024-03' UNION ALL
                     SELECT '2024-04'
            ) AS months
            LEFT JOIN tb_csv_plp p ON DATE_FORMAT(p.dt_envio, '%Y-%m') = months.mes AND p.store_id = " . $loja . " 
            GROUP BY months.mes
            ORDER BY months.mes ASC;";
                    $x = queryArray($db_apisup, $query, 'x');
                    $query = "SELECT plp as x FROM `tb_csv_plp` WHERE store_id = " . $loja . "  GROUP by plp";
                    $datasets = queryArray($db_apisup, $query, 'x');
                    $datasetValues = [];
                    $i = 0;
                    foreach ($datasets as $value) {
                        $query = "SELECT IFNULL(COUNT(plp), 0) AS plp, months.mes
                 FROM (
                    
                     SELECT '2024-02' AS mes UNION ALL
                     SELECT '2024-03' UNION ALL
                     SELECT '2024-04'
                 ) AS months
                 LEFT JOIN tb_csv_plp p ON DATE_FORMAT(p.dt_envio, '%Y-%m') = months.mes AND p.store_id = " . $loja . " and p.plp = '" . $value . "' 
                 GROUP BY months.mes
                 ORDER BY months.mes ASC;";
                        $datasetValues[$i] = queryArray($db_apisup, $query, 'plp');
                        $i++;
                    }
                    renderLineChart('teste', 6, 'Trimestral tag', $x, $datasets, $datasetValues);

                    ?>
                </div>
                <div class="dados">
                    <?php

                    $query = "SELECT `conteudo`
            FROM `tb_csv_plp`
            WHERE  store_id = " . $loja . " and (conteudo like '%" . $busca . "%' or plp like '%" . $busca . "%') 
            GROUP BY `conteudo`";
                    $x = ['2023', '2024'];
                    $datasets = queryArray($db_apisup, $query, 'conteudo');
                    $i = 0;
                    $datasetValues = [];

                    foreach ($datasets as $value) {
                        $query = "SELECT IFNULL(COUNT(p.conteudo), 0) AS qtd, years.year
                    FROM (
                        SELECT '2023' AS year UNION ALL
                        SELECT '2024'
                        ) AS years
                        LEFT JOIN tb_csv_plp p ON YEAR(p.dt_envio) = years.year AND p.store_id = " . $loja . " and (p.conteudo like '%" . $busca . "%' or p.plp like '%" . $busca . "%') and p.conteudo ='" . $value . "'
                        GROUP BY years.year
                        ORDER BY years.year;";
                        $datasetValues[$i] = queryArray($db_apisup, $query, 'qtd');
                        $i++;
                    }
                    renderLineChart('teste2', 6, 'Anual campanhas', $x, $datasets, $datasetValues);
                    ?>
                </div>
                <div class="dados">
                    <?php
                    $query = "SELECT `plp` TAG,COUNT(`plp`) QTD ,YEAR(`dt_envio`) ANO
            FROM `tb_csv_plp`
            WHERE store_id = " . $loja . " and (conteudo like '%" . $busca . "%' or plp like '%" . $busca . "%') " . $meses . "
            GROUP BY `plp`,YEAR(`dt_envio`)
            ORDER BY YEAR(`dt_envio`) DESC";

                    $data = executeQuery($db_apisup, $query);
                    renderTable($data, 'table');
                    ?>
                </div>
                <div class="dados">
                    <?php
                    $query = "SELECT `plp` TAG ,COUNT(`plp`) QTD,date_format(`dt_envio`,'%y-%m') PERIODO
            FROM `tb_csv_plp`
            WHERE store_id = " . $loja . " and (conteudo like '%" . $busca . "%' or plp like '%" . $busca . "%') " . $meses . "
            GROUP BY `plp`,date_format(`dt_envio`,'%y-%m')
            ORDER BY date_format(`dt_envio`,'%y-%m') DESC";

                    renderTableFromQuery("table","Nenhum dado encontrado", $db_apisup, $query);

                    ?>
                </div>
                <div class="dados">
                    <?php
                    $query = "SELECT `conteudo`CAMPANHA,COUNT(`conteudo`) QTD,YEAR(`dt_envio`) ANO
           FROM `tb_csv_plp`
           WHERE store_id = " . $loja . " and (conteudo like '%" . $busca . "%' or plp like '%" . $busca . "%') " . $meses . "
           GROUP BY `conteudo`,YEAR(`dt_envio`)
           ORDER BY YEAR(`dt_envio`) DESC";
                    $css = 'table';
                    renderTableFromQuery("table","Nenhum dado encontrado", $db_apisup, $query);

                    ?>
                </div>
                <div class="dados">
                    <?php
                    $query = "SELECT `conteudo` CAMPANHA,COUNT(`objeto`)    QTD,date_format(`dt_envio`,'%y-%m') PERIODO
            FROM `tb_csv_plp`
            WHERE store_id = " . $loja . " and (conteudo like '%" . $busca . "%' or plp like '%" . $busca . "%')" . $meses . "
            GROUP BY `conteudo`,date_format(`dt_envio`,'%y-%m')
            ORDER BY date_format(`dt_envio`,'%y-%m') DESC";
                    $css = 'table';
                    renderTableFromQuery("table","Nenhum dado encontrado", $db_apisup, $query);

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




<div class="dados">
                    <?php

                    $query = "SELECT IFNULL(COUNT(plp), 0) AS total_plp, months.mes as x
                    FROM (
                    SELECT '2024-02' AS mes UNION ALL
                    SELECT '2024-03' UNION ALL
                    SELECT '2024-04'
                    ) AS months
                    LEFT JOIN tb_csv_plp p ON DATE_FORMAT(p.dt_envio, '%Y-%m') = months.mes AND p.store_id = " . $loja . " 
                    GROUP BY months.mes
                    ORDER BY months.mes ASC;";
                    $x = queryArray($db_apisup, $query, 'x');
                    $query = "SELECT plp as x FROM `tb_csv_plp` WHERE store_id = " . $loja . "  GROUP by plp";
                    $datasets = queryArray($db_apisup, $query, 'x');
                    $datasetValues = [];
                    $i = 0;
                    foreach ($datasets as $value) {
                        $query = "SELECT IFNULL(COUNT(plp), 0) AS plp, months.mes
                        FROM (

                        SELECT '2024-02' AS mes UNION ALL
                        SELECT '2024-03' UNION ALL
                        SELECT '2024-04'
                        ) AS months
                        LEFT JOIN tb_csv_plp p ON DATE_FORMAT(p.dt_envio, '%Y-%m') = months.mes AND p.store_id = " . $loja . " and p.plp = '" . $value . "' 
                        GROUP BY months.mes
                        ORDER BY months.mes ASC;";
                        $datasetValues[$i] = queryArray($db_apisup, $query, 'plp');
                        $i++;
                    }
                    renderLineChart('teste', 3, 'Trimestral tag', $x, $datasets, $datasetValues);

                    ?>
                </div>
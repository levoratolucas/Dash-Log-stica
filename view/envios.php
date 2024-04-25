<!-- index.php  -->
<?php
include '../config/check_auth.php';
include '../controler/biblioteca.php';
include '../config/config.php';
include '../view/layout/formPlp.php';
$loja = $_SESSION['loja'];

$loja3 = 'and plp.store_id = ' . $loja;
$loja2 = 'and store_id = ' . $loja;
$loja1 = $loja;
if ($loja ==999) {
  $loja = 999;
  $loja2 = '';
  $loja3 = '';
  $loja1 ='';
}
$meses = '';
$mes = '';
$mese=1;
if (isset($_GET['busca'])) {
    $busca = $_GET['busca'];
    $mes = $_GET['mes'];
    $mese = $_GET['mes'];
    if ($mes == '') {
        $mese = 1;
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
                    where 1=1 " . $loja3 . "
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

                <div class="dados60">
                    <h3>Envios por ano</h3>
                    <div>
                        <?php
                        $query = "SELECT COUNT(`objeto`) Quantidade,YEAR(`dt_envio`) as Ano
                        FROM `tb_csv_plp`
                        WHERE 1=1  " . $loja2 . "
                        GROUP BY YEAR(`dt_envio`)
                        ORDER BY YEAR(`dt_envio`) DESC";
                        $css = 'table';
                        $data = executeQuery($db_apisup, $query);
                        renderTable($data, 'table');
                        ?>
                    </div>

                </div>
                <div class="dados30">
                    <h3>Reenvios</h3>
                    <div>
                        <?php
                        $query = "SELECT COUNT(`objeto`) Quantidade,YEAR(`dt_envio`) as Ano
                        FROM `tb_csv_plp`
                        WHERE plp like '%REENVIO%' " . $loja2 . "
                        GROUP BY YEAR(`dt_envio`)
                        ORDER BY YEAR(`dt_envio`) DESC";
                        $css = 'table';
                        $data = executeQuery($db_apisup, $query);
                        renderTable($data, 'table');
                        ?>
                    </div>
                </div>
                <div class="dados">
                    <h3>Envios por mes</h3>
                    <iframe class="iframeEnvios" src="https://catalogo.yoobe.co/suporte/levoratech/dados/enviosMes.php?page=1&mes=<?= $mese ?>&busca=<?= $busca ?>&loja=<?= $loja ?>" frameborder="0"></iframe>
                </div>
                <div class="dados">
                    <h3>Envios por Campanha</h3>
                    <iframe class="iframeEnvios" src="https://catalogo.yoobe.co/suporte/levoratech/dados/enviosMesCampanha.php?page=1&mes=<?= $mese ?>&busca=<?= $busca ?>&loja=<?= $loja ?>" frameborder="0"></iframe>
                </div>
                <div class="dados" style="display: none;">
                    <h3>Envios por tag</h3>
                    <iframe class="iframeEnvios" src="https://catalogo.yoobe.co/suporte/levoratech/dados/enviosMesTag.php?page=1&mes=<?= $mese ?>&busca=<?= $busca ?>&loja=<?= $loja ?>" frameborder="0"></iframe>
                </div>
                <div class="dados95">
                    <h3>Swag track</h3>
                    <iframe class="iframeEnvios" src="https://catalogo.yoobe.co/suporte/levoratech/dados/swagtrack.php?page=1&mes=<?= $mese ?>&busca=<?= $busca ?>&loja=<?= $loja ?>" frameborder="0"></iframe>
                </div>


            </div>

        </div>

    </main>


    <?php
    gerarFooter('LEVORATECH')
    ?>
</body>

</html>
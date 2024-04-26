<!-- index.php  -->
<?php
include '../config/check_auth.php';
include '../controler/biblioteca.php';
include '../config/config.php';
include '../view/layout/formPlp.php';
$loja = $_SESSION['loja'];
if ($loja != 431 && $loja != 999) {
  header('Location: pedidos.php');
  exit();
}
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
  <div class="dados_full" style="max-height: 600px; margin-top:10px; overflow:auto;">
    <div class="dados95">
      <?php
      $meses = queryArray($db_apisup, 'select mes from financas where ano = 24 group by mes order by mes desc', "mes");
      foreach ($meses as $mes) {
        echo "<h3>" . $mes . "/24 </h3>";
        $sql_spree = "SELECT 
        
        plp.conteudo,
        CASE 
            WHEN plp.conteudo LIKE '%Rdversary%' THEN CONCAT('R$ ', FORMAT(count(f.valor) * 4.9 + sum(f.valor * 1.3), 2))
            WHEN plp.conteudo LIKE '%Baby Doer%' THEN CONCAT('R$ ', FORMAT(count(f.valor) * 8.9 + sum(f.valor * 1.3), 2))
            ELSE CONCAT('R$ ', FORMAT(sum(f.valor * 1.3), 2))
        END as Valor_cobrar,
        CASE 
            WHEN plp.conteudo LIKE '%Rdversary%' THEN CONCAT('R$ ', FORMAT(count(f.valor) * 12.8, 2))
            WHEN plp.conteudo LIKE '%Baby Doer%' THEN CONCAT('R$ ', FORMAT(count(f.valor) * 8.9, 2))
            ELSE 'R$ 0.00'
        END as Adicionais,
        CONCAT('R$ ', FORMAT(sum(f.valor * 1.3), 2)) as valorEnvios,
        count(plp.conteudo) as Quantidade
        FROM 
            tb_csv_plp plp
        RIGHT JOIN 
            financas f ON f.rastreio = plp.objeto
        JOIN 
            spree_stores_on st ON plp.store_id = st.store_id
        WHERE 
            plp.store_id = 431 AND f.mes = " . $mes . " 
        GROUP BY 
            plp.conteudo;
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
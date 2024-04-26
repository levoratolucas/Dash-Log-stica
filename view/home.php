<!-- index.php  -->
<?php
include '../config/check_auth.php';
if ($_SESSION['loja'] != 999) {
    header('Location: pedidos.php');
    exit();
}
include '../controler/biblioteca.php';
include '../config/config.php';
require '../view/layout/header.php';
$loja = '';
$meses = '';
if (isset($_GET['busca']) || isset($_GET['mes'])) {
    $loja = $_GET['busca'];
    $mes = $_GET['mes'];
    if ($mes == '') {
        $mes = '';
    } else {
        $meses = "and date_format(dt_envio,'%Y-%m') = '" . $mes . "' ";
    }
}
$css = 'table';
?>
<div class="lateral">
    <a href="https://app.stokki.com.br/pt-br/login" target="_blank">STOKKI</a>
    <a href="https://app.pipefy.com/open-cards/860737223" target="_blank">PIPEFY</a>
    <a href="http://swag.yoobe.app" target="_blank" id="linkLoja">LOJAS SWAG</a>
    <a href="https://admin.yoobe.io/admin/orders" target="_blank">SPREE</a>
    <a href="https://yoobe.zendesk.com/auth/v2/login" target="_blank">ZENDESK</a>
    <a href="https://account.postmarkapp.com/login" target="_blank">POSTMARK</a>
    <a href="https://erp.tiny.com.br" target="_blank">TINY</a>
    <div class="suporte">
                <h3>Inserir devolvidos</h3>
                <?php  include '../dados/inserirReenvio.php' 
                ?>
            </div>
</div>
<div class="menu">
    <div class="dados_full">
        <div class="dados30">
            
        </div>
        <div class="dados95">
            <div class="suporte">
                <h3>Pedidos com erro no tiny</h3>
                <?php
                $query = "SELECT  o.number,u.name,spa.id,o.tiny_id,u.document_value,u.contact_phone,u.email
                FROM spree_orders o 
                join spree_addresses spa on spa.id = o.ship_address_id
                join spree_stores s on s.id = o.store_id
                JOIN spree_users u ON u.id = o.user_id
                JOIN employee_shopkeeper_stores e ON e.spree_user_id = u.id
                WHERE spa.firstname ='' and o.state = 'complete' and to_char(completed_at,'YY')>'23' ";
                renderTableFromQuery("table","Nenhum dado encontrado", $db_pg, $query);
                ?>
            </div>
        </div>
        <div class="dados95">
            <div class="suporte">
                <h3>pedidos dedolvidos</h3>
                <?php
                include '../dados/dadosreenvio.php'
                ?>
            </div>
        </div>

    </div>


</div>

</div>

</main>


<?php
gerarFooter('LEVORATECH')
?>
</body>

</html>

<!-- <div class="dados">
    
</div>
<div class="dados">
    
</div>
<div class="dados">

</div> -->
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
<div class="lateral"><!-- for preenchendo as  lojas -->
    <a href="https://app.stokki.com.br/pt-br/login" target="_blank">STOKKI</a>
    <a href="https://app.pipefy.com/open-cards/860737223" target="_blank">PIPEFY</a>
    <a href="http://swag.yoobe.app" target="_blank" id="linkLoja">LOJAS SWAG</a>
    <a href="https://admin.yoobe.io/admin/orders" target="_blank">SPREE</a>
    <a href="https://yoobe.zendesk.com/auth/v2/login" target="_blank">ZENDESK</a>
    <a href="https://account.postmarkapp.com/login" target="_blank">POSTMARK</a>
    <a href="https://erp.tiny.com.br" target="_blank">TINY</a>
    <div class="dados95" id="dadosReenvio">
        <div>
            <h3>Plp reenvio</h3>
            <?php
            include '../dados/plpReenvio.php';
            ?>
        </div>
        <div>
            <h3>Plp campanha</h3>
            <?php
            include '../dados/plpCampanha.php';
            ?>
        </div>
    </div>
</div>
<div class="menu">
    <div class="dados_full">
        <div class="dados95">
            <div class="suporte">
                <h3>Swag track</h3>
                <iframe class="iframeEnvios" src="https://catalogo.yoobe.co/suporte/levoratech/dados/swagtrack.php?page=1&mes=1&busca=&loja=" frameborder="0"></iframe>
            </div>
        </div>
        <div class="dados30">
            <div class="suporte">
                <h3>Rastreamento</h3>
                <form id="rastrear" method="GET" action="">
                    <input type="text" id="codigo_objeto" name="codigo_objeto" placeholder="RASTREIO">
                </form>

                <div id="resultado">
                    <?php

                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                        // Verificando se o campo de busca foi enviado
                        if (isset($_GET['codigo_objeto'])) {
                            $codigoObjeto   = trim($_GET['codigo_objeto']);
                            rastrearObjeto($codigoObjeto);
                        }
                    }

                    ?>
                </div>
            </div>
        </div>
        <div class="dados30">
            <h3>Token usuários</h3>
            <div class="suporte">
                <?php include '../dados/dadostokenUser.php'; ?>
            </div>
        </div>
        <div class="dados30" id="dadosCampanha">
            <div class="suporte">
                <h3>busca usuario por pedido</h3>
                <div class="search2">
                    <form id="searchForm" method="GET" action="">
                        <input type="text" name="busca2" id="read2" placeholder="PEDIDO / E-MAIL">
                    </form>
                </div>
                <div>
                    <?php
                    $dbHandle_pg = $db_pg;
                    $busca2 = '';

                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                        // Verificando se o campo de busca2 foi enviado
                        if (isset($_GET['busca2'])) {
                            $busca2 = trim($_GET['busca2']);

                            if ($busca2 != '') {
                                searchTable($dbHandle_pg, $busca2);
                            } else {
                                $busca2 = '';
                                // searchTable($dbHandle_pg, $busca2);
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    function ajustarAltura() {
        var iframeReenvio = document.getElementById('iframeReenvio');
        var dadosDivReenvio = document.getElementById('dadosReenvio');
        dadosDivReenvio.style.height = iframeReenvio.contentWindow.document.body.scrollHeight + 'px';

        var iframeCampanha = document.getElementById('iframeCampanha');
        var dadosDivCampanha = document.getElementById('dadosCampanha');
        dadosDivCampanha.style.height = iframeCampanha.contentWindow.document.body.scrollHeight + 'px';
    }

    document.getElementById('iframeReenvio').addEventListener('load', ajustarAltura);
    document.getElementById('iframeCampanha').addEventListener('load', ajustarAltura);
    window.addEventListener('load', ajustarAltura);
</script>
</main>
<?php
gerarFooter('LEVORATECH')
?>
</body>

</html>
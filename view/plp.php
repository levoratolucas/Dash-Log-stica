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
</div>
<div class="menu">
    <div class="dados_full">
        <div class="dados95">
            <iframe style="width: 100%; height:100%;" src="https://catalogo.yoobe.co/suporte/levoratech/dados/dadosplpPags.php" frameborder="0"></iframe>
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
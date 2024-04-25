<?php
require '../view/layout/formPlp.php';
$lojas = [479, 442, 420, 527, 487, 530, 446, 509, 481, 529, 480, 489, 419, 471, 493, 469, 431, 484, 462, 521, 513, 461, 525, 511];
$lojas_str = implode(',', $lojas);
$sql_spree = "SELECT code FROM spree_stores WHERE id IN ($lojas_str) ORDER BY code";
$req2 = $db_pg->prepare($sql_spree);
$req2->execute();
$lojas_list = $req2->fetchAll();?>


<div id="tokenUser">
    <form method="post">
        <select name=loja>
            <option value=""> -- Selecione a Loja -- </option>
            <?php
            foreach ($lojas_list as $l) {
                echo '<option value="' . strtolower($l['code']) . '">' . strtolower($l['code']) . '</option>';
            }
            ?>


        </select>
        <p>
            <input type=email name=email placeholder="Email do usuario">
        <p>
            <input type="submit"  name="gerar" value="gerar" >
            <!-- <button type="submit" name="gerar" value="gerar">Gerar token</button> -->

    </form>
</div>
<?php

if (isset($_REQUEST["gerar"])) {
    $email = trim($_REQUEST["email"] ?? '');
    $loja = trim($_REQUEST["loja"] ?? '');

    if (empty($email)) {
        echo '<p style="font-color:red">Email invalido</p>';
    }
    if (empty($loja)) {
        echo '<p  style="font-color:red">Loja invalida</p>';
    }

    if (!empty($email) && !empty($loja)) {

        $token = md5($email . $loja . time());

        $sql_spree1 = "select id from spree_users where email = '$email' limit 1";
        $req21 = $db_pg->prepare($sql_spree1);
        $req21->execute();
        $uu = $req21->fetchAll();
        $i = 0;
        $url_loja_token = "https://" . $loja . ".yoobe.app/?token=" . $token;
        foreach ($uu as $u) {
            $i = 1;
            $upd2 = "update spree_users set auth_token='$token' where email = '$email' ";
            $req_u = $db_pg->prepare($upd2);
            $req_u->execute();
        }
        if ($i == 0) {
            echo '<p  style="font-color:red">usuario com este email nao encontrado</p>';
        } else {

            echo "<p>Link Para onboarding:<br> <b>" . $url_loja_token . "&redirect=/onboarding</b></p>";
            echo "<p>Link Para loja:<br> <b>" . $url_loja_token . "</b></p>";
            echo "<p>Link Para Pedidos:<br> <b>" . $url_loja_token . "&redirect=/my-orders</b></p>";
        }
    }
}
?>
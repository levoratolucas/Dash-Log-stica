
<div class="lateral">
    <h3>Lojas com adicionais</h3>    
    <?php $adicionais = [431,471,511,442,505];

    $nomeloja = queryArray($db_apisup, 'select code from spree_stores_on where store_id in('.implode(',',$adicionais,).')
', "code");   


    foreach($nomeloja as $i){
        echo '<a href="financeiro'.$i.'.php" >'.name_Format($i).'</a>';
    }    
    ?>


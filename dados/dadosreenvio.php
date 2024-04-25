<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['busca'])) {
        $busca = $_POST['busca'];
        echo  $busca;
    }
}else{
    $busca ='';
}

function displayTableOC($dbHandle_pg, $query, $columns, $coluna, $selectValues, $selectTexts)
{
    
?>
    
    <style>
        textarea {
            width: 100%;
            padding: 10px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        
    </style>
<?php
    $result = $dbHandle_pg->query($query);
    $rowCount = $result->rowCount();

    echo "<div class='table'>";
    if ($rowCount > 0) {
        echo "<table>";
        echo "<tr class='tr'>";
        foreach (array_slice($columns, 0, -1) as $column) {
            echo "<th>{$column}</th>";
        }
        echo "<th>{$coluna}</th>";
        echo "<th>ATUALIZAR</th>";
        echo "</tr>
        </thead>";
        echo "<tbody>";

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            foreach (array_slice($row, 0, -2) as $value) {
                echo "<td>{$value}</td>";
            }
            echo "<td>
                    <form method='post'>";
            echo "<input type='hidden' name='id' value='{$row['id']}'>";
            echo "<select name='status_column'>";
            echo '<option value="' . $row['status'] . '">' . $selectTexts[($row['status'] - 1)] . '</option>';
            for ($i = 0; $i < count($selectValues); $i++) {
                echo "<option value='{$selectValues[$i]}'";
                if ($row['status'] == $selectValues[$i]) {
                    echo " selected";
                }
                echo ">{$selectTexts[$i]}</option>";
            }
            echo "</select>";
            echo "</td>";
            echo "<td >";
            echo "<br><textarea style='width: 200px;' name='obs' id='obs' cols='10' rows='2' oninput='autoResize(this)'>" . $row['obs'] . "</textarea></td>";
            echo "<td><button type='submit' name='submit'>Atualizar</button></form></td>";
            echo "</tr>";
        }
        echo "</tbody>";

        echo "</table></div>";
    } else {
        echo "<p>Nenhum resultado encontrado.</p>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    $conteudoInput = $_POST["obs"]; 
    $status = $_POST["status_column"];
    $conteudoPrimeiraColunalinha = $_POST["id"];
    $updateQuery = "UPDATE spree_reenvios SET obs = '{$conteudoInput}', status = '{$status}' WHERE id = '{$conteudoPrimeiraColunalinha}'";
    $statement = $db_apisup->prepare($updateQuery);
    $statement->execute();
}
$sql_spree = "SELECT ree.id id,plp.destinatario, ree.rastreio,
date_format(plp.data_criacao,'%d/%m/%y') ,date_format(ree.updated_at,'%d/%m/%y'), 
ree.status status,ree.obs obs
FROM `spree_reenvios` ree 
join tb_csv_plp plp on plp.objeto = ree.rastreio 
where ree.status <> 2 and (ree.rastreio like '%".$busca."%')
order by plp.data_criacao desc
";
$selectValues = array(1, 2, 3, 4, 5, 6); 
$selectTexts = array('SEM TRATAMENTO', 'ENVIADO/RETORNADO', 'AGUARDANDO RETORNO', 'VOLTAR ESTOQUE', 'FALAR GESTOR', 'DANIFICADO'); 
$columns = ['id', 'DESTINATARIo', 'RASTREIO', 'ENVIADO', 'ATUALIZADO ', 'STATUS', 'OBS'];

?>
<div class="reenvio">

    <div class="search2">
        <form id="searchForm2" method="post" action="">
            <input type="text" name="busca" placeholder="DESTINATARIO/PEDIDO/EMAIL">
        </form>
    </div>
    <?php 
displayTableOC($db_apisup, $sql_spree, $columns, 'obs', $selectValues, $selectTexts);
?>
</div>
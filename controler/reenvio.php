<?php
// Incluir o arquivo de configuração do banco de dados
include '../config/config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificando se o campo de busca foi enviado
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

    echo "<div class='painel'>";
    if ($rowCount > 0) {
        echo "<table>";
        echo "<tr class='tr'>";

        // Exibir todas as colunas, exceto a última
        foreach (array_slice($columns, 0, -1) as $column) {
            echo "<th>{$column}</th>";
        }

        // Adicionar coluna para o select e coluna para o input de texto e botão de atualização
        echo "<th>{$coluna}</th>";
        echo "<th>ATUALIZAR</th>";

        echo "</tr>
        </thead>";

        echo "<tbody>";

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";

            // Exibir todas as colunas, exceto a última
            foreach (array_slice($row, 0, -2) as $value) {
                echo "<td>{$value}</td>";
            }

            // Coluna final com o select e input de texto e botão de atualização
            echo "<td>
                    <form method='post'>"; // Formulário para atualizar
            echo "<input type='hidden' name='id' value='{$row['id']}'>"; // Campo oculto para enviar o ID

            // Select com opções para a coluna de status
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
            echo "<td>";
            // Textarea para a coluna de observações
            echo "<br><textarea name='obs' id='obs' cols='10' rows='2' oninput='autoResize(this)'>" . $row['obs'] . "</textarea></td>";

            // Botão de atualização
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

    $conteudoInput = $_POST["obs"]; // Recupera o conteúdo do textarea para a coluna de observações
    $status = $_POST["status_column"]; // Recupera o valor selecionado no select para a coluna de status
    $conteudoPrimeiraColunalinha = $_POST["id"];

    // Atualiza a coluna de observações e de status na tabela
    $updateQuery = "UPDATE spree_reenvios SET obs = '{$conteudoInput}', status = '{$status}' WHERE id = '{$conteudoPrimeiraColunalinha}'";
    $statement = $db_apisup->prepare($updateQuery);
    $statement->execute();
    echo "Query: $updateQuery";
}
?>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }


    
    h2 {
        margin-top: 0;
        color: #333;
    }

    form {
        margin-top: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        color: #555;
    }

    input[type="text"],
    select {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button[type="submit"] {
        background-color: #4caf50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }
</style>
<link rel="stylesheet" href="../css/table.css">
<link rel="stylesheet" href="../css/footer.css">

<?php

$sql_spree = "SELECT ree.id id,plp.destinatario, ree.rastreio,
date_format(plp.data_criacao,'%d/%m/%y'),date_format(ree.updated_at,'%d/%m/%y'), 
ree.status status,ree.obs obs
FROM `spree_reenvios` ree 
join tb_csv_plp plp on plp.objeto = ree.rastreio 
where ree.status <> 2 and (ree.rastreio like '%".$busca."%')
order by plp.data_criacao desc
";
$selectValues = array(1, 2, 3, 4, 5, 6); // Valores correspondentes aos status
$selectTexts = array('SEM TRATAMENTO', 'ENVIADO/RETORNADO', 'AGUARDANDO RETORNO', 'VOLTAR ESTOQUE', 'FALAR GESTOR', 'DANIFICADO'); // Textos correspondentes aos status
$columns = ['id', 'DESTINATARII', 'RASTREIO', 'STATUS', 'DATA', 'update', 'obs'];

?>
<div class="search2">
        <form id="searchForm2" method="post" action="">
            <input type="text" name="busca" placeholder="DESTINATARIO/PEDIDO/EMAIL">
        </form>
    </div>
<?php 
displayTableOC($db_apisup, $sql_spree, $columns, 'obs', $selectValues, $selectTexts);
?>
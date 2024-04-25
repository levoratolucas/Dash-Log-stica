<style>
    .plptable {
        font-family: Arial, sans-serif;
        width: 100%;
        border-collapse: collapse;
    }

    .plptable th,
    .plptable td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #dddddd;
    }

    .plptable th {
        background-color: #3498db;
        /* Azul para o cabeçalho */
        color: #ffffff;
        /* Texto branco para melhor contraste */
    }

    .plptable tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .plptable tbody tr:hover {
        background-color: #f2f2f2;
    }

    /* Estilo para a paginação */
    .paginas {
        margin-top: 20px;
        text-align: center;
    }

    .paginas a {
        display: inline-block;
        padding: 8px 16px;
        margin: 0 4px;
        text-decoration: none;
        color: #ffffff;
        /* Texto branco */
        border: 1px solid #3498db;
        /* Borda azul */
        border-radius: 4px;
        background-color: #3498db;
        /* Azul */
        transition: background-color 0.3s ease;
    }

    .paginas a:hover {
        background-color: #4CAF50;
        /* Cor de destaque ao passar o mouse */
    }

    .paginas .current-page {
        background-color: #4CAF50;
        /* Cor de destaque para a página atual */
        color: white;
    }
</style>
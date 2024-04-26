<!-- biblioteca.php  -->

<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<style>
    /* Estilo para a tabela */
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
        background-color: black;
        position: sticky;
        color: #ffffff;
        top: 0;
    }

    .plptable tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .suporte {
        width: 100%;
        text-align: center;
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
        border: 1px solid black;
        /* Borda azul */
        border-radius: 4px;
        background-color: black;
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
<style>
    /* #tokenUser {

        text-align: center;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    #tokenUser form {
        display: flex;
        flex-direction: column;
    }

    #tokenUser select,
    #tokenUser input[type="email"],
    #tokenUser button[type="submit"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        text-align: center;
    }

    #tokenUser select {
        height: 40px;
    }

    #tokenUser input[type="email"] {
        height: 40px;
    }

    #tokenUser button[type="submit"] {
        background-color: #461a60;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    #tokenUser button[type="submit"]:hover {
        background-color: #291435;
    }

    #tokenUser p {
        margin: 5px 0;
        font-size: 14px;
    }

    #resultTokenUser {
        text-align: center;

        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    #resultTokenUser p {
        margin: 10px 0;
        font-size: 16px;
    }

    #resultTokenUser p b {
        color: black;
    }

    #resultTokenUser p.error {
        color: red;
    } */

    * {
        padding: 0;
        margin: 0;
        font-family: 'Poppins', sans-serif;
    }

    h3 {
        padding: 10px;
        font-weight: 700;
        color: #000;
    }




    body {
        width: 100vw;
    }

    main {
        width: 100%;
        display: flex;
    }

    .lateral {
        display: block;
        width: 150px;
        min-height: 500px;
        background-color: #E886C5;

        color: black;
    }

    .menu {
        width: calc(100% - 150px);
        min-height: 800px;
        background-color: #E886C5;
        
    }

    .dados_full {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        justify-content: space-around;
        text-align: center;
        background-color: #E886C5;
    }

    .dados {
        width: 47%;
        margin-bottom: 5px;
        overflow: auto;
    }


    /* suporte  */
    .dados95 {
        width: 96.5%;
        margin-bottom: 5px;
        overflow: auto;
    }

    .dados60 {
        width: 60%;
        margin-bottom: 5px;
        overflow: auto;
    }

    .dados30 {
        width: 30%;
        margin-bottom: 5px;
        /* background-color: #fff; */
        overflow: auto;
    }

    .lateral a {
        display: block;
        padding: 10px;
        text-decoration: none;
        transition: background-color 0.3s, color 0.3s;
        /* border-bottom: 1px solid #ccc; */
        color: black;
    }

    .lateral a:hover {
        background-color: #f0f0f0;
        color: #000;
    }



    /* Estilo para a tabela */
    .table {
        width: calc(100% - 10px);
        overflow: auto;
        border-collapse: collapse;
    }

    .table th {
        background-color: black;
        position: sticky;
        color: #ffffff;
        top: 0;
        padding: 8px;
        position: sticky;
        text-align: left;
        top: -8px;
        border: 1px solid black;
        /* Borda azul */
        height: 20px;
    }
    header{
        position: sticky;
        top: 0;
        z-index: 3;
    }
    .table td {
        padding: 8px;
        border: 1px solid #ddd;
    }

    .table tr {
        background-color: white;
    }

    .table tr:hover {
        background-color: #f5f5f5;
    }

    /* Estilo para a paginação */
    .paginas {
        margin-top: 20px;
        text-align: center;
    }

    .iframeEnvios {
        width: 100%;
        min-height: 600px;
        margin-top: 5px;
        /* padding: 5px; */
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 1);
    }


    .paginas a {
        display: inline-block;
        padding: 8px 16px;
        margin: 0 4px;
        text-decoration: none;
        color: #ffffff;
        /* Texto branco */
        border: 1px solid black;
        /* Borda azul */
        border-radius: 4px;
        background-color: black;
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


    @media screen and (max-width: 800px) {
        .lateral {
            display: flex;
            flex-wrap: wrap;
            /* height: 100px; */
            min-height: 10px;
            width: 100%;
        }

        .menu {
            width: 100%;
        }

        .lateral a {
            width: 25%;
            margin: auto;
            height: auto;
        }

        main {
            display: block;
        }

        .dados {
            width: 90%;
            margin: auto;
            margin-top: 5px;
        }

        .dados95,
        .dados30,
        .dados60 {
            width: 90%;
            margin: auto;
            margin-top: 5px;
        }

        .form {
            display: flex;
        }
    }
</style>

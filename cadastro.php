<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <style type="text/css"> 
        body{
            font-family: Arial, sans-serif;
            background-color: rgb(32, 33, 36);
            justify-content: center; 
            align-items: center;
            margin: 0;
        }
        .centro {
            width: 300px; 
             
            background-color: white; 
            margin: 0 auto; 
            text-align: left;
            padding: 20px; 
            border: 1px solid #ccc; 
            border-radius: 2%;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: rgb(32, 33, 36);;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: rgb(28, 29, 32);;
        }
        a{
            color: white;
        }
    </style>
</head>
<body>
    <a href="index.html">Voltar à página inicial</a>
    <div class="centro">
        <h2>Cadastro de pacientes</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="nome">Nome Completo:</label>
            <input type="text" id="nome" name="nome" required><br><br>

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required><br><br>

            <label for="rg">RG:</label>
            <input type="text" id="rg" name="rg" required><br><br>

            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade" required><br><br>

            <label for="convenio">Convênio:</label>
            <select id="convenio" name="convenio">
                <option value="nenhum">Nenhum</option>
                <option value="unimed">Unimed</option>
                <option value="freigalvao">Frei Galvão</option>
                <option value="hapvida">HapVida</option>
                <option value="bradesco">Bradesco Saúde</option>
            </select><br><br>

            <label  for="foto">Foto:</label>
            <input type="file" id="foto" name="foto"><br><br>

            <input type="submit" value="Enviar">
        </form>
    </div>
</body>
</html>

<?php
    include("funcoes.php");

    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        $nome = $_POST["nome"];
        $cpf = $_POST["cpf"];
        $rg = $_POST["rg"];
        $idade = $_POST["idade"];
        $convenio = $_POST["convenio"];
        $foto = $_FILES["foto"];

        if ((trim($cpf) == "") || (trim($nome) == "")) {
            echo "<span id='warning'>RA e nome são obrigatórios!</span>";
        } else {
            cadastrar($nome, $cpf, $rg, $idade, $convenio, $foto);
        }
    }
?>
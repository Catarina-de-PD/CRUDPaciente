<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Paciente</title>
    <style>
    body {
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
        background-color: rgb(32, 33, 36);
        ;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 3px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: rgb(28, 29, 32);
        ;
    }

    a {
        color: white;
    }
</style>
</head>
<body>
<a href="index.html">Voltar à página principal</a>
    <div class="centro" enctype="multipart/form-data">
    <h2>Exclusão de pacientes</h2>
    <?php
        include("funcoes.php");

        if (!isset($_POST["cpf"])) {
            echo "Selecione o paciente a ser excluído!";
        } else {
            $cpf = $_POST["cpf"];
            excluir($cpf);
        }
    ?>
    </div>
</body>
</html>


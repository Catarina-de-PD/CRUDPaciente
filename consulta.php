<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de pacientes</title>
    <style type="text/css">
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

        .centro2 {
            width: fit-content;
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
    <h2>Consulta de pacientes</h2>
        <form method="post">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf"><br><br>
            <input type="submit" value="Consultar">
        </form>
    </div>
    <br>
    <div class="centro2" enctype="multipart/form-data">
        <?php
        include("funcoes.php");
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $cpf = $_POST["cpf"];
            consulta($cpf);
        }
        ?>
    </div>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edição de Pacientes</title>
</head>
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
    }

    a {
        color: white;
    }
</style>

<body>
    <a href="index.html">Voltar à página inicial</a> | <a href="consulta.php">Voltar à página de consulta</a>
    <div class="centro">
        <h2>Edição de pacientes</h2>
        <?php

include("funcoes.php");

if (!isset($_POST["cpf"])) {
    echo "Selecione o paciente a ser editado!";
} else {
    $cpf = $_POST["cpf"];

    try {
        $stmt = buscarEdicao($cpf);

        $unimed = "";
        $freigalvao = "";
        $hapvida = "";
        $bradescosaude = "";

        while ($row = $stmt->fetch()) {
            $foto = $row['foto'];
            if ($row['convenio'] == "unimed") {
                $unimed = "selected";
            } else if ($row['convenio'] == "frei galvão") {
                $freigalvao = "selected";
            } else if ($row['convenio'] == "hapvida") {
                $hapvida = "selected";
            } else if ($row['convenio'] == "bradesco saúde") {
                $bradescoSaude = "selected";
            }

            echo "<form method='post' enctype='multipart/form-data'>\n
            CPF:<br>\n
            <input type='text' size='10' name='cpf' value='$row[cpf]' readonly><br><br>\n
            Nome:<br>\n
            <input type='text' size='30' name='nome' value='$row[nome]'><br><br>\n
            Idade:<br>\n
            <input type='text' size='30' name='idade' value='$row[idade]'><br><br>\n
            Foto:<br>";

            if ($foto=="") {
              echo "-<br><br>";
            } else {
              echo  "<img src='data:image;base64,". base64_encode($foto)."' width='50px' height='50px'><br><br>";
            }

            echo "
             <input type='file' name='foto'><br><br>

            Convenio:<br>
            <select name='convenio'
                <option></option>
                 <option value='Unimed' $unimed>Unimed</option>
                <option value='FreiGalvao' $freigalvao>FreiGalvao</option>
                <option value='HapVida' $hapvida>HapVida</option>
                <option value='BradescoSaude' $bradescosaude>Bradesco Saúde</option>
             </select><br><br>
             <input type='submit' name='salvar' value='Salvar Alterações'>
            </form>";

            if(isset($_POST['salvar'])){
                $cpf = $_POST['cpf'];
                $nome = $_POST['nome'];
                $idade = $_POST['idade'];
                $convenio = $_POST['convenio'];
                $foto = $_FILES['foto'];
                editar($cpf, $nome, $idade, $convenio, $foto);

            }        

            
        }

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

}

?>
    </div>
</body>
</html>


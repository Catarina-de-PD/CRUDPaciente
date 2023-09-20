<?php
function conectarBD()
{
  try {
    $db =  'mysql:host=143.106.241.3;dbname=cl201171;charset=utf8';
    $user = 'cl201171';
    $passwd = 'cl*27092005';
    $pdo = new PDO($db, $user, $passwd);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
  } catch (PDOException $e) {
    $output = 'Impossível conectar BD : ' . $e . '<br>';
    echo $output;
  }
}

function verificarCadastro($cpf, $pdo)
{
  $stmt = $pdo->prepare("select * from paciente where cpf = :cpf");
  $stmt->bindParam(':cpf', $cpf);
  $stmt->execute();

  $rows = $stmt->rowCount();
  return $rows;
}

function cadastrar($nome, $cpf, $rg, $idade, $convenio, $foto)
{
  try {
    $pdo = conectarBD();
    $rows = verificarCadastro($cpf, $pdo);

    if ($rows <= 0) {
      if ($foto['name'] == "") {
        $fotobinario = null;
      } else {
        $fotobinario = file_get_contents($foto['tmp_name']);
      }

      $stmt = $pdo->prepare("insert into paciente (nome, cpf, rg, idade, convenio, foto) values(:nome, :cpf, :rg, :idade, :convenio, :foto)");
      $stmt->bindParam(':nome', $nome);
      $stmt->bindParam(':cpf', $cpf);
      $stmt->bindParam(':rg', $rg);
      $stmt->bindParam(':idade', $idade);
      $stmt->bindParam(':convenio', $convenio);
      $stmt->bindParam(':foto', $fotobinario);
      $stmt->execute();
      echo "<span id='success'>Aluno Cadastrado com sucesso!</span>";
    } else {
      echo "<span id='error'>CPF já cadastrado!</span>";
    }
  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }

  $pdo = null;
}

function consulta($cpf)
{
  $pdo = conectarBD();

  if (isset($_POST["cpf"]) && ($_POST["cpf"] != "")) {
    $cpf = $_POST["cpf"];
    $stmt = $pdo->prepare("select * from paciente 
            where cpf= :cpf order by nome");
    $stmt->bindParam(':cpf', $cpf);
  } else {
    $stmt = $pdo->prepare("select * from paciente 
            order by nome, convenio");
  }

  try {
    //buscando dados
    $stmt->execute();

    echo "<form method='post'enctype='multipart/form-data'><table border='1px'>";
    echo "<tr><th></th><th>CPF</th><th>Nome</th><th>RG</th><th>Idade</th><th>Convenio</th><th>Foto</th></tr>";

    while ($row = $stmt->fetch()) {
      echo "<tr>";
      echo "<td><input type='radio' name='cpf' value='" . $row['cpf'] . "'>";
      echo "<td>" . $row['cpf'] . "</td>";
      echo "<td>" . $row['nome'] . "</td>";
      echo "<td>" . $row['rg'] . "</td>";
      echo "<td>" . $row['idade'] . "</td>";
      echo "<td>" . $row['convenio'] . "</td>";

      if ($row["foto"] == null) {
        echo "<td align='center'>-</td>";
      } else {
        echo "<td align='center'><img src='data:image;base64," . base64_encode($row["foto"]) . "' width='50px' height='50px'></td>";
      }
      echo "</tr>";
    }
    echo "</table><br> 
      <button type='submit' formaction='excluir.php'>Excluir</button>
      <button type='submit' formaction='editar.php'>Editar</button>
    </form>";


  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }

  $pdo = null;
}

function buscarEdicao($cpf)
{
    $pdo = conectarBD();
    $stmt = $pdo->prepare('select * from paciente where cpf = :cpf');
    $stmt->bindParam(':cpf', $cpf);
    $stmt->execute();
    return $stmt;
}

function excluir($cpf)
{
  try {
    $pdo = conectarBD();
    $stmt = $pdo->prepare('DELETE FROM paciente WHERE cpf = :cpf');
    $stmt->bindParam(':cpf', $cpf);
    $stmt->execute();

    echo "Paciente excluído com sucesso!";
  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }
}

function editar($cpf, $nome, $idade, $convenio, $foto){
  $foto = $_FILES['foto'];
  $nomeFoto = $foto['name'];
  $tipoFoto = $foto['type'];
  $tamanhoFoto = $foto['size'];
  $pdo = conectarBD();
  if ($nomeFoto != "") {
      $fotoBinario = file_get_contents($foto['tmp_name']);
      $stmt = $pdo->prepare('UPDATE paciente SET nome = :nome, convenio = :convenio, idade = :idade, foto = :foto  WHERE cpf = :cpf');
      $stmt->bindParam(':nome', $nome);
      $stmt->bindParam(':convenio', $convenio);
      $stmt->bindParam(':cpf', $cpf);
      $stmt->bindParam(':idade', $idade);
      $stmt->bindParam(':foto', $fotoBinario);
  } else {
      $stmt = $pdo->prepare('UPDATE paciente SET nome = :nome, convenio = :convenio, idade = :idade WHERE cpf = :cpf');
      $stmt->bindParam(':nome', $nome);
      $stmt->bindParam(':convenio', $convenio);
      $stmt->bindParam(':cpf', $cpf);
      $stmt->bindParam(':idade', $idade);
  }
  try {
      $stmt->execute();
      echo "Os dados do paciente foram alterados com sucesso!";
  } catch (PDOException $e) {
      echo 'Error: ' . $e->getMessage();
  }
  $pdo = null;
}
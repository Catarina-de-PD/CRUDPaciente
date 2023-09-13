<?php
     function conectarBD() {
        try {         
            $db =  'mysql:host=143.106.241.3;dbname=cl201171;charset=utf8';
            $user = 'cl201171';
            $passwd = 'cl*27092005';
            $pdo = new PDO($db, $user, $passwd);
            
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
        } catch (PDOException $e) {
            $output = 'Impossível conectar BD : ' . $e . '<br>';
            echo $output;
        }    
    }

    function verificarCadastro($cpf, $pdo) {
        $stmt = $pdo->prepare("select * from paciente where cpf = :cpf");
        $stmt->bindParam(':cpf', $cpf);
        $stmt->execute();

        $rows = $stmt->rowCount();
        return $rows;
    }

    function cadastrar($nome, $cpf, $rg, $idade, $convenio, $foto){
        try {
            $pdo = conectarBD();
            $rows = verificarCadastro($cpf, $pdo);

            if ($rows <= 0) {
                if($foto['name'] == ""){
                    $fotobinario = null;
                }else{
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
                echo "<span id='sucess'>Aluno Cadastrado!</span>";
            } else {
                echo "<span id='error'>Ra já existente!</span>";
            }
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

?>
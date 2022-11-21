<?php
require_once 'person-class.php';
$pessoa = new Person("agenda", "localhost", "root", "");
?>

<!DOCTYPE html5>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <header>
            <h1>Agenda</h1>
        </header>

        <?php 
            if(isset($_POST['Nome'])) {
                $nome = addslashes($_POST['Nome']);
                $sexo = addslashes($_POST['Sexo']);
                $nasc = addslashes($_POST['Data De Nascimento']);
                $telefone = addslashes($_POST['Telefone']);
                $email = addslashes($_POST['Email']);

                if(!empty($nome) && !empty($sexo) && !empty($nasc) && !empty($telefone) && !empty($email)) {
                    if(!$pessoa->CadastrarPessoa($nome, $sexo, $nasc, $telefone, $email)) {
                        echo "Email já cadastrado não pode ser cadastrado novamente!";
                    }
                } 
                else {
                    echo "Volte e Preencha todos os campos!";
                }
            }
        ?>
        <section id=forms>
            <form method="POST">
                <h2>Cadastro</h2>
                     <label for="">Nome: </label>
                    <input type="text" name="nome" id="nome">
                    <label for="">Email: </label>
                    <input type="text" name="email" id="email">
                    <label for="">Sexo: (M, F, N)</label>
                    <input type="text" name="email" id="email">
                    <label for="">Data de Nascimento:</label>
                    <input type="date" name="Data" id="Data">
                    <label for="">(DDD) N° de Telefone:</label>
                    <input type="number" name="numb" id="numb">
                    <input type="submit" value="Cadastrar">
            </form>
        </section>
        <section id = tabela>
            <table>
                <tr id=titulo>
                    <td>Nome</td>
                    <td>sexo</td>
                    <td>data de nascimento</td>
                    <td>telefone</td>
                    <td colspan="2">email</td>
                </tr>
            <?php 
                $dados = $pessoa->BuscarDados();
                if(count($dados) > 0) {
                    for($i = 0; $i < count($dados); $i++) {
                        echo "<tr>";
                        foreach($dados[$i] as $k => $v) {
                            if($k != "id_pessoa") {
                                echo "<td>".$v."</td>";
                            }
                        }
                        ?>
                            <td><a href="">Editar</a><a href="">Excluir</a></td>
                        <?php 
                        echo "</tr>";
                    }
                }
                else {
                    echo "Ainda não há pessoas cadastradas!";
                }
            ?>
            </table>
        </section>    
    </body>
</html>

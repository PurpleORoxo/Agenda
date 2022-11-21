<?php

Class Person 
{

    private $pdo;

    public function __construct($dbname, $host, $user, $senha)
    {   
        try {
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $user, $senha);
        }

        catch (PDOException $e) {
            echo "Problema com o banco de dados ".$e->getMessage();
            exit();
        }

        catch (Exception $e) {

            echo "Erro genérico: ".$e->getMessage();
            exit();
        }
    }

    public function BuscarDados() {

        $res = array();
        $cmd = $this->pdo->query("SELECT * FROM tb_pessoa ORDER BY ds_nome");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    }

    public function CadastrarPessoa($ds_nome, $cd_sexo, $dt_nasc, $nr_telefone, $ds_email) {
        $cmd = $this->pdo->prepare("SELECT id_pessoa FROM tb_pessoa WHERE ds_email = :e");
        $cmd->bindValue(":e", $ds_email);
        $cmd->execute();
        if($cmd->rowCount() > 0) {
            return false;
        }
        else {
            $cmd = $this->pdo->prepare("INSERT INTO tb_pessoa (ds_nome, cd_sexo, dt_nasc, nr_telefone, ds_email) VALUES (:n, :s, :na, :t, :e)");

            $cmd->bindValue(":n", $ds_nome);
            $cmd->bindValue(":s", $cd_sexo);
            $cmd->bindValue(":na", $dt_nasc);
            $cmd->bindValue(":t", $nr_telefone);
            $cmd->bindValue(":e", $ds_email);

            $cmd->execute();
            return true;
        }
    }

    public function ExcluirPessoa($id) {
        $cmd = $this->pdo->prepare("DELETE FROM tb_pessoa WHERE id_pessoa = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }
}
?> 

<?php
    Class Pessoa {
        private $pdo;
        // conexão com banco de dados
        public function __construct($dbname, $host, $user, $senha) {
            try {
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
            }
            catch(PDOException $e) {
                echo "Erro com Banco de Dados: ".$e->getMessage();
                exit();
            }
            catch(Exception $e) {
                echo "Erro generico: ".$e->getMessage();
                exit();
            }
        }
        // FUNÇÃO PARA BUSCAR DADOS E COLOCAR NO CANTO DIREITO
        public function buscarDados() {
            $res = array();
            $cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }
        // funcao de cadastrar pessoas mp banco de dados
        public function cadastrarPessoa($nome, $telefone, $email) {
            // antes de cadastrar verificar se ja possui um email cadastrado
            $cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
            $cmd->bindValue(":e",$email);
            $cmd->execute();
            if($cmd->rowCount() > 0) // email ja existe no banco de dados
            {
                return false;
            }
            else // nao foi encontrado o emaail
            {
                $cmd = $this->pdo->prepare("INSERT INTO pessoa(nome, telefone, email) VALUES (:n, :t, :e)");
                $cmd->bindValue(":n",$nome);
                $cmd->bindValue(":t",$telefone);
                $cmd->bindValue(":e",$email);
                $cmd->execute();
                return true;
            }
        }
        public function excluirPessoa($id) {
            $cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
            $cmd->bindValue(":id",$id);
            $cmd->execute();
        }
        // buscar dados de uma pessoa
        public function buscarDadosPessoa($id) {
            $res = array();
            $cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
            $cmd->bindValue(":id",$id);
            $cmd->execute();
            $res = $cmd->fetch(PDO::FETCH_ASSOC);
            return $res;
        }
        // atualizar dados no banco de dados
        public function atualizarDados() {
            
        }
    }
?>
<?php

/**
 * Classe de conexão ao banco de dados usando PDO no padrão Singleton.
 * Modo de Usar:
 * require_once './Database.class.php';
 * $db = Database::conexao();
 * E agora use as funções do PDO (prepare, query, exec) em cima da variável $db.
 */
class Database
{
    # Variável que guarda a conexão PDO.
    protected static $db;

    # Private construct - garante que a classe só possa ser instanciada internamente.
    function __construct()
    {
        # Informações sobre o banco de dados:
        $db_host = "localhost";
        $db_nome = "cadastro_de_pessoas";
        $db_usuario = "root";
        $db_senha = "";
        $db_driver = "mysql";

        # Informações sobre o sistema:
        $sistema_titulo = "Nome do Sistema";
        $sistema_email = "alguem@gmail.com";

        try {
            # Atribui o objeto PDO à variável $db.
            self::$db = new PDO("$db_driver:host=$db_host; dbname=$db_nome", $db_usuario, $db_senha);
            # Garante que o PDO lance exceções durante erros.
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            # Garante que os dados sejam armazenados com codificação UFT-8.
            self::$db->exec('SET NAMES utf8');
        } catch (PDOException $e) {
            # Envia um e-mail para o e-mail oficial do sistema, em caso de erro de conexão.
            mail($sistema_email, "PDOException em $sistema_titulo", $e->getMessage());
            # Então não carrega nada mais da página.
            die("Connection Error: " . $e->getMessage());
        }
    }

    # Método estático - acessível sem instanciação.
    public static function conexao()
    {
        # Garante uma única instância. Se não existe uma conexão, criamos uma nova.
        if (!self::$db) {
            new Database();
        }

        # Retorna a conexão.
        return self::$db;
    }
}

class Crud
{

    private $conn;

    function __construct()
    {
        $this->pdo = new Database();
    }

    function insertCadastro($fields)
    {
        try {
            $insert = $this->pdo::conexao()->prepare('INSERT INTO cadastro(tipo_de_pessoa, nome_fantasia, cpf_cnpj, razao, endereco, numero, complemento, 
                                                                           cep, municipio, uf, e_mail, telefone, celular, cliente, fornecedor, funcionario) 
                                                                           VALUES(:TIPO_DE_PESSOA, :NOME_FANTASIA, :CPF_CNPJ, :RAZAO, :ENDERECO, :NUMERO, 
                                                                           :COMPLEMENTO, :CEP, :MUNICIPIO, :UF, :E_MAIL, :TELEFONE, :CELULAR, :CLIENTE, 
                                                                           :FORNECEDOR, :FUNCIONARIO)');
            $insert->execute($fields);
            return json_encode(['Status' => true, 'msg' => 'Cadatro realizado com sucesso.']);
        } catch (PDOException $ex) {
            return json_encode(['Status' => false, 'msg' => $ex->message]);
        }
    }

    function updateCadastro($fields)
    {
        try {
            $update = $this->pdo::conexao()->prepare('UPDATE cadastro SET tipo_de_pessoa = :TIPO_DE_PESSOA, nome_fantasia = :NOME_FANTASIA,
                                                      cpf_cnpj= :CPF_CNPJ, razao= :RAZAO, endereco= :ENDERECO, numero= :NUMERO,
                                                     complemento= :COMPLEMENTO, cep= :CEP, municipio= :MUNICIPIO, uf= :UF, e_mail= :E_MAIL, 
                                                     telefone= :TELEFONE, celular= :CELULAR, cliente= :CLIENTE, fornecedor= :FORNECEDOR, 
                                                     funcionario= :FUNCIONARIO WHERE codigo = :CODIGO');
            $update->execute($fields);
            return json_encode(['Status' => true, 'msg' => 'Cadatro atualizado com sucesso.']);
        } catch (PDOException $ex) {
            return json_encode(['Status' => false, 'msg' => $ex->message]);
        }
    }

    function deleteCadastro($deleta)
    {
        try {
            $delete = $this->pdo::conexao()->prepare('DELETE FROM cadastro WHERE codigo = :ID');
            $delete->execute([':ID' => $deleta]);
            return json_encode(['Status' => true, 'msg' => 'Cadatro excluido com sucesso.']);
        } catch (\PDOException $ex) {
            return json_encode(['Status' => false, 'msg' => $ex->message]);
        }
    }

    function consuCadastro($search = null, $edit = null)
    {
            if (!empty($edit) && $edit){
                $select = $this->pdo::conexao()->prepare('SELECT * FROM cadastro WHERE codigo = :ID');  
                $select->execute([':ID'=> $search]); 
            }elseif(!empty($search)){
                $select = $this->pdo::conexao()->prepare('SELECT * FROM cadastro WHERE nome_fantasia LIKE :TXT OR cpf_cnpj LIKE :TXT OR tipo_de_pessoa LIKE :TXT');  
                $select->execute([':TXT'=> '%' . $search . '%']); 
            }else{
                $select = $this->pdo::conexao()->query('SELECT * FROM cadastro');
            }
            return json_encode(['Status' => true, 'dados' => $select->fetchAll(PDO::FETCH_ASSOC)]);
        
    }
}

$crud = new Crud();

if (!empty($_POST['nome']) && empty($_POST['codigo'])){
    $cadastra = [
        ':TIPO_DE_PESSOA' => $_POST['pessoa'],
        ':NOME_FANTASIA'  => $_POST['nome'],
        ':CPF_CNPJ'       => $_POST['cpf_cnpj'],
        ':RAZAO'          => $_POST['razao'],
        ':ENDERECO'       => $_POST['endereco'],
        ':NUMERO'         => $_POST['numero'] ,
        ':COMPLEMENTO'    => $_POST['complemento'],
        ':CEP'            => $_POST['cep'],
        ':MUNICIPIO'      => $_POST['municipio'],
        ':UF'             => $_POST['uf'],
        ':E_MAIL'         => $_POST['e_mail'],
        ':TELEFONE'       => $_POST['tel'],
        ':CELULAR'        => $_POST['cel'],
        ':CLIENTE'        => !empty($_POST['cliente']) ? $_POST['cliente'] : false,
        ':FORNECEDOR'     => !empty($_POST['fornecedor']) ? $_POST['fornecedor'] : false,
        ':FUNCIONARIO'    => !empty($_POST['funcionario']) ? $_POST['funcionario'] : false
    ];

    if (empty($_POST['cliente']) && empty($_POST['fornecedor']) && empty($_POST['funcionario'])){
        echo json_encode(['Status' => false, 'msg' => 'Necessario informar o tipo de cadastro.']);
    }else{
        echo $crud->insertCadastro($cadastra);
    }    
}

if(isset($_GET['search'])){
    echo $crud->consuCadastro($_GET['search'], !empty($_GET['edt']) ? $_GET['edt'] : null);
}

if(!empty($_GET['del'])){
    echo $crud->deleteCadastro($_GET['del']);
}

if (!empty($_POST['nome']) && !empty($_POST['codigo'])){
    $cadastra = [
        ':CODIGO'         => $_POST['codigo'],
        ':TIPO_DE_PESSOA' => $_POST['pessoa'],
        ':NOME_FANTASIA'  => $_POST['nome'],
        ':CPF_CNPJ'       => $_POST['cpf_cnpj'],
        ':RAZAO'          => $_POST['razao'],
        ':ENDERECO'       => $_POST['endereco'],
        ':NUMERO'         => $_POST['numero'] ,
        ':COMPLEMENTO'    => $_POST['complemento'],
        ':CEP'            => $_POST['cep'],
        ':MUNICIPIO'      => $_POST['municipio'],
        ':UF'             => $_POST['uf'],
        ':E_MAIL'         => $_POST['e_mail'],
        ':TELEFONE'       => $_POST['tel'],
        ':CELULAR'        => $_POST['cel'],
        ':CLIENTE'        => !empty($_POST['cliente']) ? $_POST['cliente'] : false,
        ':FORNECEDOR'     => !empty($_POST['fornecedor']) ? $_POST['fornecedor'] : false,
        ':FUNCIONARIO'    => !empty($_POST['funcionario']) ? $_POST['funcionario'] : false
    ];
    if (empty($_POST['cliente']) && empty($_POST['fornecedor']) && empty($_POST['funcionario'])){
        echo json_encode(['Status' => false, 'msg' => 'Necessario informar o tipo de cadastro.']);
    }else{
        echo $crud->updateCadastro($cadastra);
    }
}
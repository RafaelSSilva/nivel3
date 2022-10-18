<?php
if (!empty($_REQUEST['action'])) {
    $host     = '127.0.0.1';
    $user     = 'root';
    $password = '';
    $database = 'livro';
    $conn     = mysqli_connect($host, $user, $password, $database);

    if ($_REQUEST['action'] == 'edit') {
        $id     = (int) $_GET['id'];
        $result = mysqli_query($conn, "SELECT id, nome, endereco, bairro, telefone, email, id_cidade FROM pessoa WHERE id = '{$id}'");
        $pessoa = mysqli_fetch_assoc($result);       
    } else if ($_REQUEST['action'] == 'save') {
        $pessoa = $_POST;
        
        if (empty($pessoa['id'])) {
            $result = mysqli_query($conn, 'SELECT MAX(id) as next FROM pessoa');
            $next   = (int) mysqli_fetch_assoc($result)['next'] + 1;
            $result = mysqli_query($conn, "INSERT INTO pessoa (id, nome, endereco, bairro, telefone, email, id_cidade) VALUE ('{$next}', '{$pessoa['nome']}', '{$pessoa['endereco']}', '{$pessoa['bairro']}', '{$pessoa['telefone']}', '{$pessoa['email']}', '{$pessoa['id_cidade']}')");                  
        } else {
            $result = mysqli_query($conn, "UPDATE pessoa SET nome = '{$pessoa['nome']}', endereco = '{$pessoa['endereco']}', bairro = '{$pessoa['bairro']}', telefone = '{$pessoa['telefone']}', email = '{$pessoa['email']}', id_cidade = '{$pessoa['id_cidade']}' WHERE id = '{$pessoa['id']}'");
        }
        
        print ($result) ? 'Registro salvo com sucesso.' : $result;
    }

    mysqli_close($conn);
} else {
    $pessoa = [];
    $pessoa['id'] = $pessoa['nome'] = $pessoa['endereco'] = $pessoa['bairro'] = $pessoa['telefone'] = $pessoa['email'] = $pessoa['id_cidade'] = ''; 
}

require_once 'lista_combo_cidades.php';
$form = file_get_contents('html/form.html');
$form = str_replace(['{id}', '{nome}', '{endereco}', '{bairro}', '{telefone}', '{email}'], $pessoa, $form);
$form = str_replace('{cidades}', lista_combo_cidades($pessoa['id_cidade']), $form);
print $form;


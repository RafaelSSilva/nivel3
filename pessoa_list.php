<?php
$host     = '127.0.0.1';
$user     = 'root';
$password = '';
$database = 'livro';

$conn   = mysqli_connect($host, $user, $password, $database);

if (!empty($_GET['action']) AND $_GET['action'] == 'delete') {
    $id     = (int) $_GET['id'];
    $result = mysqli_query($conn, "DELETE FROM pessoa WHERE id = '{$id}'");
}

$result = mysqli_query($conn, "SELECT id, nome, endereco, bairro, telefone FROM pessoa ORDER BY id");

$items = '';
while ($row = mysqli_fetch_assoc($result)) {
    $item   = file_get_contents('html/item.html');
    $items .= str_replace(['{id}', '{nome}', '{endereco}', '{bairro}', '{telefone}'], $row, $item);
}

$list = file_get_contents('html/list.html');
$list = str_replace('{items}', $items, $list);
print $list;
<?php
    function lista_combo_cidades ($id = null) {
        $output   = '';
        $host     = '127.0.0.1';
        $user     = 'root';
        $password = '';
        $database = 'livro';

        $conn   = mysqli_connect($host, $user, $password, $database);
        $result = mysqli_query($conn, "SELECT id, nome FROM cidade");

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)){
                $check  = ($row['id'] == $id) ? 'selected=1' : '';
                $output .= "<option $check value='{$row['id']}'>{$row['nome']}</option>\n";
            }
        }

        mysqli_close($conn);
        
        return $output;
    }
<?php
session_start();
include_once('conn.php');

if(isset($_POST['submit'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuario WHERE nome='$nome' AND email='$email' AND senha='$senha'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $usuario = mysqli_fetch_assoc($result);
        
        $_SESSION['logado'] = true;
        $_SESSION['tipo'] = 'usuario';
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['endereco'] = $usuario['endereco'];
        $_SESSION['bairro'] = $usuario['bairro'];
        $_SESSION['id'] = $usuario['id'];
        
        header('Location: ../selecao.php?sucesso=Login realizado com sucesso!');
        exit();
    } else {
        header('Location: ../login.html?erro=Nome, email ou senha incorretos');
        exit();
    }
}
?>
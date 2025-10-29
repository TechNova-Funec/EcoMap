<?php
session_start();
include_once('conn.php');

if(isset($_POST['submit'])) {
    
    // Limpar e validar os dados de entrada
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = mysqli_real_escape_string($conn, $_POST['senha']);

    // Verificar se os campos estão preenchidos
    if(empty($nome) || empty($email) || empty($senha)) {
        header('Location: ../login.html?erro=Preencha todos os campos');
        exit();
    }

    $sql = "SELECT * FROM usuario WHERE nome='$nome' AND email='$email' AND senha='$senha'";
    $result = mysqli_query($conn, $sql);

    if($result && mysqli_num_rows($result) > 0){
        $usuario = mysqli_fetch_assoc($result);
        
        $_SESSION['logado'] = true;
        $_SESSION['tipo'] = 'usuario';
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['bairro'] = $usuario['bairro'];
        $_SESSION['id'] = $usuario['id'];
        
        header('Location: ../selecao.php?sucesso=Login realizado com sucesso!');
        exit();
    } else {
        // Debug: verificar o que está acontecendo
        error_log("Login falhou para: nome=$nome, email=$email");
        header('Location: ../login.html?erro=Nome, email ou senha incorretos');
        exit();
    }
} else {
    // Se não foi submetido via POST, redirecionar
    header('Location: ../login.html');
    exit();
}
?>
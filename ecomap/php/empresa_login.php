<?php
session_start();
include_once('conn.php');

if(isset($_POST['submit'])) {
    $cnpj = $_POST['cnpj'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM empresa WHERE cnpj='$cnpj' AND email='$email' AND senha='$senha'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $empresa = mysqli_fetch_assoc($result);
    
        $_SESSION['logado'] = true;
        $_SESSION['tipo'] = 'empresa';
        $_SESSION['nome'] = $empresa['nome'];
        $_SESSION['email'] = $empresa['email'];
        $_SESSION['endereco'] = $empresa['endereco'];
        $_SESSION['bairro'] = $empresa['bairro'];
        $_SESSION['id'] = $empresa['cnpj'];
        
        header('Location: ../empresa_dashboard.php?sucesso=Login realizado com sucesso!');
        exit();
    } else {
        header('Location: ../login.html?erro=CNPJ, email ou senha incorretos');
        exit();
    }
}
?>
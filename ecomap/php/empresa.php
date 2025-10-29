<?php
session_start();

if(isset($_POST['submit'])){
    include_once('conn.php');

    $cnpj = $_POST['cnpj'];
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    
    // Processar os resíduos selecionados
    $residuos = [];
    if(isset($_POST['residuos']) && is_array($_POST['residuos'])) {
        $residuos = $_POST['residuos'];
    }
    
    // Converter array em string separada por vírgulas
    $residuos_str = implode(', ', $residuos);
    
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha'];

    // Verificar se pelo menos um resíduo foi selecionado
    if(empty($residuos)) {
        header('Location: ../cadastro.html?erro=Selecione pelo menos um tipo de resíduo');
        exit();
    }

    // Verificar se CNPJ já existe
    $check_cnpj = mysqli_query($conn, "SELECT cnpj FROM empresa WHERE cnpj = '$cnpj'");
    if(mysqli_num_rows($check_cnpj) > 0) {
        header('Location: ../cadastro.html?erro=CNPJ já cadastrado');
        exit();
    }

    // Verificar se email já existe
    $check_email = mysqli_query($conn, "SELECT email FROM empresa WHERE email = '$email'");
    if(mysqli_num_rows($check_email) > 0) {
        header('Location: ../cadastro.html?erro=Email já cadastrado');
        exit();
    }

    $result = mysqli_query($conn, "INSERT INTO empresa (cnpj, nome, endereco, bairro, residuo, email, telefone, senha) VALUES ('$cnpj','$nome','$endereco','$bairro','$residuos_str','$email','$telefone','$senha')");

    if($result){
        // login automático após cadastro
        $_SESSION['logado'] = true;
        $_SESSION['tipo'] = 'empresa';
        $_SESSION['nome'] = $nome;
        $_SESSION['email'] = $email;
        $_SESSION['endereco'] = $endereco;
        $_SESSION['bairro'] = $bairro;
        $_SESSION['id'] = $cnpj;
        
        // manda pra página do dashboard da empresa com mensagem de sucesso
        header('Location: ../empresa_dashboard.php?sucesso=Cadastro realizado com sucesso!');
        exit();
    } else {
        header('Location: ../cadastro.html?erro=Erro ao cadastrar empresa. Tente novamente.');
        exit();
    }
}
?>
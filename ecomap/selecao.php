<?php
session_start();

// verificar se o usuário está logado como usuário
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo'] !== 'usuario') {
    header('Location: login.html');
    exit();
}

$nome = $_SESSION['nome'];
$email = $_SESSION['email'];
$bairro = $_SESSION['bairro'];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eco Map - Buscar Empresas</title>
  <link rel="stylesheet" href="css/selecao.css">
  <link rel="stylesheet" href="css/mensagens.css">
  <link rel="icon" href="img/logo_semfundo.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
  <header class="header">
    <div class="container header-container">
      <div class="logo">
        <img src="img/LOGOINDEX.png" alt="Logo Eco Map" class="logo-icon" />
        <h1>Eco Map</h1>
      </div>
      <nav class="nav">
        <ul>
          <li><a href="index.html#inicio">Início</a></li>
          <li><a href="index.html#servicos">Serviços</a></li>
          <li class="user-info">
            <div class="user-dropdown">
              <span class="user-name" id="userName"><?php echo explode(' ', $nome)[0]; ?></span>
              <div class="dropdown-content">
                <div class="user-details">
                  <p><strong id="displayName"><?php echo htmlspecialchars($nome); ?></strong></p>
                  <p id="displayEmail"><?php echo htmlspecialchars($email); ?></p>
                  <p id="displayBairro"><?php echo htmlspecialchars($bairro); ?></p>
                </div>
                <a href="php/logout.php" class="logout-btn">Sair</a>
              </div>
            </div>
          </li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="selecao-main">
    <div class="container">
      <div class="selecao-container">
        <h1 class="selecao-title">Encontre Empresas de Coleta no seu Bairro</h1>
        <div class="info-card">
          <div class="info-icon">
            <i class="fas fa-map-marker-alt"></i>
          </div>
          <div class="info-content">
            <h3>Seu bairro: <span class="bairro-destaque"><?php echo ucwords($bairro); ?></span></h3>
            <p>Clique no botão abaixo para visualizar as empresas cadastradas no seu bairro:</p>
            <a href="php/buscar_empresas.php" class="btn btn-primary btn-large">Ver pontos de coleta no meu bairro</a>
          </div>
        </div>
        
        <div class="features-grid">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-search"></i>
            </div>
            <h3>Busca Inteligente</h3>
            <p>Encontre empresas de coleta especializadas no seu bairro</p>
          </div>
          
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-phone-alt"></i>
            </div>
            <h3>Contato Direto</h3>
            <p>Entre em contato diretamente com as empresas via WhatsApp</p>
          </div>
          
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-info-circle"></i>
            </div>
            <h3>Informações Completas</h3>
            <p>Acesse endereço, telefone e tipos de resíduos aceitos</p>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="footer">
    <div class="container">
      <p>&copy; 2025 Eco Map — Conectando sustentabilidade e tecnologia.</p>
    </div>
  </footer>

  <a href="https://wa.me/5531920077134?text=Olá,%20gostaria%20de%20saber%20mais%20sobre%20o%20EcoMap"
     class="whatsapp-float" target="_blank">
    <i class="fab fa-whatsapp"></i>
  </a>

  <script src="js/mensagens.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const urlParams = new URLSearchParams(window.location.search);
      const sucesso = urlParams.get('sucesso');

      if (sucesso) {
        mensagemManager.sucesso(sucesso);
      }
    });
  </script>
</body>
</html>
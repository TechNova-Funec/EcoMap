<?php
session_start();

// verifica se o usuário está logado como empresa
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo'] !== 'empresa') {
    header('Location: login.html');
    exit();
}

$nome = $_SESSION['nome'];
$email = $_SESSION['email'];
$endereco = $_SESSION['endereco'];
$bairro = $_SESSION['bairro'];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eco Map - Dashboard Empresarial</title>
    <link rel="stylesheet" href="css/empresa_dashboard.css">
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
                                    <p id="displayEndereco"><?php echo htmlspecialchars($endereco); ?></p>
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

    <main class="dashboard-main">
        <div class="container">
            <div class="welcome-section">
                <h1>Bem-vinda ao Eco Map, <?php echo explode(' ', $nome)[0]; ?>!</h1>
                <p class="subtitle">Sua empresa agora faz parte da revolução sustentável</p>
            </div>

            <div class="dashboard-content">
                <div class="info-section">
                    <h2><i class="fas fa-bullseye"></i> Como o Eco Map Funciona</h2>
                    <div class="info-grid">
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3>Visibilidade</h3>
                            <p>Sua empresa agora aparece para milhares de usuários que buscam pontos de coleta de resíduos especiais</p>
                        </div>
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <h3>Conexões</h3>
                            <p>Conecte-se diretamente com pessoas e empresas que precisam descartar resíduos de forma responsável</p>
                        </div>
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h3>Crescimento</h3>
                            <p>Aumente seu fluxo de clientes e fortaleça sua marca como empresa sustentável</p>
                        </div>
                    </div>
                </div>

                <div class="impact-section">
                    <h2><i class="fas fa-leaf"></i> Impacto Socioambiental</h2>
                    <div class="impact-content">
                        <div class="impact-text">
                            <h3>Sua empresa está fazendo a diferença!</h3>
                            <p>Ao se cadastrar no Eco Map, você contribui para:</p>
                            <ul>
                                <li><i class="fas fa-check"></i> <strong>Redução da poluição</strong> - Resíduos sendo destinados corretamente</li>
                                <li><i class="fas fa-check"></i> <strong>Conscientização ambiental</strong> - Educação sobre descarte consciente</li>
                                <li><i class="fas fa-check"></i> <strong>Economia circular</strong> - Materiais sendo reaproveitados</li>
                                <li><i class="fas fa-check"></i> <strong>Comunidade mais limpa</strong> - Menos resíduos em aterros e ruas</li>
                                <li><i class="fas fa-check"></i> <strong>ODS da ONU</strong> - Contribuição com os Objetivos de Desenvolvimento Sustentável</li>
                            </ul>
                        </div>
                        <div class="impact-image">
                            <div class="placeholder-image">
                                <i class="fas fa-globe-americas"></i>
                                <p>Impacto Positivo</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="benefits-section">
                    <h2><i class="fas fa-rocket"></i> Benefícios para Sua Empresa</h2>
                    <div class="benefits-grid">
                        <div class="benefit-card">
                            <h3>Marketing Verde</h3>
                            <p>Destaque-se como empresa comprometida com a sustentabilidade</p>
                        </div>
                        <div class="benefit-card">
                            <h3>Novos Clientes</h3>
                            <p>Atraia clientes conscientes que valorizam práticas ambientais</p>
                        </div>
                        <div class="benefit-card">
                            <h3>Networking</h3>
                            <p>Conecte-se com outras empresas do setor de reciclagem</p>
                        </div>
                        <div class="benefit-card">
                            <h3>Credibilidade</h3>
                            <p>Fortaleça a confiança dos seus clientes e parceiros</p>
                        </div>
                    </div>
                </div>

                <div class="next-steps">
                    <h2><i class="fas fa-tasks"></i> Próximos Passos</h2>
                    <div class="steps">
                        <div class="step">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h3>Atualize suas informações</h3>
                                <p>Mantenha seus dados sempre atualizados para melhor visibilidade</p>
                            </div>
                        </div>
                        <div class="step">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h3>Compartilhe sua participação</h3>
                                <p>Divulgue nas redes sociais que sua empresa faz parte do Eco Map</p>
                            </div>
                        </div>
                        <div class="step">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h3>Prepare-se para contatos</h3>
                                <p>Esteja pronto para atender novos clientes interessados em descarte consciente</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-support">
                    <h2><i class="fas fa-comments"></i> Precisa de Ajuda?</h2>
                    <p>Nossa equipe está aqui para apoiar sua empresa nessa jornada sustentável</p>
                    <div class="contact-options">
                        <a href="https://wa.me/5531920077134?text=Olá,%20sou%20uma%20empresa%20cadastrada%20no%20Eco%20Map%20e%20gostaria%20de%20mais%20informações" 
                           class="btn btn-primary" target="_blank">
                            <i class="fab fa-whatsapp"></i> Suporte via WhatsApp
                        </a>
                        <a href="mailto:suporte@ecomap.com.br" class="btn btn-outline">
                            <i class="fas fa-envelope"></i> Email de Suporte
                        </a>
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
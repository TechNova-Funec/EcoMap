<?php
session_start();
include_once('conn.php');

// verifica se o usuário está logado e se é um tipo usuário
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo'] !== 'usuario') {
    header('Location: ../login.html');
    exit();
}

// obtém o bairro do usuário logado
$bairro_usuario = $_SESSION['bairro'];

// busca as empresas do banco de dados que estão no mesmo bairro do usuário
$sql = "SELECT cnpj, nome, endereco, bairro, residuo, telefone, email FROM empresa WHERE bairro = '$bairro_usuario'";
$result = mysqli_query($conn, $sql);
$empresas = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eco Map - Empresas no seu Bairro</title>
    <link rel="stylesheet" href="../css/empresas.css">
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="header">
        <div class="container header-container">
            <div class="logo">
                <img src="../img/logo.jpeg" alt="Logo Eco Map" class="logo-icon" />
                <h1>Eco Map</h1>
            </div>
            <nav class="nav">
                <ul>
                    <li><a href="../index.html#inicio">Início</a></li>
                    <li><a href="../index.html#servicos">Serviços</a></li>
                    <li class="user-info">
                        <div class="user-dropdown">
                            <span class="user-name" id="userName"><?php echo explode(' ', $_SESSION['nome'])[0]; ?></span>
                            <div class="dropdown-content">
                                <div class="user-details">
                                    <p><strong id="displayName"><?php echo $_SESSION['nome']; ?></strong></p>
                                    <p id="displayEmail"><?php echo $_SESSION['email']; ?></p>
                                    <p id="displayBairro"><?php echo $_SESSION['bairro']; ?></p>
                                </div>
                                <a href="logout.php" class="logout-btn">Sair</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="empresas-main">
        <div class="container">
            <div class="empresas-container">
                <h1 class="empresas-title">Empresas no seu bairro: <span class="bairro-destaque"><?php echo ucwords($bairro_usuario); ?></span></h1>
                
                <?php if (empty($empresas)): ?>
                    <div class="no-results">
                        <div class="no-results-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h2>Nenhuma empresa encontrada</h2>
                        <p>Não há empresas cadastradas no seu bairro no momento.</p>
                        <p>Que tal incentivar empresas da sua região a se cadastrarem no Eco Map?</p>
                        <a href="../selecao.php" class="btn btn-primary">Voltar</a>
                    </div>
                <?php else: ?>
                    <div class="empresas-layout">
                        <div class="empresas-list">
                            <h3>Empresas Disponíveis (<?php echo count($empresas); ?>)</h3>
                            <?php foreach ($empresas as $empresa): ?>
                                <div class="empresa-item" data-empresa='<?php echo json_encode($empresa); ?>'>
                                    <div class="empresa-avatar">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div class="empresa-info">
                                        <h4><?php echo htmlspecialchars($empresa['nome']); ?></h4>
                                        <div class="empresa-residuos">
                                            <?php 
                                            // Mostrar os primeiros resíduos como tags
                                            $residuos_array = explode(', ', $empresa['residuo']);
                                            $primeiros_residuos = array_slice($residuos_array, 0, 2);
                                            foreach ($primeiros_residuos as $residuo): 
                                            ?>
                                                <span class="residuo-tag"><?php echo htmlspecialchars($residuo); ?></span>
                                            <?php endforeach; ?>
                                            <?php if (count($residuos_array) > 2): ?>
                                                <span class="residuo-tag mais">+<?php echo count($residuos_array) - 2; ?> mais</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="empresa-details" id="empresaDetails">
                            <div class="details-placeholder">
                                <i class="fas fa-hand-pointer"></i>
                                <h3>Selecione uma empresa</h3>
                                <p>Clique em uma empresa da lista ao lado para ver os detalhes completos</p>
                            </div>
                        </div>
                    </div>

                    <div class="actions">
                        <a href="../selecao.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Voltar</a>
                    </div>
                <?php endif; ?>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const empresaItems = document.querySelectorAll('.empresa-item');
            const empresaDetails = document.getElementById('empresaDetails');

            empresaItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Remove active class from all items
                    empresaItems.forEach(i => i.classList.remove('active'));
                    
                    // Add active class to clicked item
                    this.classList.add('active');
                    
                    // Get empresa data
                    const empresaData = JSON.parse(this.getAttribute('data-empresa'));
                    
                    // Processar resíduos para exibição
                    const residuosArray = empresaData.residuo.split(', ');
                    const residuosHTML = residuosArray.map(residuo => 
                        `<span class="residuo-tag">${residuo}</span>`
                    ).join('');
                    
                    // Update details section
                    empresaDetails.innerHTML = `
                        <div class="empresa-card">
                            <div class="empresa-header">
                                <div class="empresa-avatar-large">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div class="empresa-title">
                                    <h2>${empresaData.nome}</h2>
                                    <div class="empresa-residuos-preview">
                                        ${residuosArray.slice(0, 3).map(residuo => 
                                            `<span class="residuo-tag small">${residuo}</span>`
                                        ).join('')}
                                        ${residuosArray.length > 3 ? 
                                            `<span class="residuo-tag small mais">+${residuosArray.length - 3} mais</span>` : 
                                            ''
                                        }
                                    </div>
                                </div>
                            </div>
                            <div class="empresa-info-detailed">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="info-content">
                                        <strong>Endereço:</strong>
                                        <p>${empresaData.endereco}</p>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-map"></i>
                                    </div>
                                    <div class="info-content">
                                        <strong>Bairro:</strong>
                                        <p>${empresaData.bairro}</p>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-recycle"></i>
                                    </div>
                                    <div class="info-content">
                                        <strong>Tipos de Resíduos:</strong>
                                        <div class="residuos-list">
                                            ${residuosHTML}
                                        </div>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-phone-alt"></i>
                                    </div>
                                    <div class="info-content">
                                        <strong>Telefone:</strong>
                                        <p>${empresaData.telefone}</p>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="info-content">
                                        <strong>Email:</strong>
                                        <p>${empresaData.email}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="empresa-actions">
                                <a href="https://wa.me/55${empresaData.telefone.replace(/\D/g, '')}?text=Olá,%20gostaria%20de%20saber%20mais%20sobre%20o%20descarte%20de%20resíduos%20na%20empresa%20${encodeURIComponent(empresaData.nome)}%20-%20Tipos:%20${encodeURIComponent(empresaData.residuo)}" 
                                   class="btn btn-primary btn-whatsapp" target="_blank">
                                    <i class="fab fa-whatsapp"></i> Entrar em Contato
                                </a>
                            </div>
                        </div>
                    `;
                });
            });

            // Auto-select first empresa if exists
            if (empresaItems.length > 0) {
                empresaItems[0].click();
            }
        });
    </script>
</body>
</html>
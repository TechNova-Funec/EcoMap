// Sistema de mensagens de feedback
class MensagemManager {
    constructor() {
        this.container = null;
        this.init();
    }

    init() {
        // Criar container para mensagens se não existir
        this.container = document.getElementById('mensagens-container');
        if (!this.container) {
            this.container = document.createElement('div');
            this.container.id = 'mensagens-container';
            this.container.className = 'mensagem-flutuante';
            document.body.appendChild(this.container);
        }
    }

    mostrar(mensagem, tipo = 'info') {
        const mensagemElement = document.createElement('div');
        mensagemElement.className = `mensagem ${tipo}`;
        
        const icon = this.getIcon(tipo);
        
        mensagemElement.innerHTML = `
            <div class="mensagem-icon">${icon}</div>
            <div class="mensagem-conteudo">${mensagem}</div>
        `;

        this.container.appendChild(mensagemElement);

        // Remover mensagem após 5 segundos
        setTimeout(() => {
            if (mensagemElement.parentNode) {
                mensagemElement.parentNode.removeChild(mensagemElement);
            }
        }, 5000);
    }

    getIcon(tipo) {
        const icons = {
            sucesso: '✓',
            erro: '✕',
            info: 'ℹ'
        };
        return icons[tipo] || icons.info;
    }

    sucesso(mensagem) {
        this.mostrar(mensagem, 'sucesso');
    }

    erro(mensagem) {
        this.mostrar(mensagem, 'erro');
    }

    info(mensagem) {
        this.mostrar(mensagem, 'info');
    }
}

// Instância global
const mensagemManager = new MensagemManager();
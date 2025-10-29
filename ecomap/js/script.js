// script.js

// Scroll suave para navegação
document.addEventListener('DOMContentLoaded', () => {
    const navLinks = document.querySelectorAll('nav a');

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Verifica se o link é uma âncora válida (começa com # e não é apenas #)
            if (href && href.startsWith('#') && href.length > 1) {
                e.preventDefault();
                const targetId = href.substring(1);
                const targetSection = document.getElementById(targetId);

                if (targetSection) {
                    // Calcula a posição de destino com offset do cabeçalho fixo
                    const headerHeight = document.querySelector('header').offsetHeight;
                    const targetPosition = targetSection.offsetTop - headerHeight;

                    // Aplica o scroll suave
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth' 
                    });
                }
            }
        });
    });

    // Inicializar o carrossel de participantes
    initCarousel();
});

// Carrossel de participantes
function initCarousel() {
    const items = [
        { img: "https://i.pravatar.cc/300?img=48", name: "Lorenzo Simão", role: "Análise de Dados" },
        { img: "https://i.pravatar.cc/300?img=5",  name: "Miguel Felipe", role: "Back-end" },
        { img: "https://i.pravatar.cc/300?img=15", name: "Lucas Tadeu", role: "Designer" },
        { img: "https://i.pravatar.cc/300?img=22", name: "Davi Gualberto", role: "Front-end" },
    ];

    const track = document.getElementById('track');
    const pagination = document.getElementById('pagination');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    let activeIndex = 0;
    const cardsPerView = 4; // Número de cards visíveis por vez

    function renderItems() {
        track.innerHTML = '';
        items.forEach(it => {
            const card = document.createElement('div');
            card.className = 'participant-card';
            card.setAttribute('role', 'listitem');
            card.innerHTML = `
                <div class="avatar">
                    <img src="${it.img}" alt="${it.name}">
                </div>
                <h3 class="name">${it.name}</h3>
                <p class="role">${it.role}</p>
            `;
            track.appendChild(card);
        });
        renderPagination();
        updateCarousel();
    }

    function renderPagination() {
        pagination.innerHTML = '';
        
        // Calcular número de páginas baseado no número de cards por view
        const numPages = Math.ceil(items.length / cardsPerView);
        
        for (let i = 0; i < numPages; i++) {
            const dot = document.createElement('button');
            dot.className = 'pagination-dot';
            if (i === activeIndex) {
                dot.classList.add('active');
                dot.setAttribute('aria-current', 'true');
            }
            dot.setAttribute('role', 'tab');
            dot.setAttribute('aria-label', `Ir para grupo ${i + 1}`);
            dot.addEventListener('click', () => setActive(i));
            pagination.appendChild(dot);
        }
    }

    function setActive(index) {
        const numPages = Math.ceil(items.length / cardsPerView);
        if (index < 0) index = 0;
        if (index >= numPages) index = numPages - 1;
        activeIndex = index;
        updateCarousel();
    }

    function updateCarousel() {
        if (track.children.length === 0) return;
        
        const cardWidth = track.children[0].offsetWidth + 20; // Largura do card + margem
        track.style.transform = `translateX(-${activeIndex * cardWidth * cardsPerView}px)`;

        // Atualizar dots de paginação
        const dots = document.querySelectorAll('.pagination-dot');
        dots.forEach((dot, index) => {
            const isActive = index === activeIndex;
            dot.classList.toggle('active', isActive);
            if (isActive) {
                dot.setAttribute('aria-current', 'true');
            } else {
                dot.removeAttribute('aria-current');
            }
        });

        // Atualizar estado dos botões
        const numPages = Math.ceil(items.length / cardsPerView);
        prevBtn.disabled = activeIndex === 0;
        nextBtn.disabled = activeIndex === numPages - 1;
        
        // Adicionar/remover atributos ARIA para acessibilidade
        if (prevBtn.disabled) {
            prevBtn.setAttribute('aria-disabled', 'true');
        } else {
            prevBtn.removeAttribute('aria-disabled');
        }
        
        if (nextBtn.disabled) {
            nextBtn.setAttribute('aria-disabled', 'true');
        } else {
            nextBtn.removeAttribute('aria-disabled');
        }
    }

    // Event listeners
    prevBtn.addEventListener('click', () => setActive(activeIndex - 1));
    nextBtn.addEventListener('click', () => setActive(activeIndex + 1));

    // Ajustar o carrossel no redimensionamento da janela
    window.addEventListener('resize', updateCarousel);

    // Inicializar
    renderItems();
}
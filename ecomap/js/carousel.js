// js/carousel.js - Script do Carrossel da Equipe (1 card visível por vez para 5 membros)

class TeamCarousel {
    constructor() {
        this.carousel = document.querySelector('.team-carousel');
        this.cards = document.querySelectorAll('.team-card');
        this.prevBtn = document.querySelector('.carousel-prev');
        this.nextBtn = document.querySelector('.carousel-next');
        this.dots = document.querySelectorAll('.dot');
        this.currentIndex = 0;
        this.cardsPerView = 1; // Mostrar 1 card por vez
        this.totalCards = this.cards.length;
        this.maxIndex = this.totalCards - 1; // Índice máximo baseado no número total de cards (0-4 para 5 cards)
        
        this.init();
    }
    
    init() {
        // Calcular largura inicial
        this.updateCardWidth();
        
        // Event listeners para os botões
        this.prevBtn.addEventListener('click', () => this.prev());
        this.nextBtn.addEventListener('click', () => this.next());
        
        // Event listeners para os dots
        this.dots.forEach((dot, index) => {
            dot.addEventListener('click', () => this.goToSlide(index));
        });
        
        // Swipe para mobile
        this.addSwipeSupport();
        
        // Auto-play (opcional)
        this.startAutoPlay();
        
        // Pausar auto-play no hover
        this.carousel.addEventListener('mouseenter', () => this.stopAutoPlay());
        this.carousel.addEventListener('mouseleave', () => this.startAutoPlay());
        
        // Atualizar na redimensionamento da janela
        window.addEventListener('resize', () => this.handleResize());
        
        // Atualizar estado inicial
        this.updateCarousel();
    }
    
    updateCardWidth() {
        const containerWidth = this.carousel.parentElement.offsetWidth;
        this.cardWidth = containerWidth; // Card ocupa 100% da largura do container
        
        // Aplicar largura aos cards
        this.cards.forEach(card => {
            card.style.flex = `0 0 ${this.cardWidth}px`;
        });
    }
    
    updateCarousel() {
        const translateX = -this.currentIndex * this.cardWidth;
        this.carousel.style.transform = `translateX(${translateX}px)`;
        this.updateDots();
        this.updateButtons();
    }
    
    updateDots() {
        this.dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === this.currentIndex);
        });
    }
    
    updateButtons() {
        this.prevBtn.disabled = this.currentIndex === 0;
        this.nextBtn.disabled = this.currentIndex >= this.maxIndex;
    }
    
    prev() {
        if (this.currentIndex > 0) {
            this.currentIndex--;
            this.updateCarousel();
        }
    }
    
    next() {
        if (this.currentIndex < this.maxIndex) {
            this.currentIndex++;
            this.updateCarousel();
        }
    }
    
    goToSlide(index) {
        if (index >= 0 && index <= this.maxIndex) {
            this.currentIndex = index;
            this.updateCarousel();
        }
    }
    
    addSwipeSupport() {
        let startX = 0;
        let currentX = 0;
        let isDragging = false;
        
        this.carousel.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isDragging = true;
        });
        
        this.carousel.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            currentX = e.touches[0].clientX;
        });
        
        this.carousel.addEventListener('touchend', () => {
            if (!isDragging) return;
            
            const diff = startX - currentX;
            const swipeThreshold = 50;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    this.next();
                } else {
                    this.prev();
                }
            }
            
            isDragging = false;
        });
        
        // Suporte a mouse para desktop
        this.carousel.addEventListener('mousedown', (e) => {
            startX = e.clientX;
            isDragging = true;
            e.preventDefault();
        });
        
        document.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            currentX = e.clientX;
        });
        
        document.addEventListener('mouseup', () => {
            if (!isDragging) return;
            
            const diff = startX - currentX;
            const swipeThreshold = 50;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    this.next();
                } else {
                    this.prev();
                }
            }
            
            isDragging = false;
        });
    }
    
    startAutoPlay() {
        this.stopAutoPlay(); // Limpar qualquer intervalo existente
        this.autoPlayInterval = setInterval(() => {
            if (this.currentIndex < this.maxIndex) {
                this.next();
            } else {
                this.goToSlide(0);
            }
        }, 4000); // Muda a cada 4 segundos
    }
    
    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
        }
    }
    
    handleResize() {
        setTimeout(() => {
            this.updateCardWidth();
            this.updateCarousel();
        }, 100);
    }
}

// Inicializar o carrossel quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', () => {
    new TeamCarousel();
});
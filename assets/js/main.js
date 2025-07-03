document.addEventListener('DOMContentLoaded', function() {

    const servicosCards = document.querySelectorAll('.servicos .card');

    servicosCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.classList.add('is-flipped');
        });

        card.addEventListener('mouseleave', () => {
            card.classList.remove('is-flipped');
        });
    });


    const itensAnimados = document.querySelectorAll('.processos__item');

    if (itensAnimados.length > 0) {
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1 
        });

        itensAnimados.forEach(item => {
            observer.observe(item);
        });
    }

});
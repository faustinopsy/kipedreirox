/**
 * ============================================================
 * KIPEDREIRO – Toast Notification System
 * Módulo modular e reutilizável
 *
 * Uso programático:
 *   Toast.show({ type: 'success', message: 'Salvo com sucesso!' });
 *   Toast.show({ type: 'error',   message: 'Erro ao salvar.' });
 *   Toast.show({ type: 'warning', message: 'Atenção!', duration: 6000 });
 *
 * Leitura automática do flash PHP via:
 *   <div id="flash-data" data-toast-type="success" data-toast-message="Mensagem" hidden></div>
 * ============================================================
 */

const Toast = (() => {
    // ── Config ──────────────────────────────────────────────
    const DEFAULT_DURATION = 4500; // ms

    const CONFIG = {
        success: {
            title: 'Sucesso',
            icon: '&#10003;',     // ✓
        },
        error: {
            title: 'Erro',
            icon: '&#10007;',     // ✗
        },
        erros: {                  // alias PHP do tipo "erros"
            title: 'Atenção',
            icon: '&#9888;',      // ⚠
            cssType: 'warning',
        },
        warning: {
            title: 'Atenção',
            icon: '&#9888;',
        },
        info: {
            title: 'Informação',
            icon: '&#8505;',      // ℹ
        },
    };

    // ── Garantir container no DOM ────────────────────────────
    function _getContainer() {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            document.body.appendChild(container);
        }
        return container;
    }

    // ── Remover toast com animação de saída ──────────────────
    function _remove(toastEl) {
        if (toastEl._removing) return;
        toastEl._removing = true;
        toastEl.classList.add('kp-toast--removing');
        toastEl.addEventListener('animationend', () => toastEl.remove(), { once: true });
        // fallback caso animationend não dispare
        setTimeout(() => { if (toastEl.parentNode) toastEl.remove(); }, 400);
    }

    // ── Criar e exibir um toast ──────────────────────────────
    function show({ type = 'info', message = '', duration = DEFAULT_DURATION } = {}) {
        const cfg      = CONFIG[type] ?? CONFIG.info;
        const cssType  = cfg.cssType ?? type;
        const title    = cfg.title;
        const icon     = cfg.icon;

        const container = _getContainer();

        // ── Estrutura HTML ───────────────────────────────────
        const toast = document.createElement('div');
        toast.className = `kp-toast kp-toast--${cssType}`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');

        toast.innerHTML = `
            <div class="kp-toast__body">
                <div class="kp-toast__icon" aria-hidden="true">${icon}</div>
                <div class="kp-toast__content">
                    <p class="kp-toast__title">${title}</p>
                    <p class="kp-toast__message">${message}</p>
                </div>
                <button class="kp-toast__close" aria-label="Fechar notificação">&#10005;</button>
            </div>
            <div class="kp-toast__progress">
                <div class="kp-toast__progress-bar"></div>
            </div>
        `;

        container.appendChild(toast);

        // ── Progress bar ─────────────────────────────────────
        const bar = toast.querySelector('.kp-toast__progress-bar');
        let elapsed   = 0;
        let startTime = null;
        let rafId     = null;
        let paused    = false;

        function startProgress() {
            startTime = performance.now() - elapsed;
            rafId = requestAnimationFrame(tick);
        }

        function tick(now) {
            if (paused) return;
            elapsed = now - startTime;
            const fraction = Math.min(elapsed / duration, 1);
            bar.style.transform = `scaleX(${1 - fraction})`;
            if (fraction < 1) {
                rafId = requestAnimationFrame(tick);
            } else {
                _remove(toast);
            }
        }

        startProgress();

        // ── Pause on hover ───────────────────────────────────
        toast.addEventListener('mouseenter', () => {
            paused = true;
            cancelAnimationFrame(rafId);
        });
        toast.addEventListener('mouseleave', () => {
            paused = false;
            startProgress();
        });

        // ── Botão fechar ─────────────────────────────────────
        toast.querySelector('.kp-toast__close').addEventListener('click', () => {
            cancelAnimationFrame(rafId);
            _remove(toast);
        });

        return toast;
    }

    // ── Atalhos por tipo ─────────────────────────────────────
    const success = (message, opts = {}) => show({ type: 'success', message, ...opts });
    const error   = (message, opts = {}) => show({ type: 'error',   message, ...opts });
    const warning = (message, opts = {}) => show({ type: 'warning', message, ...opts });
    const info    = (message, opts = {}) => show({ type: 'info',    message, ...opts });

    // ── Leitura automática do flash PHP no carregamento ──────
    function _readFlash() {
        const flashEl = document.getElementById('flash-data');
        if (!flashEl) return;

        const type    = flashEl.dataset.toastType    ?? '';
        const message = flashEl.dataset.toastMessage ?? '';

        if (type && message) {
            show({ type, message });
        }

        flashEl.remove(); // limpa o elemento após leitura
    }

    // Aguarda DOM pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', _readFlash);
    } else {
        _readFlash();
    }

    // ── API pública ──────────────────────────────────────────
    return { show, success, error, warning, info };
})();

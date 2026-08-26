document.addEventListener('DOMContentLoaded', () => {
    const popup = document.querySelector('[data-consultation-popup]');

    if (!popup) {
        return;
    }

    const closeButtons = popup.querySelectorAll('[data-popup-close]');
    const focusableSelector = [
        'a[href]',
        'button:not([disabled])',
        'input:not([disabled]):not([type="hidden"])',
        'select:not([disabled])',
        'textarea:not([disabled])',
        '[tabindex]:not([tabindex="-1"])',
    ].join(',');
    const storageKey = 'lawyer-theme-consultation-popup-seen';
    const delay = Number.parseInt(popup.dataset.delay || '30000', 10);
    let previousActiveElement = null;
    let previousBodyOverflow = '';

    const hasBeenSeen = () => {
        try {
            return window.sessionStorage.getItem(storageKey) === 'true';
        } catch (error) {
            return false;
        }
    };

    const markAsSeen = () => {
        try {
            window.sessionStorage.setItem(storageKey, 'true');
        } catch (error) {
            // The popup can still work when storage is unavailable.
        }
    };

    const openPopup = () => {
        if (!popup.hidden) {
            return;
        }

        previousActiveElement = document.activeElement;
        previousBodyOverflow = document.body.style.overflow;
        popup.hidden = false;
        document.body.style.overflow = 'hidden';
        markAsSeen();

        const firstFocusable = popup.querySelector(focusableSelector);
        firstFocusable?.focus();
    };

    const closePopup = () => {
        if (popup.hidden) {
            return;
        }

        popup.hidden = true;
        document.body.style.overflow = previousBodyOverflow;

        if (previousActiveElement instanceof HTMLElement) {
            previousActiveElement.focus();
        }
    };

    closeButtons.forEach((button) => {
        button.addEventListener('click', closePopup);
    });

    document.addEventListener('keydown', (event) => {
        if (popup.hidden) {
            return;
        }

        if (event.key === 'Escape') {
            closePopup();
            return;
        }

        if (event.key !== 'Tab') {
            return;
        }

        const focusableElements = Array.from(popup.querySelectorAll(focusableSelector));

        if (!focusableElements.length) {
            event.preventDefault();
            return;
        }

        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];

        if (event.shiftKey && document.activeElement === firstElement) {
            event.preventDefault();
            lastElement.focus();
        } else if (!event.shiftKey && document.activeElement === lastElement) {
            event.preventDefault();
            firstElement.focus();
        }
    });

    document.addEventListener('wpcf7mailsent', (event) => {
        if (popup.contains(event.target)) {
            window.setTimeout(closePopup, 1200);
        }
    });

    if (!hasBeenSeen()) {
        window.setTimeout(openPopup, Number.isFinite(delay) ? delay : 30000);
    }
});

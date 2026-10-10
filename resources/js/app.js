import './bootstrap';
import Alpine from 'alpinejs';
import Sortable from 'sortablejs';

window.Alpine = Alpine;
window.Sortable = Sortable;
window.openModal  = (id, payload) => window.dispatchEvent(new CustomEvent('open-modal',  { detail: { id, payload } }));
window.closeModal = () => window.dispatchEvent(new CustomEvent('close-modal'));
document.addEventListener('alpine:init', () => {
    Alpine.store('toasts', {
        toasts: [],
        notify(message, type = 'success') {
            const id = Date.now() + Math.random();
            this.toasts.push({ id, message, type });
            setTimeout(() => this.dismiss(id), 3000);       // tự biến mất sau 3s
        },
        dismiss(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        },
    });

    Alpine.data('toastContainer', () => ({
        get items() { return Alpine.store('toasts').toasts; },
        dismiss(id)  { Alpine.store('toasts').dismiss(id); },
        classes(type) {
            return {
                success: 'bg-emerald-600 text-white',
                error:   'bg-red-600 text-white',
                info:    'bg-gray-900 text-white',
            }[type] ?? 'bg-gray-900 text-white';
        },
        icon(type) {
            return {
                success: '✓', error: '✕', info: 'ℹ',
            }[type] ?? 'ℹ';
        },
    }));
});
Alpine.start();

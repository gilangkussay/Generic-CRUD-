document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!window.confirm(form.dataset.confirm || 'Lanjutkan tindakan ini?')) {
                event.preventDefault();
            }
        });
    });

    document.querySelectorAll('.alert-close').forEach((button) => {
        button.addEventListener('click', () => button.closest('.alert')?.remove());
    });

    const toggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    toggle?.addEventListener('click', () => sidebar?.classList.toggle('sidebar-open'));
});

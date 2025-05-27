
    // Fungsi untuk menghilangkan flash message secara manual
    function closeFlashMessage(button) {
        const flashMessage = button.parentElement;
        flashMessage.style.opacity = '0';
        setTimeout(() => flashMessage.remove(), 500);
    }

    // Auto hide flash message setelah 3 detik
    document.addEventListener('DOMContentLoaded', () => {
        const flashMessages = document.querySelectorAll('.flash-message');
        flashMessages.forEach((message) => {
            setTimeout(() => {
                message.style.opacity = '0';
                setTimeout(() => message.remove(), 500);
            }, 3000); // 3 detik
        });
    });


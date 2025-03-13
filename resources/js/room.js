document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll('.view-details');

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            alert('Oda detayları gösteriliyor!');
        });
    });
});

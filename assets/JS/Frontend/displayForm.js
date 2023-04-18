const divForm = document.querySelector('.js-form');
const btn = document.querySelector('.js-btn-message');

if (divForm && btn) {
    btn.addEventListener('click', () => {
        if (getComputedStyle(divForm).display == 'none') {
            divForm.style.display = 'block';
            btn.innerHTML = 'Enlever le nouveau message';
        } else {
            divForm.style.display = 'none';
            btn.innerHTML = 'Ajouter un nouveau message';
        }
    })
}

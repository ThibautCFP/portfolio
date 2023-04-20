const divForm = document.querySelector('.js-form');
const btn = document.querySelector('.js-btn-message');

if (divForm && btn) {
    btn.addEventListener('click', () => {
        if (getComputedStyle(divForm).display == 'none') {
            divForm.style.display = 'block';
            let posDivForm = divForm.getBoundingClientRect();
            btn.innerHTML = 'Enlever le nouveau message';
            window.scrollTo(posDivForm.x, posDivForm.y);
        } else {
            let postBtn = btn.getBoundingClientRect();
            divForm.style.display = 'none';
            btn.innerHTML = 'Ajouter un nouveau message';
            window.scrollTo(postBtn.x + 1, postBtn.y + 1);
        }
    })
}

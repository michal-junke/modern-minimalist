function toggleMobileMenu() {
    document.querySelector('.js-burger').classList.toggle('is-active');
    document.querySelector('.js-main-menu').classList.toggle('is-active');
    console.log('Clicked');
}
var mobileMenu = document.querySelector('.js-burger');
mobileMenu.addEventListener('click', () => toggleMobileMenu());
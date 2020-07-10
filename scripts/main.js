function twttr() {
    document.getElementById("martin").innerHTML = "<span style='color: #bb0000'>@</span>maruzek";
}

function twttrOut() {
    document.getElementById("martin").innerHTML = "MARTIN <span style='color: #bb0000'>R</span>ŮŽEK";
}

function ig() {
    document.getElementById("martin").innerHTML = "<span style='color: #bb0000'>@</span>martin_ruzek";
}

function igOut() {
    document.getElementById("martin").innerHTML = "MARTIN <span style='color: #bb0000'>R</span>ŮŽEK";
}

function navLinkClick() {
    const nav = document.querySelector('#navigation');
    nav.classList.toggle('nav-active');
}

const navSlide = () => {
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('#navigation');
    const navLinks = document.querySelectorAll('#navigation li');

    burger.addEventListener('click', () => {
        nav.classList.toggle('nav-active');
    });
}
navSlide();

function smoothScroll(target, duration) {

}
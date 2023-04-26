const header = document.querySelector('header')
const scrollDown = document.querySelector('.scroll-down')
const scrollFilterRight = document.querySelector('.scroll-filter.right')
const scrollFilterLeft = document.querySelector('.scroll-filter.left')

window.addEventListener('scroll', () => {
    if (window.scrollY >= 20) {
        header.classList.add('active')
    } else {
        header.classList.remove('active')
    }
})

if (scrollDown) {
    scrollDown.addEventListener('click', () => {
        window.scroll({
            top: window.innerHeight * 0.9,
            left: 0,
            behavior: 'smooth',
        })
    })
}

import { ValidForm } from './module/ValidForm.js'
import { InputImage } from './module/InputImage.js'

const forms = document.querySelectorAll('form')
const errorContainer = document.querySelector('.error-container')
const thisUrl = 'http://localhost/lestruellesardechoises.fr/public/'
const aboutLink = document.querySelector('.about_link')
const projectsLink = document.querySelector('.projects_link')

if (forms) {
    forms.forEach((form) => {
        var validForm = new ValidForm(form, errorContainer, thisUrl)
        form.addEventListener('submit', (event) => {
            event.preventDefault()
            validForm.formSubmit()
        })
    })
}

const inputsFile = document.querySelectorAll('.file')

if (inputsFile) {
    inputsFile.forEach((input, index) => {
        const dt = new DataTransfer()
        var inputImage = new InputImage(input, dt, forms[index], errorContainer)
        input.addEventListener('change', () => {
            inputImage.loadImage()
        })
    })
}

const menuBurger = document.querySelector('.menu-burger')
const menu = document.querySelector('.menu')

if (menuBurger) {
    menuBurger.addEventListener('click', () => {
        menu.classList.toggle('active')
        menuBurger.classList.toggle('active')
    })
}

const delContentBtn = document.querySelectorAll('.del_content')

const getDelContent = async (form) => {
    var formData = new FormData()
    formData.append('id', form.querySelector('.id-item > input').value)

    await fetch(thisUrl + 'get/delete-content', {
        method: 'POST',
        body: formData,
    }).then(form.parentNode.remove())
}

if (delContentBtn) {
    delContentBtn.forEach((btn) => {
        btn.addEventListener('click', () => {
            getDelContent(btn.previousElementSibling)
        })
    })
}

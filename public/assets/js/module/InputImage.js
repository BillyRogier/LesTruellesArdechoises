import { ValidForm } from './ValidForm.js'

export class InputImage {
    constructor(input, dt, form, errorContainer, url) {
        this.errorContainer = errorContainer
        this.input = input
        this.form = form
        this.imgContainer = this.form.querySelector(
            '.img-container > .item-container'
        )
        this.allInputsImage =
            this.imgContainer.querySelectorAll('.img-item > input')
        this.dt = dt
        this.url = url
        this.deleteImage()
    }

    loadImage() {
        if (this.input.files) {
            for (var i = 0; i < this.input.files.length; i++) {
                var file = this.input.files[i]
                var reader = new FileReader()
                reader.onloadstart = () => {
                    if (this.allInputsImage[0]) {
                        if (
                            this.allInputsImage[0].value == '' ||
                            (this.allInputsImage[0].value != '' &&
                                !/[\[\]\\?]/g.test(this.allInputsImage[0].name))
                        ) {
                            this.imgContainer.innerHTML = 'Chargement...'
                        }
                    }
                }
                reader.onload = () => {
                    if (
                        this.allInputsImage[0].value == '' ||
                        (this.allInputsImage[0].value != '' &&
                            !/[\[\]\\?]/g.test(this.allInputsImage[0].name))
                    ) {
                        this.imgContainer.innerHTML = ''
                    }
                }
                reader.onloadend = () => {
                    this.imgContainer.innerHTML += `
                        <div class="img-item">
                            <input name="${
                                !/[\[\]\\?]/g.test(this.input.name)
                                    ? 'img'
                                    : 'img[]'
                            }" type="hidden" value="${file.name}">
                            <img src="${reader.result}">
                            <input name="alt" type="text" placeholder="Description image" class="img_alt">
                            <span class="del_image btn">delete</span>
                        </div>`
                    this.deleteImage()
                    new ValidForm(this.form, this.errorContainer).getErrorInput(
                        this.imgContainer.querySelector('input')
                    )
                }
                reader.readAsDataURL(this.input.files[i])
                this.dt.items.add(this.input.files[i])
            }
            this.input.files = this.dt.files
        }
    }

    deleteImage() {
        const allBtn = this.form.querySelectorAll('.del_image')
        if (allBtn) {
            allBtn.forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    if (allBtn.length == 1) {
                        btn.parentNode.querySelector('img').remove()
                        btn.parentNode.querySelector('.img_alt').remove()
                        btn.parentNode.querySelector('input').value = ''
                        btn.remove()
                    } else {
                        btn.parentNode.remove()
                    }
                    this.dt.items.remove(this.input.files[index])
                    this.input.files = this.dt.files
                })
            })
        }
    }
}

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
        this.valid = new ValidForm(this.form, this.errorContainer)
    }

    loadImage() {
        if (this.input.files) {
            var curFiles = this.input.files
            for (var i = 0; i < curFiles.length; i++) {
                if (this.allInputsImage[0]) {
                    if (
                        this.allInputsImage[0].value == '' ||
                        (this.allInputsImage[0].value != '' &&
                            !/[\[\]\\?]/g.test(this.allInputsImage[0].name))
                    ) {
                        this.imgContainer.innerHTML = 'Chargement...'
                    }
                }
                if (
                    this.allInputsImage[0].value == '' ||
                    (this.allInputsImage[0].value != '' &&
                        !/[\[\]\\?]/g.test(this.allInputsImage[0].name))
                ) {
                    this.imgContainer.innerHTML = ''
                }
                this.imgContainer.innerHTML += `
                        <div class="img-item">
                            <input name="${
                                !/[\[\]\\?]/g.test(this.input.name)
                                    ? 'img'
                                    : 'img[]'
                            }" type="hidden" value="${curFiles[i].name}">
                            <img >
                            <input name="${
                                !/[\[\]\\?]/g.test(this.input.name)
                                    ? 'alt'
                                    : 'alt[]'
                            }" type="text" placeholder="Description image" class="img_alt">
                            <span class="del_image btn">delete</span>
                        </div>`

                var image =
                    this.imgContainer.lastElementChild.querySelector('img')
                image.src = window.URL.createObjectURL(curFiles[i])
                this.deleteImage()
                this.valid.getErrorInput(
                    this.imgContainer.querySelector('input')
                )
                this.dt.items.add(curFiles[i])
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

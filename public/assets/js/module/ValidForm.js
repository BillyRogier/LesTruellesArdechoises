export class ValidForm {
    send = false
    valid = false
    propertie = ''

    constructor(form, errorContainer) {
        this.form = form
        this.errorContainer = errorContainer
    }

    successRedirection(data) {
        if (data.success_location) {
            window.location.href = data.success_location
        }
        return false
    }

    getErrorPropertie(elt) {
        if (this.propertie != '') {
            var prop = this.propertie['properties']
            if (prop[elt.name] && elt.name != 'id') {
                if (prop[elt.name]['length']) {
                    if (elt.value.length > prop[elt.name]['length']) {
                        this.error.innerHTML =
                            '<li>Le champs ' +
                            elt.name +
                            ' doit contenir maximum ' +
                            prop[elt.name]['length'] +
                            ' characters</li>'
                    }
                }
                if (prop[elt.name]['type']) {
                    if (prop[elt.name]['type'] == 'int') {
                        if (!/^-?[0-9]+$/.test(elt.value)) {
                            this.error.innerHTML +=
                                '<li>Le champs ' +
                                elt.name +
                                ' doit contenir seulement des chiffres </li>'
                        }
                    } else if (prop[elt.name]['type'] == 'float') {
                        if (!/^-?[0-9-.]+$/.test(elt.value)) {
                            this.error.innerHTML +=
                                '<li>Le champs ' +
                                elt.name +
                                ' doit contenir seulement des chiffres </li>'
                        }
                    }
                }
            }
        }
    }

    getErrorInput(elt) {
        this.valid = false
        this.eltParent = elt.parentNode.parentNode.parentNode
        this.error = this.eltParent.querySelector('.error-message')
        this.error.innerHTML = ''
        this.getErrorPropertie(elt)
        if (elt.type == 'email') {
            var emailTest =
                /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
            if (!emailTest.test(elt.value)) {
                this.error.innerHTML +=
                    '<li>Veuillez rentrez un email valide</li>'
            }
        } else if (
            elt.type == 'password' &&
            elt.getAttribute('data-pass') == true
        ) {
            if (7 > elt.value.length) {
                this.error.innerHTML +=
                    '<li>Mot de passe trop court (min 7 characters)</li>'
            }
            if (!/[0-9]/.test(elt.value)) {
                this.error.innerHTML +=
                    '<li>Le mot de passe doit contenir au moins un chiffre</li>'
            }
            if (!/[a-z]/.test(elt.value)) {
                this.error.innerHTML +=
                    '<li>Le mot de passe doit contenir au moins une lettre miniscule</li>'
            }
            if (!/[A-Z]/.test(elt.value)) {
                this.error.innerHTML +=
                    '<li>Le mot de passe doit contenir au moins une lettre majuscule</li>'
            }
            if (!/[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/.test(elt.value)) {
                this.error.innerHTML +=
                    '<li>Le mot de passe doit contenir au moins un character spécial</li>'
            }
        }
        if (
            this.error.innerHTML == '' &&
            elt.type != 'file' &&
            (elt.value != '' || elt.getAttribute('data-req') == true)
        ) {
            this.eltParent.classList.remove('invalid')
            this.eltParent.classList.add('active')
            this.valid = true
        } else if (
            elt.value == '' &&
            elt.type != 'file' &&
            elt.name != 'id' &&
            elt.getAttribute('data-req') != true
        ) {
            this.error.innerHTML =
                '<li>Veuillez remplir le champs ' + elt.name + '</li>'
            this.eltParent.classList.remove('active')
            this.eltParent.classList.add('invalid')
        }
        if (this.error.innerHTML != '' || this.errorContainer.innerHTML != '') {
            this.eltParent.classList.remove('active')
            this.eltParent.classList.add('invalid')
        }
    }

    inputEvent(elements) {
        elements.forEach((elt) => {
            elt.addEventListener('input', () => {
                this.getErrorInput(elt)
            })
            elt.addEventListener('change', () => {
                this.getErrorInput(elt)
            })
            this.getErrorInput(elt)
        })
    }

    async formSend() {
        var action = this.form.action
        var formData = new FormData(this.form)

        await fetch(action, {
            method: 'POST',
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                const inputForm = this.form.querySelectorAll('input')
                const textareaForm = this.form.querySelectorAll('textarea')
                const selectForm = this.form.querySelectorAll('select')
                if (!this.successRedirection(data)) {
                    this.errorContainer.innerHTML = data.error_container
                    this.propertie = data
                    this.inputEvent(inputForm)
                    this.inputEvent(textareaForm)
                    this.inputEvent(selectForm)
                }
            })
    }

    formSubmit() {
        if (this.send === false || this.valid === true) {
            this.errorContainer.innerHTML = ''
            this.send = true
            return this.formSend()
        }
    }
}

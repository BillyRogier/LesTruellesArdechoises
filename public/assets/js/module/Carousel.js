export class Carousel {
    index = 0

    constructor(touchContainer, carousel) {
        this.touchContainer = touchContainer
        this.carousel = carousel

        this.carouselItems = carousel.querySelectorAll('.carousel-item')
        this.carouselIndicators = carousel.parentNode.querySelectorAll(
            '.carousel-indicator'
        )
        this.carouselIndicators[0].parentNode.style['grid-template-columns'] =
            'repeat(' + this.carouselIndicators.length + ', min-content)'

        this.buttons = carousel.parentNode.querySelectorAll(
            '.carousel-arrows > .arrow'
        )
        this.setItem()
        this.setMove()
    }

    setItem = () => {
        if (this.index < this.carouselItems.length && this.index >= 0) {
            for (let n = 0; n < this.carouselItems.length; n++) {
                this.carouselItems[n].style['transform'] = `translateX(${
                    (n + this.index) * 100
                }%)`
            }
        } else if (this.index < 0) {
            for (let n = this.carouselItems.length - 1; n >= 0; n--) {
                this.carouselItems[n].style['transform'] = `translateX(${
                    (n + this.index) * 100
                }%)`
            }
        }
        if (this.index < -4) {
            this.index = 0
            this.setItem()
        }
        if (this.index > 0) {
            this.index = -4
            this.setItem()
        }
    }

    setMove = () => {
        this.buttons.forEach((btn) => {
            btn.addEventListener('click', () => {
                btn.classList.contains('left') ? this.index++ : this.index--
                console.log(this.index)
                this.setItem()
            })
        })
    }
}

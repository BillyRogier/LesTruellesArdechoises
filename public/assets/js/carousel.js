const carouselHome = document.querySelector('#home > .carousel')
// const carouselReview = document.querySelector('#review .carousel')
const sliders = document.querySelectorAll('.slider')

const carouselCreation = (carousel, interval) => {
    const carouselItems = carousel.querySelectorAll('.carousel-item')
    const carouselIndicators = carousel.parentNode.querySelectorAll(
        '.carousel-indicator'
    )
    carouselIndicators[0].parentNode.style['grid-template-columns'] =
        'repeat(' + carouselIndicators.length + ' , min-content)'
    const button = carousel.parentNode.querySelectorAll(
        '.carousel-arrows > .arrow'
    )
    let current = 0
    let prev = carouselItems.length - 1
    let next = 1
    let wait = false
    let x = 0
    let old = 0

    carouselItems[current].classList.add('active')

    if (carouselItems.length > 1) {
        carouselIndicators[current].classList.add('active')
        if (carouselItems.length <= 2) {
            carouselItems[prev].classList.add('prev')
        } else {
            carouselItems[prev].classList.add('prev')
            carouselItems[next].classList.add('next')
        }

        const gotoNum = (number) => {
            carouselIndicators[current].classList.remove('active')

            current = number
            prev = current - 1
            next = current + 1

            carouselItems.forEach((item) => {
                item.classList.remove('active')
                item.classList.remove('prev')
                item.classList.remove('next')
            })

            if (next == carouselItems.length) {
                next = 0
            }

            if (prev == -1) {
                prev = carouselItems.length - 1
            }

            carouselItems[current].classList.add('active')
            carouselItems[prev].classList.add('prev')
            carouselIndicators[current].classList.add('active')
            carouselItems[next].classList.add('next')
        }

        const gotoPrev = () => {
            if (prev == next) {
                carouselIndicators[current].classList.remove('active')

                current = prev
                prev = current - 1
                next = current + 1

                if (next == carouselItems.length) {
                    next = 0
                }

                if (prev == -1) {
                    prev = carouselItems.length - 1
                }

                carouselItems[prev].classList.remove('active')
                if (carouselItems[current].classList.contains('prev')) {
                    carouselItems[prev].classList.add('next')
                } else {
                    carouselItems[prev].classList.add('prev')
                }
                carouselItems[current].classList.remove('prev', 'next')
                carouselItems[current].classList.add('active')
                carouselIndicators[current].classList.add('active')
            } else {
                current > 0
                    ? gotoNum(current - 1)
                    : gotoNum(carouselItems.length - 1)
            }
        }

        const gotoNext = () => {
            if (prev == next) {
                carouselIndicators[current].classList.remove('active')

                current = prev
                prev = current - 1
                next = current + 1

                if (next == carouselItems.length) {
                    next = 0
                }

                if (prev == -1) {
                    prev = carouselItems.length - 1
                }

                carouselItems[next].classList.remove('active')
                if (carouselItems[current].classList.contains('next')) {
                    carouselItems[next].classList.add('prev')
                } else {
                    carouselItems[next].classList.add('next')
                }
                carouselItems[current].classList.remove('prev', 'next')
                carouselItems[current].classList.add('active')
                carouselIndicators[current].classList.add('active')
            } else {
                current < carouselItems.length - 1
                    ? gotoNum(current + 1)
                    : gotoNum(0)
            }
        }

        const autoSlide = (val) => {
            if (val === true) {
                interval = setInterval(() => {
                    gotoNext()
                }, 4000)
            } else {
                clearInterval(interval)
            }
        }

        button.forEach((btn) => {
            btn.addEventListener('click', () => {
                autoSlide(false)
                if (wait != true) {
                    btn.classList.contains('left') ? gotoPrev() : gotoNext()
                    wait = true
                    setTimeout(() => {
                        wait = false
                    }, 600)
                }
            })
        })

        carouselIndicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                autoSlide(false)
                if (wait != true) {
                    if (prev == next && current < prev) {
                        gotoNext()
                    } else if (prev == next && current > prev) {
                        gotoPrev()
                    } else {
                        gotoNum(index)
                    }
                    wait = true
                    setTimeout(() => {
                        wait = false
                    }, 600)
                }
            })
        })

        const drag = (e) => {
            autoSlide(false)
            old = x
            x = e.touches[0].clientX
        }

        const end = () => {
            if (wait != true) {
                if (x > old) {
                    gotoPrev()
                } else {
                    gotoNext()
                }
                wait = true
                setTimeout(() => {
                    wait = false
                }, 600)
            }
        }

        if (interval == 'home') {
            document.querySelector('#home').addEventListener('touchmove', drag)
            document.querySelector('#home').addEventListener('touchend', end)
        }
        carousel.addEventListener('touchmove', drag)
        carousel.addEventListener('touchend', end)
        window.addEventListener('load', autoSlide(true))
    } else {
        carouselIndicators.forEach((item) => {
            item.remove()
        })
    }
}

if (carouselHome) {
    carouselCreation(carouselHome, 'home')
}
// if (carouselReview) {
//     carouselCreation(carouselReview, 'review')
// }

const sliderCreation = (slider) => {
    const sliderItems = slider.querySelectorAll('.slider-item')
    slider.style['grid-template-columns'] =
        'repeat(' +
        sliderItems.length +
        ' , ' +
        (window.innerWidth - 80 > 310 ? 310 : window.innerWidth - 80) +
        'px)'
    const sliderIndicators =
        slider.parentNode.querySelectorAll('.slider-indicator')
    sliderIndicators[0].parentNode.style['grid-template-columns'] =
        'repeat(' + sliderIndicators.length + ' , min-content)'
    const button = slider.parentNode.querySelectorAll(
        '.slider-container > .slider-arrows > .arrow'
    )

    const sliderScroll = () => {
        if (slider.offsetWidth < slider.scrollWidth) {
            if (slider.scrollLeft == slider.scrollWidth - slider.offsetWidth) {
                button[0].parentNode
                    .querySelector('.arrow.right')
                    .classList.add('active')
                button[0].parentNode
                    .querySelector('.arrow.left')
                    .classList.remove('active')
            } else if (slider.scrollLeft == 0) {
                button[0].parentNode
                    .querySelector('.arrow.right')
                    .classList.remove('active')
                button[0].parentNode
                    .querySelector('.arrow.left')
                    .classList.add('active')
            } else {
                button[0].parentNode
                    .querySelector('.arrow.right')
                    .classList.remove('active')
                button[0].parentNode
                    .querySelector('.arrow.left')
                    .classList.remove('active')
            }
        } else {
            button[0].parentNode
                .querySelector('.arrow.left')
                .classList.add('active')
            button[0].parentNode
                .querySelector('.arrow.right')
                .classList.add('active')
        }
    }

    sliderScroll()
    window.addEventListener('resize', sliderScroll)
    slider.addEventListener('scroll', sliderScroll)

    if (sliderItems.length > 1) {
        const showindicator = () => {
            for (i = 0; i <= sliderIndicators.length - 1; i++) {
                let sliderItemsWidth = sliderItems[0].offsetWidth + 20
                let vue = Math.round(slider.offsetWidth / sliderItemsWidth)
                if (
                    i >= sliderIndicators.length - vue + 1 ||
                    sliderIndicators.length - vue + 1 == 1
                ) {
                    sliderIndicators[i].style.display = 'none'
                } else {
                    sliderIndicators[i].style.display = 'block'
                }
            }
        }

        showindicator()
        window.addEventListener('load', showindicator)
        window.addEventListener('resize', showindicator)

        const scrollSlider = () => {
            sliderItems.forEach((item, index) => {
                let w = item.offsetWidth + 20
                if (
                    slider.scrollLeft >= w * index - w / 2 &&
                    slider.scrollLeft <= w * (index + 1) - w / 2
                ) {
                    sliderIndicators[index].classList.add('active')
                } else {
                    sliderIndicators[index].classList.remove('active')
                }
            })
        }

        sliderIndicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                slider.scrollTo(
                    (sliderItems[index].offsetWidth + 20) * index,
                    0
                )
            })
        })

        slider.addEventListener('load', scrollSlider())
        slider.addEventListener('scroll', scrollSlider)

        button.forEach((btn) => {
            btn.addEventListener('click', () => {
                btn.classList.contains('left')
                    ? (slider.scrollTo(
                          slider.scrollLeft - sliderItems[0].offsetWidth + 20,
                          0
                      ),
                      sliderScroll())
                    : (slider.scrollTo(
                          slider.scrollLeft + sliderItems[0].offsetWidth + 20,
                          0
                      ),
                      sliderScroll())
            })
        })
    } else {
        sliderIndicators.forEach((item) => {
            item.remove()
        })
    }
}

if (sliders) {
    sliders.forEach((slider) => {
        sliderCreation(slider)
    })
}

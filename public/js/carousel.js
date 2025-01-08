function loadCarousel(carousel, carouselNavigation, left, right, element) {
    const count = element[0];
    const carouselDictionary = element[1];
    const $carousel = $(carousel);
    const $navBar = $(carouselNavigation);
    let lengthCarousel = count;
    let currentIndex = 0;
    let debounce = false;
    let speed = 400;

    for (let i = 0; i < lengthCarousel; i++) {
        $carousel.append(`<div class="News-container-box">
                            <img class="object-cover h-fit" style="border-radius: inherit;" src="${carouselDictionary}${i + 1}.Landscape.png" alt="iklan ke-${i + 1}">
                        </div>`);
        $navBar.append(`<a id='dot-${i}' class='navBar-dots dothover'></a>`);
        $(`#dot-${i}`).click(function () {
            goNav(i);
        });
    }

    let interval = window.setInterval(rotateSlides, 3000)

    function update() {
        if (currentIndex < 0) {
            currentIndex = lengthCarousel - 1;
        } else if (currentIndex >= lengthCarousel) {
            currentIndex = 0;
        }

        for (let i = 0; i < lengthCarousel; i++) {
            let dot = $(`#dot-${i}`);
            if (i === currentIndex) {
                dot.animate({borderRadius: '15px'}, 0);
                dot.css("background-color", 'rgb(8, 56, 112)');
                dot.animate({width: '20px'}, 0);
            } else {
                dot.animate({borderRadius: '100%'}, 0);
                dot.css("background-color", 'rgba(8, 56, 112,0.482)');
                dot.animate({width: '7px'}, 0);
            }
        }
    }

    let currentSlide;

    function goNav(index) {
        let total = Math.abs(currentIndex - index);
        let functions;
        if (index >= currentIndex) {
            functions = nextSlide;
        } else {
            functions = prevSlide;
        }

        for (let i = 0; i < total; i++) {
            $(".News-container-box").stop(true, true);
            speed = 400 - total * 100;
            if (speed <= 200) {
                speed = 200;
            }
            functions();
        }
        speed = 400;
    }

    function nextSlide() {
        if (debounce) {
            return;
        }

        debounce = true;
        window.clearInterval(interval);

        let $firstSlide = $('#carousel').find('div:first');
        let clone = $firstSlide.clone();
        clone.appendTo("#carousel");
        currentSlide = $firstSlide;
        $firstSlide.animate({marginLeft: -$firstSlide.width()}, speed, function () {
            $firstSlide.remove();
            debounce = false;
            interval = window.setInterval(rotateSlides, 3000);
        })
        currentIndex++;
        update();
    }

    function prevSlide() {
        if (debounce) {
            return;
        }

        debounce = true;
        window.clearInterval(interval);

        let $lastSlide = $('#carousel').find('div:last');
        let clone = $lastSlide.clone();
        clone.prependTo("#carousel");
        clone.css({marginLeft: -clone.width()});
        currentSlide = clone;
        clone.animate({marginLeft: 0}, speed, function () {
            $lastSlide.remove();
            debounce = false;
            interval = window.setInterval(rotateSlides, 3000);
        })

        currentIndex--;
        update();
    }

    function rotateSlides() {
        nextSlide();
    }

    $(right).click(function () {
        nextSlide();
    })

    $(left).click(function () {
        prevSlide();
    })

    update();
}
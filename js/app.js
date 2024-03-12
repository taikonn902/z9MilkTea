
//banner
document.addEventListener("DOMContentLoaded", function () {
    var carouselInner = document.querySelector(".carousel-inner");

    function shiftAndMove() {
        carouselInner.style.transition = "transform 1s ease-in-out";
        carouselInner.style.transform = "translateX(-100%)";

        setTimeout(function () {
            var firstItem = document.querySelector(".carousel-item:first-child");
            carouselInner.appendChild(firstItem);
            carouselInner.style.transition = "none";
            carouselInner.style.transform = "translateX(0)";
        }, 1000); 
    }

    setInterval(shiftAndMove, 3000); 
});

// =============================================================================================

function scrollDown() {
    var topNewItems = document.getElementById('NewItems');
    var headerHeight = 200; // Điều chỉnh độ cao của header-fixed của bạn

    if (topNewItems) {
        var offsetTop = topNewItems.offsetTop - headerHeight;

        window.scroll({
            top: offsetTop,
            behavior: 'smooth'
        });
    }
}

// =====================================================================================================================

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

var topButton = document.querySelector('.top-page-btn');

topButton.addEventListener('click', scrollToTop);

window.addEventListener('scroll', function () {
    if (window.scrollY > 10) {
        topButton.style.opacity = '1';
        topButton.style.pointerEvents = 'auto';
        topButton.classList.add('visible');
    } else {
        topButton.style.opacity = '0';
        topButton.style.pointerEvents = 'none';
        topButton.classList.remove('visible');
    }
});

// ==============================================================================================

function showCart(event) {
    event.preventDefault();
    var showCart = document.getElementById('show-cart');
    var iconCart = event.currentTarget;
    var cartLengthElement = document.getElementById('lenght-cart');

    if (showCart.classList.contains('show')) {
        showCart.classList.remove('show');
        iconCart.style.color = '#221F20';
        cartLengthElement.style.color = '#221F20';
    } else {
        showCart.classList.add('show');
        iconCart.style.color = '#fff';
        cartLengthElement.style.color = '#fff';
    }
}

// ===========================================================================================================

var header = document.getElementById("header-page");
var isHeaderFixed = false;

var header = document.getElementById("header-page");
var isHeaderFixed = false;

window.addEventListener("scroll", function() {
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop > 200 && !isHeaderFixed) {
        // Khi cuộn xuống hơn 50 pixel, thêm class 'fixed-header'
        header.classList.add("fixed-header");
        // Xóa thuộc tính id
        header.removeAttribute("id");
        isHeaderFixed = true;
    } else if (scrollTop <= 50 && isHeaderFixed) {
        // Khi cuộn lên trên 50 pixel, xóa class 'fixed-header'
        header.classList.remove("fixed-header");
        // Thêm lại thuộc tính id
        header.setAttribute("id", "header-page");
        isHeaderFixed = false;
    }
});





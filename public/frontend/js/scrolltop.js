const btnScrollTop = document.querySelector("#btn-top-wrapper-wrapper");
const btnToTop = document.querySelector("#btn-move-top");

btnScrollTop.addEventListener("click", function () {
    window.scrollTo({
        top: 0,
        left: 0,
        behavior: "smooth",
    });
});

window.addEventListener("scroll", scrollToTop);
function scrollToTop() {
    if (window.scrollY > 300) {
        //Show button
        if (!btnToTop.classList.contains("btnAppear")) {
            btnToTop.classList.remove("btnDisAppear");
            btnToTop.classList.add("btnAppear");
            btnScrollTop.style.display = "block";
        }
    } else {
        //Hide button
        if (btnToTop.classList.contains("btnAppear")) {
            btnToTop.classList.remove("btnAppear");
            btnToTop.classList.add("btnDisAppear");
            setTimeout(() => {
                btnScrollTop.style.display = "none";
            }, 250);
        }
    }
}

// on scroll
$(function () {
    $(window).on("scroll", function () {
        if ($(window).scrollTop()) {
            $("header").addClass("nav-on-scroll");
            // $(".search-bar-wrapper-wrapper").addClass("search-on-scroll");
        } else {
            $("header").removeClass("nav-on-scroll");
            // $(".search-bar-wrapper-wrapper").removeClass("search-on-scroll");
        }
    });
});

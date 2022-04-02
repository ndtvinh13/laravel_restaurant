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

// icon direction
$(function () {
    $(".dropdown-toggle").on("click", function () {
        if ($(".fa-angle-down").hasClass("point-down")) {
            $(".fa-angle-down").removeClass("point-down");
            $(".fa-angle-down").addClass("point-up");
        } else {
            $(".fa-angle-down").removeClass("point-up");
            $(".fa-angle-down").addClass("point-down");
        }
    });

    $(document).on("click", function (e) {
        // When click on the screen -> there is no .dropdown-toggle class
        // it then means false -> match the condition
        if ($(e.target).is(".dropdown-toggle") === false) {
            $(".fa-angle-down").removeClass("point-up");
            $(".fa-angle-down").addClass("point-down");
        }
    });
});

$(function () {
    $(".customer-wrapper")
        .on("mouseenter", function () {
            if ($(".fa-angle-double-down").hasClass("point-down")) {
                $(".fa-angle-double-down").removeClass("point-down");
                $(".fa-angle-double-down").addClass("point-up");
            }
        })
        .on("mouseleave", function () {
            if ($(".fa-angle-double-down").hasClass("point-up")) {
                $(".fa-angle-double-down").removeClass("point-up");
                $(".fa-angle-double-down").addClass("point-down");
            }
        });
});

// Live time using moment.js
$(function ($) {
    setInterval(() => {
        let now_time = moment();
        $(".live-time").html(now_time.format("h:mm:ss a"));
    }, 1000);
});

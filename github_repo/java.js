$(document).ready(function() {
    $('nav').addClass('black'); // Ajoute la classe black dès le début

    $(".menu-icon").on("click", function() {
        $("nav ul").toggleClass("showing");
    });
});

// Effet de scrolling
$(window).on("scroll", function() {
    if ($(window).scrollTop()) {
        $('nav').addClass('black');
    } else {
        $('nav').addClass('black'); // Laisse la navbar noire même en haut
    }
});

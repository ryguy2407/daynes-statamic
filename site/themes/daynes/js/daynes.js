$(function(){
    var navbar = $('.topBar');

    animateTopBar(navbar, $(window).scrollTop());

    $(window).scroll(function() {
        var scrollPos = $(window).scrollTop();
        animateTopBar(navbar, scrollPos);
    });
});

function animateTopBar(element, scrollPos) {
    if(scrollPos <= 40) {
        element.removeClass('topBar-scroll');
    } else if(scrollPos > 100) {
        element.addClass('topBar-scroll');
    }
}
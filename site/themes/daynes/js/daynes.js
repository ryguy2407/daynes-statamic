$(function(){
    var navbar = $('.topBar');

    animateTopBar(navbar, $(window).scrollTop());

    $(window).scroll(function() {
        var scrollPos = $(window).scrollTop();
        animateTopBar(navbar, scrollPos);
    });
});

function animateTopBar(element, scrollPos) {
    if(scrollPos <= 10) {
        element.removeClass('topBar-scroll');
    } else if(scrollPos > 70) {
        element.addClass('topBar-scroll');
    }
}
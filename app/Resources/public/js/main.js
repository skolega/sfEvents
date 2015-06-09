$(document).ready(function () {

    $('.event-thumbnail').mouseover(function () {
        $(this).child('.mouseover').removeClass('hide');
    });
    $('.event-thumbnail').mouseleave(function () {
        $(this).child('.mouseover').addClass('hide');
    });
    
    
});
$(".glyphicon-globe").click(function (){
    $.get('/hide/notification');
    $('.info-badge').css('display', 'none');
});
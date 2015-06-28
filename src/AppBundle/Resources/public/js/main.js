//$(document).ready(function () {
//
//    $('.event-thumbnail').mouseover(function () {
//        $(this).child('.mouseover').removeClass('hide');
//    });
//    $('.event-thumbnail').mouseleave(function () {
//        $(this).child('.mouseover').addClass('hide');
//    });
//    
//    
//});

var hideNotificationsPath = $('.notifications').attr('data-path');
$(".notifications").click(function () {
    $('html').load(hideNotificationsPath);
    $('.glyphicon-globe .info-badge').css('display', 'none');
});
var hideMessagesPath = $('.messages').attr('data-path');
$(".messages").click(function () {
    $('html').load(hideMessagesPath);
    $('.badge-message .info-badge').css('display', 'none');
});

$(function () {
    $("#datepicker").datepicker();
});

$(function () {

    $("#tags").autocomplete({
        source: availableTags
    });
});

$("#tags").click(function () {
    $(this).attr('autocomplete', 'on');
});

$('.calendar_active').hover(function () {
    $(this).html()
});
$(document).ready(function () {
    console.log("Document is ready");
    $('.nav-item a ').click(function(e) {

        $('.nav li.active').removeClass('active');

        var $parent = $(this).parent();
        $parent.addClass('active');
        e.preventDefault();
    });
});
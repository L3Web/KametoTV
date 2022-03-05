$(document).ready(function () {
    console.log("Document is ready");
    let current = location.pathname;
    $('.nav-item a').each(function(){
        let $this = $(this);
        // if the current path is like this link, make it active
        if($this.attr('href').indexOf(current) !== -1){
            $('.active').removeClass('active');
            $this.addClass('active');
        }
    })
    /*
    $('.nav-item a ').click(function(e) {

        $('.nav li.active').removeClass('active');

        let $parent = $(this).parent();
        $parent.addClass('active');
        e.preventDefault();
    });
    */
});
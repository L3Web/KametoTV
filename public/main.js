$(document).ready(function () {
    console.log("Document is ready");
    let current = "/index.php"+location.pathname;
    $('.nav-item a').each(function(){
        let $this = $(this);
        // if the current path is like this link, make it active
        console.log($this.attr('href') +" "+ current);
        console.log($this.attr('href') === current);
        if($this.attr('href') === current){
            $('.active').removeClass('active');
            $this.addClass('active');
        }
    })
});
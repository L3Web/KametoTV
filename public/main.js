$(document).ready(function () {
    console.log("Document is ready");
    let current = location.pathname;
    $('.url a').each(function () {
        let $this = $(this);
        // if the current path is like this link, make it active
        console.log($this.attr('href') + " is equal to " + current + " ? ");
        console.log($this.attr('href') === current);
        if ($this.attr('href') === current) {
            $this.parent().addClass('active');
            return false;
        }
    })

    $(document).on('click', '.roleManagement', function (e) {
        e.stopPropagation();
    });
});
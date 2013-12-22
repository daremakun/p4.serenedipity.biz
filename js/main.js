
$(document).ready(function() {
    $(".navbar-collapse collapse li").on("click", function() {
        $(".navbar-collapse collapse li").removeClass("active");
        $(this).addClass("active");
    });
});

$('[data-rel=popover]').popover({
	trigger : 'focus'
});


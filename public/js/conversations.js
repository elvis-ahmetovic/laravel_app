$(document).ready(function() {

    $("#close-conversations").click(function() {
        $(".private-messages").removeClass("toggled");
    });
    $("#show-conversations").click(function() {
        $(".private-messages").addClass("toggled");
    });
});

$(function(){
    $(window).click(function(event) {
        var sidebar = $(".control-sidebar");
        if (
            $(".settingsBtn").has(event.target).length == 0 && !$(".settingsBtn").is(event.target)
            && $(".control-sidebar-tabs").has(event.target).length == 0 && !$(".control-sidebar-tabs").is(event.target)
        ){
            $(".control-sidebar").removeClass("control-sidebar-open")
        }
    });
})
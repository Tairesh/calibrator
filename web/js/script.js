
if (typeof VK !== 'undefined') {
    VK.init({apiId: 4540646});
}

$(function () {
    if (typeof VK !== 'undefined') {
        setInterval(function () {
            var newheight = $(document.body).height();
            if (newheight < 600) newheight = 600;

            VK.callMethod("resizeWindow", 1000, newheight);
        }, 500);
    }
//    if (self.parent.frames.length === 0) { // мы не в приложении вк
//        $('#account_settings_button').show();
//    }
})
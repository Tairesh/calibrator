
if (typeof VK !== 'undefined') {
    VK.init({apiId: 4540646});
}

$(function () {
    if (typeof VK !== 'undefined') {
        setInterval(function () {
            var newheight = $('#main-container').height();
            VK.callMethod("resizeWindow", 1000, newheight < 600 ? 600 : newheight);
        }, 500);
    }
//    if (self.parent.frames.length === 0) { // мы не в приложении вк
//        $('#account_settings_button').show();
//    }
})
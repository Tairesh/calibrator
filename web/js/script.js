
if (typeof VK !== 'undefined') {
    VK.init({apiId: 4540646});
}

function resizeVkAppWindow() {
    if (typeof VK !== 'undefined') {
        var newheight = $('#main-container').height();
        VK.callMethod("resizeWindow", 1000, newheight < 600 ? 600 : newheight);
    }
}

$(function () {    
    if (typeof VK !== 'undefined') {
        setInterval(resizeVkAppWindow, 500);
        $.ajaxStop(resizeVkAppWindow);
    }
//    if (self.parent.frames.length === 0) { // мы не в приложении вк
//        $('#account_settings_button').show();
//    }
})
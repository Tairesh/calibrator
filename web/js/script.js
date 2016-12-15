
function resizeVkAppWindow() {
    if (typeof VK !== 'undefined') {
        var newheight = $('#main-container').height();
        VK.callMethod("resizeWindow", 1000, newheight < 600 ? 600 : newheight);
    }
}

function numberWithCommas(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
}

$(function () {
    if (self.parent != self) { // мы в приложении вк    
        if (typeof VK !== 'undefined') {
            
            VK.init({apiId: 4540646});
            
            setInterval(resizeVkAppWindow, 500);
            $.ajaxStop(resizeVkAppWindow);
        }
    }
    
    $('.commas-input').on('keyup', function(){
        $(this).val(numberWithCommas($(this).val().replace(/\s/g,'')));
    });
})

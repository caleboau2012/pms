iframe = $('#report_iframe');
var iframeStyle = false;
function setiframeHeight() {
    var frameHTML = iframe.contents().find('html');
    var height = frameHTML.height()+500;
    iframe.attr('height',height ); //extra 20 for extreme buggy overflow cases
    if(!iframeStyle) {
        document.write('<style id="iframeStyle" type="text/css" media="print"></style>');
        iframeStyle = true;
    }
    $('#iframeStyle').html('.report_iframe { height: '+height+' !important;}');
}
(function(){
    setiframeHeight();
})(jQuery);

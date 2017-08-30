window.fbAsyncInit = function() {
    FB.init({
        appId      : '127814224492163',
        xfbml      : true,
        version    : 'v2.8'
    });
};
$(document).on("click", ".share-facebook", function (e) {
    e.preventDefault();
});
$(document).on("click", ".share-facebook", function (e) {
    FB.ui({
        method: 'share',
        display: 'popup',
        href: this.href,
    }, function(response){});
});
$(document).on("click", ".share-google", function (e) {
    e.preventDefault();
    window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;
});

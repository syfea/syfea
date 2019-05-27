// manage the picture in the edit or create form
jQuery("form #article_image").change(function () {
    var src = jQuery("form #article_image option:selected").text();
    jQuery('#picture').attr("src", src);
    jQuery('#picture').attr("alt", src);
});
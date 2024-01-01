$(function () {
    console.log( 'hello world');
    if ($('.tiny-mce').length) {
        window.setupTinyMce();
    }
})

window.setupTinyMce = function () {
    tinymce.init({
        selector: 'textarea',
        plugins: ' anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount,accordion,fullscreen,quickbars,advlist',
        toolbar: 'undo redo fullscreen| blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight  | numlist bullist indent outdent | emoticons charmap | removeformat accordion',
        fullscreen_native : true,
    });
}


window.setupTinyMceAll = function () {
    tinymce.init({
        selector: '.tiny-mce',
        inline : true,
        menubar : false,
    })
}

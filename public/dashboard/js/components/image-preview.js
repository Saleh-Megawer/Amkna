$(document).ready(function () {
    /**
     * Preview the image before uploading it to the server and previewing it
     */
    function previewImageBeforeUpload(inputFile, imgSrc) {
        $(inputFile).change(function (e) {
            e.preventDefault();
            let src = URL.createObjectURL(e.currentTarget.files[0]);
            $(imgSrc).attr("src", src);
        });
    }

    /**
     * Add New Review Page
     */
    previewImageBeforeUpload(".input-img", ".img");
    previewImageBeforeUpload(".input-logo", ".img-logo");
    previewImageBeforeUpload(".input-fat-logo", ".img-fat-logo");


    //about page
    previewImageBeforeUpload(".input-about-bg", ".bg-img");


    /**
     * Preview the image before uploading it to the server and previewing it
     */
    function previewBgBeforeUpload(inputFile, imgSrc) {
        $(inputFile).change(function (e) {
            e.preventDefault();
            let src = URL.createObjectURL(e.currentTarget.files[0]);
            $(imgSrc).css("background-image", "url(" + src + ")");
        });
    }

    previewBgBeforeUpload(".input-bg", ".bg");


});

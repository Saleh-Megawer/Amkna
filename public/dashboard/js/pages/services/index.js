$(document).ready(function () {

    /* Create */
    $('#btn-add-new-item').click(function (e) {
        e.preventDefault();
        $('.items').append(`<div class="row item"><div class="col-12"><hr></div><div class="col-md-5"><div class="form-group"><label class="required">أيقونة الخدمة<b style="font-size:20px;display:inline-block;height:30px" class="text-danger pr-1 font-weight-bold">*</b></label><input type="file" name="icon_image[]" value="" data-name="icon_image" data-laravel-translatable="icon_image--lara-trans-error" class="input-img" accept="image/*" required=""></div></div><div class="col-md-7"><div class="form-group"><label class="required">اسم الخدمة<b style="font-size:20px;display:inline-block;height:30px" class="text-danger pr-1 font-weight-bold">*</b></label><input type="text" name="title[]" value="" data-name="title" data-laravel-translatable="title--lara-trans-error" required=""></div></div><div class="btn-remove-item not-first-btn"><svg class="svg-inline--fa fa-trash-can" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-can" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"></path></svg></div><div class="col-md-12"><div class="form-group"><label class="required">وصف الخدمة<b style="font-size:20px;display:inline-block;height:30px" class="text-danger pr-1 font-weight-bold">*</b></label><textarea name="desc[]" id="desc[]" data-name="desc" data-laravel-translatable="desc--lara-trans-error" rows="4" required=""></textarea></div></div></div>`);

        removeItem();
    });

    function removeItem() {
        $('.btn-remove-item').click(function (e) {
            $(this).parents('.item').remove();
        });
    }
    removeItem();




});

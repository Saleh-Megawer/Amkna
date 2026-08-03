$(document).ready(function () {
    const propertyUUID = $('meta[name="property-uuid"]').attr('content');

    $(".btn-edit-item").click(function (e) {
        let btn = $(this),
            unitId = btn.attr("data-id"),
            model = $("#update-form");
        $.get(
            `${adminUrl}/properties/${propertyUUID}/units/${unitId}`,
            function (row, textStatus, jqXHR) {

                if (!model.find('input[name="_method"]').length) {
                    model.append('<input type="hidden" name="_method" value="PATCH">');
                } else {
                    model.find('input[name="_method"]').val('PATCH');
                }

                //
                model.find('input[name="item_id"]').val(row.id);
                //
                model.find('input[name="unit_number"]').val(row.unit_number);
                //
                model.find('input[name="area"]').val(row.area);
                //
                model.find('input[name="price"]').val(row.price);
                //
                model.find('input[name="bedrooms"]').val(row.bedrooms);
                //
                model.find('input[name="bathrooms"]').val(row.bathrooms);
                // Set Image Src
                $(".item-edit-image").attr("src", baseUrl + "/storage/large/properties/units/" + row.image);
                $('.image-container').show();

                // Update Action
                model.attr("action", `${adminUrl}/properties/${propertyUUID}/units/${unitId}`);
                // Update Model Name
                model.find("button").text("تحديث النموذج");
                // Update Panel Name
                $(".box-title").text("تحديث النموذج");
                // Rempve Label Star
                $(".item-image-input .form-group")
                    .find('input[name="image"]')
                    .removeAttr("required");
                $(".item-image-input .form-group").find("label b").remove();
            },
            "json"
        );
    });

});
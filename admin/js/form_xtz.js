var $=jQuery.noConflict();
$(document).ready(function () {


    function is_checked_position($check, $block) {
        if ($check.val() == "left_center" || $check.val() == "right_center") {
            $block.hide();
        } else {
            $block.show();
        }
    }


    var viber = new IMask(
        document.getElementById("validate_viber"),
        {
            mask: "+num",
            blocks: {
                num: {
                    mask: Number,
                    thousandsSeparator:  " "
                }
            }
        });

    var whatsapp = new IMask(
        document.getElementById("validate_whatsapp"),
        {
            mask: "num",
            blocks: {
                num: {
                    mask: Number,
                    thousandsSeparator: " "
                }
            }
        });



    $('input[type="checkbox"]').click(function(){


        if($(this).is(":checked") == true) {
            $(this).val(1);
        } else {
            $(this).val(0);
        }


        var input_id = $(this).attr('data-name');
        $('input[name='+"'"+input_id+"'"+']').val($(this).val());

    });

});
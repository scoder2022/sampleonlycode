<script src="{{ asset('admins/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('admins/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admins/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<script src="{{ asset('admins/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script>
    $(document).ready(function () {
        //Colorpicker
    // $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker();
        $.validator.addMethod("custom_rule", function (value, element, param) {
            if (value == 1) {
                return true;
            } else if (value == 0) {
                return true;
            } else {
                return false;
            }
        }, "You must enter {0}");

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;

        $(".next").click(function () {

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            $('#msform').validate({
                rules: {
                    approved: {
                        required: true,
                    },
                    category: {
                        required: true,
                    },
                    price: {
                        required: function () {

                            var newVal = $('input[name="price"]').val();
                            var regexp = /^(0|[1-9]+[0-9]*)$/;
                            if (regexp.test(newVal))
                                return true;
                        }
                    },
                    quantity: {
                        required: true,
                        number: true,
                        maxlength: 6
                    },
                    image: {
                        extension: "jpg,jpeg,png,gif,raw",
                    },
                },
                messages: {
                    name: {
                        required: "Product Name is required",
                        email: "Please enter a vaild email address"
                    },
                    category: {
                        required: "Please select a category",
                        minlength: "Your password must be at least 5 characters long"
                    },
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            if ((!$('#msform').valid())) {
                return false;
            }

            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function (now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 600
            });
        });

        $(".previous").click(function () {

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function (now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 600
            });
        });

        $("#submit").click(function () {
            console.log($('#msform').valid());
            if ($('#msform').valid()) {
                $('#msform').submit();
            }
            alert('something went wrong');
        });


        $('.radio-group .radio').click(function () {
            $(this).parent().find('.radio').removeClass('selected');
            $(this).addClass('selected');
        });
        //iCheck for checkbox and radio inputs
        $('.select2').select2();
    });

</script>



<script>
    CKEDITOR.replace('short_description', {
        height: 300,
        filebrowserUploadUrl: "{{route('admin.ckeditor.image-upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    $('#attribute_loader_wrapper').on('click', '.remove_attr', function () {
        $(this).closest('tr').remove();
    });

    $('#attributes_add').click(function () {
        if (typeof count !== 'undefined') {
            // the variable is defined
            count = count + 1;
        } else {
            count = 1;
        }
        $('#attribute_loader_wrapper').append(
            '<tr>\n' +
            '<td>' + count + '</td>\n' +
            '<td><input type="text" name="sku[]"></td>\n' +
            '<td><select class="form-control valid" name="size[]" aria-invalid="false"><option selected disabled>Size</option><option value="xs">Extra Small</option><option value="s">Small</option><option value="m">Medium</option><option value="l">Large</option><option value="xl">Extra Large</option></select></td>\n' +
            '<td><div class="form-group"><div class="input-group"><input type="text" name="color[]"  class="form-control my-colorpicker2 colorpicker-element" data-colorpicker-id="1" data-original-title=""><div class="input-group-addon"><i></i></div></div></div></td>\n' +
            '<td><input type="text" name="prices[]"></td>\n' +
            '<td><div class="visible-md visible-lg hidden-sm hidden-xs btn-group">\n' +
            '<button type="button" class="btn btn-xs btn-danger remove_attr">\n' +
            '<i class="fa fa-times"></i></button></div></td></tr>\n'
        );

    });

    jQuery(document).on('click', '.destroy-image', function (e) {
        jQuery(e.target).parents('.image-preview:first').remove();
    });


    $('body').on('click', '.is_main_image_button', function () {
        $('.is_main_image_hidden_field').val(0);
        $('.is_main_image_button').removeClass('active');
        $(this).find('.is_main_image_hidden_field').val(1);
        $(this).addClass('active');
    });



    function loadPreview(input) {
        var data = $(input)[0].files; //this file data
        console.log($(input));
        $.each(data, function (index, file) {
            if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) {
                var fRead = new FileReader();
                fRead.onload = (function (file) {
                    return function (e) {
                        var html =
                            '<img class="img-thumbnail img-tag img-responsive" style="width:100px;height:100px" src="' +
                            e.target.result + '"></div>' +
                            '' +
                            '<span class="selected_images"><button type="button" class="btn btn-xs btn-primary is_main_image_button selected-icon" title="Select as main image">' +
                            '<i class="fa fa-check"></i><input type="hidden" value="0" name="is_main[]" class="is_main_image_hidden_field"></button><button type="button" class="btn btn-xs btn-danger destroy-image" title="Remove file"><i class="fa fa-trash-o"></i></button></span>';
                        //create image thumb element
                        $('#thumb-output').append(html);
                    };
                })(file);
                fRead.readAsDataURL(file);
            }
        });
    }


    function generateRandomInteger() {
        return Math.floor(Math.random() * 90000) + 10000;
    }

    jQuery(document).on('click', '.btn-delete-color', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.closest("tr").remove();
    });

    $(document).ready(function () {
        jQuery(document).on('click', '.btn-add-color', function (e) {
            e.preventDefault();
            var lastRow = $('table.table-colors > tbody > tr').last().attr('data-row');
            var counter = lastRow ? parseInt(lastRow) + 1 : 1;
            var randomInteger = generateRandomInteger();
            var newRow = jQuery('<tr data-row="' + counter + '">' +
                '<td>' + counter + '</td>' +
                '<td><input type="number" name="additionals[quantity][' + randomInteger +
                ']" class="form-control" required row="2"/></td>' +
                '<td><input type="text" name="additionals[size][' + randomInteger +
                ']" class="form-control" required/></td>' +
                '<td><button type="button" class="btn btn-danger btn-xs btn-delete-color" data-color=""><i class="fa fa-trash"></i></button></td>' +
                '</tr>');
            jQuery('table.table-colors').append(newRow);
        });


        $("input[data-bootstrap-switch]").each(function () {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $(document).on("click", ".category-product", function (e) {
            e.preventDefault();
            var $this = $(this);
            document.getElementById("category_id").value = $this.attr('data-category');
            document.getElementById("category_name").value = $this.attr('data-name');

        });
    });

    function showThumbnail(file_elem, target) {
        if (file_elem.files && file_elem.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#' + target).attr('src', e.target.result).css("width", "290px");
                $('#thumb_a').attr('href', e.target.result);
                // $('selecteddiv').attr('src',e.selecteddiv.result);
            }
            reader.readAsDataURL(file_elem.files[0]);
        }
    }

</script>

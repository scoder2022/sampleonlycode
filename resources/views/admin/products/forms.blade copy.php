@extends('admin.all.layout')
@push('styles')
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('admins/plugins/iCheck/all.css') }}">

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admins/bower_components/select2/dist/css/select2.min.css') }}">

<style>/*custom font*/
    @import url(http://fonts.googleapis.com/css?family=Montserrat);

    /*basic reset*/
    * {margin: 0; padding: 0;}


    body {

        height: 100%;
        /*Image only BG fallback*/
        background: url(images/geometry.png);
        font-family: montserrat, arial, verdana;
        font-size: 13px;
    }


    /* Header */


    #header {

        width: 1200px;
        margin: 0 auto;
        height: 10px;

    }


    #logo {

        width: 1200px;
        height: 0px;		/* top navigation bar position */
        margin: 0 auto;
        padding: 0px;

    }


    #logo h1 {

        float: left;
        margin: 0;
        color: #000000;
        margin-top: 0;
        text-transform: uppercase;
        color: #528DC8;
        padding: 5px 0 0 0;
        letter-spacing: -1px;
        text-transform: uppercase;
        font-weight: normal;
        font-size: 2.5em;

    }


    #logo p {

        float: left;
        margin: 0;
        color: #000000;
        text-transform: lowercase;
        padding: 23px 0 0 10px;
        font-size: 12px;
        color: #000000;

    }


    #logo span {

        color: #000000;
        text-transform: uppercase;

    }


    /* Menu */


    #menu {

        margin: 0px auto;
        padding: 0px;
        height: 53px;

    }


    #menu ul {

        margin: 0px;
        padding: 0px;
        list-style: none;
        float: right;

    }


    #menu li {

        display: inline;

    }


    #menu a {

        display: block;
        float: left;
        height: 33px;
        font-weight: normal;
        margin: 0px;
        padding: 19px 30px 0px 30px;
        text-decoration: none;
        text-transform: capitalize;
        background: url(images/img03.jpg) no-repeat right 50%;
        font-size: 1.1em;
        color: #528DC8;

    }


    #menu a:hover {

        color: #000000;

    }


    /* Form Styles */


    #msform {

        width: 900px;
        margin: 50px auto;
        text-align: center;
        position: relative;

    }


    #msform fieldset {

        background: white;
        border: 0 none;
        border-radius: 3px;
        box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.4);
        padding: 20px 30px;
        box-sizing: border-box;
        width: 80%;
        margin: 0 10%;

        /* stacking fieldsets above each other */
        position: absolute;

    }


    /* Hide all except first fieldset */
    #msform fieldset:not(:first-of-type) {

        display: none;

    }


    /* Inputs */


    #msform input, #msform textarea {

        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-bottom: 10px;
        width: 100%;
        box-sizing: border-box;
        font-family: montserrat;
        color: #2C3E50;
        font-size: 13px;

    }


    /* Buttons */


    #msform .action-button {

        width: 100px;
        background: #27AE60;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 1px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px;

    }


    #msform .action-button:hover, #msform .action-button:focus {

        box-shadow: 0 0 0 2px white, 0 0 0 3px #27AE60;

    }


    /* Headings */


    .fs-title {

        font-size: 15px;
        text-transform: uppercase;
        color: #2C3E50;
        margin-bottom: 10px;

    }


    /* Progressbar */


    #progressbar {

        margin-bottom: 30px;
        overflow: hidden;
        /* CSS counters to number the steps */
        counter-reset: step;

    }


    #progressbar li {

        list-style-type: none;
        color: #000000;
        text-transform: uppercase;
        font-size: 9px;
        width: 33.33%;
        float: left;
        position: relative;

    }


    #progressbar li:before {

        content: counter(step);
        counter-increment: step;
        width: 20px;
        line-height: 20px;
        display: block;
        font-size: 10px;
        color: white;
        background: #000000;
        border-radius: 3px;
        margin: 0 auto 5px auto;

    }


    /* Progressbar Connectors */


    #progressbar li:after {

        content: '';
        width: 100%;
        height: 2px;
        background: #000000;
        position: absolute;
        left: -50%;
        top: 9px;
        z-index: -1; /* put it behind the numbers */

    }


    #progressbar li:first-child:after {

        /* connector not needed before the first step */
        content: none;

    }


    /* marking active/completed steps green */
    /* The number of the step and the connector before it = green */
    #progressbar li.active:before,  #progressbar li.active:after {

        background: #27AE60;
        color: #000000;

    }


    /* Required fields */


    .error {

        color: #FF0000;
        font-size: 12px;

    }

    #form {

        padding: 10px;

    }




</style>
@endpush

@section('content')<form id="msform" action="" method="POST">
    <!-- progressbar -->
    <ul id="progressbar">
        <li class="active">Upload Video Lecture</li>
        <li>Upload Lecture Notes</li>
        <li>Upload Screenshot</li>
    </ul>
    <!-- fieldsets -->
    <fieldset>
        <h2 class="fs-title">Upload Video Lecture</h2>
        <div id="form">
            <input type="file" name="videoFile" />
            <input type="text" name="videoTitle" placeholder="Video Lecture Title" required />
            <textarea name="videoDescription" rows="6" placeholder="Description" required></textarea>
        </div>
            <input type="button" name="next" class="next action-button" value="Upload" />
    </fieldset>
    <fieldset>
        <h2 class="fs-title">Upload Lecture Notes</h2>
        <div id="form">
            <input type="file" name="notesFile" />
            <input type="text" name="notesTitle" placeholder="Lecture Notes Title" />
            <textarea name="notesDescription" rows="6" placeholder="Description"></textarea>
        </div>
            <input type="button" name="previous" class="previous action-button" value="Previous" />
            <input type="button" name="next" class="next action-button" value="Upload" />
    </fieldset>
</form>
@endsection

@push('scripts')

<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<!-- iCheck 1.0.1 -->
<script src="{{ asset('admins/plugins/iCheck/icheck.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('admins/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script>

$(document).ready(function () {

    var current_fs, next_fs, previous_fs; //fieldsets
    var left, opacity, scale; //fieldset properties which we will animate
    var animating; //flag to prevent quick multi-click glitches

    $(".next").click(function () {

    	$('#msform').validate({
			rules: {
				videoFile: {
   					required: true,
    				extension:'mov|mp4|mpeg|wmv'
    			},
    			videoTitle: {
    				required: true,
    			},
    			videoDescription: {
    				required: true,
    			}
    		},
    		messages: {
    			videoFile: "Please specify a file",
				videoTitle: "Title is required",
				videoDescription: "Description is required"
			}
	    });

		if ((!$('#msform').valid())) {
       		return false;
    	}

        if (animating) return false;
        animating = true;

        current_fs = $(this).parent();				//fieldset
        next_fs = $(this).parent().next();			//next fieldset

        //activate next step on progressbar using the index of next_fs
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({
            opacity: 0
        }, {
            step: function (now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale current_fs down to 80%
                scale = 1 - (1 - now) * 0.2;
                //2. bring next_fs from the right(50%)
                left = (now * 50) + "%";
                //3. increase opacity of next_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({
                    'transform': 'scale(' + scale + ')'
                });
                next_fs.css({
                    'left': left,
                    'opacity': opacity
                });
            },
            duration: 800,
            complete: function () {
                current_fs.hide();
                animating = false;
            },
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
    });

    $(".previous").click(function () {
        if (animating) return false;
        animating = true;

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        //de-activate current step on progressbar
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();
        //hide the current fieldset with style
        current_fs.animate({
            opacity: 0
        }, {
            step: function (now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale previous_fs from 80% to 100%
                scale = 0.8 + (1 - now) * 0.2;
                //2. take current_fs to the right(50%) - from 0%
                left = ((1 - now) * 50) + "%";
                //3. increase opacity of previous_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({
                    'left': left
                });
                previous_fs.css({
                    'transform': 'scale(' + scale + ')',
                    'opacity': opacity
                });
            },
            duration: 800,
            complete: function () {
                current_fs.hide();
                animating = false;
            },
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
    });


    $(".submit").click(function () {
        return false;
    });
});

</script>

<script type="text/javascript">
    CKEDITOR.replace('.ckeditor', {
        filebrowserUploadUrl: "{{route('admin.ckeditor.image-upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({

        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    })
</script>


<script>
    jQuery(document).on('click', '.destroy-image', function (e) {
        jQuery(e.target).parents('.image-preview:first').remove();
    });


    jQuery(document).on('click', '.is_main_image_button', function (e) {
        e.preventDefault();

        jQuery('.is_main_image_button').removeClass('active');
        jQuery('.is_main_image_hidden_field').val(0);


        if (jQuery(this).hasClass('active')) {

            jQuery(this).removeClass('active');
            jQuery(this).parents('.image-preview').find('.is_main_image_hidden_field').val(0);
        } else {
            jQuery(this).addClass('active');
            jQuery(this).parents('.image-preview').find('.is_main_image_hidden_field').val(1);
        }

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
                            '<div class="image-preview"><div class="actual-image-thumbnail">' +
                            '<img class="img-thumbnail img-tag img-responsive" style="width:160px;height:160px" src="' +
                            e.target.result + '"></div>' +
                            '<div class="image-info"><div class="actions"><div class="action-buttons">' +
                            '<input type="hidden" value="0" name="images[]" class="is_main_image_hidden_field"> <button type="button" class="btn btn-xs btn-info is_main_image_button selected-icon" title="Select as main image">' +
                            '<i class="fa fa-check"></i></button><button type="button" class="btn btn-xs btn-danger destroy-image" title="Remove file"><i class="fa fa-trash"></i></button>' +
                            '</div></div></div></div>';
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
        console.log('called');
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
@endpush

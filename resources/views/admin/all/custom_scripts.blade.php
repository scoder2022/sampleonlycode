<script>
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

    function loadStatus(){
                $('.status').change(function(){
                    var id = $(this).attr('data-id');
                    var forc = $(this).attr('data-forc');
                    if($(this).prop("checked")){
                    var status = "1";
                    }else{
                    var status = "0";
                    }
                    $.ajax({
                    method:'Post',
                    url:'{{ route('admin.status_changes') }}',
                    data:{
                        _token:'{{ csrf_token() }}',
                        id:id,
                        forc:forc,
                        status:status,
                    },
                    success: function (response) {
                        var data = $.parseJSON(response);
                        if(data.error){
                        alert("sorry refresh and try again");
                        }else{
                        swal("Updated",data.message, "success");
                        }
                    },
                    error:function (a,b,c) {
                        alert('sorry refresh and try again');
                    }
                    });
                });
            }
</script>

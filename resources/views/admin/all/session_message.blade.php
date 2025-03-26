{{--
@if (Request::session()->has('message'))
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        {!! Request::session()->get('message') !!}
        <br>
    </div>
@endif
--}}
@php $message = ''; $div = ''; @endphp
@if(Request::session()->has('success'))
    @php
        $div = 'flashm alert alert-success text-center';
        $message = Request::session()->get('success');
    @endphp
    @elseif(Request::session()->has('error'))
    @php
        $div = 'flashm alert alert-danger text-center';
        $message = Request::session()->get('error');
    @endphp
    @endif
@if($message)
<div class="{!! isset($div)?$div:''  !!}">
    <button type="button" class="close" data-dismiss="alert">
        <i class="icon-remove"></i>
    </button>
    {!! isset($message) ? $message : '' !!}
    <br>
</div>
<script type="text/javascript">
    setTimeout(function(){
        $('.flashm').slideUp('slow');
    }, 5000);
</script>
@endif


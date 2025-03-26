@extends('admin.all.layout')
@push('styles')
    @include('admin.users.includes.styles')
@endpush
@section('content')
<div class="container">
    <div class="team-single">
        <div class="row">
            <div class="col-lg-4 col-md-5 xs-margin-30px-bottom">
                <div class="team-single-img">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="">
                </div>
                {{-- <div class="bg-light-gray padding-30px-all md-padding-25px-all sm-padding-20px-all ">
                    <h4 class="margin-10px-bottom font-size24 md-font-size22 sm-font-size20 font-weight-600">Class Teacher</h4>
                    <p class="sm-width-95 sm-margin-auto">We are proud of child student. We teaching great activities and best program for your kids.</p>
                    <div class="margin-20px-top team-single-icons">
                        <ul class="no-margin">
                            <li><a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="fab fa-google-plus-g"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div> --}}
            </div>

            <div class="col-lg-8 col-md-7">
                <div class="team-single-text padding-50px-left sm-no-padding-left">
                    <h4 class="font-size38 sm-font-size32 xs-font-size30">Buckle Giarza</h4>
                    <p class="no-margin-bottom">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum voluptatem.</p>
                    <div class="contact-info-section margin-40px-tb">
                        <ul class="list-style9 no-margin">

                            <li>
                                <div class="row">
                                    <div class="col-md-5 col-5">
                                        <strong class="margin-10px-left ">UserName:</strong>
                                    </div>
                                    <div class="col-md-7 col-7">
                                        <p>{{ $data->username }}</p>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="row">
                                    <div class="col-md-5 col-5">
                                        <strong class="margin-10px-left ">Full Name:</strong>
                                    </div>
                                    <div class="col-md-7 col-7">
                                        <p>{{ $data->full_name }}</p>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>

            <div class="col-md-12">

            </div>
        </div>
    </div>
</div>
@endsection

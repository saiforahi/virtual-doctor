@extends('layouts.backend.app')

@section('title','Create Features')

@push('css')
<link href="{{asset('public/assets/backend/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
@endpush

@section('content')

<div class="container-fluid">
    <!-- Tabs With Icon Title -->
    
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Update Features
                    </h2>                    
                </div>
                <div class="body">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="body">
                                <form method="POST" action="{{ route('features.update',$features->id) }}" class="form-horizontal" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="name">Features Name </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="name" class="form-control" placeholder="Type name" name="name" value="{{ $features->name }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="name">Features Title </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="title" class="form-control" placeholder="Type title" name="title" value="{{ $features->title }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="title">Featured Image</label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <input type="file" name="image">
                                        </div>
                                        </div>
                                    </div> -->

                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="name">Feature Image </label>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail img-holder">
                                                        <img id="blah"
                                                            src=" @if(is_null($features->image)) {{ url('storage/app/public/default.png') }} @else {{ url('storage/app/public/features/' . $features->image) }} @endif "
                                                            alt="features image" height="64" width="64">

                                                        <input type="checkbox" class="form-check-input" checked
                                                            name="is_image" id="exampleCheck1"
                                                            style="height: 30px;width: 30px">
                                                    </div>
                                                    <input class="form-control" type="file" name="image"
                                                        id="imgInp">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card">
                                                <div class="header">
                                                    <h2>
                                                         Description
                                                    </h2>
                                                </div>
                                                <div class="body">
                                                    <textarea id="tinymce" name="description">{{ $features->description }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="row clearfix">
                                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                             <a href="{{route('features.index')}}" style="text-decoration: none;">
                                                    <button type="button" class="btn btn-danger m-t-15 waves-effect">CANCEL</button>
                                                    </a>
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                    </div>
                </div>                    
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Tabs With Icon Title -->
</div>
        
@endsection

@push('js')

<script src="{{ asset('public/assets/backend/plugins/tinymce/tinymce.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            //TinyMCE
            tinymce.init({
                selector: "textarea#tinymce",
                theme: "modern",
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                image_advtab: true
            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{ asset('public/assets/backend/plugins/tinymce')}}';
        });
    </script>
<script>
function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function() {
            readURL(this);
        });
</script>
@endpush
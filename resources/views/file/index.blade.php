@extends('layouts.backend.app')
@section('title','File Upload')

@push('css')
<link href="{{ asset('public/css/dropzone.css') }}" rel="stylesheet">
<link href="{{ asset('public/css/dataTables.bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('public/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endpush
@section('content')
<div class="container">
	@if(session('success'))
		<div class="alert alert-success">
			<strong>{{ session('success') }}</strong>
		</div>
	@endif
	<p>
		<a href="{{ route('formfile') }}" class="btn btn-primary">Upload File</a>
	</p>
	<div class="row">
		@foreach($files as $file)
		<div class="col-md-4">
			<div class="card">
				{{--<img class="card-img-top" src="{{ Storage::url($file->path)}}">--}}
				<div class="card-body">
					<strong class="card-title">{{ $file->title }}</strong>
					<p class="card-text">{{ $file->created_at->diffForHumans() }}</p>
					<form action="{{ route('deletefile', $file->id) }}" method="post">
						@csrf
						@method('DELETE')
						<button type="submit" class="btn btn-danger">Delete</button>
						<a href="{{ route('downloadfile', $file->id) }}" class="btn btn-primary">Download</a>
						<!-- <a href="{{ route('emailfile', $file->id) }}" class="btn btn-success">Email</a> -->
					</form>
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
@endsection
@push('js')
<script src="{{ asset('public/js/dropzone.js') }}"></script>
<script src="{{ asset('public/js/dataTables.bootstrap4.js') }}"></script>

@endpush
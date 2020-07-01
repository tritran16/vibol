@extends('layouts.admin')

@section('content')
    <form method="POST" action="{{route('admin.news.upload_image')}}" enctype="multipart/form-data" >
        @csrf
        <label>Upload Image</label>
        <input type="file" name="image" accept="image/*">
        <button type="submit">Upload</button>
    </form>

@endsection
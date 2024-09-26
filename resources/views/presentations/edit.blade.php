@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Presentation</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('presentations.update', $presentation->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $presentation->title) }}" required>
            </div>

            <div class="form-group">
                <label for="file">Update Presentation File (Optional)</label>
                <input type="file" name="file" class="form-control-file">
                <small>Current File: <a href="{{ asset('storage/' . $presentation->lien) }}" target="_blank">Download</a></small>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Presentation</button>
            <a href="{{ route('presentations.index') }}" class="btn btn-secondary mt-3">Back</a>
        </form>
    </div>
@endsection

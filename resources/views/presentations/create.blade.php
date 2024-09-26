@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Ajouter Presentation</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('presentations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row justify-content-center mb-4">
                <div class="col-md-4">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                <div class="col-md-4">
                    <label for="file">Upload Presentation (PPT, PDF)</label>
                    <input type="file" name="lien" class="form-control" required>
                </div>
            </div>
            <div class="row justify-content-center mb-4">
                <button type="submit" class="btn btn-primary mt-3 col-md-4" style="width: 20%">Ajouter</button>
                <div style="width: 5%"></div>
                <a href="{{ route('presentations.index') }}" class="btn btn-secondary mt-3 col-md-4" style="width: 20%">Back</a>
            </div>
        </form>
    </div>
@endsection

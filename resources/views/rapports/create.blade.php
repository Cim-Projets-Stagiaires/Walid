@extends('layouts.app')

@section('title', 'Create Rapport')

@section('content')
<div class="container">
    <h1>Create Rapport</h1>
    <form action="{{ route('rapports.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="title" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select class="form-select" name="type" id="type" required>
                <option value="semi">Semi Report</option>
                <option value="final">Final Report</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="rapport" class="form-label">Rapport</label>
            <input type="file" class="form-control" name="lien" id="rapport" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Edit Rapport')

@section('content')
<div class="container">
    <h1>Edit Rapport</h1>
    <form action="{{ route('rapports.update', $rapport->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ $rapport->title }}" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select class="form-select" name="type" id="type" required>
                <option value="semi" {{ $rapport->type == 'semi' ? 'selected' : '' }}>Semi Report</option>
                <option value="final" {{ $rapport->type == 'final' ? 'selected' : '' }}>Final Report</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="lien" class="form-label">Rapport</label>
            <input type="file" class="form-control" name="lien" id="lien">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection

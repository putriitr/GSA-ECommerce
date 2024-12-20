@extends('layouts.admin.master')

@section('content')
<div class="container py-5">
    <h1>Edit FAQ</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.faq.update', $faq->id) }}" method="POST">
        @csrf
        @method('PUT')

        <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.8/css/froala_editor.pkgd.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.8/js/froala_editor.pkgd.min.js"></script>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" name="keterangan" id="keterangan" rows="4" required>{{ old('keterangan', $faq->keterangan) }}</textarea>
            @error('keterangan') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <script>
            new FroalaEditor('#keterangan', {
                height: 300
            });
        </script>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
    <div class="row">
        <div class="col-lg-6 mx-auto">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="product-name">Name</label>
                    <input type="text" name="name"
                           value="{{ old('name') }}" class="form-control" id="product-name">
                </div>
                <div class="form-group">
                    <label for="product-code">Code</label>
                    <input name="code"
                           value="{{ old('code') }}" class="form-control" id="product-code">
                </div>

{{--                images upload--}}
                @for ($i = 0; $i < 3; $i++)
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="image-{{ $i }}" class="custom-file-input" id="image-{{ $i }}" accept="image/*" onchange="addPreview(this)">
                            <label class="custom-file-label text-right" for="image-1">Choose image {{ $i + 1 }}</label>
                        </div>
                    </div>
                    <img class="preview-image">
                    <button type="button" class="btn btn-danger btn-delete" onclick="deleteImage({{ $i }})">
                        <i class="fa fa-trash"></i>
                    </button>
                @endfor

                <div class="form-group">
                    <button type="submit" class="btn btn-success float-right">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function addPreview(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // shows preview with delete button
                    const preview = $(input).closest('.input-group').next('.preview-image');
                    preview.attr('src', e.target.result);
                    preview.next('button').show();

                    // changes label
                    $(input).next('label').html(input.files[0]['name']);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        function deleteImage(imageCount) {
            const input = $('#image-' + imageCount);
            input.removeAttr('value');

            // deletes preview, hides button
            const preview = input.closest('.input-group').next('.preview-image');
            preview.removeAttr('src');
            preview.next('button').hide();

            // changes label
            input.next('label').html('Choose image ' + (imageCount + 1));
        }
    </script>
@endpush

@push('styles')
    <style>
        .preview-image {
            max-width: 130px;
            margin: 20px 0;
        }

        .custom-file-label::after {
            left: 0;
            right: auto;
            border-left-width: 0;
            border-right: inherit;
        }

        .btn-delete {
            display: none;
        }
    </style>
@endpush

@extends('layouts.app')

@section('title', $product->name)

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

            <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="article-title">Name</label>
                    <input type="text" name="name"
                           value="{{ $product->name }}" class="form-control" id="product-name">
                </div>
                <div class="form-group">
                    <label for="article-content">Code</label>
                    <input name="code"
                           value="{{ $product->code }}" class="form-control" id="product-code">
                </div>

{{--                images upload--}}
                @for ($i = 0; $i < 3; $i++)
                    @php ($hasImage = isset($images[$i]))
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="image-{{ $i }}" class="custom-file-input" id="image-{{ $i }}" accept="image/*" onchange="addPreview(this)"
                                   {{$hasImage ? 'disabled' : ''}}>
                            <label class="custom-file-label text-right" for="image-1">
                                @if($hasImage)
                                    Delete current image for update
                                @else
                                    Choose image {{ $i+1 }}
                                @endif
                            </label>
                        </div>
                    </div>
                    <img class="preview-image" src="{{ $hasImage ? Storage::url($images[$i]->path) : '' }}">
                    <button type="button" class="btn btn-danger btn-delete" onclick="deleteImage(this, {{ $i }})"
                            style="{{ $hasImage ? 'display: inline-block;' : ''  }}"
                            data-image-id="{{ $hasImage ? $images[$i]->id : '' }}">
                        <i class="fa fa-trash"></i>
                    </button>
                @endfor

                <div class="form-group">
                    <button type="submit" class="btn btn-success float-right">Update</button>
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

        function deleteImage(button, imageCount) {
            button = $(button);
            const imageId = button.data('imageId');
            if (imageId) {
                $.ajax({
                    url: '{{ route('products.deleteImage') }}',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'imageId': imageId
                    },
                    success: function (response) {
                        if (response['success']) {
                            console.log('Image ID=' + imageId + ' successful deleted!');
                            button.removeAttr('data-image-id');
                            deletePreview(button, imageCount);
                        } else {
                            console.log('%c Image ID=' + imageId + ' did not delete!', 'color: red');
                        }
                    }
                });
            } else {
                deletePreview(button, imageCount);
            }
        }

        function deletePreview (button, imageCount) {
            // clears input
            const input = $('#image-' + imageCount);
            input.removeAttr('value disabled');

            // deletes preview
            const preview = input.closest('.input-group').next('.preview-image');
            preview.removeAttr('src');

            // hides button
            button.hide();

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

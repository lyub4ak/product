@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="card">
        <div class="card-body">
            <p><b>name: </b>{{ $product->name }}</p>
            <p><b>code: </b>{{ $product->code }}</p>
            <p>
                @foreach($product->images as $image)
                    <img src="{{ Storage::url($image->path ) }}" style="max-width: 200px;">
                @endforeach
            </p>
        </div>
    </div>
@endsection

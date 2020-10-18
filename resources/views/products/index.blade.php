@extends('layouts.app')

@section('title', 'All products')

@section('content')
    <a href="{{ route('products.create') }}" class="btn btn-success">Create Product</a>

    @if(session()->get('success'))
        <div class="alert alert-success mt-3">
            {{ session()->get('success') }}
        </div>
    @endif

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Code</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <th scope="row">{{ $product->id }}</th>
                    <td style="width: 200px; text-align: center;">
                        @if ($product->images)
                            <img src="{{ isset($product->images[0]) ? Storage::url($product->images[0]->path) : '' }}" style="max-width: 130px;">
                        @endif

                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->code }}</td>
                    <td class="table-buttons">
                        <a href="{{ route('products.show', $product) }}" class="btn btn-success">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
                            <i class="fa fa-pencil" ></i>
                        </a>
                        <form method="POST" action="{{ route('products.destroy', $product) }}" style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                        <a href="{{ route('products.json', $product) }}" class="btn btn-dark">
                            <i class="fa fa-code" ></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

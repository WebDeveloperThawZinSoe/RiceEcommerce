@extends('layouts.admin')

@section('body')
    <div class="container">
        <h1>Edit Product Category</h1>

        <form action="{{ route('admin.product_categories.update', $productCategory->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $productCategory->name }}" required>
            </div>
            <div class="form-group">
                                <label for="order_list">Order <span style="color:gold"> * </span></label>
                                <input type="number" class="form-control" id="order_list" name="order_list" placeholder="Name" value="{{ $productCategory->order_list }}" required>
                            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="description">{{ $productCategory->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="icon" class="form-label">Icon</label>
                <input type="file" name="icon" class="form-control" id="icon">
                @if($productCategory->icon)
                    <img src="{{ asset('images/product_categories/' . $productCategory->icon) }}" width="100" alt="{{ $productCategory->name }}">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update Category</button>
        </form>
    </div>
@endsection

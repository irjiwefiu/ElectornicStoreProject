@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">✏️ Edit Supplier: {{ $supplier->name }}</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" name="name" value="{{ old('name', $supplier->name) }}" class="form-control" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" value="{{ old('email', $supplier->email) }}" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone:</label>
                        <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}" class="form-control">
                    </div>

                    <div class="col-md-12 mb-4">
                        <label for="address" class="form-label">Address:</label>
                        <textarea name="address" class="form-control" style="height:100px">{{ old('address', $supplier->address) }}</textarea>
                    </div>
                </div>

                <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Supplier
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">➕ Add New Supplier</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            
            {{-- Validation Errors --}}
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

            <form action="{{ route('admin.suppliers.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" name="name" class="form-control" placeholder="Supplier Company Name" value="{{ old('name') }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control" placeholder="contact@supplier.com" value="{{ old('email') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone:</label>
                        <input type="text" name="phone" class="form-control" placeholder="123-456-7890" value="{{ old('phone') }}">
                    </div>

                    <div class="col-md-12 mb-4">
                        <label for="address" class="form-label">Address:</label>
                        <textarea name="address" class="form-control" style="height:100px" placeholder="Full Mailing Address">{{ old('address') }}</textarea>
                    </div>
                </div>

                <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Save Supplier
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
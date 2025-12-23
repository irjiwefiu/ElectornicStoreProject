@extends('layouts.app')

@section('page-title', 'Suppliers')

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">🚚 Suppliers</h2>
        <a href="{{ route('admin.suppliers.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            + Add Supplier
        </a>
    </div>

    <table class="w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Name</th>
                <th class="p-2">Phone</th>
                <th class="p-2">Email</th>
                <th class="p-2 text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suppliers as $supplier)
                <tr class="border-t">
                    <td class="p-2">{{ $supplier->name }}</td>
                    <td class="p-2">{{ $supplier->phone }}</td>
                    <td class="p-2">{{ $supplier->email }}</td>
                    <td class="p-2 text-right">
                        <a href="{{ route('admin.suppliers.edit', $supplier->id) }}"
                           class="text-blue-600"><b>Edit</b></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

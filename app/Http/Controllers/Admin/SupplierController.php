<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:suppliers|max:150',
            'phone' => 'nullable|max:20',
            'email' => 'nullable|email|unique:suppliers|max:100',
            'address' => 'nullable|max:255',
        ]);
        Supplier::create($validated);
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier added successfully.');
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|max:150|unique:suppliers,name,' . $supplier->id,
            'phone' => 'nullable|max:20',
            'email' => 'nullable|email|unique:suppliers,email,' . $supplier->id . '|max:100',
            'address' => 'nullable|max:255',
        ]);
        $supplier->update($validated);
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->products()->exists() || $supplier->purchases()->exists()) {
            return back()->with('error', 'Cannot delete supplier with existing products or purchase history.');
        }
        $supplier->delete();
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
}
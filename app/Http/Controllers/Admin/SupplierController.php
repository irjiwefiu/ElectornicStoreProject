<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Supplier; // ✅ Import Alert model
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

        $supplier = Supplier::create($validated);

        // 🔔 Create alert
        Alert::create([
            'title' => 'Supplier Added',
            'message' => "Supplier '{$supplier->name}' has been added.",
            'type' => 'success',
            'is_read' => false,
        ]);

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier added successfully.');
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|max:150|unique:suppliers,name,'.$supplier->id,
            'phone' => 'nullable|max:20',
            'email' => 'nullable|email|unique:suppliers,email,'.$supplier->id.'|max:100',
            'address' => 'nullable|max:255',
        ]);

        $supplier->update($validated);

        // 🔔 Create alert
        Alert::create([
            'title' => 'Supplier Updated',
            'message' => "Supplier '{$supplier->name}' has been updated.",
            'type' => 'info',
            'is_read' => false,
        ]);

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->products()->exists() || $supplier->purchases()->exists()) {
            return back()->with('error', 'Cannot delete supplier with existing products or purchase history.');
        }

        $supplierName = $supplier->name;
        $supplier->delete();

        // 🔔 Create alert
        Alert::create([
            'title' => 'Supplier Deleted',
            'message' => "Supplier '{$supplierName}' has been deleted.",
            'type' => 'warning',
            'is_read' => false,
        ]);

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
}

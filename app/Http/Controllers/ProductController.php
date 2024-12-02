<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('dashboard', compact('products'));
    }

    public function index2()
    {
        $data = Product::all();
        return view('product.index', compact('data'));
        dd($data);
        // $data = Product::orderBy('name', 'asc')->get();


        // return view('dashboard', ['data' => $data]);
        // return view('product.create');
    }

    public function store(Request $request)
    {
        // dd($request);    

        //     // Validasi input
        $request->validate([
            'name' => 'required|string|min:2',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'postal-code' => 'nullable|string|max:20',
            'date-info' => 'nullable|date',
            'grade' => 'nullable|string|in:Grade A,Grade B',
            'file-upload' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:10240', // Maks 10MB
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $data = [
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'description' => $request->input('description'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'region' => $request->input('region'),
            'postal_code' => $request->input('postal-code'),
            'date_info' => $request->input('date-info'),
            'grade' => $request->input('grade'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
        ];

        // Upload dan simpan file jika ada
        if ($request->hasFile('file-upload')) {
            $file = $request->file('file-upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('products', $filename, 'public');
            $data['image'] = $filePath;
        }

        // Simpan data ke database
        Product::create($data);

        //     // Redirect ke halaman produk dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Product added successfully.');
    }

    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'postal-code' => 'nullable|string|max:20',
            'date-info' => 'nullable|date',
            'grade' => 'nullable|string|in:Grade A,Grade B',
            'file-upload' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:10240',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $data = [
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'description' => $request->input('description'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'region' => $request->input('region'),
            'postal_code' => $request->input('postal-code'),
            'date_info' => $request->input('date-info'),
            'grade' => $request->input('grade'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
        ];

        if ($request->hasFile('file-upload')) {
            $file = $request->file('file-upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('products', $filename, 'public');
            $data['image'] = $filePath;
        }

        $product->update($data);
        return redirect()->route('dashboard')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('dashboard')->with('success', 'Product deleted successfully.');
    }
}

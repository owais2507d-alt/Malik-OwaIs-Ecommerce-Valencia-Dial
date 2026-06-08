<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Watch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class WatchController extends Controller
{
    public function index(){
        // all watches list show 
        $watches = Watch::latest()->get();
        return view('admin.watches.index',compact('watches'));

    }

    public function create(){
        return view('admin.watches.create');
    }
//// check validation 
    public function store(Request $request){
        $request->validate([
    'name'        => 'required|string|max:255',
    'brand'       => 'nullable|string|max:255',
    'description' => 'nullable|string',          
    'price'       => 'required|numeric|min:0',
    'stock'       => 'required|integer|min:0',
    'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048' ////maximum 2 mb 
]);

          $imagepath =null;
          /// if admin upload watchec image to save public/watches
          if($request->hasFile('image')){
            $imagepath =$request->file('image')->store('watches','public');
          }
         Watch::create([
    'name'        => $request->name,
    'brand'       => $request->brand ?? 'Valencia Dial',
    'description' => $request->description,      // <-- Aligned!
    'price'       => $request->price,
    'stock'       => $request->stock,
    'image'       => $imagepath
]);

        return redirect()->route('admin.watches.index')->with('success', 'Premium Watch added successfully!');
    }

    public function edit($id)
{
    $watch = Watch::findOrFail($id);
    return view('admin.watches.edit', compact('watch'));
}
    public function update(Request $request ,$id){
        $watch =Watch::findOrFail($id); 
        $request->validate([
            'name' => 'required|string|max:255',
        'brand' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data =$request->only('name','brand','price','stock','description');

        if($request->hasFile('image')){
            if($watch->image){
                storage::disk('public')->delete($watch->image);
            }
            //save new image
           $data['image'] =$request->file('image')->store('watches','public');

        }
        $watch->update($data);
 return redirect()->route('admin.watches.index')->with('success', 'Masterpiece credentials updated successfully.');
    }

    public function destroy($id)
{
    $watch = Watch::findOrFail($id);

    // Image file bhi storage se khatam karo
    if ($watch->image) {
        Storage::disk('public')->delete($watch->image);
    }

    $watch->delete();

    return redirect()->route('admin.watches.index')->with('success', 'Watch entry successfully exiled from vault.');
}
}
    
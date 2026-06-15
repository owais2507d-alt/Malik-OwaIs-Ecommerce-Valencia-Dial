<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Watch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
   public function store(Request $request)
{
    Log::info('Watch store request received.', [
        'input' => $request->except(['image']),
        'has_image' => $request->hasFile('image'),
    ]);

    $validated = $request->validate([
        'name'        => 'required|string|max:255',
        'brand'       => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'price'       => 'required|numeric|min:0',
        'stock'       => 'required|integer|min:0',
        'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
    ]);

    Log::info('Watch validation passed.', [
        'validated_data' => collect($validated)->except('image')->toArray(),
    ]);

    try {

        $imagepath = null;

        if ($request->hasFile('image')) {

            Log::info('Image upload started.', [
                'original_name' => $request->file('image')->getClientOriginalName(),
                'size' => $request->file('image')->getSize(),
                'mime' => $request->file('image')->getMimeType(),
            ]);

            $imagepath = $request->file('image')->store('watches', 'public');

            Log::info('Image stored successfully.', [
                'path' => $imagepath,
            ]);
        }

        $watch = Watch::create([
            'name'        => $request->name,
            'brand'       => $request->brand ?? 'Valencia Dial',
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'image'       => $imagepath,
        ]);

        Log::info('Watch created successfully.', [
            'watch_id' => $watch->id,
            'watch_name' => $watch->name,
        ]);

        Log::info('Redirecting to admin.watches.index');

        return redirect()
            ->route('admin.watches.index')
            ->with('success', 'Premium Watch added successfully!');

    } catch (\Exception $e) {

        Log::error('Watch creation failed.', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);

        throw $e;
    }
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
    
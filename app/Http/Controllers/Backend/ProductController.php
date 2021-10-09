<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //هنا هنعطي لكل واحد الدور بتاعه و صلاحياته
        if (!\auth()->user()->ability('superAdmin', 'manage_products,show_products')) {
            return redirect('admin/index');
        }

        $products = Product::with('category', 'tags', 'firstMedia')

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);  //بمعني وانت راجع بالكاتبجوري هات معاك مجمع المنتجات الخاصة بكل كاتبجوري

        return view('backend.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products,create_products')) {
            return redirect('admin/index');
        }

        $categories = Category::whereStatus(1)->get(['id', 'name']);
        $tags       = Tag::whereStatus(1)->get(['id', 'name']);

        return view('backend.products.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products,create_products')) {
            return redirect('admin/index');
        }

        $input['name']          = $request->name;
        $input['description']   = $request->description;
        $input['quantity']      = $request->quantity;
        $input['price']         = $request->price;
        $input['category_id']   = $request->category_id;
        $input['featured']      = $request->featured;
        $input['status']        = $request->status;

        $product = Product::create($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت

        $product->tags()->attach($request->tags); //لان هذا علاقة ماني تى ماني

        if ($request->images && count($request->images) > 0) {
            $i = 1;
            foreach ($request->images as $file) {
                $filename = $product->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();
                $file_size = $file->getSize();
                $file_type = $file->getMimeType();
                $path = ('assets/products/' . $filename);
                Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);

                $product->media()->create([
                    'file_name'     => $filename,
                    'file_size'     => $file_size,
                    'file_type'     => $file_type,
                    'file_status'   => true,
                    'file_sort'     => $i,
                ]);
                $i++;
            }
        }

        return redirect()->route('admin.products.index')->with([
            'message' => 'Product Created Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products,display_products')) {
            return redirect('admin/index');
        }

        return view('backend.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products,update_products')) {
            return redirect('admin/index');
        }

        $categories = Category::whereStatus(1)->get(['id', 'name']);
        $tags       = Tag::whereStatus(1)->get(['id', 'name']);

        return view('backend.products.edit', compact('categories', 'tags', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products,update_products')) {
            return redirect('admin/index');
        }

        $input['name']          = $request->name;
        $input['description']   = $request->description;
        $input['quantity']      = $request->quantity;
        $input['price']         = $request->price;
        $input['category_id']   = $request->category_id;
        $input['featured']      = $request->featured;
        $input['status']        = $request->status;

        $product->update($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت

        $product->tags()->sync($request->tags);

        if ($request->images && count($request->images) > 0) {
            $i = $product->media()->count() + 1;
            foreach ($request->images as $file) {
                $filename = $product->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();
                $file_size = $file->getSize();
                $file_type = $file->getMimeType();
                $path = ('assets/products/' . $filename);
                Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);

                $product->media()->create([
                    'file_name'     => $filename,
                    'file_size'     => $file_size,
                    'file_type'     => $file_type,
                    'file_status'   => true,
                    'file_sort'     => $i,
                ]);
                $i++;
            }
        }

        return redirect()->route('admin.products.index')->with([
            'message' => 'Product Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products,delete_products')) {
            return redirect('admin/index');
        }

        if($product->media()->count() > 0 )
        {
            foreach ($product->media as $media)
            {
                if (File::exists('assets/products/' . $media->file_name)) {
                    unlink('assets/products/' . $media->file_name);
                }
                $media->delete();
            }
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with([
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success'
        ]);

    }



    public function removeImage(Request $request)
    {
        // dd($request->all());

        if (!\auth()->user()->ability('superAdmin', 'manage_products,delete_products')) {
            return redirect('admin/index');
        }

        $product = Product::findOrFail($request->product_id);
        $image   = $product->media()->whereId($request->image_id)->first();
        if ($image) {
            if (File::exists('assets/products/' . $image->file_name)) {
                unlink('assets/products/' . $image->file_name);
            }
        }
        $image->delete();
        return true;
    }


}

<?php

namespace App\Http\Controllers\Backend;

use App\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //هنا هنعطي لكل واحد الدور بتاعه و صلاحياته
        if (!\auth()->user()->ability('superAdmin', 'manage_categories,show_categories')) {
            return redirect('admin/index');
        }

        $categories = Category::withCount('products')

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);  //بمعني وانت راجع بالكاتبجوري هات معاك مجمع المنتجات الخاصة بكل كاتبجوري

        return view('backend.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_categories,create_categories')) {
            return redirect('admin/index');
        }

        $main_categories = Category::whereNull('parent_id')->get(['id', 'name']);

        return view('backend.categories.create', compact('main_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_categories,create_categories')) {
            return redirect('admin/index');
        }

        $input['name']      = $request->name;
        $input['parent_id'] = $request->parent_id;
        $input['status']    = $request->status;

        if ($image = $request->file('cover')) {
            $filename = Str::slug($request->name).'.'.$image->getClientOriginalExtension();   //علشان تكون اسم الصورة نفس اسم الكاتيجوري
            $path = ('assets/categories/' . $filename);
            Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();  //لتنسيق العرض مع الطول
            })->save($path, 100);  //الجودة و درجة الوضوح تكون 100%
            $input['cover']  = $filename;
        }

        Category::create($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت

        return redirect()->route('admin.categories.index')->with([
            'message' => 'Category Created Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Country $category)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_categories,display_categories')) {
            return redirect('admin/index');
        }

        return view('backend.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_categories,update_categories')) {
            return redirect('admin/index');
        }

        $main_categories = Category::whereNull('parent_id')->get(['id', 'name']);

        return view('backend.categories.edit', compact('main_categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_categories,update_categories')) {
            return redirect('admin/index');
        }

        $input['name']      = $request->name;
        $input['slug']      = null;
        $input['parent_id'] = $request->parent_id;
        $input['status']    = $request->status;

        if ($image = $request->file('cover')) {

            if ($category->cover != null && File::exists('assets/categories/' . $category->cover)) {
                unlink('assets/categories/' . $category->cover);
            }

            $filename = Str::slug($request->name).'.'.$image->getClientOriginalExtension();   //علشان تكون اسم الصورة نفس اسم الكاتيجوري
            $path = ('assets/categories/' . $filename);
            Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();  //لتنسيق العرض مع الطول
            })->save($path, 100);  //الجودة و درجة الوضوح تكون 100%
            $input['cover']  = $filename;
        }

        $category->update($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت

        return redirect()->route('admin.categories.index')->with([
            'message' => 'Category Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_categories,delete_categories')) {
            return redirect('admin/index');
        }

        if ($category->cover != null && File::exists('assets/categories/' . $category->cover)) {
            unlink('assets/categories/' . $category->cover);
        }
        $category->delete();

        return redirect()->route('admin.categories.index')->with([
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        ]);

    }



    public function removeImage(Request $request)
    {
        // dd($request->all());

        if (!\auth()->user()->ability('superAdmin', 'manage_categories,delete_categories')) {
            return redirect('admin/index');
        }

        $category = Category::whereId($request->category_id)->first();
        if ($category) {
            if (File::exists('assets/categories/' . $category->cover)) {
                unlink('assets/categories/' . $category->cover);

                $category->cover = null;
                $category->save();
            }
        }
        return true;
    }


}


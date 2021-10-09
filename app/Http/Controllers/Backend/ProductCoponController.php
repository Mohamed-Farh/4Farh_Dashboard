<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductCoponRequest;
use App\Models\ProductCopon;
use Illuminate\Http\Request;

class ProductCoponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //هنا هنعطي لكل واحد الدور بتاعه و صلاحياته
        if (!\auth()->user()->ability('superAdmin', 'manage_productCopons,show_productCopons')) {
            return redirect('admin/index');
        }

        $copons = ProductCopon::query()

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);  //بمعني وانت راجع بالكاتبجوري هات معاك مجمع المنتجات الخاصة بكل كاتبجوري

        return view('backend.productCopons.index', compact('copons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productCopons,create_productCopons')) {
            return redirect('admin/index');
        }

        return view('backend.productCopons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCoponRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productCopons,create_productCopons')) {
            return redirect('admin/index');
        }

        $product = ProductCopon::create($request->validated()); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت

        return redirect()->route('admin.productCopons.index')->with([
            'message' => 'Product Copon Created Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCopon $productCopon)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productCopons,display_productCopons')) {
            return redirect('admin/index');
        }

        return view('backend.tags.show', compact('productCopon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCopon $productCopon)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productCopons,update_productCopons')) {
            return redirect('admin/index');
        }

        return view('backend.productCopons.edit', compact('productCopon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCoponRequest $request, ProductCopon $productCopon)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productCopons,update_productCopons')) {
            return redirect('admin/index');
        }

        $productCopon->update($request->validated());

        return redirect()->route('admin.productCopons.index')->with([
            'message' => 'Product Copon Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCopon $productCopon)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productCopons,delete_productCopons')) {
            return redirect('admin/index');
        }

        $productCopon->delete();

        return redirect()->route('admin.productCopons.index')->with([
            'message' => 'Product Copon Deleted Successfully',
            'alert-type' => 'success'
        ]);

    }



}

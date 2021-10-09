<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductReviewRequest;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //هنا هنعطي لكل واحد الدور بتاعه و صلاحياته
        if (!\auth()->user()->ability('superAdmin', 'manage_productReviews,show_productReviews')) {
            return redirect('admin/index');
        }

        $productReviews = ProductReview::query()

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);  //بمعني وانت راجع بالكاتبجوري هات معاك مجمع المنتجات الخاصة بكل كاتبجوري

        return view('backend.productReviews.index', compact('productReviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productReviews,create_productReviews')) {
            return redirect('admin/index');
        }

        return view('backend.productReviews.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductReviewRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productReviews,create_productReviews')) {
            return redirect('admin/index');
        }

        $input['name']      = $request->name;
        $input['parent_id'] = $request->parent_id;
        $input['status']    = $request->status;

        ProductReview::create($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت

        return redirect()->route('admin.productReviews.index')->with([
            'message' => 'Product Review Created Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProductReview $productReview)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productReviews,display_productReviews')) {
            return redirect('admin/index');
        }

        return view('backend.productReviews.show', compact('productReview'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductReview $productReview)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productReviews,update_productReviews')) {
            return redirect('admin/index');
        }

        return view('backend.productReviews.edit', compact('productReview'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductReviewRequest $request, ProductReview $productReview)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productReviews,update_productReviews')) {
            return redirect('admin/index');
        }

        $productReview->update($request->validated());

        return redirect()->route('admin.productReviews.index')->with([
            'message' => 'Product Review Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductReview $productReview)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productReviews,delete_productReviews')) {
            return redirect('admin/index');
        }

        $productReview->delete();

        return redirect()->route('admin.productReviews.index')->with([
            'message' => 'Product Review Deleted Successfully',
            'alert-type' => 'success'
        ]);

    }


}

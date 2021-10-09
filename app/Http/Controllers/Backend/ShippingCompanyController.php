<?php

namespace App\Http\Controllers\Backend;

use App\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ShippingCompanyRequest;
use App\Models\ShippingCompany;
use Illuminate\Http\Request;

class ShippingCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //هنا هنعطي لكل واحد الدور بتاعه و صلاحياته
        if (!\auth()->user()->ability('superAdmin', 'manage_shipping_companies,show_shipping_companies')) {
            return redirect('admin/index');
        }

        $shipping_companies = ShippingCompany::withCount('countries')

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);  //بمعني وانت راجع بالكاتبجوري هات معاك مجمع المنتجات الخاصة بكل كاتبجوري

        return view('backend.shipping_companies.index', compact('shipping_companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_shipping_companies,create_shipping_companies')) {
            return redirect('admin/index');
        }

        $countries = Country::orderBy('id', 'asc')->get(['id', 'name']);

        return view('backend.shipping_companies.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShippingCompanyRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_shipping_companies,create_shipping_companies')) {
            return redirect('admin/index');
        }

        // if($request->validated()){
        //     dd($request->except('countries', 'submit'), $request->only('countries'));
        // }else{
        //     dd('OK');
        // }

        if($request->validated()){
            $shippingCompany = ShippingCompany::create($request->except('countries'));
            $shippingCompany->countries()->attach(array_values($request->countries));

            return redirect()->route('admin.shipping_companies.index')->with([
                'message' => 'ShippingCompany Created Successfully',
                'alert-type' => 'success'
            ]);

        }else{
            return redirect()->route('admin.shipping_companies.index')->with([
                'message' => 'Something Wrong',
                'alert-type' => 'error'
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShippingCompany $shippingCompany)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_shipping_companies,display_shipping_companies')) {
            return redirect('admin/index');
        }

        return view('backend.shipping_companies.show', compact('shippingCompany'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ShippingCompany $shippingCompany)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_shipping_companies,update_shipping_companies')) {
            return redirect('admin/index');
        }

        $shippingCompany->with('countries');
        $countries = Country::get(['id', 'name']);

        return view('backend.shipping_companies.edit', compact('shippingCompany', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
                    // public function update(ShippingCompanyRequest $request, ShippingCompany $shippingCompany)
                    // {

                    //     if (!\auth()->user()->ability('superAdmin', 'manage_shipping_companies,update_shipping_companies')) {
                    //         return redirect('admin/index');
                    //     }

                    //     if($request->validated()){
                    //         $shippingCompany->update($request->except('countries', '_token', 'submit'));
                    //         $shippingCompany->countries()->sync(array_values($request->countries));

                    //         return redirect()->route('admin.shipping_companies.index')->with([
                    //             'message' => 'ShippingCompany Updated Successfully',
                    //             'alert-type' => 'success'
                    //         ]);

                    //     }else{
                    //         return redirect()->route('admin.shipping_companies.index')->with([
                    //             'message' => 'Something Wrong',
                    //             'alert-type' => 'danger'
                    //         ]);
                    //     }
                    // }

    public function update(Request $request, ShippingCompany $shippingCompany)
    {

        if (!\auth()->user()->ability('superAdmin', 'manage_shipping_companies,update_shipping_companies')) {
            return redirect('admin/index');
        }

       $validate = $request->validate([
            'name'          => 'required|max:255',
            'code'          => 'required|max:255|unique:shipping_companies,code,'.$request->id,
            'description'   => 'required',
            'fast'          => 'required',
            'cost'          => 'required|numeric',
            'status'        => 'required',
            'countries'     => 'required',
        ]);

        if($validate){
            $shippingCompany->update($request->except('countries', '_token', 'submit'));
            $shippingCompany->countries()->sync(array_values($request->countries));

            return redirect()->route('admin.shipping_companies.index')->with([
                'message' => 'ShippingCompany Updated Successfully',
                'alert-type' => 'success'
            ]);

        }else{
            return redirect()->route('admin.shipping_companies.index')->with([
                'message' => 'Something Wrong',
                'alert-type' => 'danger'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShippingCompany $shippingCompany)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_shipping_companies,delete_shipping_companies')) {
            return redirect('admin/index');
        }

        $shippingCompany->delete();

        return redirect()->route('admin.shipping_companies.index')->with([
            'message' => 'ShippingCompany Deleted Successfully',
            'alert-type' => 'success'
        ]);

    }



}

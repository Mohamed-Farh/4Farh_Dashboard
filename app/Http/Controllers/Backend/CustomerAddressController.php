<?php

namespace App\Http\Controllers\Backend;

use App\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CustomerAddressRequest;
use App\Models\UserAddress;
use App\User;
use Illuminate\Http\Request;

class CustomerAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //هنا هنعطي لكل واحد الدور بتاعه و صلاحياته
        if (!\auth()->user()->ability('superAdmin', 'manage_customer_addresses,show_customer_addresses')) {
            return redirect('admin/index');
        }

        $customer_addresses = UserAddress::with('user')

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereDefaultAddress(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);  //بمعني وانت راجع بالكاتبجوري هات معاك مجمع المنتجات الخاصة بكل كاتبجوري

        return view('backend.customer_addresses.index', compact('customer_addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customer_addresses,create_customer_addresses')) {
            return redirect('admin/index');
        }

        $countries = Country::whereStatus(true)->get(['id', 'name']);

        return view('backend.customer_addresses.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerAddressRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customer_addresses,create_customer_addresses')) {
            return redirect('admin/index');
        }

        UserAddress::create($request->validated()); //جميع الحقول اللي عملت ليها فاليديت اعمل ليها كريات

        return redirect()->route('admin.customer_addresses.index')->with([
            'message' => 'CustomerAddress Created Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(UserAddress $customer_address)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customer_addresses,display_customer_addresses')) {
            return redirect('admin/index');
        }

        return view('backend.customer_addresses.show', compact('customer_address'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(UserAddress $customer_address)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customer_addresses,update_customer_addresses')) {
            return redirect('admin/index');
        }

        $countries = Country::whereStatus(true)->get(['id', 'name']);

        return view('backend.customer_addresses.edit', compact('customer_address', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerAddressRequest $request, UserAddress $customer_address)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customer_addresses,update_customer_addresses')) {
            return redirect('admin/index');
        }

        $customer_address->update($request->validated());

        return redirect()->route('admin.customer_addresses.index')->with([
            'message' => 'CustomerAddress Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAddress $customer_address)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customer_addresses,delete_customer_addresses')) {
            return redirect('admin/index');
        }

        $customer_address->delete();

        return redirect()->route('admin.customer_addresses.index')->with([
            'message' => 'CustomerAddress Deleted Successfully',
            'alert-type' => 'success'
        ]);

    }



}

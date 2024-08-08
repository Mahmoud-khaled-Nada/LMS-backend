<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Requests\AdminPanel\CreateCouponRequest;
use App\Http\Requests\AdminPanel\UpdateCouponRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\CouponRepository;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Str;
use Flash;

class CouponController extends AppBaseController
{
    private $couponRepository;
    public function __construct(CouponRepository $couponRepo)
    {
        $this->couponRepository = $couponRepo;
        $this->middleware('permission:View Coupon|Create Coupon|Update Coupon|Delete Coupon', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create Coupon', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update Coupon', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Coupon', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $coupons = $this->couponRepository->all();
        return view('AdminPanel.coupons.index' , get_defined_vars() );
    }

    public function create()
    {
        return view('AdminPanel.coupons.create');
    }

    public function store(CreateCouponRequest $request)
    {
        $input                   = $request->validated();
        $input['code']           = Str::random(10);
        $input['remaining']      = $input['number_of_use'];
        $coupon = $this->couponRepository->create($input);
        return redirect(route('coupons.index'))->with('success' , __('lang.created'));
    }

    public function show($id)
    {
        $coupon = $this->couponRepository->find($id);
        if (empty($coupon)) {
            return redirect(route('coupons.index'));
        }
        return view('coupons.show')->with('coupon', $coupon);
    }

    public function edit($id)
    {
        $coupon = $this->couponRepository->find($id);
        if (empty($coupon)) {
            return redirect(route('coupons.index'));
        }
        return view('AdminPanel.coupons.edit' , get_defined_vars() );
    }

    public function update($id, UpdateCouponRequest $request)
    {
        $coupon  = Coupon::findOrFail($id);
        $data = $request->validated();
        $data['remaining'] = $data['number_of_use'] - $coupon->number_of_use + $coupon->remaining;
        $coupon->update($data);
        return redirect(route('coupons.index'))->with('success' , __('lang.updated'));
    }

    public function destroy($id)
    {
        $coupon = $this->couponRepository->find($id);
        if (empty($coupon)) {
            return redirect(route('coupons.index'));
        }
        $this->couponRepository->delete($id);
        return redirect(route('coupons.index'))->with('success' , __('lang.deleted'));
    }
}

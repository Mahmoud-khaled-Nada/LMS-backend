<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Requests\CreateOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Course;
use App\Repositories\OfferRepository;
use Illuminate\Http\Request;
use Flash;

class OfferController extends AppBaseController
{

    private $offerRepository;
    public function __construct(OfferRepository $offerRepo)
    {
        $this->offerRepository = $offerRepo;
        $this->middleware('permission:View Offer|Create Coupon|Update Coupon|Delete Coupon', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create Offer', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update Offer', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Offer', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $offers = $this->offerRepository->all();
        return view('AdminPanel.offers.index' , get_defined_vars() );
    }

    public function create()
    {
        $courses = Course::get();
        return view('AdminPanel.offers.create' , get_defined_vars() );
    }

    public function store(CreateOfferRequest $request)
    {
        $input = $request->all();
        $offer = $this->offerRepository->create($input);
        return redirect(route('offers.index'))->with( 'success' , __('lang.created') );;
    }

    // public function show($id)
    // {
    //     $offer = $this->offerRepository->find($id);
    //     if (empty($offer)) {
    //         return redirect(route('offers.index'));
    //     }
    //     return view('offers.show')->with('offer', $offer);
    // }

    public function edit($id)
    {
        $courses = Course::get();
        $offer = $this->offerRepository->find($id);
        if (empty($offer)) {
            return redirect(route('offers.index'));
        }
        return view('AdminPanel.offers.edit' , get_defined_vars() );
    }

    public function update($id, UpdateOfferRequest $request)
    {
        $offer = $this->offerRepository->find($id);
        if (empty($offer)) {
            return redirect(route('offers.index'));
        }
        $offer = $this->offerRepository->update($request->all(), $id);
        return redirect(route('offers.index'));
    }

    public function destroy($id)
    {
        $offer = $this->offerRepository->find($id);
        if (empty($offer)) {
            return redirect(route('offers.index'));
        }
        $this->offerRepository->delete($id);
        return redirect(route('offers.index'));
    }
}

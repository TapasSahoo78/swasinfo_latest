<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Offers;
use Illuminate\Http\Request;

class OffersController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->setPageTitle('All Products');
        if (auth()->user()->id == 1) {
            $listOffers = Offers::orderBy('created_at', 'desc')->get();
        } else {
            $listOffers = Offers::where('created_by', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        }
        return view('admin.offers.list-offer-page', compact('listOffers'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'discount' => 'required|numeric',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);
            \DB::beginTransaction();
            try {
                $offer = new Offers();
                $offer->name = $validatedData['name'];
                $offer->price = $validatedData['price'];
                $offer->persantage = $validatedData['discount'];
                $offer->start_date = $validatedData['start_date'];
                $offer->end_date = $validatedData['end_date'];
                $offer->save();
                \DB::commit();
                return $this->responseRedirect('admin.offer.list', 'offer created successfully', 'success', false);
            } catch (\Exception $e) {
                \DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.offers.add-offer-page');
    }
}

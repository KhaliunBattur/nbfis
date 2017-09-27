<?php

namespace App\Http\Controllers;

use App\Support\Currency;
use App\Support\CurrencyRepositoryInterface;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * @var CurrencyRepositoryInterface
     */
    private $currencyRepository;

    /**
     * CurrencyController constructor.
     * @param CurrencyRepositoryInterface $currencyRepository
     */
    public function __construct(CurrencyRepositoryInterface $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currencys = $this->currencyRepository->findByPaginate($request->get('per_page'), $request->all());

        return response()->json([
            'model' => $currencys
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->valid($request);
        if($request->get('id') == 0)
        {
            $currency = Currency::create($request->all());

            return response()->json([
                'result' => !is_null($currency)
            ]);

        }
        else
        {
            $currency = $this->currencyRepository->findById($request->get('id'));

            return response()->json([
                'result' => $currency->update($request->all())
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currency = $this->currencyRepository->findById($id);
        return response()->json(['result'=>$currency->delete()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function lists(Request $request)
    {
        $currencies = $this->currencyRepository->search($request->get('q'));

        return response()->json([
            'lists' => $currencies
        ]);
    }
    private function valid($request)
    {
        $this->validate($request, [
            'name' => 'required',
            'exchange' => 'required',
            'marker' => 'required',
        ]);
    }
}

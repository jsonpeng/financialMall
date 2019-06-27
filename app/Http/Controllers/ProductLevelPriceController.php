<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductLevelPriceRequest;
use App\Http\Requests\UpdateProductLevelPriceRequest;
use App\Repositories\ProductLevelPriceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ProductLevelPriceController extends AppBaseController
{
    /** @var  ProductLevelPriceRepository */
    private $productLevelPriceRepository;

    public function __construct(ProductLevelPriceRepository $productLevelPriceRepo)
    {
        $this->productLevelPriceRepository = $productLevelPriceRepo;
    }

    /**
     * Display a listing of the ProductLevelPrice.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->productLevelPriceRepository->pushCriteria(new RequestCriteria($request));
        $productLevelPrices = $this->productLevelPriceRepository->all();

        return view('product_level_prices.index')
            ->with('productLevelPrices', $productLevelPrices);
    }

    /**
     * Show the form for creating a new ProductLevelPrice.
     *
     * @return Response
     */
    public function create()
    {
        return view('product_level_prices.create');
    }

    /**
     * Store a newly created ProductLevelPrice in storage.
     *
     * @param CreateProductLevelPriceRequest $request
     *
     * @return Response
     */
    public function store(CreateProductLevelPriceRequest $request)
    {
        $input = $request->all();

        $productLevelPrice = $this->productLevelPriceRepository->create($input);

        Flash::success('Product Level Price saved successfully.');

        return redirect(route('productLevelPrices.index'));
    }

    /**
     * Display the specified ProductLevelPrice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $productLevelPrice = $this->productLevelPriceRepository->findWithoutFail($id);

        if (empty($productLevelPrice)) {
            Flash::error('Product Level Price not found');

            return redirect(route('productLevelPrices.index'));
        }

        return view('product_level_prices.show')->with('productLevelPrice', $productLevelPrice);
    }

    /**
     * Show the form for editing the specified ProductLevelPrice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $productLevelPrice = $this->productLevelPriceRepository->findWithoutFail($id);

        if (empty($productLevelPrice)) {
            Flash::error('Product Level Price not found');

            return redirect(route('productLevelPrices.index'));
        }

        return view('product_level_prices.edit')->with('productLevelPrice', $productLevelPrice);
    }

    /**
     * Update the specified ProductLevelPrice in storage.
     *
     * @param  int              $id
     * @param UpdateProductLevelPriceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductLevelPriceRequest $request)
    {
        $productLevelPrice = $this->productLevelPriceRepository->findWithoutFail($id);

        if (empty($productLevelPrice)) {
            Flash::error('Product Level Price not found');

            return redirect(route('productLevelPrices.index'));
        }

        $productLevelPrice = $this->productLevelPriceRepository->update($request->all(), $id);

        Flash::success('Product Level Price updated successfully.');

        return redirect(route('productLevelPrices.index'));
    }

    /**
     * Remove the specified ProductLevelPrice from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $productLevelPrice = $this->productLevelPriceRepository->findWithoutFail($id);

        if (empty($productLevelPrice)) {
            Flash::error('Product Level Price not found');

            return redirect(route('productLevelPrices.index'));
        }

        $this->productLevelPriceRepository->delete($id);

        Flash::success('Product Level Price deleted successfully.');

        return redirect(route('productLevelPrices.index'));
    }
}

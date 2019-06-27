<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\OldProductRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\OldProduct;

class ProductController extends AppBaseController
{
    /** @var  OldProductRepository */
    private $OldProductRepository;

    public function __construct(OldProductRepository $productRepo)
    {
        $this->OldProductRepository = $productRepo;
    }

    /**
     * Display a listing of the Product.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if (OldProduct::count()) {
            $product = OldProduct::first();
            return view('products.edit')->with('product', $product);
       } else {
           return view('products.create');
       }
        /*
        $this->OldProductRepository->pushCriteria(new RequestCriteria($request));
        $products = $this->OldProductRepository->all();

        return view('products.index')
            ->with('products', $products);
            */
    }

    /**
     * Show the form for creating a new Product.
     *
     * @return Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created Product in storage.
     *
     * @param CreateProductRequest $request
     *
     * @return Response
     */
    public function store(CreateProductRequest $request)
    {
        $input = $request->all();

        $product = $this->OldProductRepository->create($input);

        Flash::success('保存成功');

        return redirect(route('products.index'));
    }

    /**
     * Display the specified Product.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $product = $this->OldProductRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('信息不存在');

            return redirect(route('products.index'));
        }

        return view('products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified Product.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $product = $this->OldProductRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('信息不存在');

            return redirect(route('products.index'));
        }

        return view('products.edit')->with('product', $product);
    }

    /**
     * Update the specified Product in storage.
     *
     * @param  int              $id
     * @param UpdateProductRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductRequest $request)
    {
        $product = $this->OldProductRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('信息不存在');

            return redirect(route('products.index'));
        }

        $product = $this->OldProductRepository->update($request->all(), $id);

        Flash::success('更新成功');

        return redirect(route('products.index'));
    }

    /**
     * Remove the specified Product from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $product = $this->OldProductRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('信息不存在');

            return redirect(route('products.index'));
        }

        $this->OldProductRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('products.index'));
    }
}

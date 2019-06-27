<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlatFormCatRequest;
use App\Http\Requests\UpdatePlatFormCatRequest;
use App\Repositories\PlatFormCatRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\PlatFormCat;

class PlatFormCatController extends AppBaseController
{
    /** @var  PlatFormCatRepository */
    private $platFormCatRepository;

    public function __construct(PlatFormCatRepository $platFormCatRepo)
    {
        $this->platFormCatRepository = $platFormCatRepo;
    }

    /**
     * Display a listing of the PlatFormCat.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$this->platFormCatRepository->pushCriteria(new RequestCriteria($request));
        //$platFormCats = $this->platFormCatRepository->all();
        $platFormCats = PlatFormCat::orderBy('sort', 'desc')->get();

        return view('plat_form_cats.index')
            ->with('platFormCats', $platFormCats);
    }

    /**
     * Show the form for creating a new PlatFormCat.
     *
     * @return Response
     */
    public function create()
    {
        return view('plat_form_cats.create')
         ->with('model_required',\Zcjy::modelRequiredParam($this->platFormCatRepository->model()));
    }

    /**
     * Store a newly created PlatFormCat in storage.
     *
     * @param CreatePlatFormCatRequest $request
     *
     * @return Response
     */
    public function store(CreatePlatFormCatRequest $request)
    {
        $input = $request->all();

        $platFormCat = $this->platFormCatRepository->create($input);

        Flash::success('保存成功');

        return redirect(route('platFormCats.index'));
    }

    /**
     * Display the specified PlatFormCat.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $platFormCat = $this->platFormCatRepository->findWithoutFail($id);

        if (empty($platFormCat)) {
            Flash::error('平台不存在');

            return redirect(route('platFormCats.index'));
        }

        return view('plat_form_cats.show')->with('platFormCat', $platFormCat);
    }

    /**
     * Show the form for editing the specified PlatFormCat.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $platFormCat = $this->platFormCatRepository->findWithoutFail($id);

        if (empty($platFormCat)) {
            Flash::error('平台不存在');

            return redirect(route('platFormCats.index'));
        }

        return view('plat_form_cats.edit')
        ->with('platFormCat', $platFormCat)
        ->with('model_required',\Zcjy::modelRequiredParam($this->platFormCatRepository->model()));
    }

    /**
     * Update the specified PlatFormCat in storage.
     *
     * @param  int              $id
     * @param UpdatePlatFormCatRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePlatFormCatRequest $request)
    {
        $platFormCat = $this->platFormCatRepository->findWithoutFail($id);

        if (empty($platFormCat)) {
            Flash::error('平台不存在');

            return redirect(route('platFormCats.index'));
        }

        $platFormCat = $this->platFormCatRepository->update($request->all(), $id);

        Flash::success('更新成功');

        return redirect(route('platFormCats.index'));
    }

    /**
     * Remove the specified PlatFormCat from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $platFormCat = $this->platFormCatRepository->findWithoutFail($id);

        if (empty($platFormCat)) {
            Flash::error('平台不存在');

            return redirect(route('platFormCats.index'));
        }

        $this->platFormCatRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('platFormCats.index'));
    }
}

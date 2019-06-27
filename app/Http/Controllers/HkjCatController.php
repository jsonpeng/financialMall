<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateHkjCatRequest;
use App\Http\Requests\UpdateHkjCatRequest;
use App\Repositories\HkjCatRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\HkjCat;

class HkjCatController extends AppBaseController
{
    /** @var  HkjCatRepository */
    private $hkjCatRepository;

    public function __construct(HkjCatRepository $hkjCatRepo)
    {
        $this->hkjCatRepository = $hkjCatRepo;
    }

    /**
     * Display a listing of the HkjCat.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$this->hkjCatRepository->pushCriteria(new RequestCriteria($request));
        //$hkjCats = $this->hkjCatRepository->all();
        $hkjCats = HkjCat::orderBy('sort', 'desc')->get();

        return view('hkj_cats.index')
            ->with('hkjCats', $hkjCats);
    }

    /**
     * Show the form for creating a new HkjCat.
     *
     * @return Response
     */
    public function create()
    {
        return view('hkj_cats.create')
        ->with('model_required',\Zcjy::modelRequiredParam($this->hkjCatRepository->model()));
    }

    /**
     * Store a newly created HkjCat in storage.
     *
     * @param CreateHkjCatRequest $request
     *
     * @return Response
     */
    public function store(CreateHkjCatRequest $request)
    {
        $input = $request->all();

        $hkjCat = $this->hkjCatRepository->create($input);

        Flash::success('保存成功');

        return redirect(route('hkjCats.index'));
    }

    /**
     * Display the specified HkjCat.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $hkjCat = $this->hkjCatRepository->findWithoutFail($id);

        if (empty($hkjCat)) {
            Flash::error('信息不存在');

            return redirect(route('hkjCats.index'));
        }

        return view('hkj_cats.show')->with('hkjCat', $hkjCat);
    }

    /**
     * Show the form for editing the specified HkjCat.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $hkjCat = $this->hkjCatRepository->findWithoutFail($id);

        if (empty($hkjCat)) {
            Flash::error('信息不存在');

            return redirect(route('hkjCats.index'));
        }

        return view('hkj_cats.edit')
        ->with('hkjCat', $hkjCat)
        ->with('model_required',\Zcjy::modelRequiredParam($this->hkjCatRepository->model()));
    }

    /**
     * Update the specified HkjCat in storage.
     *
     * @param  int              $id
     * @param UpdateHkjCatRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateHkjCatRequest $request)
    {
        $hkjCat = $this->hkjCatRepository->findWithoutFail($id);

        if (empty($hkjCat)) {
            Flash::error('信息不存在');

            return redirect(route('hkjCats.index'));
        }

        $hkjCat = $this->hkjCatRepository->update($request->all(), $id);

        Flash::success('更新成功');

        return redirect(route('hkjCats.index'));
    }

    /**
     * Remove the specified HkjCat from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $hkjCat = $this->hkjCatRepository->findWithoutFail($id);

        if (empty($hkjCat)) {
            Flash::error('信息不存在');

            return redirect(route('hkjCats.index'));
        }

        $this->hkjCatRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('hkjCats.index'));
    }
}

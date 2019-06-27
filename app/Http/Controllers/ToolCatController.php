<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateToolCatRequest;
// use App\Http\Requests\UpdateToolCatRequest;
use App\Repositories\ToolCatRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ToolCatController extends AppBaseController
{
    /** @var  ToolCatRepository */
    private $toolCatRepository;

    public function __construct(ToolCatRepository $toolCatRepo)
    {
        $this->toolCatRepository = $toolCatRepo;
    }

    /**
     * Display a listing of the ToolCat.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->toolCatRepository->pushCriteria(new RequestCriteria($request));
        $toolCats = $this->toolCatRepository->all();

        return view('tool_cats.index')
            ->with('toolCats', $toolCats);
    }

    /**
     * Show the form for creating a new ToolCat.
     *
     * @return Response
     */
    public function create()
    {
        return view('tool_cats.create')
        ->with('model_required',\Zcjy::modelRequiredParam($this->toolCatRepository->model()));
    }

    /**
     * Store a newly created ToolCat in storage.
     *
     * @param CreateToolCatRequest $request
     *
     * @return Response
     */
    public function store(CreateToolCatRequest $request)
    {
        $input = $request->all();

        $toolCat = $this->toolCatRepository->create($input);

        Flash::success('添加成功.');

        return redirect(route('toolCats.index'));
    }

    /**
     * Display the specified ToolCat.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $toolCat = $this->toolCatRepository->findWithoutFail($id);

        if (empty($toolCat)) {
            Flash::error('Tool Cat not found');

            return redirect(route('toolCats.index'));
        }

        return view('tool_cats.show')->with('toolCat', $toolCat);
    }

    /**
     * Show the form for editing the specified ToolCat.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $toolCat = $this->toolCatRepository->findWithoutFail($id);

        if (empty($toolCat)) {
            Flash::error('Tool Cat not found');

            return redirect(route('toolCats.index'));
        }

        return view('tool_cats.edit')
        ->with('toolCat', $toolCat)
        ->with('model_required',\Zcjy::modelRequiredParam($this->toolCatRepository->model()));
    }

    /**
     * Update the specified ToolCat in storage.
     *
     * @param  int              $id
     * @param UpdateToolCatRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $toolCat = $this->toolCatRepository->findWithoutFail($id);

        if (empty($toolCat)) {
            Flash::error('Tool Cat not found');

            return redirect(route('toolCats.index'));
        }

        $toolCat = $this->toolCatRepository->update($request->all(), $id);

        Flash::success('更新成功.');

        return redirect(route('toolCats.index'));
    }

    /**
     * Remove the specified ToolCat from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $toolCat = $this->toolCatRepository->findWithoutFail($id);

        if (empty($toolCat)) {
            Flash::error('Tool Cat not found');

            return redirect(route('toolCats.index'));
        }

        $this->toolCatRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('toolCats.index'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaperTypeRequest;
use App\Http\Requests\UpdatePaperTypeRequest;
use App\Repositories\PaperTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PaperTypeController extends AppBaseController
{
    /** @var  PaperTypeRepository */
    private $paperTypeRepository;

    public function __construct(PaperTypeRepository $paperTypeRepo)
    {
        $this->paperTypeRepository = $paperTypeRepo;
    }

    /**
     * Display a listing of the PaperType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->paperTypeRepository->pushCriteria(new RequestCriteria($request));

        $paperTypes = $this->defaultSearchState($this->paperTypeRepository);
        
        $paperTypes = $this->defaultPaginate($paperTypes);

        return view('paper_types.index')
            ->with('paperTypes', $paperTypes);
    }

    /**
     * Show the form for creating a new PaperType.
     *
     * @return Response
     */
    public function create()
    {
        return view('paper_types.create');
    }

    /**
     * Store a newly created PaperType in storage.
     *
     * @param CreatePaperTypeRequest $request
     *
     * @return Response
     */
    public function store(CreatePaperTypeRequest $request)
    {
        $input = $request->all();

        $paperType = $this->paperTypeRepository->create($input);

        Flash::success('试题分类添加成功.');

        return redirect(route('paperTypes.index'));
    }

    /**
     * Display the specified PaperType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $paperType = $this->paperTypeRepository->findWithoutFail($id);

        if (empty($paperType)) {
            Flash::error('Paper Type not found');

            return redirect(route('paperTypes.index'));
        }

        return view('paper_types.show')->with('paperType', $paperType);
    }

    /**
     * Show the form for editing the specified PaperType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $paperType = $this->paperTypeRepository->findWithoutFail($id);

        if (empty($paperType)) {
            Flash::error('Paper Type not found');

            return redirect(route('paperTypes.index'));
        }

        return view('paper_types.edit')->with('paperType', $paperType);
    }

    /**
     * Update the specified PaperType in storage.
     *
     * @param  int              $id
     * @param UpdatePaperTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePaperTypeRequest $request)
    {
        $paperType = $this->paperTypeRepository->findWithoutFail($id);

        if (empty($paperType)) {
            Flash::error('Paper Type not found');

            return redirect(route('paperTypes.index'));
        }

        $paperType = $this->paperTypeRepository->update($request->all(), $id);

        Flash::success('试题分类更新成功.');

        return redirect(route('paperTypes.index'));
    }

    /**
     * Remove the specified PaperType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $paperType = $this->paperTypeRepository->findWithoutFail($id);

        if (empty($paperType)) {
            Flash::error('Paper Type not found');

            return redirect(route('paperTypes.index'));
        }

        $this->paperTypeRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('paperTypes.index'));
    }
}

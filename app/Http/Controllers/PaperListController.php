<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaperListRequest;
use App\Http\Requests\UpdatePaperListRequest;
use App\Repositories\PaperListRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Config;

class PaperListController extends AppBaseController
{
    /** @var  PaperListRepository */
    private $paperListRepository;

    public function __construct(PaperListRepository $paperListRepo)
    {
        $this->paperListRepository = $paperListRepo;
    }

    /**
     * Display a listing of the PaperList.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->paperListRepository->pushCriteria(new RequestCriteria($request));
       
        $paperLists = $this->defaultSearchState($this->paperListRepository);
        
        $paperLists = $this->defaultPaginate($paperLists);

        return view('paper_lists.index')
            ->with('paperLists', $paperLists);
    }

    /**
     * Show the form for creating a new PaperList.
     *
     * @return Response
     */
    public function create()
    {
        $paper_types = app('commonRepo')->paperTypeRepo()->all();
        $levels = Config::get('paper.level');

        return view('paper_lists.create')
            ->with('paper_types',$paper_types)
            ->with('levels',$levels);
    }

    /**
     * Store a newly created PaperList in storage.
     *
     * @param CreatePaperListRequest $request
     *
     * @return Response
     */
    public function store(CreatePaperListRequest $request)
    {
        $input = $request->all();

        $paperList = $this->paperListRepository->create($input);

        Flash::success('试卷添加成功.');

        return redirect(route('paperLists.index'));
    }

    /**
     * Display the specified PaperList.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $paperList = $this->paperListRepository->findWithoutFail($id);

        if (empty($paperList)) {
            Flash::error('Paper List not found');

            return redirect(route('paperLists.index'));
        }

        return view('paper_lists.show')->with('paperList', $paperList);
    }

    /**
     * Show the form for editing the specified PaperList.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $paperList = $this->paperListRepository->findWithoutFail($id);

        if (empty($paperList)) {
            Flash::error('Paper List not found');

            return redirect(route('paperLists.index'));
        }
        $paper_types = app('commonRepo')->paperTypeRepo()->all();
        $levels = Config::get('paper.level');
        return view('paper_lists.edit')
        ->with('paperList', $paperList)
        ->with('paper_types',$paper_types)
        ->with('levels',$levels);
    }

    /**
     * Update the specified PaperList in storage.
     *
     * @param  int              $id
     * @param UpdatePaperListRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePaperListRequest $request)
    {
        $paperList = $this->paperListRepository->findWithoutFail($id);

        if (empty($paperList)) {
            Flash::error('Paper List not found');

            return redirect(route('paperLists.index'));
        }

        $paperList = $this->paperListRepository->update($request->all(), $id);

        Flash::success('试卷更新成功.');

        return redirect(route('paperLists.index'));
    }

    /**
     * Remove the specified PaperList from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $paperList = $this->paperListRepository->findWithoutFail($id);

        if (empty($paperList)) {
            Flash::error('Paper List not found');

            return redirect(route('paperLists.index'));
        }

        $this->paperListRepository->delete($id);

        Flash::success('Paper List deleted successfully.');

        return redirect(route('paperLists.index'));
    }
}

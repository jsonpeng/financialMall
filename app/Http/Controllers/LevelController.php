<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLevelRequest;
// use App\Http\Requests\UpdateLevelRequest;
use App\Repositories\LevelRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class LevelController extends AppBaseController
{
    /** @var  LevelRepository */
    private $levelRepository;

    public function __construct(LevelRepository $levelRepo)
    {
        $this->levelRepository = $levelRepo;
    }

    /**
     * Display a listing of the Level.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->levelRepository->pushCriteria(new RequestCriteria($request));
        $levels = $this->levelRepository->Paginate();

        return view('levels.index')
            ->with('levels', $levels);
    }

    /**
     * Show the form for creating a new Level.
     *
     * @return Response
     */
    public function create()
    {
        return view('levels.create')
         ->with('model_required',\Zcjy::modelRequiredParam($this->levelRepository));
    }

    /**
     * Store a newly created Level in storage.
     *
     * @param CreateLevelRequest $request
     *
     * @return Response
     */
    public function store(CreateLevelRequest $request)
    {
        $input = $request->all();

        $level = $this->levelRepository->create($input);

        Flash::success('添加成功.');

        return redirect(route('levels.index'));
    }

    /**
     * Display the specified Level.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $level = $this->levelRepository->findWithoutFail($id);

        if (empty($level)) 
        {
            Flash::error('Level not found');

            return redirect(route('levels.index'));
        }

        return view('levels.show')->with('level', $level);
    }

    /**
     * Show the form for editing the specified Level.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $level = $this->levelRepository->findWithoutFail($id);

        if (empty($level)) 
        {
            Flash::error('Level not found');

            return redirect(route('levels.index'));
        }

        return view('levels.edit')
        ->with('level', $level)
        ->with('model_required',\Zcjy::modelRequiredParam($this->levelRepository));

    }

    /**
     * Update the specified Level in storage.
     *
     * @param  int              $id
     * @param UpdateLevelRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $level = $this->levelRepository->findWithoutFail($id);

        if (empty($level)) 
        {
            Flash::error('Level not found');

            return redirect(route('levels.index'));
        }

        $level = $this->levelRepository->update($request->all(), $id);

        Flash::success('更新成功.');

        return redirect(route('levels.index'));
    }

    /**
     * Remove the specified Level from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $level = $this->levelRepository->findWithoutFail($id);

        if (empty($level)) 
        {
            Flash::error('Level not found');

            return redirect(route('levels.index'));
        }

        $this->levelRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('levels.index'));
    }
}

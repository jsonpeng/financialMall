<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSoundPostCatRequest;
use App\Http\Requests\UpdateSoundPostCatRequest;
use App\Repositories\SoundPostCatRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class SoundPostCatController extends AppBaseController
{
    /** @var  SoundPostCatRepository */
    private $soundPostCatRepository;

    public function __construct(SoundPostCatRepository $soundPostCatRepo)
    {
        $this->soundPostCatRepository = $soundPostCatRepo;
    }

    /**
     * Display a listing of the SoundPostCat.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->soundPostCatRepository->pushCriteria(new RequestCriteria($request));
        $soundPostCats = $this->soundPostCatRepository->Paginate();

        return view('sound_post_cats.index')
            ->with('soundPostCats', $soundPostCats);
    }

    /**
     * Show the form for creating a new SoundPostCat.
     *
     * @return Response
     */
    public function create()
    {
        return view('sound_post_cats.create')
         ->with('model_required',\Zcjy::modelRequiredParam($this->soundPostCatRepository->model()));
    }

    /**
     * Store a newly created SoundPostCat in storage.
     *
     * @param CreateSoundPostCatRequest $request
     *
     * @return Response
     */
    public function store(CreateSoundPostCatRequest $request)
    {
        $input = $request->all();

        $soundPostCat = $this->soundPostCatRepository->create($input);

        Flash::success('保存成功.');

        return redirect(route('soundPostCats.index'));
    }

    /**
     * Display the specified SoundPostCat.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $soundPostCat = $this->soundPostCatRepository->findWithoutFail($id);

        if (empty($soundPostCat)) {
            Flash::error('Sound Post Cat not found');

            return redirect(route('soundPostCats.index'));
        }

        return view('sound_post_cats.show')->with('soundPostCat', $soundPostCat);
    }

    /**
     * Show the form for editing the specified SoundPostCat.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $soundPostCat = $this->soundPostCatRepository->findWithoutFail($id);

        if (empty($soundPostCat)) {
            Flash::error('Sound Post Cat not found');

            return redirect(route('soundPostCats.index'));
        }

        return view('sound_post_cats.edit')
        ->with('soundPostCat', $soundPostCat)
        ->with('model_required',\Zcjy::modelRequiredParam($this->soundPostCatRepository->model()));
    }

    /**
     * Update the specified SoundPostCat in storage.
     *
     * @param  int              $id
     * @param UpdateSoundPostCatRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSoundPostCatRequest $request)
    {
        $soundPostCat = $this->soundPostCatRepository->findWithoutFail($id);

        if (empty($soundPostCat)) {
            Flash::error('Sound Post Cat not found');

            return redirect(route('soundPostCats.index'));
        }

        $soundPostCat = $this->soundPostCatRepository->update($request->all(), $id);

        Flash::success('更新成功.');

        return redirect(route('soundPostCats.index'));
    }

    /**
     * Remove the specified SoundPostCat from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $soundPostCat = $this->soundPostCatRepository->findWithoutFail($id);

        if (empty($soundPostCat)) {
            Flash::error('Sound Post Cat not found');

            return redirect(route('soundPostCats.index'));
        }

        $this->soundPostCatRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('soundPostCats.index'));
    }
}

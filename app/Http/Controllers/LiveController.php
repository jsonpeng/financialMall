<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLiveRequest;
use App\Http\Requests\UpdateLiveRequest;
use App\Repositories\LiveRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class LiveController extends AppBaseController
{
    /** @var  LiveRepository */
    private $liveRepository;

    public function __construct(LiveRepository $liveRepo)
    {
        $this->liveRepository = $liveRepo;
    }

    /**
     * Display a listing of the Live.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->liveRepository->pushCriteria(new RequestCriteria($request));
        $lives = $this->liveRepository->all();

        return view('lives.index')
            ->with('lives', $lives);
    }

    /**
     * Show the form for creating a new Live.
     *
     * @return Response
     */
    public function create()
    {
        return view('lives.create')
          ->with('model_required',\Zcjy::modelRequiredParam($this->liveRepository->model()));
    }

    /**
     * Store a newly created Live in storage.
     *
     * @param CreateLiveRequest $request
     *
     * @return Response
     */
    public function store(CreateLiveRequest $request)
    {
        $input = $request->all();

        if (array_key_exists('content', $input)) {
            $input['content'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
            $input['content'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
        }

        $live = $this->liveRepository->create($input);

        Flash::success('保存成功.');

        return redirect(route('lives.index'));
    }

    /**
     * Display the specified Live.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $live = $this->liveRepository->findWithoutFail($id);

        if (empty($live)) {
            Flash::error('Live not found');

            return redirect(route('lives.index'));
        }

        return view('lives.show')->with('live', $live);
    }

    /**
     * Show the form for editing the specified Live.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $live = $this->liveRepository->findWithoutFail($id);

        if (empty($live)) {
            Flash::error('Live not found');

            return redirect(route('lives.index'));
        }

        return view('lives.edit')
        ->with('live', $live)
        ->with('model_required',\Zcjy::modelRequiredParam($this->liveRepository->model()));
    }

    /**
     * Update the specified Live in storage.
     *
     * @param  int              $id
     * @param UpdateLiveRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLiveRequest $request)
    {
        $live = $this->liveRepository->findWithoutFail($id);

        if (empty($live)) {
            Flash::error('Live not found');

            return redirect(route('lives.index'));
        }

        $input = $request->all();

        if (array_key_exists('content', $input)) {
            $input['content'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
            $input['content'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
        }

        $live = $this->liveRepository->update($input, $id);

        Flash::success('更新成功.');

        return redirect(route('lives.index'));
    }

    /**
     * Remove the specified Live from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $live = $this->liveRepository->findWithoutFail($id);

        if (empty($live)) {
            Flash::error('Live not found');

            return redirect(route('lives.index'));
        }

        $this->liveRepository->delete($id);

        Flash::success('Live deleted successfully.');

        return redirect(route('lives.index'));
    }
}

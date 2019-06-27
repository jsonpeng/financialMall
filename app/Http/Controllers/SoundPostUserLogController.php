<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSoundPostUserLogRequest;
use App\Http\Requests\UpdateSoundPostUserLogRequest;
use App\Repositories\SoundPostUserLogRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class SoundPostUserLogController extends AppBaseController
{
    /** @var  SoundPostUserLogRepository */
    private $soundPostUserLogRepository;

    public function __construct(SoundPostUserLogRepository $soundPostUserLogRepo)
    {
        $this->soundPostUserLogRepository = $soundPostUserLogRepo;
    }

    /**
     * Display a listing of the SoundPostUserLog.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->soundPostUserLogRepository->pushCriteria(new RequestCriteria($request));
        $soundPostUserLogs = $this->soundPostUserLogRepository->all();

        return view('sound_post_user_logs.index')
            ->with('soundPostUserLogs', $soundPostUserLogs);
    }

    /**
     * Show the form for creating a new SoundPostUserLog.
     *
     * @return Response
     */
    public function create()
    {
        return view('sound_post_user_logs.create');
    }

    /**
     * Store a newly created SoundPostUserLog in storage.
     *
     * @param CreateSoundPostUserLogRequest $request
     *
     * @return Response
     */
    public function store(CreateSoundPostUserLogRequest $request)
    {
        $input = $request->all();

        $soundPostUserLog = $this->soundPostUserLogRepository->create($input);

        Flash::success('Sound Post User Log saved successfully.');

        return redirect(route('soundPostUserLogs.index'));
    }

    /**
     * Display the specified SoundPostUserLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $soundPostUserLog = $this->soundPostUserLogRepository->findWithoutFail($id);

        if (empty($soundPostUserLog)) {
            Flash::error('Sound Post User Log not found');

            return redirect(route('soundPostUserLogs.index'));
        }

        return view('sound_post_user_logs.show')->with('soundPostUserLog', $soundPostUserLog);
    }

    /**
     * Show the form for editing the specified SoundPostUserLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $soundPostUserLog = $this->soundPostUserLogRepository->findWithoutFail($id);

        if (empty($soundPostUserLog)) {
            Flash::error('Sound Post User Log not found');

            return redirect(route('soundPostUserLogs.index'));
        }

        return view('sound_post_user_logs.edit')->with('soundPostUserLog', $soundPostUserLog);
    }

    /**
     * Update the specified SoundPostUserLog in storage.
     *
     * @param  int              $id
     * @param UpdateSoundPostUserLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSoundPostUserLogRequest $request)
    {
        $soundPostUserLog = $this->soundPostUserLogRepository->findWithoutFail($id);

        if (empty($soundPostUserLog)) {
            Flash::error('Sound Post User Log not found');

            return redirect(route('soundPostUserLogs.index'));
        }

        $soundPostUserLog = $this->soundPostUserLogRepository->update($request->all(), $id);

        Flash::success('Sound Post User Log updated successfully.');

        return redirect(route('soundPostUserLogs.index'));
    }

    /**
     * Remove the specified SoundPostUserLog from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $soundPostUserLog = $this->soundPostUserLogRepository->findWithoutFail($id);

        if (empty($soundPostUserLog)) {
            Flash::error('Sound Post User Log not found');

            return redirect(route('soundPostUserLogs.index'));
        }

        $this->soundPostUserLogRepository->delete($id);

        Flash::success('Sound Post User Log deleted successfully.');

        return redirect(route('soundPostUserLogs.index'));
    }
}

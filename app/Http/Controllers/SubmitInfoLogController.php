<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubmitInfoLogRequest;
use App\Http\Requests\UpdateSubmitInfoLogRequest;
use App\Repositories\SubmitInfoLogRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\SubmitInfoLog;

class SubmitInfoLogController extends AppBaseController
{
    /** @var  SubmitInfoLogRepository */
    private $submitInfoLogRepository;

    public function __construct(SubmitInfoLogRepository $submitInfoLogRepo)
    {
        $this->submitInfoLogRepository = $submitInfoLogRepo;
    }

    /**
     * Display a listing of the SubmitInfoLog.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->submitInfoLogRepository->pushCriteria(new RequestCriteria($request));
        $submitInfoLogs = defaultPaginate($this->submitInfoLogRepository);

        return view('submit_info_logs.index')
            ->with('submitInfoLogs', $submitInfoLogs);
    }

    /**
     * Show the form for creating a new SubmitInfoLog.
     *
     * @return Response
     */
    public function create()
    {
        return view('submit_info_logs.create');
    }

    /**
     * Store a newly created SubmitInfoLog in storage.
     *
     * @param CreateSubmitInfoLogRequest $request
     *
     * @return Response
     */
    public function store(CreateSubmitInfoLogRequest $request)
    {
        $input = $request->all();

        $submitInfoLog = $this->submitInfoLogRepository->create($input);

        Flash::success('Submit Info Log saved successfully.');

        return redirect(route('submitInfoLogs.index'));
    }

    /**
     * Display the specified SubmitInfoLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $submitInfoLog = $this->submitInfoLogRepository->findWithoutFail($id);

        if (empty($submitInfoLog)) {
            Flash::error('Submit Info Log not found');

            return redirect(route('submitInfoLogs.index'));
        }

        return view('submit_info_logs.show')->with('submitInfoLog', $submitInfoLog);
    }

    /**
     * Show the form for editing the specified SubmitInfoLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $submitInfoLog = $this->submitInfoLogRepository->findWithoutFail($id);

        if (empty($submitInfoLog)) {
            Flash::error('Submit Info Log not found');

            return redirect(route('submitInfoLogs.index'));
        }

        return view('submit_info_logs.edit')->with('submitInfoLog', $submitInfoLog);
    }

    /**
     * Update the specified SubmitInfoLog in storage.
     *
     * @param  int              $id
     * @param UpdateSubmitInfoLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSubmitInfoLogRequest $request)
    {
        $submitInfoLog = $this->submitInfoLogRepository->findWithoutFail($id);

        if (empty($submitInfoLog)) {
            Flash::error('Submit Info Log not found');

            return redirect(route('submitInfoLogs.index'));
        }

        $submitInfoLog = $this->submitInfoLogRepository->update($request->all(), $id);

        Flash::success('更新成功.');

        return redirect(route('submitInfoLogs.index'));
    }

    /**
     * Remove the specified SubmitInfoLog from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $submitInfoLog = $this->submitInfoLogRepository->findWithoutFail($id);

        if (empty($submitInfoLog)) {
            Flash::error('Submit Info Log not found');

            return redirect(route('submitInfoLogs.index'));
        }

        $this->submitInfoLogRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('submitInfoLogs.index'));
    }

    public function front(Request $request)
    {
        $submitLogs = SubmitInfoLog::orderBy('created_at', 'desc')->paginate(15);
        return view('submit_info_logs.index_front')
            ->with('submitInfoLogs', $submitLogs);
    }
}

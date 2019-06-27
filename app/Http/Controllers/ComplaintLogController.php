<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateComplaintLogRequest;
use App\Http\Requests\UpdateComplaintLogRequest;
use App\Repositories\ComplaintLogRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ComplaintLogController extends AppBaseController
{
    /** @var  ComplaintLogRepository */
    private $complaintLogRepository;

    public function __construct(ComplaintLogRepository $complaintLogRepo)
    {
        $this->complaintLogRepository = $complaintLogRepo;
    }

    /**
     * Display a listing of the ComplaintLog.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->complaintLogRepository->pushCriteria(new RequestCriteria($request));
        $complaintLogs = $this->complaintLogRepository
        ->orderBy('created_at','desc')
        ->paginate(15);

        return view('complaint_logs.index')
            ->with('complaintLogs', $complaintLogs);
    }

    /**
     * Show the form for creating a new ComplaintLog.
     *
     * @return Response
     */
    public function create()
    {
        return view('complaint_logs.create');
    }

    /**
     * Store a newly created ComplaintLog in storage.
     *
     * @param CreateComplaintLogRequest $request
     *
     * @return Response
     */
    public function store(CreateComplaintLogRequest $request)
    {
        $input = $request->all();

        $complaintLog = $this->complaintLogRepository->create($input);

        Flash::success('Complaint Log saved successfully.');

        return redirect(route('complaintLogs.index'));
    }

    /**
     * Display the specified ComplaintLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $complaintLog = $this->complaintLogRepository->findWithoutFail($id);

        if (empty($complaintLog)) {
            Flash::error('Complaint Log not found');

            return redirect(route('complaintLogs.index'));
        }

        return view('complaint_logs.show')->with('complaintLog', $complaintLog);
    }

    /**
     * Show the form for editing the specified ComplaintLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $complaintLog = $this->complaintLogRepository->findWithoutFail($id);

        if (empty($complaintLog)) {
            Flash::error('Complaint Log not found');

            return redirect(route('complaintLogs.index'));
        }

        return view('complaint_logs.edit')->with('complaintLog', $complaintLog);
    }

    /**
     * Update the specified ComplaintLog in storage.
     *
     * @param  int              $id
     * @param UpdateComplaintLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateComplaintLogRequest $request)
    {
        $complaintLog = $this->complaintLogRepository->findWithoutFail($id);

        if (empty($complaintLog)) {
            Flash::error('Complaint Log not found');

            return redirect(route('complaintLogs.index'));
        }

        $complaintLog = $this->complaintLogRepository->update($request->all(), $id);

        Flash::success('Complaint Log updated successfully.');

        return redirect(route('complaintLogs.index'));
    }

    /**
     * Remove the specified ComplaintLog from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $complaintLog = $this->complaintLogRepository->findWithoutFail($id);

        if (empty($complaintLog)) {
            Flash::error('Complaint Log not found');

            return redirect(route('complaintLogs.index'));
        }

        $this->complaintLogRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('complaintLogs.index'));
    }
}

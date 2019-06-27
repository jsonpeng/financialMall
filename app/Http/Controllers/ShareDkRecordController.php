<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateShareDkRecordRequest;
use App\Http\Requests\UpdateShareDkRecordRequest;
use App\Repositories\ShareDkRecordRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\ShareDkRecord;

class ShareDkRecordController extends AppBaseController
{
    /** @var  ShareDkRecordRepository */
    private $shareDkRecordRepository;

    public function __construct(ShareDkRecordRepository $shareDkRecordRepo)
    {
        $this->shareDkRecordRepository = $shareDkRecordRepo;
    }

    /**
     * Display a listing of the ShareDkRecord.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        // $this->shareDkRecordRepository->pushCriteria(new RequestCriteria($request));
        // $shareDkRecords = $this->shareDkRecordRepository->all();

        $shareDkRecords = ShareDkRecord::orderBy('created_at', 'desc')->paginate(15);
        return view('share_dk_records.index')
            ->with('shareDkRecords', $shareDkRecords);
    }

    /**
     * Show the form for creating a new ShareDkRecord.
     *
     * @return Response
     */
    public function create()
    {
        return view('share_dk_records.create');
    }

    /**
     * Store a newly created ShareDkRecord in storage.
     *
     * @param CreateShareDkRecordRequest $request
     *
     * @return Response
     */
    public function store(CreateShareDkRecordRequest $request)
    {
        $input = $request->all();

        $shareDkRecord = $this->shareDkRecordRepository->create($input);

        Flash::success('Share Dk Record saved successfully.');

        return redirect(route('shareDkRecords.index'));
    }

    /**
     * Display the specified ShareDkRecord.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $shareDkRecord = $this->shareDkRecordRepository->findWithoutFail($id);

        if (empty($shareDkRecord)) {
            Flash::error('Share Dk Record not found');

            return redirect(route('shareDkRecords.index'));
        }

        return view('share_dk_records.show')->with('shareDkRecord', $shareDkRecord);
    }

    /**
     * Show the form for editing the specified ShareDkRecord.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $shareDkRecord = $this->shareDkRecordRepository->findWithoutFail($id);

        if (empty($shareDkRecord)) {
            Flash::error('Share Dk Record not found');

            return redirect(route('shareDkRecords.index'));
        }

        return view('share_dk_records.edit')->with('shareDkRecord', $shareDkRecord);
    }

    /**
     * Update the specified ShareDkRecord in storage.
     *
     * @param  int              $id
     * @param UpdateShareDkRecordRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShareDkRecordRequest $request)
    {
        $shareDkRecord = $this->shareDkRecordRepository->findWithoutFail($id);

        if (empty($shareDkRecord)) {
            Flash::error('Share Dk Record not found');

            return redirect(route('shareDkRecords.index'));
        }

        $shareDkRecord = $this->shareDkRecordRepository->update($request->all(), $id);

        Flash::success('Share Dk Record updated successfully.');

        return redirect(route('shareDkRecords.index'));
    }

    /**
     * Remove the specified ShareDkRecord from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $shareDkRecord = $this->shareDkRecordRepository->findWithoutFail($id);

        if (empty($shareDkRecord)) {
            Flash::error('Share Dk Record not found');

            return redirect(route('shareDkRecords.index'));
        }

        $this->shareDkRecordRepository->delete($id);

        Flash::success('Share Dk Record deleted successfully.');

        return redirect(route('shareDkRecords.index'));
    }
}

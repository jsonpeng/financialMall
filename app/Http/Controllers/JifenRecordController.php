<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJifenRecordRequest;
use App\Http\Requests\UpdateJifenRecordRequest;
use App\Repositories\JifenRecordRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class JifenRecordController extends AppBaseController
{
    /** @var  JifenRecordRepository */
    private $jifenRecordRepository;

    public function __construct(JifenRecordRepository $jifenRecordRepo)
    {
        $this->jifenRecordRepository = $jifenRecordRepo;
    }

    /**
     * Display a listing of the JifenRecord.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->jifenRecordRepository->pushCriteria(new RequestCriteria($request));
        $jifenRecords = $this->jifenRecordRepository->all();

        return view('jifen_records.index')
            ->with('jifenRecords', $jifenRecords);
    }

    /**
     * Show the form for creating a new JifenRecord.
     *
     * @return Response
     */
    public function create()
    {
        return view('jifen_records.create');
    }

    /**
     * Store a newly created JifenRecord in storage.
     *
     * @param CreateJifenRecordRequest $request
     *
     * @return Response
     */
    public function store(CreateJifenRecordRequest $request)
    {
        $input = $request->all();

        $jifenRecord = $this->jifenRecordRepository->create($input);

        Flash::success('Jifen Record saved successfully.');

        return redirect(route('jifenRecords.index'));
    }

    /**
     * Display the specified JifenRecord.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $jifenRecord = $this->jifenRecordRepository->findWithoutFail($id);

        if (empty($jifenRecord)) {
            Flash::error('Jifen Record not found');

            return redirect(route('jifenRecords.index'));
        }

        return view('jifen_records.show')->with('jifenRecord', $jifenRecord);
    }

    /**
     * Show the form for editing the specified JifenRecord.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $jifenRecord = $this->jifenRecordRepository->findWithoutFail($id);

        if (empty($jifenRecord)) {
            Flash::error('Jifen Record not found');

            return redirect(route('jifenRecords.index'));
        }

        return view('jifen_records.edit')->with('jifenRecord', $jifenRecord);
    }

    /**
     * Update the specified JifenRecord in storage.
     *
     * @param  int              $id
     * @param UpdateJifenRecordRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateJifenRecordRequest $request)
    {
        $jifenRecord = $this->jifenRecordRepository->findWithoutFail($id);

        if (empty($jifenRecord)) {
            Flash::error('Jifen Record not found');

            return redirect(route('jifenRecords.index'));
        }

        $jifenRecord = $this->jifenRecordRepository->update($request->all(), $id);

        Flash::success('Jifen Record updated successfully.');

        return redirect(route('jifenRecords.index'));
    }

    /**
     * Remove the specified JifenRecord from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $jifenRecord = $this->jifenRecordRepository->findWithoutFail($id);

        if (empty($jifenRecord)) {
            Flash::error('Jifen Record not found');

            return redirect(route('jifenRecords.index'));
        }

        $this->jifenRecordRepository->delete($id);

        Flash::success('Jifen Record deleted successfully.');

        return redirect(route('jifenRecords.index'));
    }
}

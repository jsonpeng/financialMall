<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMoneyRecordRequest;
use App\Http\Requests\UpdateMoneyRecordRequest;
use App\Repositories\MoneyRecordRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\MoneyRecord;

class MoneyRecordController extends AppBaseController
{
    /** @var  MoneyRecordRepository */
    private $moneyRecordRepository;

    public function __construct(MoneyRecordRepository $moneyRecordRepo)
    {
        $this->moneyRecordRepository = $moneyRecordRepo;
    }

    /**
     * Display a listing of the MoneyRecord.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$this->moneyRecordRepository->pushCriteria(new RequestCriteria($request));
        //$moneyRecords = $this->moneyRecordRepository->all();

        $moneyRecords = MoneyRecord::orderBy('created_at', 'desc')->paginate(15);
        return view('money_records.index')
            ->with('moneyRecords', $moneyRecords);
    }

    /**
     * Show the form for creating a new MoneyRecord.
     *
     * @return Response
     */
    public function create()
    {
        return view('money_records.create');
    }

    /**
     * Store a newly created MoneyRecord in storage.
     *
     * @param CreateMoneyRecordRequest $request
     *
     * @return Response
     */
    public function store(CreateMoneyRecordRequest $request)
    {
        $input = $request->all();

        $moneyRecord = $this->moneyRecordRepository->create($input);

        Flash::success('Money Record saved successfully.');

        return redirect(route('moneyRecords.index'));
    }

    /**
     * Display the specified MoneyRecord.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $moneyRecord = $this->moneyRecordRepository->findWithoutFail($id);

        if (empty($moneyRecord)) {
            Flash::error('Money Record not found');

            return redirect(route('moneyRecords.index'));
        }

        return view('money_records.show')->with('moneyRecord', $moneyRecord);
    }

    /**
     * Show the form for editing the specified MoneyRecord.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $moneyRecord = $this->moneyRecordRepository->findWithoutFail($id);

        if (empty($moneyRecord)) {
            Flash::error('Money Record not found');

            return redirect(route('moneyRecords.index'));
        }

        return view('money_records.edit')->with('moneyRecord', $moneyRecord);
    }

    /**
     * Update the specified MoneyRecord in storage.
     *
     * @param  int              $id
     * @param UpdateMoneyRecordRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $moneyRecord = $this->moneyRecordRepository->findWithoutFail($id);

        if (empty($moneyRecord)) {
            Flash::error('Money Record not found');

            return redirect(route('moneyRecords.index'));
        }

        $moneyRecord = $this->moneyRecordRepository->update($request->only(['status', 'info']), $id);

        Flash::success('Money Record updated successfully.');

        return redirect(route('moneyRecords.index'));
    }

    /**
     * Remove the specified MoneyRecord from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $moneyRecord = $this->moneyRecordRepository->findWithoutFail($id);

        if (empty($moneyRecord)) {
            Flash::error('Money Record not found');

            return redirect(route('moneyRecords.index'));
        }

        $this->moneyRecordRepository->delete($id);

        Flash::success('Money Record deleted successfully.');

        return redirect(route('moneyRecords.index'));
    }
}

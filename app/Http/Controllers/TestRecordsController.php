<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTestRecordsRequest;
use App\Http\Requests\UpdateTestRecordsRequest;
use App\Repositories\TestRecordsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class TestRecordsController extends AppBaseController
{
    /** @var  TestRecordsRepository */
    private $testRecordsRepository;

    public function __construct(TestRecordsRepository $testRecordsRepo)
    {
        $this->testRecordsRepository = $testRecordsRepo;
    }

    /**
     * Display a listing of the TestRecords.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->testRecordsRepository->pushCriteria(new RequestCriteria($request));

        $testRecords = $this->defaultSearchState($this->testRecordsRepository);
        $testRecords = $this->defaultPaginate($testRecords);
        
        return view('test_records.index')
            ->with('testRecords', $testRecords);
    }

    /**
     * Show the form for creating a new TestRecords.
     *
     * @return Response
     */
    public function create()
    {
        return view('test_records.create');
    }

    /**
     * Store a newly created TestRecords in storage.
     *
     * @param CreateTestRecordsRequest $request
     *
     * @return Response
     */
    public function store(CreateTestRecordsRequest $request)
    {
        $input = $request->all();

        $testRecords = $this->testRecordsRepository->create($input);

        Flash::success('Test Records saved successfully.');

        return redirect(route('testRecords.index'));
    }

    /**
     * Display the specified TestRecords.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $testRecords = $this->testRecordsRepository->findWithoutFail($id);

        if (empty($testRecords)) {
            Flash::error('Test Records not found');

            return redirect(route('testRecords.index'));
        }

        return view('test_records.show')->with('testRecords', $testRecords);
    }

    /**
     * Show the form for editing the specified TestRecords.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $testRecords = $this->testRecordsRepository->findWithoutFail($id);

        if (empty($testRecords)) {
            Flash::error('Test Records not found');

            return redirect(route('testRecords.index'));
        }

        return view('test_records.edit')->with('testRecords', $testRecords);
    }

    /**
     * Update the specified TestRecords in storage.
     *
     * @param  int              $id
     * @param UpdateTestRecordsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTestRecordsRequest $request)
    {
        $testRecords = $this->testRecordsRepository->findWithoutFail($id);

        if (empty($testRecords)) {
            Flash::error('Test Records not found');

            return redirect(route('testRecords.index'));
        }

        $testRecords = $this->testRecordsRepository->update($request->all(), $id);

        Flash::success('Test Records updated successfully.');

        return redirect(route('testRecords.index'));
    }

    /**
     * Remove the specified TestRecords from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $testRecords = $this->testRecordsRepository->findWithoutFail($id);

        if (empty($testRecords)) {
            Flash::error('Test Records not found');

            return redirect(route('testRecords.index'));
        }

        $this->testRecordsRepository->delete($id);

        Flash::success('Test Records deleted successfully.');

        return redirect(route('testRecords.index'));
    }
}

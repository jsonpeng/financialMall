<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCashIncomeRequest;
use App\Http\Requests\UpdateCashIncomeRequest;
use App\Repositories\CashIncomeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CashIncomeController extends AppBaseController
{
    /** @var  CashIncomeRepository */
    private $cashIncomeRepository;

    public function __construct(CashIncomeRepository $cashIncomeRepo)
    {
        $this->cashIncomeRepository = $cashIncomeRepo;
    }

    /**
     * Display a listing of the CashIncome.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->cashIncomeRepository->pushCriteria(new RequestCriteria($request));
        $cashIncomes = $this->cashIncomeRepository->all();

        return view('cash_incomes.index')
            ->with('cashIncomes', $cashIncomes);
    }

    /**
     * Show the form for creating a new CashIncome.
     *
     * @return Response
     */
    public function create()
    {
        return view('cash_incomes.create');
    }

    /**
     * Store a newly created CashIncome in storage.
     *
     * @param CreateCashIncomeRequest $request
     *
     * @return Response
     */
    public function store(CreateCashIncomeRequest $request)
    {
        $input = $request->all();

        $cashIncome = $this->cashIncomeRepository->create($input);

        Flash::success('Cash Income saved successfully.');

        return redirect(route('cashIncomes.index'));
    }

    /**
     * Display the specified CashIncome.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cashIncome = $this->cashIncomeRepository->findWithoutFail($id);

        if (empty($cashIncome)) {
            Flash::error('Cash Income not found');

            return redirect(route('cashIncomes.index'));
        }

        return view('cash_incomes.show')->with('cashIncome', $cashIncome);
    }

    /**
     * Show the form for editing the specified CashIncome.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cashIncome = $this->cashIncomeRepository->findWithoutFail($id);

        if (empty($cashIncome)) {
            Flash::error('Cash Income not found');

            return redirect(route('cashIncomes.index'));
        }

        return view('cash_incomes.edit')->with('cashIncome', $cashIncome);
    }

    /**
     * Update the specified CashIncome in storage.
     *
     * @param  int              $id
     * @param UpdateCashIncomeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCashIncomeRequest $request)
    {
        $cashIncome = $this->cashIncomeRepository->findWithoutFail($id);

        if (empty($cashIncome)) {
            Flash::error('Cash Income not found');

            return redirect(route('cashIncomes.index'));
        }

        $cashIncome = $this->cashIncomeRepository->update($request->all(), $id);

        Flash::success('Cash Income updated successfully.');

        return redirect(route('cashIncomes.index'));
    }

    /**
     * Remove the specified CashIncome from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cashIncome = $this->cashIncomeRepository->findWithoutFail($id);

        if (empty($cashIncome)) {
            Flash::error('Cash Income not found');

            return redirect(route('cashIncomes.index'));
        }

        $this->cashIncomeRepository->delete($id);

        Flash::success('Cash Income deleted successfully.');

        return redirect(route('cashIncomes.index'));
    }
}

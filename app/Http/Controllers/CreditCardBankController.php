<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCreditCardBankRequest;
use App\Http\Requests\UpdateCreditCardBankRequest;
use App\Repositories\CreditCardBankRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CreditCardBankController extends AppBaseController
{
    /** @var  CreditCardBankRepository */
    private $creditCardBankRepository;

    public function __construct(CreditCardBankRepository $creditCardBankRepo)
    {
        $this->creditCardBankRepository = $creditCardBankRepo;
    }

    /**
     * Display a listing of the CreditCardBank.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->creditCardBankRepository->pushCriteria(new RequestCriteria($request));
        $creditCardBanks = $this->creditCardBankRepository->all();

        return view('credit_card_banks.index')
            ->with('creditCardBanks', $creditCardBanks);
    }

    /**
     * Show the form for creating a new CreditCardBank.
     *
     * @return Response
     */
    public function create()
    {
        return view('credit_card_banks.create')
         ->with('model_required',\Zcjy::modelRequiredParam($this->creditCardBankRepository->model()));
    }

    /**
     * Store a newly created CreditCardBank in storage.
     *
     * @param CreateCreditCardBankRequest $request
     *
     * @return Response
     */
    public function store(CreateCreditCardBankRequest $request)
    {
        $input = $request->all();

        $creditCardBank = $this->creditCardBankRepository->create($input);

        Flash::success('保存成功');

        return redirect(route('creditCardBanks.index'));
    }

    /**
     * Display the specified CreditCardBank.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $creditCardBank = $this->creditCardBankRepository->findWithoutFail($id);

        if (empty($creditCardBank)) {
            Flash::error('信息不存在');

            return redirect(route('creditCardBanks.index'));
        }

        return view('credit_card_banks.show')->with('creditCardBank', $creditCardBank);
    }

    /**
     * Show the form for editing the specified CreditCardBank.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $creditCardBank = $this->creditCardBankRepository->findWithoutFail($id);

        if (empty($creditCardBank)) {
            Flash::error('信息不存在');

            return redirect(route('creditCardBanks.index'));
        }

        return view('credit_card_banks.edit')
        ->with('creditCardBank', $creditCardBank)
        ->with('model_required',\Zcjy::modelRequiredParam($this->creditCardBankRepository->model()));
    }

    /**
     * Update the specified CreditCardBank in storage.
     *
     * @param  int              $id
     * @param UpdateCreditCardBankRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCreditCardBankRequest $request)
    {
        $creditCardBank = $this->creditCardBankRepository->findWithoutFail($id);

        if (empty($creditCardBank)) {
            Flash::error('信息不存在');

            return redirect(route('creditCardBanks.index'));
        }

        $creditCardBank = $this->creditCardBankRepository->update($request->all(), $id);

        Flash::success('更新成功');

        return redirect(route('creditCardBanks.index'));
    }

    /**
     * Remove the specified CreditCardBank from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $creditCardBank = $this->creditCardBankRepository->findWithoutFail($id);

        if (empty($creditCardBank)) {
            Flash::error('信息不存在');

            return redirect(route('creditCardBanks.index'));
        }

        $this->creditCardBankRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('creditCardBanks.index'));
    }
}

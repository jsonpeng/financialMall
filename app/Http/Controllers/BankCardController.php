<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBankCardRequest;
use App\Http\Requests\UpdateBankCardRequest;
use App\Repositories\BankCardRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class BankCardController extends AppBaseController
{
    /** @var  BankCardRepository */
    private $bankCardRepository;

    public function __construct(BankCardRepository $bankCardRepo)
    {
        $this->bankCardRepository = $bankCardRepo;
    }

    /**
     * Display a listing of the BankCard.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->bankCardRepository->pushCriteria(new RequestCriteria($request));
        $bankCards = $this->bankCardRepository->all();

        return view('bank_cards.index')
            ->with('bankCards', $bankCards);
    }

    /**
     * Show the form for creating a new BankCard.
     *
     * @return Response
     */
    public function create()
    {
        return view('bank_cards.create');
    }

    /**
     * Store a newly created BankCard in storage.
     *
     * @param CreateBankCardRequest $request
     *
     * @return Response
     */
    public function store(CreateBankCardRequest $request)
    {
        $input = $request->all();

        $bankCard = $this->bankCardRepository->create($input);

        Flash::success('银行卡保存成功.');

        return redirect(route('bankCards.index'));
    }

    /**
     * Display the specified BankCard.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $bankCard = $this->bankCardRepository->findWithoutFail($id);

        if (empty($bankCard)) {
            Flash::error('银行卡不存在');

            return redirect(route('bankCards.index'));
        }

        return view('bank_cards.show')->with('bankCard', $bankCard);
    }

    /**
     * Show the form for editing the specified BankCard.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $bankCard = $this->bankCardRepository->findWithoutFail($id);

        if (empty($bankCard)) {
            Flash::error('银行卡不存在');

            return redirect(route('bankCards.index'));
        }

        return view('bank_cards.edit')->with('bankCard', $bankCard);
    }

    /**
     * Update the specified BankCard in storage.
     *
     * @param  int              $id
     * @param UpdateBankCardRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBankCardRequest $request)
    {
        $bankCard = $this->bankCardRepository->findWithoutFail($id);

        if (empty($bankCard)) {
            Flash::error('银行卡不存在');

            return redirect(route('bankCards.index'));
        }

        $bankCard = $this->bankCardRepository->update($request->all(), $id);

        Flash::success('更新成功');

        return redirect(route('bankCards.index'));
    }

    /**
     * Remove the specified BankCard from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $bankCard = $this->bankCardRepository->findWithoutFail($id);

        if (empty($bankCard)) {
            Flash::error('银行卡不存在');

            return redirect(route('bankCards.index'));
        }

        $this->bankCardRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('bankCards.index'));
    }
}

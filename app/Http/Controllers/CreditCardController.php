<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCreditCardRequest;
use App\Http\Requests\UpdateCreditCardRequest;
use App\Repositories\CreditCardRepository;
use App\Repositories\CreditCardBankRepository;
use App\Repositories\CreditCardThemeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\CreditCard;

class CreditCardController extends AppBaseController
{
    /** @var  CreditCardRepository */
    private $creditCardRepository;
    private $creditCardBankRepository;
    private $creditCardThemeRepository;

    public function __construct(CreditCardRepository $creditCardRepo, CreditCardBankRepository $creditCardBankRepo, CreditCardThemeRepository $creditCardThemeRepo)
    {
        $this->creditCardRepository = $creditCardRepo;
        $this->creditCardBankRepository = $creditCardBankRepo;
        $this->creditCardThemeRepository = $creditCardThemeRepo;
    }

    /**
     * Display a listing of the CreditCard.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        session(['productIndexUrl' => $request->fullUrl()]);
        //$this->creditCardRepository->pushCriteria(new RequestCriteria($request));
        //$creditCards = $this->creditCardRepository->all();
        if ($request->has('page')) {
            session(['page' => $request->input('page')]);
        } else {
            session(['page' => 1]);
        }
        
        $creditCards = CreditCard::orderBy('created_at', 'desc');

        $input = $request->all();

        if (array_key_exists('name', $input) && $input['name'] != "") {
            $creditCards->where('name', 'like', '%'.$input['name'].'%');
        }
        if (array_key_exists('theme', $input) && $input['theme'] != "全部") {
            $creditCards->where('credit_card_theme_id', $input['theme']);
        }
        if (array_key_exists('bank', $input) && $input['bank'] != "全部") {
            $creditCards->where('credit_card_bank_id', $input['bank']);
        }
        $creditCards = $creditCards->paginate(15);

        $creditCardBanks = $this->creditCardBankRepository->all();
        $creditCardThemes = $this->creditCardThemeRepository->all();

        return view('credit_cards.index')
            ->with('creditCards', $creditCards)
            ->with('creditCardBanks', $creditCardBanks)
            ->with('creditCardThemes', $creditCardThemes)
            ->withInput($input);
    }

    /**
     * Show the form for creating a new CreditCard.
     *
     * @return Response
     */
    public function create()
    {
        $creditCardBanks = $this->creditCardBankRepository->all();
        $creditCardThemes = $this->creditCardThemeRepository->all();
        return view('credit_cards.create')
        ->with('creditCardBanks', $creditCardBanks)
        ->with('creditCardThemes', $creditCardThemes)
        ->with('model_required',\Zcjy::modelRequiredParam($this->creditCardRepository->model()));
    }

    /**
     * Store a newly created CreditCard in storage.
     *
     * @param CreateCreditCardRequest $request
     *
     * @return Response
     */
    public function store(CreateCreditCardRequest $request)
    {
        $input = $request->all();

        if (array_key_exists('link', $input) && $input['link'] != '') {
            if(!preg_match("/^(http:\/\/|https:\/\/).*$/", $input['link'])){
                $input['link'] = 'http://'.$input['link'];
            }
        }

        if (empty($input['view'] )) {
             $input['view'] = random_int(100000, 500000);
        }

        $creditCard = $this->creditCardRepository->create($input);

        Flash::success('保存成功');

        return redirect(route('creditCards.index'));
    }

    /**
     * Display the specified CreditCard.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $creditCard = $this->creditCardRepository->findWithoutFail($id);

        if (empty($creditCard)) {
            Flash::error('信息不存在');

            return redirect(route('creditCards.index'));
        }

        return view('credit_cards.show')->with('creditCard', $creditCard);
    }

    /**
     * Show the form for editing the specified CreditCard.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $creditCard = $this->creditCardRepository->findWithoutFail($id);

        if (empty($creditCard)) {
            Flash::error('信息不存在');

            return redirect(route('creditCards.index'));
        }

        $creditCardBanks = $this->creditCardBankRepository->all();
        $creditCardThemes = $this->creditCardThemeRepository->all();

        return view('credit_cards.edit')
        ->with('creditCard', $creditCard)
        ->with('creditCardBanks', $creditCardBanks)
        ->with('creditCardThemes', $creditCardThemes)
        ->with('model_required',\Zcjy::modelRequiredParam($this->creditCardRepository->model()));
    }

    /**
     * Update the specified CreditCard in storage.
     *
     * @param  int              $id
     * @param UpdateCreditCardRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCreditCardRequest $request)
    {
        $creditCard = $this->creditCardRepository->findWithoutFail($id);

        if (empty($creditCard)) {
            Flash::error('信息不存在');

            return redirect(route('creditCards.index'));
        }

        $input = $request->all();
        if (array_key_exists('link', $input) && $input['link'] != '') {
            if(!preg_match("/^(http:\/\/|https:\/\/).*$/", $input['link'])){
                $input['link'] = 'http://'.$input['link'];
            }
        }

        if (empty($input['view'] )) {
             $input['view'] = random_int(100000, 500000);
        }

        if (!array_key_exists('hot', $input)) {
            $input['hot'] = 0;
        }

        $creditCard = $this->creditCardRepository->update($input, $id);

        Flash::success('更新成功');

         return redirect(session('productIndexUrl'));

        //return redirect(route('creditCards.index', ['page' => session('page')]));
    }

    /**
     * Remove the specified CreditCard from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $creditCard = $this->creditCardRepository->findWithoutFail($id);

        if (empty($creditCard)) {
            Flash::error('信息不存在');

            return redirect(route('creditCards.index'));
        }

        $this->creditCardRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('creditCards.index', ['page' => session('page')]));
    }
}

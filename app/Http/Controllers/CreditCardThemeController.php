<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCreditCardThemeRequest;
use App\Http\Requests\UpdateCreditCardThemeRequest;
use App\Repositories\CreditCardThemeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CreditCardThemeController extends AppBaseController
{
    /** @var  CreditCardThemeRepository */
    private $creditCardThemeRepository;

    public function __construct(CreditCardThemeRepository $creditCardThemeRepo)
    {
        $this->creditCardThemeRepository = $creditCardThemeRepo;
    }

    /**
     * Display a listing of the CreditCardTheme.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->creditCardThemeRepository->pushCriteria(new RequestCriteria($request));
        $creditCardThemes = $this->creditCardThemeRepository->all();

        return view('credit_card_themes.index')
            ->with('creditCardThemes', $creditCardThemes);
    }

    /**
     * Show the form for creating a new CreditCardTheme.
     *
     * @return Response
     */
    public function create()
    {
        return view('credit_card_themes.create')
          ->with('model_required',\Zcjy::modelRequiredParam($this->creditCardThemeRepository->model()));
    }

    /**
     * Store a newly created CreditCardTheme in storage.
     *
     * @param CreateCreditCardThemeRequest $request
     *
     * @return Response
     */
    public function store(CreateCreditCardThemeRequest $request)
    {
        $input = $request->all();

        $creditCardTheme = $this->creditCardThemeRepository->create($input);

        Flash::success('保存成功');

        return redirect(route('creditCardThemes.index'));
    }

    /**
     * Display the specified CreditCardTheme.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $creditCardTheme = $this->creditCardThemeRepository->findWithoutFail($id);

        if (empty($creditCardTheme)) {
            Flash::error('信息不存在');

            return redirect(route('creditCardThemes.index'));
        }

        return view('credit_card_themes.show')->with('creditCardTheme', $creditCardTheme);
    }

    /**
     * Show the form for editing the specified CreditCardTheme.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $creditCardTheme = $this->creditCardThemeRepository->findWithoutFail($id);

        if (empty($creditCardTheme)) {
            Flash::error('信息不存在');

            return redirect(route('creditCardThemes.index'));
        }

        return view('credit_card_themes.edit')
        ->with('creditCardTheme', $creditCardTheme)
        ->with('model_required',\Zcjy::modelRequiredParam($this->creditCardThemeRepository->model()));
    }

    /**
     * Update the specified CreditCardTheme in storage.
     *
     * @param  int              $id
     * @param UpdateCreditCardThemeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCreditCardThemeRequest $request)
    {
        $creditCardTheme = $this->creditCardThemeRepository->findWithoutFail($id);

        if (empty($creditCardTheme)) {
            Flash::error('信息不存在');

            return redirect(route('creditCardThemes.index'));
        }

        $creditCardTheme = $this->creditCardThemeRepository->update($request->all(), $id);

        Flash::success('更新成功');

        return redirect(route('creditCardThemes.index'));
    }

    /**
     * Remove the specified CreditCardTheme from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $creditCardTheme = $this->creditCardThemeRepository->findWithoutFail($id);

        if (empty($creditCardTheme)) {
            Flash::error('信息不存在');

            return redirect(route('creditCardThemes.index'));
        }

        $this->creditCardThemeRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('creditCardThemes.index'));
    }
}

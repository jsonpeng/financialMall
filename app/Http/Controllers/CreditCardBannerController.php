<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCreditCardBannerRequest;
use App\Http\Requests\UpdateCreditCardBannerRequest;
use App\Repositories\CreditCardBannerRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CreditCardBannerController extends AppBaseController
{
    /** @var  CreditCardBannerRepository */
    private $creditCardBannerRepository;

    public function __construct(CreditCardBannerRepository $creditCardBannerRepo)
    {
        $this->creditCardBannerRepository = $creditCardBannerRepo;
    }

    /**
     * Display a listing of the CreditCardBanner.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->creditCardBannerRepository->pushCriteria(new RequestCriteria($request));
        $creditCardBanners = $this->creditCardBannerRepository->all();

        return view('credit_card_banners.index')
            ->with('creditCardBanners', $creditCardBanners);
    }

    /**
     * Show the form for creating a new CreditCardBanner.
     *
     * @return Response
     */
    public function create()
    {
        return view('credit_card_banners.create');
    }

    /**
     * Store a newly created CreditCardBanner in storage.
     *
     * @param CreateCreditCardBannerRequest $request
     *
     * @return Response
     */
    public function store(CreateCreditCardBannerRequest $request)
    {
        $input = $request->all();

        $creditCardBanner = $this->creditCardBannerRepository->create($input);

        Flash::success('保存成功');

        return redirect(route('creditCardBanners.index'));
    }

    /**
     * Display the specified CreditCardBanner.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $creditCardBanner = $this->creditCardBannerRepository->findWithoutFail($id);

        if (empty($creditCardBanner)) {
            Flash::error('信息不存在');

            return redirect(route('creditCardBanners.index'));
        }

        return view('credit_card_banners.show')->with('creditCardBanner', $creditCardBanner);
    }

    /**
     * Show the form for editing the specified CreditCardBanner.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $creditCardBanner = $this->creditCardBannerRepository->findWithoutFail($id);

        if (empty($creditCardBanner)) {
            Flash::error('信息不存在');

            return redirect(route('creditCardBanners.index'));
        }

        return view('credit_card_banners.edit')->with('creditCardBanner', $creditCardBanner);
    }

    /**
     * Update the specified CreditCardBanner in storage.
     *
     * @param  int              $id
     * @param UpdateCreditCardBannerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCreditCardBannerRequest $request)
    {
        $creditCardBanner = $this->creditCardBannerRepository->findWithoutFail($id);

        if (empty($creditCardBanner)) {
            Flash::error('信息不存在');

            return redirect(route('creditCardBanners.index'));
        }

        $creditCardBanner = $this->creditCardBannerRepository->update($request->all(), $id);

        Flash::success('更新成功');

        return redirect(route('creditCardBanners.index'));
    }

    /**
     * Remove the specified CreditCardBanner from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $creditCardBanner = $this->creditCardBannerRepository->findWithoutFail($id);

        if (empty($creditCardBanner)) {
            Flash::error('信息不存在');

            return redirect(route('creditCardBanners.index'));
        }

        $this->creditCardBannerRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('creditCardBanners.index'));
    }
}

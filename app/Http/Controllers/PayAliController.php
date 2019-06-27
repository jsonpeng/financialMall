<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePayAliRequest;
use App\Http\Requests\UpdatePayAliRequest;
use App\Repositories\PayAliRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PayAliController extends AppBaseController
{
    /** @var  PayAliRepository */
    private $payAliRepository;

    public function __construct(PayAliRepository $payAliRepo)
    {
        $this->payAliRepository = $payAliRepo;
    }

    /**
     * Display a listing of the PayAli.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->payAliRepository->pushCriteria(new RequestCriteria($request));
        $payAlis = $this->payAliRepository->all();

        return view('pay_alis.index')
            ->with('payAlis', $payAlis);
    }

    /**
     * Show the form for creating a new PayAli.
     *
     * @return Response
     */
    public function create()
    {
        return view('pay_alis.create');
    }

    /**
     * Store a newly created PayAli in storage.
     *
     * @param CreatePayAliRequest $request
     *
     * @return Response
     */
    public function store(CreatePayAliRequest $request)
    {
        $input = $request->all();

        $payAli = $this->payAliRepository->create($input);

        Flash::success('保存成功');

        return redirect(route('payAlis.index'));
    }

    /**
     * Display the specified PayAli.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $payAli = $this->payAliRepository->findWithoutFail($id);

        if (empty($payAli)) {
            Flash::error('信息不存在');

            return redirect(route('payAlis.index'));
        }

        return view('pay_alis.show')->with('payAli', $payAli);
    }

    /**
     * Show the form for editing the specified PayAli.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $payAli = $this->payAliRepository->findWithoutFail($id);

        if (empty($payAli)) {
            Flash::error('信息不存在');

            return redirect(route('payAlis.index'));
        }

        return view('pay_alis.edit')->with('payAli', $payAli);
    }

    /**
     * Update the specified PayAli in storage.
     *
     * @param  int              $id
     * @param UpdatePayAliRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePayAliRequest $request)
    {
        $payAli = $this->payAliRepository->findWithoutFail($id);

        if (empty($payAli)) {
            Flash::error('信息不存在');

            return redirect(route('payAlis.index'));
        }

        $payAli = $this->payAliRepository->update($request->all(), $id);

        Flash::success('更新成功');

        return redirect(route('payAlis.index'));
    }

    /**
     * Remove the specified PayAli from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $payAli = $this->payAliRepository->findWithoutFail($id);

        if (empty($payAli)) {
            Flash::error('信息不存在');

            return redirect(route('payAlis.index'));
        }

        $this->payAliRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('payAlis.index'));
    }
}

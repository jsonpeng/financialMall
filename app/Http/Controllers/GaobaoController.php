<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGaobaoRequest;
use App\Http\Requests\UpdateGaobaoRequest;
use App\Repositories\GaobaoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class GaobaoController extends AppBaseController
{
    /** @var  GaobaoRepository */
    private $gaobaoRepository;

    public function __construct(GaobaoRepository $gaobaoRepo)
    {
        $this->gaobaoRepository = $gaobaoRepo;
    }

    /**
     * Display a listing of the Gaobao.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->gaobaoRepository->pushCriteria(new RequestCriteria($request));
        $gaobaos = $this->gaobaoRepository->all();

        return view('gaobaos.index')
            ->with('gaobaos', $gaobaos);
    }

    /**
     * Show the form for creating a new Gaobao.
     *
     * @return Response
     */
    public function create()
    {
        return view('gaobaos.create');
    }

    /**
     * Store a newly created Gaobao in storage.
     *
     * @param CreateGaobaoRequest $request
     *
     * @return Response
     */
    public function store(CreateGaobaoRequest $request)
    {
        $input = $request->all();

        $gaobao = $this->gaobaoRepository->create($input);

        Flash::success('Gaobao saved successfully.');

        return redirect(route('gaobaos.index'));
    }

    /**
     * Display the specified Gaobao.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $gaobao = $this->gaobaoRepository->findWithoutFail($id);

        if (empty($gaobao)) {
            Flash::error('Gaobao not found');

            return redirect(route('gaobaos.index'));
        }

        return view('gaobaos.show')->with('gaobao', $gaobao);
    }

    /**
     * Show the form for editing the specified Gaobao.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $gaobao = $this->gaobaoRepository->findWithoutFail($id);

        if (empty($gaobao)) {
            Flash::error('Gaobao not found');

            return redirect(route('gaobaos.index'));
        }

        return view('gaobaos.edit')->with('gaobao', $gaobao);
    }

    /**
     * Update the specified Gaobao in storage.
     *
     * @param  int              $id
     * @param UpdateGaobaoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGaobaoRequest $request)
    {
        $gaobao = $this->gaobaoRepository->findWithoutFail($id);

        if (empty($gaobao)) {
            Flash::error('Gaobao not found');

            return redirect(route('gaobaos.index'));
        }

        $gaobao = $this->gaobaoRepository->update($request->all(), $id);

        Flash::success('Gaobao updated successfully.');

        return redirect(route('gaobaos.index'));
    }

    /**
     * Remove the specified Gaobao from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $gaobao = $this->gaobaoRepository->findWithoutFail($id);

        if (empty($gaobao)) {
            Flash::error('Gaobao not found');

            return redirect(route('gaobaos.index'));
        }

        $this->gaobaoRepository->delete($id);

        Flash::success('Gaobao deleted successfully.');

        return redirect(route('gaobaos.index'));
    }
}

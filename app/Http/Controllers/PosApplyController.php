<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePosApplyRequest;
use App\Http\Requests\UpdatePosApplyRequest;
use App\Repositories\PosApplyRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\PosApply;

class PosApplyController extends AppBaseController
{
    /** @var  PosApplyRepository */
    private $posApplyRepository;

    public function __construct(PosApplyRepository $posApplyRepo)
    {
        $this->posApplyRepository = $posApplyRepo;
    }

    /**
     * Display a listing of the PosApply.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        
        $posApplies = PosApply::orderBy('created_at', 'desc')->paginate(15);

        return view('pos_applies.index')
            ->with('posApplies', $posApplies);
    }

    /**
     * Show the form for creating a new PosApply.
     *
     * @return Response
     */
    public function create()
    {
        return view('pos_applies.create');
    }

    /**
     * Store a newly created PosApply in storage.
     *
     * @param CreatePosApplyRequest $request
     *
     * @return Response
     */
    public function store(CreatePosApplyRequest $request)
    {
        $input = $request->all();

        $posApply = $this->posApplyRepository->create($input);

        Flash::success('Pos Apply saved successfully.');

        return redirect(route('posApplies.index'));
    }

    /**
     * Display the specified PosApply.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $posApply = $this->posApplyRepository->findWithoutFail($id);

        if (empty($posApply)) {
            Flash::error('Pos Apply not found');

            return redirect(route('posApplies.index'));
        }

        return view('pos_applies.show')->with('posApply', $posApply);
    }

    /**
     * Show the form for editing the specified PosApply.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $posApply = $this->posApplyRepository->findWithoutFail($id);

        if (empty($posApply)) {
            Flash::error('Pos Apply not found');

            return redirect(route('posApplies.index'));
        }

        return view('pos_applies.edit')->with('posApply', $posApply);
    }

    /**
     * Update the specified PosApply in storage.
     *
     * @param  int              $id
     * @param UpdatePosApplyRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePosApplyRequest $request)
    {
        $posApply = $this->posApplyRepository->findWithoutFail($id);

        if (empty($posApply)) {
            Flash::error('Pos Apply not found');

            return redirect(route('posApplies.index'));
        }

        $posApply = $this->posApplyRepository->update($request->all(), $id);

        Flash::success('Pos Apply updated successfully.');

        return redirect(route('posApplies.index'));
    }

    /**
     * Remove the specified PosApply from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $posApply = $this->posApplyRepository->findWithoutFail($id);

        if (empty($posApply)) {
            Flash::error('Pos Apply not found');

            return redirect(route('posApplies.index'));
        }

        $this->posApplyRepository->delete($id);

        Flash::success('Pos Apply deleted successfully.');

        return redirect(route('posApplies.index'));
    }
}

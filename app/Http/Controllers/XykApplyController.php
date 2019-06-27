<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateXykApplyRequest;
use App\Http\Requests\UpdateXykApplyRequest;
use App\Repositories\XykApplyRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\XykApply;

class XykApplyController extends AppBaseController
{
    /** @var  XykApplyRepository */
    private $xykApplyRepository;

    public function __construct(XykApplyRepository $xykApplyRepo)
    {
        $this->xykApplyRepository = $xykApplyRepo;
    }

    /**
     * Display a listing of the XykApply.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        
        $xykApplies = XykApply::orderBy('created_at', 'desc')->paginate(15);

        return view('xyk_applies.index')
            ->with('xykApplies', $xykApplies);
    }

    /**
     * Show the form for creating a new XykApply.
     *
     * @return Response
     */
    public function create()
    {
        return view('xyk_applies.create');
    }

    /**
     * Store a newly created XykApply in storage.
     *
     * @param CreateXykApplyRequest $request
     *
     * @return Response
     */
    public function store(CreateXykApplyRequest $request)
    {
        $input = $request->all();

        $xykApply = $this->xykApplyRepository->create($input);

        Flash::success('Xyk Apply saved successfully.');

        return redirect(route('xykApplies.index'));
    }

    /**
     * Display the specified XykApply.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $xykApply = $this->xykApplyRepository->findWithoutFail($id);

        if (empty($xykApply)) {
            Flash::error('Xyk Apply not found');

            return redirect(route('xykApplies.index'));
        }

        return view('xyk_applies.show')->with('xykApply', $xykApply);
    }

    /**
     * Show the form for editing the specified XykApply.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $xykApply = $this->xykApplyRepository->findWithoutFail($id);

        if (empty($xykApply)) {
            Flash::error('Xyk Apply not found');

            return redirect(route('xykApplies.index'));
        }

        return view('xyk_applies.edit')->with('xykApply', $xykApply);
    }

    /**
     * Update the specified XykApply in storage.
     *
     * @param  int              $id
     * @param UpdateXykApplyRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateXykApplyRequest $request)
    {
        $xykApply = $this->xykApplyRepository->findWithoutFail($id);

        if (empty($xykApply)) {
            Flash::error('Xyk Apply not found');

            return redirect(route('xykApplies.index'));
        }

        $xykApply = $this->xykApplyRepository->update($request->all(), $id);

        Flash::success('Xyk Apply updated successfully.');

        return redirect(route('xykApplies.index'));
    }

    /**
     * Remove the specified XykApply from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $xykApply = $this->xykApplyRepository->findWithoutFail($id);

        if (empty($xykApply)) {
            Flash::error('Xyk Apply not found');

            return redirect(route('xykApplies.index'));
        }

        $this->xykApplyRepository->delete($id);

        Flash::success('Xyk Apply deleted successfully.');

        return redirect(route('xykApplies.index'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGonglueRequest;
use App\Http\Requests\UpdateGonglueRequest;
use App\Repositories\GonglueRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class GonglueController extends AppBaseController
{
    /** @var  GonglueRepository */
    private $gonglueRepository;

    public function __construct(GonglueRepository $gonglueRepo)
    {
        $this->gonglueRepository = $gonglueRepo;
    }

    /**
     * Display a listing of the Gonglue.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->gonglueRepository->pushCriteria(new RequestCriteria($request));
        $gonglues = $this->gonglueRepository->all();

        return view('gonglues.index')
            ->with('gonglues', $gonglues);
    }

    /**
     * Show the form for creating a new Gonglue.
     *
     * @return Response
     */
    public function create()
    {
        return view('gonglues.create');
    }

    /**
     * Store a newly created Gonglue in storage.
     *
     * @param CreateGonglueRequest $request
     *
     * @return Response
     */
    public function store(CreateGonglueRequest $request)
    {
        $input = $request->all();

        if (array_key_exists('content', $input)) {
            $input['content'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
            $input['content'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
        }

        $gonglue = $this->gonglueRepository->create($input);

        Flash::success('Gonglue saved successfully.');

        return redirect(route('gonglues.index'));
    }

    /**
     * Display the specified Gonglue.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $gonglue = $this->gonglueRepository->findWithoutFail($id);

        if (empty($gonglue)) {
            Flash::error('Gonglue not found');

            return redirect(route('gonglues.index'));
        }

        return view('gonglues.show')->with('gonglue', $gonglue);
    }

    /**
     * Show the form for editing the specified Gonglue.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $gonglue = $this->gonglueRepository->findWithoutFail($id);

        if (empty($gonglue)) {
            Flash::error('Gonglue not found');

            return redirect(route('gonglues.index'));
        }

        return view('gonglues.edit')->with('gonglue', $gonglue);
    }

    /**
     * Update the specified Gonglue in storage.
     *
     * @param  int              $id
     * @param UpdateGonglueRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGonglueRequest $request)
    {
        $gonglue = $this->gonglueRepository->findWithoutFail($id);

        if (empty($gonglue)) {
            Flash::error('Gonglue not found');

            return redirect(route('gonglues.index'));
        }

        $input = $request->all();

        if (!array_key_exists('shelf', $input)) {
            $input['shelf'] = 0;
        }

        if (array_key_exists('content', $input)) {
            $input['content'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
            $input['content'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
        }

        $gonglue = $this->gonglueRepository->update($input, $id);

        Flash::success('Gonglue updated successfully.');

        return redirect(route('gonglues.index'));
    }

    /**
     * Remove the specified Gonglue from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $gonglue = $this->gonglueRepository->findWithoutFail($id);

        if (empty($gonglue)) {
            Flash::error('Gonglue not found');

            return redirect(route('gonglues.index'));
        }

        $this->gonglueRepository->delete($id);

        Flash::success('Gonglue deleted successfully.');

        return redirect(route('gonglues.index'));
    }
}

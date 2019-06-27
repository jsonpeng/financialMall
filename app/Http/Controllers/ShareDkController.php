<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateShareDkRequest;
use App\Http\Requests\UpdateShareDkRequest;
use App\Repositories\ShareDkRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ShareDkController extends AppBaseController
{
    /** @var  ShareDkRepository */
    private $shareDkRepository;

    public function __construct(ShareDkRepository $shareDkRepo)
    {
        $this->shareDkRepository = $shareDkRepo;
    }

    /**
     * Display a listing of the ShareDk.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->shareDkRepository->pushCriteria(new RequestCriteria($request));
        $shareDks = $this->shareDkRepository->all();

        return view('share_dks.index')
            ->with('shareDks', $shareDks);
    }

    /**
     * Show the form for creating a new ShareDk.
     *
     * @return Response
     */
    public function create()
    {
        return view('share_dks.create')
          ->with('model_required',\Zcjy::modelRequiredParam($this->shareDkRepository->model()));
    }

    /**
     * Store a newly created ShareDk in storage.
     *
     * @param CreateShareDkRequest $request
     *
     * @return Response
     */
    public function store(CreateShareDkRequest $request)
    {
        $input = $request->all();

        if (!array_key_exists('shelf', $input)) {
            $input['shelf'] = 0;
        }

        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }

        $shareDk = $this->shareDkRepository->create($input);

        Flash::success('Share Dk saved successfully.');

        return redirect(route('shareDks.index'));
    }

    /**
     * Display the specified ShareDk.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $shareDk = $this->shareDkRepository->findWithoutFail($id);

        if (empty($shareDk)) {
            Flash::error('Share Dk not found');

            return redirect(route('shareDks.index'));
        }

        return view('share_dks.show')->with('shareDk', $shareDk);
    }

    /**
     * Show the form for editing the specified ShareDk.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $shareDk = $this->shareDkRepository->findWithoutFail($id);

        if (empty($shareDk)) {
            Flash::error('Share Dk not found');

            return redirect(route('shareDks.index'));
        }

        return view('share_dks.edit')
        ->with('shareDk', $shareDk)
        ->with('model_required',\Zcjy::modelRequiredParam($this->shareDkRepository->model()));
    }

    /**
     * Update the specified ShareDk in storage.
     *
     * @param  int              $id
     * @param UpdateShareDkRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShareDkRequest $request)
    {
        $shareDk = $this->shareDkRepository->findWithoutFail($id);

        if (empty($shareDk)) {
            Flash::error('Share Dk not found');

            return redirect(route('shareDks.index'));
        }

        $input = $request->all();

        if (!array_key_exists('shelf', $input)) {
            $input['shelf'] = 0;
        }

        

        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }

        $shareDk = $this->shareDkRepository->update($input, $id);

        Flash::success('Share Dk updated successfully.');

        return redirect(route('shareDks.index'));
    }

    /**
     * Remove the specified ShareDk from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $shareDk = $this->shareDkRepository->findWithoutFail($id);

        if (empty($shareDk)) {
            Flash::error('Share Dk not found');

            return redirect(route('shareDks.index'));
        }

        $this->shareDkRepository->delete($id);

        Flash::success('Share Dk deleted successfully.');

        return redirect(route('shareDks.index'));
    }
}

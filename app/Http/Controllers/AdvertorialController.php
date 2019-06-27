<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdvertorialRequest;
use App\Http\Requests\UpdateAdvertorialRequest;
use App\Repositories\AdvertorialRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\Advertorial;

class AdvertorialController extends AppBaseController
{
    /** @var  AdvertorialRepository */
    private $advertorialRepository;

    public function __construct(AdvertorialRepository $advertorialRepo)
    {
        $this->advertorialRepository = $advertorialRepo;
    }

    /**
     * Display a listing of the Advertorial.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        // $this->advertorialRepository->pushCriteria(new RequestCriteria($request));
        // $advertorials = $this->advertorialRepository->all();

        // return view('advertorials.index')
        //     ->with('advertorials', $advertorials);
        $user = auth('admin')->user();

        $advertorial = Advertorial::first();

        if (empty($advertorial)) {

            return view('advertorials.create');

       } else {

           return view('advertorials.edit')->with('advertorial', $advertorial);
           
       }
    }

    /**
     * Show the form for creating a new Advertorial.
     *
     * @return Response
     */
    public function create()
    {
        return view('advertorials.create');
    }

    /**
     * Store a newly created Advertorial in storage.
     *
     * @param CreateAdvertorialRequest $request
     *
     * @return Response
     */
    public function store(CreateAdvertorialRequest $request)
    {
        $input = $request->all();

        $user = auth('admin')->user();

        if (array_key_exists('content', $input)) {
            $input['content'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
            $input['content'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
            $input['content'] = str_replace("../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
        }

        $advertorial = $this->advertorialRepository->create($input);

        Flash::success('Advertorial saved successfully.');

        return redirect(route('advertorials.index'));
    }

    /**
     * Display the specified Advertorial.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $advertorial = $this->advertorialRepository->findWithoutFail($id);

        if (empty($advertorial)) {
            Flash::error('Advertorial not found');

            return redirect(route('advertorials.index'));
        }

        return view('advertorials.show')->with('advertorial', $advertorial);
    }

    /**
     * Show the form for editing the specified Advertorial.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $advertorial = $this->advertorialRepository->findWithoutFail($id);

        if (empty($advertorial)) {
            Flash::error('Advertorial not found');

            return redirect(route('advertorials.index'));
        }

        return view('advertorials.edit')->with('advertorial', $advertorial);
    }

    /**
     * Update the specified Advertorial in storage.
     *
     * @param  int              $id
     * @param UpdateAdvertorialRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAdvertorialRequest $request)
    {
        $advertorial = $this->advertorialRepository->findWithoutFail($id);

        if (empty($advertorial)) {
            Flash::error('Advertorial not found');

            return redirect(route('advertorials.index'));
        }

        $input = $request->all();

        if (array_key_exists('content', $input)) {
            $input['content'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
            $input['content'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
            $input['content'] = str_replace("../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
        }

        $advertorial = $this->advertorialRepository->update($input, $id);

        Flash::success('Advertorial updated successfully.');

        return redirect(route('advertorials.index'));
    }

    /**
     * Remove the specified Advertorial from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $advertorial = $this->advertorialRepository->findWithoutFail($id);

        if (empty($advertorial)) {
            Flash::error('Advertorial not found');

            return redirect(route('advertorials.index'));
        }

        $this->advertorialRepository->delete($id);

        Flash::success('Advertorial deleted successfully.');

        return redirect(route('advertorials.index'));
    }
}

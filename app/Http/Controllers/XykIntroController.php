<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateXykIntroRequest;
use App\Http\Requests\UpdateXykIntroRequest;
use App\Repositories\XykIntroRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\XykIntro;

class XykIntroController extends AppBaseController
{
    /** @var  XykIntroRepository */
    private $xykIntroRepository;

    public function __construct(XykIntroRepository $xykIntroRepo)
    {
        $this->xykIntroRepository = $xykIntroRepo;
    }

    /**
     * Display a listing of the XykIntro.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        // $this->xykIntroRepository->pushCriteria(new RequestCriteria($request));
        // $xykIntros = $this->xykIntroRepository->all();

        // return view('xyk_intros.index')
        //     ->with('xykIntros', $xykIntros);
        if (XykIntro::count()) {
            $xykIntro = XykIntro::first();
            return view('xyk_intros.edit')->with('xykIntro', $xykIntro);
        }else{
            return view('xyk_intros.create');
        }
    }

    /**
     * Show the form for creating a new XykIntro.
     *
     * @return Response
     */
    public function create()
    {
        return view('xyk_intros.create');
    }

    /**
     * Store a newly created XykIntro in storage.
     *
     * @param CreateXykIntroRequest $request
     *
     * @return Response
     */
    public function store(CreateXykIntroRequest $request)
    {
        $input = $request->all();

        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }

        $xykIntro = $this->xykIntroRepository->create($input);

        Flash::success('Xyk Intro saved successfully.');

        return redirect(route('xykIntros.index'));
    }

    /**
     * Display the specified XykIntro.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $xykIntro = $this->xykIntroRepository->findWithoutFail($id);

        if (empty($xykIntro)) {
            Flash::error('Xyk Intro not found');

            return redirect(route('xykIntros.index'));
        }

        return view('xyk_intros.show')->with('xykIntro', $xykIntro);
    }

    /**
     * Show the form for editing the specified XykIntro.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $xykIntro = $this->xykIntroRepository->findWithoutFail($id);

        if (empty($xykIntro)) {
            Flash::error('Xyk Intro not found');

            return redirect(route('xykIntros.index'));
        }

        return view('xyk_intros.edit')->with('xykIntro', $xykIntro);
    }

    /**
     * Update the specified XykIntro in storage.
     *
     * @param  int              $id
     * @param UpdateXykIntroRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateXykIntroRequest $request)
    {
        $xykIntro = $this->xykIntroRepository->findWithoutFail($id);

        if (empty($xykIntro)) {
            Flash::error('Xyk Intro not found');

            return redirect(route('xykIntros.index'));
        }

        $input = $request->all();

        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }

        $xykIntro = $this->xykIntroRepository->update($input, $id);

        Flash::success('Xyk Intro updated successfully.');

        return redirect(route('xykIntros.index'));
    }

    /**
     * Remove the specified XykIntro from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $xykIntro = $this->xykIntroRepository->findWithoutFail($id);

        if (empty($xykIntro)) {
            Flash::error('Xyk Intro not found');

            return redirect(route('xykIntros.index'));
        }

        $this->xykIntroRepository->delete($id);

        Flash::success('Xyk Intro deleted successfully.');

        return redirect(route('xykIntros.index'));
    }
}

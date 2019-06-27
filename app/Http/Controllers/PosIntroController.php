<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePosIntroRequest;
use App\Http\Requests\UpdatePosIntroRequest;
use App\Repositories\PosIntroRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\PosIntro;

class PosIntroController extends AppBaseController
{
    /** @var  PosIntroRepository */
    private $posIntroRepository;

    public function __construct(PosIntroRepository $posIntroRepo)
    {
        $this->posIntroRepository = $posIntroRepo;
    }

    /**
     * Display a listing of the PosIntro.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if (PosIntro::count()) {
            $posIntro = PosIntro::first();
            return view('pos_intros.edit')->with('posIntro', $posIntro);
        }else{
            return view('pos_intros.create');
        }
    }

    /**
     * Show the form for creating a new PosIntro.
     *
     * @return Response
     */
    public function create()
    {
        return view('pos_intros.create');
    }

    /**
     * Store a newly created PosIntro in storage.
     *
     * @param CreatePosIntroRequest $request
     *
     * @return Response
     */
    public function store(CreatePosIntroRequest $request)
    {
        $input = $request->all();

        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }

        $posIntro = $this->posIntroRepository->create($input);

        Flash::success('Pos Intro saved successfully.');

        return redirect(route('posIntros.index'));
    }

    /**
     * Display the specified PosIntro.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $posIntro = $this->posIntroRepository->findWithoutFail($id);

        if (empty($posIntro)) {
            Flash::error('Pos Intro not found');

            return redirect(route('posIntros.index'));
        }

        return view('pos_intros.show')->with('posIntro', $posIntro);
    }

    /**
     * Show the form for editing the specified PosIntro.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $posIntro = $this->posIntroRepository->findWithoutFail($id);

        if (empty($posIntro)) {
            Flash::error('Pos Intro not found');

            return redirect(route('posIntros.index'));
        }

        return view('pos_intros.edit')->with('posIntro', $posIntro);
    }

    /**
     * Update the specified PosIntro in storage.
     *
     * @param  int              $id
     * @param UpdatePosIntroRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePosIntroRequest $request)
    {
        $posIntro = $this->posIntroRepository->findWithoutFail($id);

        if (empty($posIntro)) {
            Flash::error('Pos Intro not found');

            return redirect(route('posIntros.index'));
        }

        $input = $request->all();

        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }

        $posIntro = $this->posIntroRepository->update($input, $id);

        Flash::success('Pos Intro updated successfully.');

        return redirect(route('posIntros.index'));
    }

    /**
     * Remove the specified PosIntro from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $posIntro = $this->posIntroRepository->findWithoutFail($id);

        if (empty($posIntro)) {
            Flash::error('Pos Intro not found');

            return redirect(route('posIntros.index'));
        }

        $this->posIntroRepository->delete($id);

        Flash::success('Pos Intro deleted successfully.');

        return redirect(route('posIntros.index'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAttachUserLevelRequest;
use App\Http\Requests\UpdateAttachUserLevelRequest;
use App\Repositories\AttachUserLevelRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AttachUserLevelController extends AppBaseController
{
    /** @var  AttachUserLevelRepository */
    private $attachUserLevelRepository;

    public function __construct(AttachUserLevelRepository $attachUserLevelRepo)
    {
        $this->attachUserLevelRepository = $attachUserLevelRepo;
    }

    /**
     * Display a listing of the AttachUserLevel.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->attachUserLevelRepository->pushCriteria(new RequestCriteria($request));
        $attachUserLevels = $this->attachUserLevelRepository->all();

        return view('attach_user_levels.index')
            ->with('attachUserLevels', $attachUserLevels);
    }

    /**
     * Show the form for creating a new AttachUserLevel.
     *
     * @return Response
     */
    public function create()
    {
        return view('attach_user_levels.create');
    }

    /**
     * Store a newly created AttachUserLevel in storage.
     *
     * @param CreateAttachUserLevelRequest $request
     *
     * @return Response
     */
    public function store(CreateAttachUserLevelRequest $request)
    {
        $input = $request->all();

        $attachUserLevel = $this->attachUserLevelRepository->create($input);

        Flash::success('Attach User Level saved successfully.');

        return redirect(route('attachUserLevels.index'));
    }

    /**
     * Display the specified AttachUserLevel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $attachUserLevel = $this->attachUserLevelRepository->findWithoutFail($id);

        if (empty($attachUserLevel)) {
            Flash::error('Attach User Level not found');

            return redirect(route('attachUserLevels.index'));
        }

        return view('attach_user_levels.show')->with('attachUserLevel', $attachUserLevel);
    }

    /**
     * Show the form for editing the specified AttachUserLevel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $attachUserLevel = $this->attachUserLevelRepository->findWithoutFail($id);

        if (empty($attachUserLevel)) {
            Flash::error('Attach User Level not found');

            return redirect(route('attachUserLevels.index'));
        }

        return view('attach_user_levels.edit')->with('attachUserLevel', $attachUserLevel);
    }

    /**
     * Update the specified AttachUserLevel in storage.
     *
     * @param  int              $id
     * @param UpdateAttachUserLevelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAttachUserLevelRequest $request)
    {
        $attachUserLevel = $this->attachUserLevelRepository->findWithoutFail($id);

        if (empty($attachUserLevel)) {
            Flash::error('Attach User Level not found');

            return redirect(route('attachUserLevels.index'));
        }

        $attachUserLevel = $this->attachUserLevelRepository->update($request->all(), $id);

        Flash::success('Attach User Level updated successfully.');

        return redirect(route('attachUserLevels.index'));
    }

    /**
     * Remove the specified AttachUserLevel from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $attachUserLevel = $this->attachUserLevelRepository->findWithoutFail($id);

        if (empty($attachUserLevel)) {
            Flash::error('Attach User Level not found');

            return redirect(route('attachUserLevels.index'));
        }

        $this->attachUserLevelRepository->delete($id);

        Flash::success('Attach User Level deleted successfully.');

        return redirect(route('attachUserLevels.index'));
    }
}

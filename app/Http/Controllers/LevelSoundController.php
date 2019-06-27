<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLevelSoundRequest;
use App\Http\Requests\UpdateLevelSoundRequest;
use App\Repositories\LevelSoundRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class LevelSoundController extends AppBaseController
{
    /** @var  LevelSoundRepository */
    private $levelSoundRepository;

    public function __construct(LevelSoundRepository $levelSoundRepo)
    {
        $this->levelSoundRepository = $levelSoundRepo;
    }

    /**
     * Display a listing of the LevelSound.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->levelSoundRepository->pushCriteria(new RequestCriteria($request));
        $levelSounds = $this->levelSoundRepository->all();

        return view('level_sounds.index')
            ->with('levelSounds', $levelSounds);
    }

    /**
     * Show the form for creating a new LevelSound.
     *
     * @return Response
     */
    public function create()
    {
        return view('level_sounds.create');
    }

    /**
     * Store a newly created LevelSound in storage.
     *
     * @param CreateLevelSoundRequest $request
     *
     * @return Response
     */
    public function store(CreateLevelSoundRequest $request)
    {
        $input = $request->all();

        $levelSound = $this->levelSoundRepository->create($input);

        Flash::success('Level Sound saved successfully.');

        return redirect(route('levelSounds.index'));
    }

    /**
     * Display the specified LevelSound.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $levelSound = $this->levelSoundRepository->findWithoutFail($id);

        if (empty($levelSound)) {
            Flash::error('Level Sound not found');

            return redirect(route('levelSounds.index'));
        }

        return view('level_sounds.show')->with('levelSound', $levelSound);
    }

    /**
     * Show the form for editing the specified LevelSound.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $levelSound = $this->levelSoundRepository->findWithoutFail($id);

        if (empty($levelSound)) {
            Flash::error('Level Sound not found');

            return redirect(route('levelSounds.index'));
        }

        return view('level_sounds.edit')->with('levelSound', $levelSound);
    }

    /**
     * Update the specified LevelSound in storage.
     *
     * @param  int              $id
     * @param UpdateLevelSoundRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLevelSoundRequest $request)
    {
        $levelSound = $this->levelSoundRepository->findWithoutFail($id);

        if (empty($levelSound)) {
            Flash::error('Level Sound not found');

            return redirect(route('levelSounds.index'));
        }

        $levelSound = $this->levelSoundRepository->update($request->all(), $id);

        Flash::success('Level Sound updated successfully.');

        return redirect(route('levelSounds.index'));
    }

    /**
     * Remove the specified LevelSound from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $levelSound = $this->levelSoundRepository->findWithoutFail($id);

        if (empty($levelSound)) {
            Flash::error('Level Sound not found');

            return redirect(route('levelSounds.index'));
        }

        $this->levelSoundRepository->delete($id);

        Flash::success('Level Sound deleted successfully.');

        return redirect(route('levelSounds.index'));
    }
}

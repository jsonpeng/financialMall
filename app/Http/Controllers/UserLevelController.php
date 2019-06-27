<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserLevelRequest;
use App\Http\Requests\UpdateUserLevelRequest;
use App\Repositories\UserLevelRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class UserLevelController extends AppBaseController
{
    /** @var  UserLevelRepository */
    private $userLevelRepository;

    public function __construct(UserLevelRepository $userLevelRepo)
    {
        $this->userLevelRepository = $userLevelRepo;
    }

    /**
     * Display a listing of the UserLevel.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->userLevelRepository->pushCriteria(new RequestCriteria($request));
        $userLevels = $this->userLevelRepository->all();

        return view('user_levels.index')
            ->with('userLevels', $userLevels);
    }

    /**
     * Show the form for creating a new UserLevel.
     *
     * @return Response
     */
    public function create()
    {
        return view('user_levels.create')
            ->with('model_required',\Zcjy::modelRequiredParam($this->userLevelRepository->model()));
    }

    /**
     * Store a newly created UserLevel in storage.
     *
     * @param CreateUserLevelRequest $request
     *
     * @return Response
     */
    public function store(CreateUserLevelRequest $request)
    {
        $input = $request->all();

        if(!$this->userLevelRepository->levelUnique($input))
        {
            // Flash::error('');
            return redirect(route('userLevels.create'))
                    ->withErrors('请填写会员等级 或者更改会员等级(会员等级重复)')
                    ->withInput($input);
        }

        $userLevel = $this->userLevelRepository->create($input);

        Flash::success('保存成功.');

        return redirect(route('userLevels.index'));
    }

    /**
     * Display the specified UserLevel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $userLevel = $this->userLevelRepository->findWithoutFail($id);

        if (empty($userLevel)) {
            Flash::error('会员卡不存在');

            return redirect(route('userLevels.index'));
        }

        return view('user_levels.show')->with('userLevel', $userLevel);
    }

    /**
     * Show the form for editing the specified UserLevel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $userLevel = $this->userLevelRepository->findWithoutFail($id);

        if (empty($userLevel)) {
            Flash::error('会员卡不存在');

            return redirect(route('userLevels.index'));
        }

        return view('user_levels.edit')
        ->with('userLevel', $userLevel)
        ->with('model_required',\Zcjy::modelRequiredParam($this->userLevelRepository->model()));
    }

    /**
     * Update the specified UserLevel in storage.
     *
     * @param  int              $id
     * @param UpdateUserLevelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserLevelRequest $request)
    {
        $userLevel = $this->userLevelRepository->findWithoutFail($id);

        if (empty($userLevel)) {
            Flash::error('会员卡不存在');

            return redirect(route('userLevels.index'));
        }

        $userLevel = $this->userLevelRepository->update($request->all(), $id);

        Flash::success('更新成功.');

        return redirect(route('userLevels.index'));
    }

    /**
     * Remove the specified UserLevel from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $userLevel = $this->userLevelRepository->findWithoutFail($id);

        if (empty($userLevel)) {
            Flash::error('会员卡不存在');

            return redirect(route('userLevels.index'));
        }

        $this->userLevelRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('userLevels.index'));
    }
}

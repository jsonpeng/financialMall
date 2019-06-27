<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateHkjRequest;
use App\Http\Requests\UpdateHkjRequest;
use App\Repositories\HkjRepository;
use App\Repositories\HkjCatRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\Hkj;
use App\Models\UserLevel;

class HkjController extends AppBaseController
{
    /** @var  HkjRepository */
    private $hkjRepository;
    private $hkjCatRepository;

    public function __construct(HkjRepository $hkjRepo, HkjCatRepository $hkjCatRepo)
    {
        $this->hkjRepository = $hkjRepo;
        $this->hkjCatRepository = $hkjCatRepo;
    }

    /**
     * Display a listing of the Hkj.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->has('page')) {
            session(['page' => $request->input('page')]);
        } else {
            session(['page' => 1]);
        }

        $input  = $request->all();
        $categories = $this->hkjCatRepository->all();

        $hkjs = app('commonRepo')
        ->AmazingManPostRepo()
        ->adminAmazingManPublishs('hkj');

        if (array_key_exists('name', $input) && $input['name'] != "") {
            $hkjs->where('name', 'like', '%'.$input['name'].'%');
        }
        if (array_key_exists('category', $input) && $input['category'] != "全部") {
            $hkjs->where('hkj_cat_id', $input['category']);
        }

        $hkjs = $hkjs->paginate(15);

        return view('hkjs.index')->with('hkjs', $hkjs)->with('categories', $categories)->withInput($input);
    }

    /**
     * Show the form for creating a new Hkj.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->hkjCatRepository->all();
        $userLevels = UserLevel::orderBy('level', 'asc')->get();
        $levels = [0 => '免费'];
        foreach ($userLevels as $key => $value) {
            $levels[$value->id] = $value->name;
        }
        return view('hkjs.create')
        ->with('categories', $categories)
        ->with('levels', $levels)
        ->with('model_required',\Zcjy::modelRequiredParam($this->hkjRepository->model()));
    }

    /**
     * Store a newly created Hkj in storage.
     *
     * @param CreateHkjRequest $request
     *
     * @return Response
     */
    public function store(CreateHkjRequest $request)
    {
        $input = $request->all();

        if (empty($input['view'] )) {
             $input['view'] = random_int(10000, 20000);
        }

        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }

        if (array_key_exists('level', $input) && $input['level'] > 0) {
            $userLevel = UserLevel::where('id', $input['level'])->first();
            if (!empty($userLevel)) {
                $input['level_name'] = $userLevel->name;
                $input['level'] = $userLevel->level;
            }
        }else{
            $input['level_name'] = '免费';
            $input['level'] = 0;
        }

        $hkj = $this->hkjRepository->create($input);

        app('commonRepo')->AmazingManPostRepo()->syncSavePost($hkj->id,'hkj');

        Flash::success('保存成功');

        return redirect(route('hkjs.index'));
    }

    /**
     * Display the specified Hkj.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $hkj = $this->hkjRepository->findWithoutFail($id);

        if (empty($hkj)) {
            Flash::error('信息不存在');

            return redirect(route('hkjs.index'));
        }

        return view('hkjs.show')->with('hkj', $hkj);
    }

    /**
     * Show the form for editing the specified Hkj.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $hkj = $this->hkjRepository->findWithoutFail($id);

        if (empty($hkj)) {
            Flash::error('信息不存在');

            return redirect(route('hkjs.index'));
        }

        $categories = $this->hkjCatRepository->all();

        $userLevels = UserLevel::orderBy('level', 'asc')->get();
        $levels = [0 => '免费'];
        foreach ($userLevels as $key => $value) {
            $levels[$value->id] = $value->name;
        }

        return view('hkjs.edit')
        ->with('hkj', $hkj)
        ->with('categories', $categories)
        ->with('levels', $levels)
        ->with('model_required',\Zcjy::modelRequiredParam($this->hkjRepository->model()));
    }

    /**
     * Update the specified Hkj in storage.
     *
     * @param  int              $id
     * @param UpdateHkjRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateHkjRequest $request)
    {
        $hkj = $this->hkjRepository->findWithoutFail($id);

        if (empty($hkj)) {
            Flash::error('信息不存在');

            return redirect(route('hkjs.index'));
        }

        $input = $request->all();
        if (!array_key_exists('hot', $input)) {
            $input['hot'] = 0;
        }

        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }

        if (array_key_exists('level', $input) && $input['level'] > 0) {
            $userLevel = UserLevel::where('id', $input['level'])->first();
            if (!empty($userLevel)) {
                $input['level_name'] = $userLevel->name;
                $input['level'] = $userLevel->level;
            }
        }else{
            $input['level_name'] = '免费';
            $input['level'] = 0;
        }

        $hkj = $this->hkjRepository->update($input, $id);

        Flash::success('更新成功');

        return redirect(route('hkjs.index', ['page' => session('page')]));
    }

    /**
     * Remove the specified Hkj from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $hkj = $this->hkjRepository->findWithoutFail($id);

        if (empty($hkj)) {
            Flash::error('信息不存在');

            return redirect(route('hkjs.index'));
        }

        $this->hkjRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('hkjs.index', ['page' => session('page')]));
    }


    public function refreshHkjDate(Request $request, $id)
    {
        $hkj = $this->hkjRepository->findWithoutFail($id);

        if (empty($hkj)) {
            Flash::error('信息不存在');

            return ['code' => 1, 'message' => '信息不存在'];
        }

        $hkj->created_at = \Carbon\Carbon::now();
        $hkj->save();
        return ['code' => 0, 'message' => '修改成功'];
    }
}

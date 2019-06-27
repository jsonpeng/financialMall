<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAmazingManRequest;
use App\Http\Requests\UpdateAmazingManRequest;
use App\Repositories\AmazingManRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Hash;

class AmazingManController extends AppBaseController
{
    /** @var  AmazingManRepository */
    private $amazingManRepository;

    public function __construct(AmazingManRepository $amazingManRepo)
    {
        $this->amazingManRepository = $amazingManRepo;
    }

    /**
     * Display a listing of the AmazingMan.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->amazingManRepository->pushCriteria(new RequestCriteria($request));
        $amazingMen = $this->amazingManRepository->allMans();

        return view('amazing_men.index')
            ->with('amazingMen', $amazingMen);
    }

    /**
     * Show the form for creating a new AmazingMan.
     *
     * @return Response
     */
    public function create()
    {
        return view('amazing_men.create')
        ->with('model_required',\Zcjy::modelRequiredParam($this->amazingManRepository));
    }

    /**
     * Store a newly created AmazingMan in storage.
     *
     * @param CreateAmazingManRequest $request
     *
     * @return Response
     */
    public function store(CreateAmazingManRequest $request)
    {
        $input = $request->all();

        if(!empty($input['email'])){

            if($this->amazingManRepository->countUnique($input['email']))
            {
                return  redirect(route('amazingMen.create'))
                        ->withErrors('该邮箱账号已存在,请更换账号后重试')
                        ->withInput($input);
            }

        }

        if(array_key_exists('password',$input))
        {
            $input['password'] = Hash::make($input['password']);
        }

        $input['type'] = '达人';

        if(empty($input['fans']))
        {
            $input['fans'] = random_int(1000,10000);
        }

        $amazingMan = $this->amazingManRepository->create($input);
        
        $amazingMan = $amazingMan->assignRole('文章编辑');

        Flash::success('添加成功.');

        return redirect(route('amazingMen.index'));
    }

    /**
     * Display the specified AmazingMan.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $amazingMan = $this->amazingManRepository->findWithoutFail($id);

        if (empty($amazingMan)) {
            Flash::error('Amazing Man not found');

            return redirect(route('amazingMen.index'));
        }

        return view('amazing_men.show')->with('amazingMan', $amazingMan);
    }

    /**
     * Show the form for editing the specified AmazingMan.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $amazingMan = $this->amazingManRepository->findWithoutFail($id);

        if (empty($amazingMan)) {
            Flash::error('Amazing Man not found');

            return redirect(route('amazingMen.index'));
        }

        return view('amazing_men.edit')
        ->with('amazingMan', $amazingMan)
        ->with('model_required',\Zcjy::modelRequiredParam($this->amazingManRepository));
    }

    /**
     * Update the specified AmazingMan in storage.
     *
     * @param  int              $id
     * @param UpdateAmazingManRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAmazingManRequest $request)
    {
        $amazingMan = $this->amazingManRepository->findWithoutFail($id);

        if (empty($amazingMan)) {
            Flash::error('Amazing Man not found');

            return redirect(route('amazingMen.index'));
        }

        $input = $request->all();

        if(array_key_exists('password',$input))
        {
            $input['password'] = Hash::make($input['password']);
        }

        $amazingMan = $this->amazingManRepository->update($input, $id);

        Flash::success('更新成功.');

        return redirect(route('amazingMen.index'));
    }

    /**
     * Remove the specified AmazingMan from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $amazingMan = $this->amazingManRepository->findWithoutFail($id);

        if (empty($amazingMan)) {
            Flash::error('Amazing Man not found');

            return redirect(route('amazingMen.index'));
        }

        $this->amazingManRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('amazingMen.index'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSoundPostRequest;
use App\Http\Requests\UpdateSoundPostRequest;
use App\Repositories\SoundPostRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\UserLevel;

class SoundPostController extends AppBaseController
{
    /** @var  SoundPostRepository */
    private $soundPostRepository;

    public function __construct(SoundPostRepository $soundPostRepo)
    {
        $this->soundPostRepository = $soundPostRepo;
    }

    /**
     * Display a listing of the SoundPost.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->soundPostRepository->pushCriteria(new RequestCriteria($request));

        $soundPosts = app('commonRepo')
        ->AmazingManPostRepo()
        ->adminAmazingManPublishs('soundPost')
        ->paginate(15);

        return view('sound_posts.index')
            ->with('soundPosts', $soundPosts);
    }

    /**
     * Show the form for creating a new SoundPost.
     *
     * @return Response
     */
    public function create()
    {
        $userLevels = UserLevel::orderBy('level', 'asc')->get();
        $levels = [0 => '免费'];
        foreach ($userLevels as $key => $value) 
        {
            $levels[$value->id] = $value->name;
        }
        $cats = [0 => '无'];
        $allCats = app('commonRepo')->SoundPostCatRepo()->all();
        foreach ($allCats as $key => $cat) {
            $cats[$cat->id] = $cat->name;
        }
        return view('sound_posts.create')
        ->with('levels', $levels)
        ->with('cats',$cats)
        ->with('model_required',\Zcjy::modelRequiredParam($this->soundPostRepository->model()));
    }

    /**
     * Store a newly created SoundPost in storage.
     *
     * @param CreateSoundPostRequest $request
     *
     * @return Response
     */
    public function store(CreateSoundPostRequest $request)
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
        }
        else{
            $input['level_name'] = '免费';
            $input['level'] = 0;
        }

        $soundPost = $this->soundPostRepository->create($input);

        app('commonRepo')->AmazingManPostRepo()->syncSavePost($soundPost->id,'soundPost');

        Flash::success('添加成功.');

        return redirect(route('soundPosts.index'));
    }

    /**
     * Display the specified SoundPost.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $soundPost = $this->soundPostRepository->findWithoutFail($id);

        if (empty($soundPost)) {
            Flash::error('Sound Post not found');

            return redirect(route('soundPosts.index'));
        }

        return view('sound_posts.show')->with('soundPost', $soundPost);
    }

    /**
     * Show the form for editing the specified SoundPost.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $soundPost = $this->soundPostRepository->findWithoutFail($id);

        if (empty($soundPost)) {
            Flash::error('Sound Post not found');

            return redirect(route('soundPosts.index'));
        }

        $userLevels = UserLevel::orderBy('level', 'asc')->get();
        $levels = [0 => '免费'];
        foreach ($userLevels as $key => $value) 
        {
            $levels[$value->id] = $value->name;
        }
        $cats = [0 => '无'];
        $allCats = app('commonRepo')->SoundPostCatRepo()->all();
        foreach ($allCats as $key => $cat) {
            $cats[$cat->id] = $cat->name;
        }
        return view('sound_posts.edit')
        ->with('soundPost', $soundPost)
        ->with('levels', $levels)
        ->with('cats',$cats)
        ->with('model_required',\Zcjy::modelRequiredParam($this->soundPostRepository->model()));
    }

    /**
     * Update the specified SoundPost in storage.
     *
     * @param  int              $id
     * @param UpdateSoundPostRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSoundPostRequest $request)
    {
        $soundPost = $this->soundPostRepository->findWithoutFail($id);

        if (empty($soundPost)) {
            Flash::error('Sound Post not found');

            return redirect(route('soundPosts.index'));
        }

        $input = $request->all();

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

        $soundPost = $this->soundPostRepository->update($input, $id);

        Flash::success('更新成功.');

        return redirect(route('soundPosts.index'));
    }

    /**
     * Remove the specified SoundPost from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $soundPost = $this->soundPostRepository->findWithoutFail($id);

        if (empty($soundPost)) {
            Flash::error('Sound Post not found');

            return redirect(route('soundPosts.index'));
        }

        $this->soundPostRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('soundPosts.index'));
    }
}

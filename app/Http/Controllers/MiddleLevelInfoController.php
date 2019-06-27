<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMiddleLevelInfoRequest;
use App\Http\Requests\UpdateMiddleLevelInfoRequest;
use App\Repositories\MiddleLevelInfoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use Illuminate\Support\Facades\Input;

class MiddleLevelInfoController extends AppBaseController
{
    /** @var  MiddleLevelInfoRepository */
    private $middleLevelInfoRepository;

    public function __construct(MiddleLevelInfoRepository $middleLevelInfoRepo)
    {
        $this->middleLevelInfoRepository = $middleLevelInfoRepo;
    }

    /**
     * Display a listing of the MiddleLevelInfo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->middleLevelInfoRepository->pushCriteria(new RequestCriteria($request));
        $middleLevelInfos = $this->defaultPaginate($this->middleLevelInfoRepository);

        return view('middle_level_infos.index')
            ->with('middleLevelInfos', $middleLevelInfos);
    }

    /**
     * Show the form for creating a new MiddleLevelInfo.
     *
     * @return Response
     */
    public function create()
    {
        $userLevels = \App\Models\UserLevel::orderBy('level', 'asc')->get();
        $levels = ['免费' => '免费'];
        foreach ($userLevels as $key => $value) 
        {
            $levels[$value->name] = $value->name;
        }

        $selectedCategories = [];

        $cats = app('commonRepo')->SoundPostCatRepo()->all();

        return view('middle_level_infos.create')
         ->with('levels',$levels)
         ->with('selectedCategories',$selectedCategories)
         ->with('model_required',\Zcjy::modelRequiredParam($this->middleLevelInfoRepository))
         ->with('cats',$cats);
    }

    /**
     * Store a newly created MiddleLevelInfo in storage.
     *
     * @param CreateMiddleLevelInfoRequest $request
     *
     * @return Response
     */
    public function store(CreateMiddleLevelInfoRequest $request)
    {
        $input = $request->all();

        if (empty($input['view'] )) {
             $input['view'] = random_int(10000, 20000);
        }

        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }

        $middleLevelInfo = $this->middleLevelInfoRepository->create($input);

        if(array_key_exists('sound_posts',$input))
        {
            $middleLevelInfo = $middleLevelInfo->sounds()->sync($input['sound_posts']);
        }

        Flash::success('保存成功.');

        return redirect(route('middleLevelInfos.index'));
    }

    /**
     * Display the specified MiddleLevelInfo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $middleLevelInfo = $this->middleLevelInfoRepository->findWithoutFail($id);

        if (empty($middleLevelInfo)) {
            Flash::error('没有找到该信息');

            return redirect(route('middleLevelInfos.index'));
        }

        return view('middle_level_infos.show')->with('middleLevelInfo', $middleLevelInfo);
    }

    /**
     * Show the form for editing the specified MiddleLevelInfo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $middleLevelInfo = $this->middleLevelInfoRepository->findWithoutFail($id);

        if (empty($middleLevelInfo)) {
            Flash::error('没有找到该信息');

            return redirect(route('middleLevelInfos.index'));
        }

        $userLevels = \App\Models\UserLevel::orderBy('level', 'asc')->get();

        $levels = ['免费' => '免费'];

        foreach ($userLevels as $key => $value) 
        {
            $levels[$value->name] = $value->name;
        }
        $selectedCategories = [];

        $sounds = $middleLevelInfo->sounds;

        foreach ($sounds as $key => $value) 
        {
           $selectedCategories[] = $value->id;
        }

        $cats = app('commonRepo')->SoundPostCatRepo()->all();
        
        return view('middle_level_infos.edit')
        ->with('middleLevelInfo', $middleLevelInfo)
        ->with('levels',$levels)
        ->with('selectedCategories',$selectedCategories)
        ->with('model_required',\Zcjy::modelRequiredParam($this->middleLevelInfoRepository->model()))
        ->with('cats',$cats);
    }

    /**
     * Update the specified MiddleLevelInfo in storage.
     *
     * @param  int              $id
     * @param UpdateMiddleLevelInfoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMiddleLevelInfoRequest $request)
    {
        $middleLevelInfo = $this->middleLevelInfoRepository->findWithoutFail($id);

        if (empty($middleLevelInfo)) {
            Flash::error('没有找到该信息');

            return redirect(route('middleLevelInfos.index'));
        }

        $input = $request->all();

        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }

        if (empty($input['view'] )) {
             $input['view'] = random_int(10000, 20000);
        }

        $this->middleLevelInfoRepository->update($input, $id);

        if(array_key_exists('sound_posts',$input))
        {
            $middleLevelInfo = $middleLevelInfo->sounds()->sync($input['sound_posts']);
        }

        Flash::success('更新成功.');

        return redirect(route('middleLevelInfos.index'));
    }

    /**
     * Remove the specified MiddleLevelInfo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $middleLevelInfo = $this->middleLevelInfoRepository->findWithoutFail($id);

        if (empty($middleLevelInfo)) {
            Flash::error('没有找到该信息');

            return redirect(route('middleLevelInfos.index'));
        }

        $this->middleLevelInfoRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('middleLevelInfos.index'));
    }

    public function fileUpload(Request $request)
    {

        $file =  Input::file('file');

        // $allowed_extensions = ["mp3", "mp4"];
       
        // if(!empty($file)) {
        //     if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
        //         //return zcjy_callback_data('图片格式不正确',1,$api_type);
        //         return ;
        //     }
        // }
        $extension = $file->getClientOriginalExtension();

        $disk = \Storage::disk('qiniu-video');

        $fileName = time().'.'.$extension;

        $result = $disk->put('', $file);               //上传文件

        $downloadurl = 'http://pa59j6gfn.bkt.clouddn.com/'.$result;

        return ['code' => 0, 'url' => $downloadurl];

        // #图片文件夹
        // $destinationPath = empty($user) ? "uploads/admin/" : "uploads/user/";

        // if (!file_exists($destinationPath)){
        //     mkdir($destinationPath,0777,true);
        // }
       
        // $extension = $file->getClientOriginalExtension();
        // $fileName = str_random(10).'.'.$extension;
        // $file->move($destinationPath, $fileName);

        // $image_path=public_path().'/'.$destinationPath.$fileName;
        
        // $img = Image::make($image_path);
        // $img->resize(640, 640);
        // $img->save($image_path,70);

        // $host='http://'.$_SERVER["HTTP_HOST"];

        // if(env('online_version') == 'https'){
        //      $host='https://'.$_SERVER["HTTP_HOST"];
        // }

        // #图片路径
        // $path=$host.'/'.$destinationPath.$fileName;

        // return zcjy_callback_data([
        //         'src'=>$path,
        //         'current_time' => date('Y-m-d H:i:s')
        //     ],0,$api_type);
    }

    
}

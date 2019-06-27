<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Repositories\SysSettingRepository as SettingRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\SysSetting;

class SettingController extends AppBaseController
{
    /** @var  SettingRepository */
    private $settingRepository;

    public function __construct(SettingRepository $settingRepo)
    {
        $this->settingRepository = $settingRepo;
    }

    /**
     * Display a listing of the Setting.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
       if (SysSetting::count()) {
            $setting = SysSetting::first();
            return view('settings.edit')->with('settingAdmin', $setting);
       } else {
           $setting = SysSetting::create([
                'name' => '网站名称',
                'scale' => 10,
                'intro' => '网站介绍',
           ]);
           return view('settings.edit')->with('settingAdmin', $setting);
       }
       
    }

    public function serviceProtocal(Request $request)
    {
        if (SysSetting::count()) {
            $setting = SysSetting::first();
            return view('settings.protocal')->with('settingAdmin', $setting);
       } else {
           $setting = SysSetting::create([
                'name' => '网站名称',
                'scale' => 10,
                'intro' => '网站介绍',
           ]);
           return view('settings.protocal')->with('settingAdmin', $setting);
       }
    }

    public function saleProtocal(Request $request)
    {
        if (SysSetting::count()) {
            $setting = SysSetting::first();
            return view('settings.sale_protocal')->with('settingAdmin', $setting);
        } else {
           $setting = SysSetting::create([
                'name' => '网站名称',
                'scale' => 10,
                'intro' => '网站介绍',
           ]);
           return view('settings.sale_protocal')->with('settingAdmin', $setting);
        }
    }

    public function indexVoice(Request $request)
    {
        if (SysSetting::count()) {
            $setting = SysSetting::first();
            return view('settings.index_voice')->with('settingAdmin', $setting);
        } else {
           $setting = SysSetting::create([
                'name' => '网站名称',
                'scale' => 10,
                'intro' => '网站介绍',
           ]);
           return view('settings.index_voice')->with('settingAdmin', $setting);
        }
    }

    public function intro(Request $request)
    {
        if (SysSetting::count()) {
            $setting = SysSetting::first();
            return view('settings.intro')->with('settingAdmin', $setting);
        } else {
           $setting = SysSetting::create([
                'name' => '网站名称',
                'scale' => 10,
                'intro' => '网站介绍',
           ]);
           return view('settings.intro')->with('settingAdmin', $setting);
        }
    }

    public function kefu(Request $request)
    {
        if (SysSetting::count()) {
            $setting = SysSetting::first();
            return view('settings.kefu')->with('settingAdmin', $setting);
        } else {
           $setting = SysSetting::create([
                'name' => '网站名称',
                'scale' => 10,
                'intro' => '网站介绍',
           ]);
           return view('settings.kefu')->with('settingAdmin', $setting);
        }
    }

    /**
     * Show the form for creating a new Setting.
     *
     * @return Response
     */
    public function create()
    {
        return view('settings.create');
    }

    /**
     * Store a newly created Setting in storage.
     *
     * @param CreateSettingRequest $request
     *
     * @return Response
     */
    public function store(CreateSettingRequest $request)
    {
        $input = $request->all();

        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }

        if (array_key_exists('share_intro', $input)) {
            $input['share_intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['share_intro']);
            $input['share_intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['share_intro']);
        }

        if (array_key_exists('earn_intro', $input)) {
            $input['earn_intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['earn_intro']);
            $input['earn_intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['earn_intro']);
        }

        $setting = $this->settingRepository->create($input);

        Flash::success('设置保存成功');

        return redirect(route('settings.index'));
    }

    /**
     * Display the specified Setting.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $setting = $this->settingRepository->findWithoutFail($id);

        if (empty($setting)) {
            Flash::error('信息不存在');

            return redirect(route('settings.index'));
        }

        return view('settings.show')->with('setting', $setting);
    }

    /**
     * Show the form for editing the specified Setting.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $setting = $this->settingRepository->findWithoutFail($id);

        if (empty($setting)) {
            Flash::error('信息不存在');

            return redirect(route('settings.index'));
        }

        return view('settings.edit')->with('setting', $setting);
    }

    /**
     * Update the specified Setting in storage.
     *
     * @param  int              $id
     * @param UpdateSettingRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSettingRequest $request)
    {
        $setting = $this->settingRepository->findWithoutFail($id);

        if (empty($setting)) {
            Flash::error('信息不存在');

            return redirect(route('settings.index'));
        }
        $input = $request->all();
        if (!array_key_exists('shoufei_xinyongka', $input)) {
            $input['shoufei_xinyongka'] = 0;
        }
        if (!array_key_exists('shoufei_jieqian', $input)) {
            $input['shoufei_jieqian'] = 0;
        }
        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }

        if (array_key_exists('share_intro', $input)) {
            $input['share_intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['share_intro']);
            $input['share_intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['share_intro']);
        }

        if (array_key_exists('earn_intro', $input)) {
            $input['earn_intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['earn_intro']);
            $input['earn_intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['earn_intro']);
        }

        $setting = $this->settingRepository->update($input, $id);

        Flash::success('信息更新成功');
        
        if ($request->has('law')) {
            return redirect('/zcjy/settings/service_protocal');
        }else if($request->has('law_sale')){
            return redirect('/zcjy/settings/sale_protocal');
        }else if($request->has('intro_voice')){
            return redirect('/zcjy/settings/index_voice');
        }else if($request->has('intro')){
            return redirect('/zcjy/settings/intro');
        }else {
            return redirect(route('settings.index'));
        }
        
        
    }

    /**
     * Remove the specified Setting from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $setting = $this->settingRepository->findWithoutFail($id);

        if (empty($setting)) {
            Flash::error('信息不存在');

            return redirect(route('settings.index'));
        }

        $this->settingRepository->delete($id);

        Flash::success('信息删除成功');

        return redirect(route('settings.index'));
    }
}

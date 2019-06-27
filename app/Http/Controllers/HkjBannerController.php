<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateHkjBannerRequest;
use App\Http\Requests\UpdateHkjBannerRequest;
use App\Repositories\HkjBannerRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\HkjBanner;

class HkjBannerController extends AppBaseController
{
    /** @var  HkjBannerRepository */
    private $hkjBannerRepository;

    public function __construct(HkjBannerRepository $hkjBannerRepo)
    {
        $this->hkjBannerRepository = $hkjBannerRepo;
    }

    /**
     * Display a listing of the HkjBanner.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$this->hkjBannerRepository->pushCriteria(new RequestCriteria($request));
        //$hkjBanners = $this->hkjBannerRepository->all();
        $hkjBanners = HkjBanner::orderBy('sort', 'desc')->get();
        return view('hkj_banners.index')
            ->with('hkjBanners', $hkjBanners);
    }

    /**
     * Show the form for creating a new HkjBanner.
     *
     * @return Response
     */
    public function create()
    {
        return view('hkj_banners.create');
    }

    /**
     * Store a newly created HkjBanner in storage.
     *
     * @param CreateHkjBannerRequest $request
     *
     * @return Response
     */
    public function store(CreateHkjBannerRequest $request)
    {
        $input = $request->all();
        if (array_key_exists('link', $input) && $input['link'] != '') {
            if(!preg_match("/^(http:\/\/|https:\/\/).*$/", $input['link'])){
                $input['link'] = 'http://'.$input['link'];
            }
        }

        $hkjBanner = $this->hkjBannerRepository->create($input);

        Flash::success('保存成功');

        return redirect(route('hkjBanners.index'));
    }

    /**
     * Display the specified HkjBanner.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $hkjBanner = $this->hkjBannerRepository->findWithoutFail($id);

        if (empty($hkjBanner)) {
            Flash::error('信息不存在');

            return redirect(route('hkjBanners.index'));
        }

        return view('hkj_banners.show')->with('hkjBanner', $hkjBanner);
    }

    /**
     * Show the form for editing the specified HkjBanner.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $hkjBanner = $this->hkjBannerRepository->findWithoutFail($id);

        if (empty($hkjBanner)) {
            Flash::error('信息不存在');

            return redirect(route('hkjBanners.index'));
        }

        return view('hkj_banners.edit')->with('hkjBanner', $hkjBanner);
    }

    /**
     * Update the specified HkjBanner in storage.
     *
     * @param  int              $id
     * @param UpdateHkjBannerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateHkjBannerRequest $request)
    {
        $hkjBanner = $this->hkjBannerRepository->findWithoutFail($id);

        if (empty($hkjBanner)) {
            Flash::error('信息不存在');

            return redirect(route('hkjBanners.index'));
        }

        $input = $request->all();
        if (array_key_exists('link', $input) && $input['link'] != '') {
            if(!preg_match("/^(http:\/\/|https:\/\/).*$/", $input['link'])){
                $input['link'] = 'http://'.$input['link'];
            }
        }

        $hkjBanner = $this->hkjBannerRepository->update($input, $id);

        Flash::success('更新成功');

        return redirect(route('hkjBanners.index'));
    }

    /**
     * Remove the specified HkjBanner from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $hkjBanner = $this->hkjBannerRepository->findWithoutFail($id);

        if (empty($hkjBanner)) {
            Flash::error('信息不存在');

            return redirect(route('hkjBanners.index'));
        }

        $this->hkjBannerRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('hkjBanners.index'));
    }
}

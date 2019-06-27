<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlatformBannerRequest;
use App\Http\Requests\UpdatePlatformBannerRequest;
use App\Repositories\PlatformBannerRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PlatformBannerController extends AppBaseController
{
    /** @var  PlatformBannerRepository */
    private $platformBannerRepository;

    public function __construct(PlatformBannerRepository $platformBannerRepo)
    {
        $this->platformBannerRepository = $platformBannerRepo;
    }

    /**
     * Display a listing of the PlatformBanner.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->platformBannerRepository->pushCriteria(new RequestCriteria($request));
        $platformBanners = $this->platformBannerRepository->all();

        return view('platform_banners.index')
            ->with('platformBanners', $platformBanners);
    }

    /**
     * Show the form for creating a new PlatformBanner.
     *
     * @return Response
     */
    public function create()
    {
        return view('platform_banners.create');
    }

    /**
     * Store a newly created PlatformBanner in storage.
     *
     * @param CreatePlatformBannerRequest $request
     *
     * @return Response
     */
    public function store(CreatePlatformBannerRequest $request)
    {
        $input = $request->all();

        $platformBanner = $this->platformBannerRepository->create($input);

        Flash::success('保存成功');

        return redirect(route('platformBanners.index'));
    }

    /**
     * Display the specified PlatformBanner.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $platformBanner = $this->platformBannerRepository->findWithoutFail($id);

        if (empty($platformBanner)) {
            Flash::error('信息不存在');

            return redirect(route('platformBanners.index'));
        }

        return view('platform_banners.show')->with('platformBanner', $platformBanner);
    }

    /**
     * Show the form for editing the specified PlatformBanner.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $platformBanner = $this->platformBannerRepository->findWithoutFail($id);

        if (empty($platformBanner)) {
            Flash::error('信息不存在');

            return redirect(route('platformBanners.index'));
        }

        return view('platform_banners.edit')->with('platformBanner', $platformBanner);
    }

    /**
     * Update the specified PlatformBanner in storage.
     *
     * @param  int              $id
     * @param UpdatePlatformBannerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePlatformBannerRequest $request)
    {
        $platformBanner = $this->platformBannerRepository->findWithoutFail($id);

        if (empty($platformBanner)) {
            Flash::error('信息不存在');

            return redirect(route('platformBanners.index'));
        }

        $platformBanner = $this->platformBannerRepository->update($request->all(), $id);

        Flash::success('更新成功');

        return redirect(route('platformBanners.index'));
    }

    /**
     * Remove the specified PlatformBanner from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $platformBanner = $this->platformBannerRepository->findWithoutFail($id);

        if (empty($platformBanner)) {
            Flash::error('信息不存在');

            return redirect(route('platformBanners.index'));
        }

        $this->platformBannerRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('platformBanners.index'));
    }
}

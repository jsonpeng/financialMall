<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNoticeRequest;
use App\Http\Requests\UpdateNoticeRequest;
use App\Repositories\NoticeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Notice;

class NoticeController extends AppBaseController
{
    /** @var  NoticeRepository */
    private $noticeRepository;

    public function __construct(NoticeRepository $noticeRepo)
    {
        $this->noticeRepository = $noticeRepo;
    }

    /**
     * Display a listing of the Notice.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$this->noticeRepository->pushCriteria(new RequestCriteria($request));
        //$notices = $this->noticeRepository->all();
        $notices =  Notice::orderBy('created_at', 'desc')->paginate(15);

        return view('notices.index')
            ->with('notices', $notices);
    }

    /**
     * Show the form for creating a new Notice.
     *
     * @return Response
     */
    public function create()
    {
        return view('notices.create')
          ->with('model_required',\Zcjy::modelRequiredParam($this->noticeRepository->model()));
    }

    /**
     * Store a newly created Notice in storage.
     *
     * @param CreateNoticeRequest $request
     *
     * @return Response
     */
    public function store(CreateNoticeRequest $request)
    {
        $input = $request->all();

        $user = auth('admin')->user();

        // if ($user->type == '总部管理员') {
        //     return redirect('/zcjy/admins');
        // }

        //弹窗显示
        if (array_key_exists('popup', $input) && $input['popup']) {
            Notice::where('popup', 1)->update(['popup' => 0]);
        }

        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }

        // $account = $user->account->account;

        // $input['account'] = $account;

        $notice = $this->noticeRepository->create($input);

        Flash::success('保存成功');

        return redirect(route('notices.index'));
    }

    /**
     * Display the specified Notice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $notice = $this->noticeRepository->findWithoutFail($id);

        if (empty($notice)) {
            Flash::error('通知不存在');

            return redirect(route('notices.index'));
        }

        return view('notices.show')->with('notice', $notice);
    }

    /**
     * Show the form for editing the specified Notice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $notice = $this->noticeRepository->findWithoutFail($id);

        if (empty($notice)) {
            Flash::error('通知不存在');

            return redirect(route('notices.index'));
        }

        return view('notices.edit')
        ->with('notice', $notice)
        ->with('model_required',\Zcjy::modelRequiredParam($this->noticeRepository->model()));
    }

    /**
     * Update the specified Notice in storage.
     *
     * @param  int              $id
     * @param UpdateNoticeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNoticeRequest $request)
    {
        $notice = $this->noticeRepository->findWithoutFail($id);

        if (empty($notice)) {
            Flash::error('通知不存在');

            return redirect(route('notices.index'));
        }

        //弹窗显示
        $input = $request->all();

        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }

        if (array_key_exists('popup', $input) && $input['popup']) {
            Notice::where('popup', 1)->update(['popup' => 0]);
        }else{
            $input['popup'] = 0;
        }

        $notice = $this->noticeRepository->update($input, $id);

        Flash::success('更新成功');

        return redirect(route('notices.index'));
    }

    /**
     * Remove the specified Notice from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $notice = $this->noticeRepository->findWithoutFail($id);

        if (empty($notice)) {
            Flash::error('通知不存在');

            return redirect(route('notices.index'));
        }

        $this->noticeRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('notices.index'));
    }
}

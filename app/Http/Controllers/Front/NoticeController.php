<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Models\OldProduct;
use Flash;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

use App\Repositories\NoticeRepository;

class NoticeController extends Controller
{
    private $noticeRepository;

    public function __construct(NoticeRepository $noticeRepo)
    {
        $this->noticeRepository = $noticeRepo;
    }

    public function show(Request $request, $id)
    {
        $notice = $this->noticeRepository->findWithoutFail($id);

        if (empty($notice)) {
            return redirect('/');
        }else{
            $notice->update(['view' => $notice->view + 1]);
        }
        return view('front.notice.show')
            ->with('notice', $notice);
    }
}

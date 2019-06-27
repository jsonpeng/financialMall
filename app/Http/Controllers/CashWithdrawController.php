<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCashWithdrawRequest;
use App\Http\Requests\UpdateCashWithdrawRequest;
use App\Repositories\CashWithdrawRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use Config;
use Log;
use Pay;

use App\Models\CashWithdraw;
use App\Models\PayAli;
use App\User;
use App\Models\CashIncome;
use App\Models\OldOrder;
use Carbon\Carbon;

use AopClient;
use AlipayFundTransToaccountTransferRequest;

class CashWithdrawController extends AppBaseController
{
    /** @var  CashWithdrawRepository */
    private $cashWithdrawRepository;

    public function __construct(CashWithdrawRepository $cashWithdrawRepo)
    {
        $this->cashWithdrawRepository = $cashWithdrawRepo;
    }

    /**
     * Display a listing of the CashWithdraw.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        // $this->cashWithdrawRepository->pushCriteria(new RequestCriteria($request));
        // $cashWithdraws = $this->cashWithdrawRepository->all();
        $cashWithdraws = CashWithdraw::orderBy('created_at', 'desc')->paginate(15);

        return view('cash_withdraws.index')
            ->with('cashWithdraws', $cashWithdraws);
    }

    /**
     * Show the form for creating a new CashWithdraw.
     *
     * @return Response
     */
    public function create()
    {
        return view('cash_withdraws.create');
    }

    /**
     * Store a newly created CashWithdraw in storage.
     *
     * @param CreateCashWithdrawRequest $request
     *
     * @return Response
     */
    public function store(CreateCashWithdrawRequest $request)
    {
        $input = $request->all();

        $cashWithdraw = $this->cashWithdrawRepository->create($input);

        Flash::success('Cash Withdraw saved successfully.');

        return redirect(route('cashWithdraws.index'));
    }

    /**
     * Display the specified CashWithdraw.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cashWithdraw = $this->cashWithdrawRepository->findWithoutFail($id);

        if (empty($cashWithdraw)) {
            Flash::error('Cash Withdraw not found');

            return redirect(route('cashWithdraws.index'));
        }

        return view('cash_withdraws.show')->with('cashWithdraw', $cashWithdraw);
    }

    /**
     * Show the form for editing the specified CashWithdraw.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cashWithdraw = $this->cashWithdrawRepository->findWithoutFail($id);

        if (empty($cashWithdraw)) {
            Flash::error('Cash Withdraw not found');

            return redirect(route('cashWithdraws.index'));
        }

        //用户信息
        $user = User::where('id', $cashWithdraw->user_id)->first();
        $incomes = round(CashIncome::where('user_id', $cashWithdraw->user_id)->where('type', '<>', '取现退款')->sum('count'), 2);
        $withdraws_done = round(CashWithdraw::where('user_id', $cashWithdraw->user_id)->where('status', '审核通过')->sum('count'), 2);
        $withdraws_pendding = round(CashWithdraw::where('user_id', $cashWithdraw->user_id)->where('status', '待审核')->sum('count'), 2);
        $order_count = OldOrder::where('user_id', $cashWithdraw->user_id)->where('pay_status', '已支付')->count();

        return view('cash_withdraws.edit', compact('cashWithdraw', 'user', 'incomes', 'withdraws_done', 'withdraws_pendding', 'order_count'));
    }

    /**
     * Update the specified CashWithdraw in storage.
     *
     * @param  int              $id
     * @param UpdateCashWithdrawRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCashWithdrawRequest $request)
    {
        $cashWithdraw = $this->cashWithdrawRepository->findWithoutFail($id);

        if (empty($cashWithdraw)) {
            Flash::error('Cash Withdraw not found');

            return redirect(route('cashWithdraws.index'));
        }

        $cashWithdraw = $this->cashWithdrawRepository->update($request->all(), $id);

        Flash::success('Cash Withdraw updated successfully.');

        return redirect(route('cashWithdraws.index'));
    }

    /**
     * Remove the specified CashWithdraw from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cashWithdraw = $this->cashWithdrawRepository->findWithoutFail($id);

        if (empty($cashWithdraw)) {
            Flash::error('Cash Withdraw not found');

            return redirect(route('cashWithdraws.index'));
        }

        $this->cashWithdrawRepository->delete($id);

        Flash::success('Cash Withdraw deleted successfully.');

        return redirect(route('cashWithdraws.index'));
    }


    public function confirmCashWithdraw(Request $request, $id)
    {
        try {
            $user = auth('admin')->user();

            $cashWithdraw = CashWithdraw::where('id', $id)->where('status', '待审核')->first();
            if (empty($cashWithdraw)) {
                return ['message' => '该笔退款不存在或者已经退款', 'code' => 1];
            }

            // $config = Config::get('pay.alipay');
            // $payAli = PayAli::inRandomOrder()->first();

            // $aop = new AopClient ();
            // $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
            // $aop->appId = $payAli->app_id;
            // $aop->rsaPrivateKey = $config['private_key'];
            // $aop->alipayrsaPublicKey=$config['ali_public_key'];
            // $aop->apiVersion = '1.0';
            // $aop->signType = 'RSA2';
            // $aop->charset='utf-8';
            // $aop->format='json';
            // $request = new AlipayFundTransToaccountTransferRequest ();
            // $request->setBizContent("{" .
            //     "\"out_biz_no\":\"".$cashWithdraw->id."\"," .
            //     "\"payee_type\":\"ALIPAY_LOGONID\"," .
            //     "\"payee_account\":\"".$cashWithdraw->zhifubao."\"," .
            //     "\"amount\":\"".$cashWithdraw->count."\"," .
            //     "\"payer_show_name\":\"".$cashWithdraw->name."\"," .
            //     "\"remark\":\"用户提现\"" .
            // "}");
            // $result = $aop->execute ($request); 

            // $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
            // $resultCode = $result->$responseNode->code;
            // if(!empty($resultCode)&&$resultCode == 10000){
            //     Log::info('success');
            // } else {
            //     Log::info('failure');
            // }

            //向支付宝发起转账请求
            $order = [
                'out_biz_no' => $cashWithdraw->id.'_'.time(),
                'payee_type' => 'ALIPAY_LOGONID',
                'payee_account' => $cashWithdraw->zhifubao,
                'amount' => $cashWithdraw->count,
            ];

            $payAli = PayAli::inRandomOrder()->first();
            if (empty($payAli)) {
                return ['message' => '没有支付宝账户信息', 'code' => 1];
            }
            
            $config = Config::get('pay.alipay');

            $config['app_id'] = $payAli->app_id;
            $config['notify_url'] = $request->root().'/alipay_notify';
            $config['return_url'] = $request->root().'/alipay_return';

            $alipay = \Yansongda\Pay\Pay::alipay($config);
            // Log::info('transfer alipay');
            // 
            $result = $alipay->transfer($order);

            if ($result->code == 10000) {
                $cashWithdraw->trade_no = $result->order_id;
                $cashWithdraw->out_trade_no = $result->out_biz_no;
                $cashWithdraw->operate_time = Carbon::now();
                $cashWithdraw->status = '审核通过';
                $cashWithdraw->save();

                return ['message' => '转账成功', 'code' => 0];
            } else {
                return ['message' => '转账失败', 'code' => 1];
            }
            
            
        } catch (Exception $e) {
            return ['message' => '转账失败', 'code' => 1];
        }
        
    }

    public function confirmCashWithdrawByHand(Request $request, $id)
    {
        try {
            $user = auth('admin')->user();

            $cashWithdraw = CashWithdraw::where('id', $id)->where('status', '待审核')->first();

            $cashWithdraw->status = '审核通过';
            $cashWithdraw->reason = '人工审核通过';
            $cashWithdraw->operate_time = Carbon::now();
            $cashWithdraw->save();
            return ['message' => '操作成功', 'code' => 0];
        } catch (Exception $e) {
            return ['message' => '处理失败', 'code' => 1];
        }
    }

    public function rejectCashWithdraw(Request $request, $id)
    {
        try {
            $user = auth('admin')->user();

            $cashWithdraw = CashWithdraw::where('id', $id)->where('status', '待审核')->first();
            if (empty($cashWithdraw)) {
                return ['message' => '信息不存在', 'code' => 1];
            }

            $cashWithdraw->status = '审核不通过';
            $cashWithdraw->operate_time = Carbon::now();
            $cashWithdraw->save();

            //把钱退回账户
            $user = User::where('id', $cashWithdraw->user_id)->first();
            if ($user) {
                $user->money += $cashWithdraw->count;
                $user->money_all += $cashWithdraw->count;
                $user->save();

                // CashIncome::create([
                //     'type' => '取现退款',
                //     'count' => $cashWithdraw->count,
                //     'user_id' => $user->id,
                //     'custorm_name' => $user->nickname,
                //     'custorm_mobile' => $user->mobile,
                //     'des' => '取现退款，管理员审核拒绝'
                // ]);
            }
            
            return ['message' => '操作成功', 'code' => 0];
        } catch (Exception $e) {
            return ['message' => '处理失败', 'code' => 1];
        }
    }
}

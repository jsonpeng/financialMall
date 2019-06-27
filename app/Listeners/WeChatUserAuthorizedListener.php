<?php

namespace App\Listeners;

use Overtrue\LaravelWeChat\Events\WeChatUserAuthorized;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\Models\MoneyRecord;

use Illuminate\Support\Facades\Log;

class WeChatUserAuthorizedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  WeChatUserAuthorized  $event
     * @return void
     */
    public function handle(WeChatUserAuthorized $event)
    {
        // $weixin_user = $event->user;
        // $isNewSession = $event->isNewSession;
        // if ($isNewSession) {
        //     $user = User::where('openid', $weixin_user['original']['openid'])->first();
        //     if (is_null($user)) {
        //         // 新建用户
        //         $user = User::create([
        //             'openid' => $weixin_user['original']['openid'],
        //             'name' => $weixin_user['original']['nickname'],
        //             'nickname' => $weixin_user['original']['nickname'],
        //             'header' => $weixin_user['original']['headimgurl'],
        //             'sex' => $weixin_user['original']['sex'],
        //             'province' => $weixin_user['original']['province'],
        //             'city' => $weixin_user['original']['city'],
        //             'country' => $weixin_user['original']['country'],
        //             'money_all' => 100,
        //             'money' => 100,
        //         ]);
        //         //操作记录
        //         MoneyRecord::create([
        //             'user_id' => $user->id,
        //             'type' => '红包',
        //             'money' => 100,
        //             'info' => '新用户注册红包',
        //             'remark' => $user->id,
        //             'status' => '已完成',
        //             'count' => ' '
        //         ]);
        //     }else{
        //         if ($user->money == 0) {
        //             $user->update([
        //                 'nickname' => $weixin_user['original']['nickname'],
        //                 'header' => $weixin_user['original']['headimgurl'],
        //                 'sex' => $weixin_user['original']['sex'],
        //                 'province' => $weixin_user['original']['province'],
        //                 'city' => $weixin_user['original']['city'],
        //                 'country' => $weixin_user['original']['country'],
        //                 'money_all' => 100,
        //                 'money' => 100,
        //             ]);
        //             //操作记录
        //             MoneyRecord::create([
        //                 'user_id' => $user->id,
        //                 'type' => '红包',
        //                 'money' => 100,
        //                 'info' => '新用户注册红包',
        //                 'remark' => $user->id,
        //                 'status' => '已完成',
        //                 'count' => ' '
        //             ]);
        //         } else {
        //             $user->update([
        //                 'nickname' => $weixin_user['original']['nickname'],
        //                 'header' => $weixin_user['original']['headimgurl'],
        //                 'sex' => $weixin_user['original']['sex'],
        //                 'province' => $weixin_user['original']['province'],
        //                 'city' => $weixin_user['original']['city'],
        //                 'country' => $weixin_user['original']['country'],
        //             ]);
        //         }
        //     }
        // }
        
    }
}

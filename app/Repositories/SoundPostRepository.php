<?php

namespace App\Repositories;

use App\Models\SoundPost;
use InfyOm\Generator\Common\BaseRepository;
use Cache;
use Config;
use App\Models\SoundPostUserLog;
use App\Models\MiddleLevelInfo;

/**
 * Class SoundPostRepository
 * @package App\Repositories
 * @version February 15, 2019, 1:42 pm CST
 *
 * @method SoundPost findWithoutFail($id, $columns = ['*'])
 * @method SoundPost find($id, $columns = ['*'])
 * @method SoundPost first($columns = ['*'])
*/
class SoundPostRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'intro',
        'image',
        'view',
        'level',
        'level_name',
        'free_info'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SoundPost::class;
    }

    //获取所有音频课程系列
    public function getAllCacheSoundPosts($skip = 0,$take = 20)
    {
        return Cache::remember('zcjy_all_sound_posts_'.$skip.'_'.$take,Config::get('web.cachetime'),function() use($skip,$take){
            return SoundPost::orderBy('created_at','desc')
                   ->with('cat')
                   ->skip($skip)
                   ->take($take)
                   ->get();
        });
    }

    /**
     * 获取音频课程详情
     * @param  [type] $sound_post_id [description]
     * @param  [type] $user          [description]
     * @return [type]                [description]
     */
    public function getCacheSoundPostDetail($sound_post_id,$user = null)
    {
           // return Cache::remember('zcjy_sound_posts_detail_'.$sound_post_id,Config::get('web.cachetime'),function() use($sound_post_id){
                    $sound_post = MiddleLevelInfo::find($sound_post_id);
                    if(!empty($sound_post))
                    {
                        $cat = $sound_post->cat;
                         ##附带会员卡信息
                        $sound_post = app('commonRepo')->attachKeChenLevelInfo($sound_post);
                        ##附带收藏状态
                        $sound_post['collect_status'] = app('commonRepo')->UserPostRepo()->userCollectStatus(optional($user)->id,$sound_post->id,'soundPost') ? 1 : 0;
                        ##是否有权限可以看
                        $sound_post['can_read'] = app('commonRepo')->varifyUserCanMem($user,$sound_post);
                        ##观看记录信息
                        $sound_post['watch_log'] = SoundPostUserLog::where('user_id',$user->id)
                        ->where('sound_post_id',$sound_post->id)
                        ->first();
                        //attachKeChenLevelInfo
                        // $kechengs = $sound_post->kechengs()->get();
                        // if(count($kechengs))
                        // {
                        //     foreach ($kechengs as $key => $kecheng) {
                        //         ##附带会员卡信息
                        //         $kechengs[$key] = app('commonRepo')->attachKeChenLevelInfo($kecheng);
                        //         ##附带收藏状态
                        //         $kecheng['collect_status'] = app('commonRepo')->UserPostRepo()->userCollectStatus(optional($user)->id,$kecheng->id,'soundPost') ? 1 : 0;
                        //         ##是否有权限可以看
                        //         $kecheng['can_read'] = app('commonRepo')->varifyUserCanMem($user,$kecheng);
                        //         ##观看记录信息
                        //         $kecheng['watch_log'] = SoundPostUserLog::where('user_id',$user->id)
                        //         ->where('sound_post_id',$kecheng->id)
                        //         ->first();

                        //     }
                        // }
                        return zcjy_callback_data(['detail'=>$sound_post,'cat'=>$cat]);
                    }
                    else{
                        return zcjy_callback_data('没有找到该音频课程',1);
                    }
           // });
    }

    /**
     * 保存音频观看记录 并且顺带获取额外积分
     * @param  [type] $sound_post_id [description]
     * @param  [type] $user          [description]
     * @return [type]                [description]
     */
    public function saveSoundPostWatchLog($sound_post_id,$user,$input)
    {
        $soundPost = MiddleLevelInfo::find($sound_post_id);

        if(empty($soundPost))
        {
            return zcjy_callback_data('没有找到该课程',1);
        }

        $log = SoundPostUserLog::where('user_id',$user->id)->where('sound_post_id',$sound_post_id)->first();

        $input['user_id'] = $user->id;
        $input['sound_post_id'] = $sound_post_id;

        if(!empty($log))
        {
            if($log->whether_end)
            {
                return zcjy_callback_data('已经获取过积分奖励,请勿重复提交',1);
            }
      
            $log->update([
                'last_see_time' => $input['last_see_time'],
                'whether_end'   => $input['whether_end']
            ]);
        }
        else{
            SoundPostUserLog::create($input);
        }

        if($input['whether_end'])
        {
            //消耗用户积分
            $user->credits = $user->credits + $soundPost->jifen;
            $user->save();

            app('commonRepo')->addCreditLog($user->credits,$soundPost->jifen,'用户观看完课程'.$soundPost->title.',赠送'.$soundPost->jifen.'积分',6,$user->id);
            return zcjy_callback_data('保存记录成功,成功获取'.$soundPost->jifen.'积分');
        }

        return zcjy_callback_data('保存记录成功');

    }
}

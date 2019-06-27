<?php

namespace App\Repositories;

use App\Models\SoundPostCat;
use App\Models\MiddleLevelInfo;
use App\Models\UserLevel;
use App\Models\SoundPostUserLog;
use InfyOm\Generator\Common\BaseRepository;
use Cache;
use Config;

/**
 * Class SoundPostCatRepository
 * @package App\Repositories
 * @version March 1, 2019, 3:09 pm CST
 *
 * @method SoundPostCat findWithoutFail($id, $columns = ['*'])
 * @method SoundPostCat find($id, $columns = ['*'])
 * @method SoundPostCat first($columns = ['*'])
*/
class SoundPostCatRepository extends BaseRepository
{
    use \ZcjyRepoTrait;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SoundPostCat::class;
    }

    public function getCacheAllCat()
    {
        return Cache::remember('all_sound_cats',1,function(){
             return SoundPostCat::all();
        });
    }

    //getKechengsByCardName
    public function getKechengsByCardName($card_name,$user,$skip=0,$take=20)
    {
         return Cache::remember('all_kechengs_by_cardname'.$card_name.'_'.$user->id.$skip.$take,1,function() use($card_name,$user,$skip,$take){
            $level = UserLevel::where('name',$card_name)->first();
            if(empty($level))
            {
                return [];
            }
            
            $kechengs = MiddleLevelInfo::where('level',$level->name)
                    ->orderBy('created_at','desc')
                    ->skip($skip)
                    ->take($take)
                    ->get();
            if(count($kechengs))
            {
                    foreach ($kechengs as $key => $kecheng) 
                    {
                        ##附带会员卡信息
                        $kechengs[$key] = app('commonRepo')->attachKeChenLevelInfo($kecheng);
                        ##附带收藏状态
                        $kecheng['collect_status'] = app('commonRepo')->UserPostRepo()->userCollectStatus(optional($user)->id,$kecheng->id,'soundPost') ? 1 : 0;
                        ##是否有权限可以看
                        $kecheng['can_read'] = app('commonRepo')->varifyUserCanMem($user,$kecheng);
                        ##观看记录信息
                        $kecheng['watch_log'] = SoundPostUserLog::where('user_id',$user->id)
                        ->where('sound_post_id',$kecheng->id)
                        ->first();

                    }
            }
            return $kechengs;

         });
    }

    //通过分类id获取课程列表
    public function getKechengsByCatId($cat_id=null,$user,$type=null,$skip = 0,$take = 20)
    {
        return Cache::remember('all_kechengs_by_catid_'.$cat_id.'_'.$user->id.$type.$skip.$take,1,function() use($cat_id,$user,$type,$skip,$take){
          
             $kechengs =  MiddleLevelInfo::where('id','>',0);
            
            if(!empty($cat_id) && $cat_id != '{cat_id}')
            {
                $kechengs = $kechengs->where('cat_id',$cat_id);
            }

            if(!empty($type))
            {
                $kechengs = $kechengs->where('type',$type);
            }

             $kechengs = $kechengs
                    ->orderBy('created_at','desc')
                    ->skip($skip)
                    ->take($take)
                    ->get();
                    if(count($kechengs))
                    {
                            foreach ($kechengs as $key => $kecheng) 
                            {
                                ##附带会员卡信息
                                $kechengs[$key] = app('commonRepo')->attachKeChenLevelInfo($kecheng);
                                ##附带收藏状态
                                $kecheng['collect_status'] = app('commonRepo')->UserPostRepo()->userCollectStatus(optional($user)->id,$kecheng->id,'soundPost') ? 1 : 0;
                                ##是否有权限可以看
                                $kecheng['can_read'] = app('commonRepo')->varifyUserCanMem($user,$kecheng);
                                ##观看记录信息
                                $kecheng['watch_log'] = SoundPostUserLog::where('user_id',$user->id)
                                ->where('sound_post_id',$kecheng->id)
                                ->first();

                            }
                    }
                return $kechengs;

        });
    }
}

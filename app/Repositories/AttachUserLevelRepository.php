<?php

namespace App\Repositories;

use App\Models\AttachUserLevel;
use App\Models\Level;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AttachUserLevelRepository
 * @package App\Repositories
 * @version February 27, 2019, 3:21 pm CST
 *
 * @method AttachUserLevel findWithoutFail($id, $columns = ['*'])
 * @method AttachUserLevel find($id, $columns = ['*'])
 * @method AttachUserLevel first($columns = ['*'])
*/
class AttachUserLevelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'level_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AttachUserLevel::class;
    }

    public function levelAll($user = null)
    {
        $levels =  Level::all();

        if(!empty($user))
        {
            $level = $this->userLevel($user);
            if(!empty($level))
            {
                foreach ($levels as $key => $item) {
                   $level->level_id == $item->id ? $item['active'] = 1 : $item['active'] = 0;
                }
            }
        }
        return $levels;
    }

    public function userLevel($user)
    {
        return AttachUserLevel::where('user_id',$user->id)->first();
    }

    public function userLevelName($user)
    {
        $level = $this->userLevel($user);
        if(empty($level))
        {
            return '';
        }
        return optional(Level::find($level->level_id))->name;
    }

    public function userLevelObj($user)
    {
        $level = $this->userLevel($user);
        if(empty($level))
        {
            return '';
        }
        return Level::find($level->level_id);
    }

    /**
     * 分拥
     * @param  [type] $user      [返佣的用户]
     * @param  [type] $level     [推荐的等级]
     * @param  [type] $userLevel [用户购买的会员卡]
     * @return [type]            [被图鉴的人]
     */
    public function userReturnMoney($user,$level,$userLevel,$child = null)
    {
        //$userLevelObj = null;

        // if ($level == 1) {
        //     $userLevelObj = $this->userLevelObj($user);
            # 分拥
        //     if(empty($userLevelObj))
        //     {
        //         return isset($userLevel->{'level_money_1'.$level}) ? $userLevel->{'level_money_1'.$level} : 0;
        //     }
        // } 
        // else {
        //     # 二级分佣
        //     if (empty($child)) {
        //         return 0;
        //     }
        //     $userLevelObj = $this->userLevelObj($child);
        // }

        $userLevelObj = $this->userLevelObj($user);
        if (empty($userLevelObj)) {
            return 0;
        }
        
        return isset($userLevelObj->{'level'.$userLevel->level.'_'.$level}) ? $userLevelObj->{'level'.$userLevel->level.'_'.$level} : 0;

    }

    public function deleteUserLevel($user)
    {
        return AttachUserLevel::where('user_id',$user->id)->delete();
    }

    public function syncSaveUserLevel($input,$user,$action = 'create')
    {
        if(isset($input['level_id']) && !empty($input['level_id']))
        {
            if($action == 'update')
            {
                $this->deleteUserLevel($user);
            }
            AttachUserLevel::create([
                'user_id'  => $user->id,
                'level_id' => $input['level_id']
            ]);
        }
    }

    /**
     * 给买的会员送新等级
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function attachNewUserMinLevel($user)
    {
        $minLevel =  Level::orderBy('sort','asc')->first();
        if(!empty($minLevel))
        {
            ##并且之前都没有等级
            if(AttachUserLevel::where('user_id',$user->id)->count() == 0)
            {
                  AttachUserLevel::create([
                    'user_id'  => $user->id,
                    'level_id' => $minLevel->id
                ]);
            }
        }
    }



}

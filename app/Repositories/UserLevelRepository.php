<?php

namespace App\Repositories;

use App\Models\UserLevel;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserLevelRepository
 * @package App\Repositories
 * @version March 17, 2018, 6:53 pm CST
 *
 * @method UserLevel findWithoutFail($id, $columns = ['*'])
 * @method UserLevel find($id, $columns = ['*'])
 * @method UserLevel first($columns = ['*'])
*/
class UserLevelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'des',
        'money'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UserLevel::class;
    }

    public function levelUnique($input)
    {
        if(isset($input['level']) && !empty($input['level']))
        {
            $unique = UserLevel::where('level',$input['level'])->first();
            return $unique ? false : true;
        }
        else{
            return false;
        }
    }
}

<?php

namespace App\Repositories;

use App\User;
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
class UserRepository extends BaseRepository
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
        return User::class;
    }

    public function FindUserByShareCode($share_code)
    {
        try {
            return User::where('share_code', $share_code)->first();
        } catch (Exception $e) {
            return null;
        }
    }
}

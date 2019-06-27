<?php

namespace App\Repositories;

use App\Models\PlatForm;
use InfyOm\Generator\Common\BaseRepository;

use Cache;
use Config;

/**
 * Class PlatFormRepository
 * @package App\Repositories
 * @version December 13, 2017, 3:49 pm CST
 *
 * @method PlatForm findWithoutFail($id, $columns = ['*'])
 * @method PlatForm find($id, $columns = ['*'])
 * @method PlatForm first($columns = ['*'])
*/
class PlatFormRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'brief',
        'image',
        'star',
        'remark',
        'view',
        'jiehao',
        'tiaojian',
        'cailiao',
        'link',
        'hot'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PlatForm::class;
    }

    public function platforms($skip, $take, $type)
    {
        return Cache::remember('platforms_skip_'.$skip.'_take_'.$take.'_type_'.$type, Config::get('zcjy.timecache'), function() use($skip, $take, $type) {
            try {
                $platForms = [];
                if ($type == 1) {
                    $platForms = PlatForm::orderBy('sort', 'desc')->orderBy('created_at', 'desc');
                }
                if ($type == 2) {
                    $platForms = PlatForm::orderBy('hot', 'desc')->orderBy('sort', 'desc')->orderBy('created_at');
                }
                if ($type == 3) {
                    $platForms = PlatForm::orderBy('star', 'desc')->orderBy('sort', 'desc')->orderBy('created_at');
                }
                // if ($cat != -1) {
                //  $platForms = $platForms->where('plat_form_cat_id', $cat);
                // }

                $platForms = $platForms->skip($skip)->take($take)->get();
                foreach ($platForms as $key => $value) {
                    $tmp = [];
                    for ($i=0; $i < $value->star; $i++) { 
                        array_push($tmp, $i);
                    }
                    $value['stars'] = $tmp;
                }

                return $platForms;
            } catch (Exception $e) {
                return [];
            }
        });
    }

    public function catPlatforms($cat_id,$skip,$take)
    {
        return Cache::remember('platforms_cat_'.$cat_id.'_skip_'.$skip.'_take_'.$take, Config::get('zcjy.timecache'), function() use($cat_id, $skip, $take) {
            try {
                $platForms = PlatForm::where('plat_form_cat_id',$cat_id)->orderBy('sort', 'desc')->orderBy('created_at');
                $platForms = $platForms->skip($skip)->take($take)->get();
                foreach ($platForms as $key => $value) {
                    $tmp = [];
                    for ($i=0; $i < $value->star; $i++) { 
                        array_push($tmp, $i);
                    }
                    $value['stars'] = $tmp;
                }

                return $platForms;
            } catch (Exception $e) {
                return [];
            }
        });
    }
}

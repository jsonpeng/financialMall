<?php

namespace App\Repositories;

use App\Models\Tool;
use App\Models\ToolCat;
use InfyOm\Generator\Common\BaseRepository;

use Cache;
use Config;

/**
 * Class ToolRepository
 * @package App\Repositories
 * @version March 30, 2018, 8:42 am CST
 *
 * @method Tool findWithoutFail($id, $columns = ['*'])
 * @method Tool find($id, $columns = ['*'])
 * @method Tool first($columns = ['*'])
*/
class ToolRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'link'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Tool::class;
    }

    public function CacheAll()
    {
        return Cache::remember('tools', Config::get('zcjy.timecache'), function() {
            try {
                return Tool::all();
            } catch (Exception $e) {
                return;
            }
        });
    }

    public function getToolCatsWithTools()
    {
        return Cache::remember('toolcats_with_tool', Config::get('zcjy.timecache'), function() {
            try {
                $ToolCats = ToolCat::all();
                foreach ($ToolCats as $key => $ToolCat) {
                    $ToolCat['tools'] = Tool::where('cat_id',$ToolCat->id)->get();
                }
                return $ToolCats;
            } catch (Exception $e) {
                return;
            }
        });
    }

    public function getToolsBySlug($slug,$skip = 0,$take =20)
    {
        return Cache::remember('get_tools_by_slug'.$slug.$skip.$take,1,function() use ($slug,$skip,$take){
            $cats = ToolCat::where('slug',$slug)->get();
            if(empty($cats))
            {
                return [];
            }
            $cat_id_arr = [];
            foreach ($cats as $key => $value) {
               $cat_id_arr[] = $value->id;
            }
            return Tool::whereIn('cat_id',$cat_id_arr)
            ->orderBy('created_at','desc')
            ->skip($skip)
            ->take($take)
            ->get();
        });
    }


}

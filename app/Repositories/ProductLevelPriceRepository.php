<?php

namespace App\Repositories;

use App\Models\ProductLevelPrice;
use App\Models\UserLevel;

use InfyOm\Generator\Common\BaseRepository;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

/**
 * Class ProductLevelPriceRepository
 * @package App\Repositories
 * @version February 11, 2019, 11:44 am CST
 *
 * @method ProductLevelPrice findWithoutFail($id, $columns = ['*'])
 * @method ProductLevelPrice find($id, $columns = ['*'])
 * @method ProductLevelPrice first($columns = ['*'])
*/
class ProductLevelPriceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'product_id',
        'type',
        'level_id',
        'price'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProductLevelPrice::class;
    }

    /**
     * 最底层函数获取等级商品
     * @param  string $productOrSpec [description]
     * @param  [type] $product_id     [description]
     * @return [type]                [description]
     */
    public function getLevelProduct($productOrSpec="product",$product_id)
    {
         return ProductLevelPrice::where('type',$productOrSpec)
            ->where('product_id',$product_id);
    }

    /**
     * 获取会员等级商品详情
     * @param  string $productOrSpec [description]
     * @param  [type] $level_id      [description]
     * @param  [type] $product_id    [description]
     * @return [type]                [description]
     */
    public function getlevelProductDetail($productOrSpec="product",$level_id,$product_id=null)
    {
              return ProductLevelPrice::where('type',$productOrSpec)
                     ->where('level_id',$level_id)
                     ->where('product_id',$product_id)
                     ->first();
    }

    /**
     * 获取所有会员等级 附带上缓存
     * @return [type] [description]
     */
    public function getCacheAllLevel()
    {
        return Cache::remember('cache_all_levels',Config::get('web.cachetime'),function(){
            return $this->getAllLevel();
        });
    }

    /**
     * 获取所有会员等级 带上附带服务
     * @return [type] [description]
     */
    public function getAllLevel()
    {
        $levels = UserLevel::all();
        foreach ($levels as $key => $level) 
        {
            $level['services'] = spaceList($level->attach_words);
        }
        return $levels;
    }

    /**
     * 为生成的规格表格附加会员价格信息
     * @param [type] $str [description]
     */
    public function addSpecTr($str)
    {
        $levels = $this->getAllLevel();

        foreach ($levels as $key => $level) 
        {
            $str .= ' <td><b>'.$level->name.'价格</b></td>';
        }

        return $str;
    }

    /**
     * 为生成的规格表单附加会员价格信息
     * @param [type] $str [description]
     */
    public function addSpecInput($str,$item_key,$spec_id)
    {
        $levels = $this->getAllLevel();
        $i = -1;
        foreach ($levels as $key => $level) 
        {
            $level_price = $this->getlevelProductDetail('spec',$level->id,$spec_id);
            $str .= sprintf("<td width=100><input name=item[%s][level_price_".$level->id."] class='form-control' value='%s' onkeyup='this.value=this.value.replace(/[^\d.]/g,\"\")' onpaste='this.value=this.value.replace(/[^\d.]/g,\"\")' /></td>", $item_key, !empty($level_price) ? $level_price->price : 0);
        }

        return $str;
    }

    /**
     * 为指定的spec添加价格
     * @param [type] $arr     [description]
     * @param [type] $spec_id [description]
     */
    public function addArrSpecLevelPrice($arr,$spec_id)
    {
        $all_level_prices =  $this->getAllLevelWithPrice($spec_id,'spec');

        foreach ($all_level_prices as $key => $level) 
        {
          $arr['level_price_'.$level->id] = $level->level_price;
        }
        return $arr;
    }

    /**
     * 获取单个商品的会员等级价格
     * @param  string $productOrSpec [description]
     * @param  [type] $product_id    [description]
     * @return [type]                [description]
     */
    public function getAllLevelWithPrice($product_id=null,$productOrSpec="product")
    {
        $levels = $this->getAllLevel();

        foreach ($levels as $key => $level) 
        {
            $level_price = $this->getlevelProductDetail($productOrSpec,$level->id,$product_id);
            $level['level_price'] = !is_null($level_price) ? $level_price->price : null;
            // if(is_null($level['$level_price']))
            // {
            //     unset($levels[$key]);
            // }
        }

        return $levels;
    }

    /**
     * 删除对应会员等级的商品
     * @param  string $productOrSpec [description]
     * @param  [type] $product_id     [description]
     * @return [type]                [description]
     */
    public function deleteLevelProductPrice($productOrSpec="product",$product_id)
    {
        return $this->getLevelProduct($productOrSpec,$product_id)->delete();
    }


    /**
     * 存储会员等级价格
     * @param  string $productOrSpec [description]
     * @param  [type] $product_id     [description]
     * @param  [type] $level_id      [description]
     * @return [type]                [description]
     */
    public function saveLevelPrice($input,$product_id,$action='create',$productOrSpec="product")
    {
        if($action == 'update')
        {
            $this->deleteLevelProductPrice($productOrSpec,$product_id);
        }

        foreach ($input as $key => $value) 
        {
           if(strpos($key,'level_price_') !== false)
           {
                $form_attr = explode('_',$key);
                $level_id = $form_attr[2];
                ProductLevelPrice::create([
                    'type'      => $productOrSpec,
                    'product_id'=> $product_id,
                    'level_id'  => $level_id,
                    'price'     => $value
                ]);
           }
        }
        return '保存成功';
    }

}

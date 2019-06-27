<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\SpecProductPrice;
use App\Models\Item;

class CartRepository 
{


    /**
     * 获取购物车列表
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public static function getItem($user_id)
    {
        $items =  Item::where('user_id',$user_id)->whereNull('order_id')->get();
        $items = self::attachMaxBuy($items);
        return $items;
    }

    /**
     * 添加最大购买数量
     * @param  [type] $items [description]
     * @return [type]        [description]
     */
    public static function attachMaxBuy($items)
    {
      if(count($items))
      {
        foreach ($items as $key => $item) 
        {
            $spec_id = null;
            #规格
            if(isset($item->spec_key) && isset($item->spec_keyname))
            {
              $spec = self::searchSpec($item);

              if(!empty($spec))
              {
                $spec_id = $spec->id;
              }

            }
            #普通商品
            $product = $item->product;
            $item['max_buy'] = app('commonRepo')->maxCanBuy($product,999999,$spec_id);
        }
        return $items;
      }
    }

    /**
     * 获取购物车 总价 总积分 及数量
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public static function get($user_id,$cart_items = null)
    {
        $items =  self::getItem($user_id);

        $count = 0;
        $price = 0;
        $jifen = 0;
        $cost  = 0;
        $cart_items_id_arr = [];

        if(!empty($cart_items))
        {
          $cart_items = json_decode($cart_items, true);
          foreach ($cart_items as $key => $cart) 
          {
              if(isset($cart['selected']) && $cart['selected'] == 1)
              {
                $cart_items_id_arr[] = $cart['id'];
              }
          }
        }
        
        if(count($items))
        {
          foreach ($items as $key => $item) 
          {
              #针对普通的结算
              if(empty($cart_items)){

               $count += $item->count;
               $price += $item->count * $item->price;
               $jifen += $item->count * $item->jifen;
               $cost  += $item->count * $item->cost;

             }#针对选择指定的
             else{
                if(count($cart_items_id_arr))
                {
                  if(in_array($item->id,$cart_items_id_arr)){
                    $count += $item->count;
                    $price += $item->count * $item->price;
                    $jifen += $item->count * $item->jifen;
                    $cost  += $item->count * $item->cost;
                  }
                  else{
                    unset($items[$key]);
                  }
                }
                else{
                  $items = [];
                }
             }
          }
          $items_arr = [];
          foreach ($items as $key => $item) 
          {
            $items_arr[] = $item;
          }
          $items = $items_arr;
        }

        return [
          'items' =>  $items,
          'count' =>  $count,
          'price' =>  round($price,2),
          'jifen' =>  $jifen,
          'cost'  =>  $cost
        ];
    }

    /**
     * 添加购物车
     * @param [type] $input [description]
     */
    public static function add($input)
    {
        #基础表单验证
        $validator = \Zcjy::form()->varifyInputParam($input,'product_id,user_id');

        #如果出现问题
        if($validator) 
        {
            return $validator;
        }

        $product_id = explode('_',$input['product_id']);

        #带有规格的
        if(count($product_id) >= 2)
        {
             //商品
            $product = app('commonRepo')->productRepo()->findWithoutFail($product_id[0]);

            if(empty($product))
            {
                return '商品不存在';
            }

            #规格id
            $spec_id    = isset($product_id[1]) ? $product_id[1] : 0;

            //规格商品
            $spec_product = app('commonRepo')->specProductPriceRepo()->findWithoutFail($spec_id);

            if(empty($spec_product))
            {
                return '商品不存在';
            }

            $item = self::searchWhetherIn($input['user_id'],$product,$spec_product);

            if($spec_product->inventory == 0)
            {
              return '该商品已无更多库存';
            }

            if($item)
            {
              #最大库存
              $input['count'] =  app('commonRepo')->maxCanBuy($product, $item->count+$input['count'],$spec_product->id);
              $action = self::update(['cart_id'=>$item->id,'count'=>$input['count']]);
              if($action)
              {
                return $action;
              }
            }
            else{

                $item_price = app('commonRepo')->getMemberPrice(user($input['user_id']),$product,$spec_product);

                Item::create([
                    'name'          => $product->name,
                    'pic'           => $spec_product->image,
                    'price'         => $item_price,
                    'cost'          => $product->cost,
                    'count'         => $input['count'],
                    'unit'          => $spec_product->key_name,
                    'product_id'    => $product->id,
                    'spec_key'      => $spec_product->key,
                    'spec_keyname'  => $spec_product->key_name,
                    'jifen'         => $spec_product->jifen,
                    'user_id'       => $input['user_id']
                ]);
            }


        }#不带规格的
        else{
            $product_id = $product_id[0];

            //商品
            $product = app('commonRepo')->productRepo()->findWithoutFail($product_id);

            if(empty($product))
            {
                return '商品不存在';
            }

            if($product->inventory == 0)
            {
              return '该商品已无更多库存';
            }

            $item = self::searchWhetherIn($input['user_id'],$product);

            if($item)
            {
              #最大库存
              $input['count'] =  app('commonRepo')->maxCanBuy($product, $item->count+$input['count']);
              $action = self::update(['cart_id'=>$item->id,'count'=> $input['count']]);
             
             if($action)
             {
                return $action;
             }

            }
            else{
                $item_price = app('commonRepo')->getMemberPrice(user($input['user_id']),$product);
                Item::create([
                    'name'      => $product->name,
                    'pic'       => $product->image,
                    'price'     => $item_price,
                    'cost'      => $product->cost,
                    'count'     => $input['count'],
                    'unit'      => '',
                    'product_id'=> $product->id,
                    'jifen'     => $product->jifen,
                    'user_id'   => $input['user_id']
                ]);
            }

        }
    }

    /**
     * 根据产品id 集合 判断是否之前添加过购物车
     * @param  [type] $product_id_arr [description]
     * @return [type]                 [description]
     */
    public static function searchWhetherIn($user_id,$product,$spec_product=null)
    {
        $item = Item::where('product_id',$product->id)
            ->where('user_id',$user_id)
            ->whereNull('order_id');
          
        #带有规格的
        if(!empty($spec_product))
        {
           $item = $item
           ->where('spec_key',$spec_product->key)
           ->where('spec_keyname',$spec_product->key_name);
        }

        return $item->first();
    }

    /**
     * 查找到具体的规格商品
     * @param  [type] $item [description]
     * @return [type]       [description]
     */
    public static function searchSpec($item)
    {
        return SpecProductPrice::where('key',$item->spec_key)
        ->where('key_name',$item->spec_keyname)
        ->where('product_id',$item->product_id)
        ->first();
    }

    /**
     * 更新购物车
     * @param  [type] $input [description]
     * @return [type]        [description]
     */
    public static function update($input)
    {
        #基础表单验证
        $validator = \Zcjy::form()->varifyInputParam($input,'cart_id');

        #如果出现问题
        if($validator) 
        {
            return $validator;
        }

        $item = Item::find($input['cart_id']);

        if(empty($item))
        {
            return '没有找到该购物车';
        }

        $product = $item->product;

        if(empty($product))
        {
            return '没有该商品';
        }

        $spec = self::searchSpec($item);

        $qty = $input['count'];

        ##更新普通商品
        if(empty($spec))
        {
           $input['count'] =  app('commonRepo')->maxCanBuy($product, $qty);
        }##更新带有规格的商品
        else{
           $input['count'] =  app('commonRepo')->maxCanBuy($product, $qty,$spec->id);
        }

        $item->update(['count'=>$qty]);
    }

    /**
     * 删除购物车
     * @param  [type] $input [description]
     * @return [type]        [description]
     */
    public static function delete($input)
    {
        #基础表单验证
        $validator = \Zcjy::form()->varifyInputParam($input,'cart_id');

        #如果出现问题
        if($validator) 
        {
            return $validator;
        }

        if(stripos($input['cart_id'],',') !== false)
        {
          $items = explode('#',$input['cart_id']);
          foreach ($items as $key => $item_id) 
          {
              $item = Item::find($item_id);
              if(!empty($item))
              {
                $item->delete();
              }
          }
        }
        else{
          $item = Item::find($input['cart_id']);
          if(empty($item))
          {
              return '没有找到该购物车';
          }
          $item->delete();
      }
    }
 

}

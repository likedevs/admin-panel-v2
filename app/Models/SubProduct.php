<?php

namespace App\Models;

use App\Base as Model;

class SubProduct extends Model
{
    protected $table = 'subproducts';

    protected $fillable = ['product_id', 'code', 'combination_id', 'combination', 'price', 'price_lei', 'actual_price', 'actual_price_lei', 'discount', 'stock', 'image', 'product_image_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function values()
    {
      return $this->hasMany(SubProductValue::class);
    }

    public function value($property_id)
    {
      return $this->hasOne(SubProductValue::class)->where('property_id', $property_id);
    }

    public function image()
    {
      return $this->hasOne(ProductImage::class, 'id', 'product_image_id');
    }

    public function combinationItem()
    {
      return $this->hasOne(SubproductCombination::class, 'id', 'combination_id');
    }

    public function cart()
    {
      return $this->hasOne(Cart::class, 'subproduct_id', 'id');
    }

    public function inWishList()
    {
        $user_id = auth('persons')->id() ? auth('persons')->id() : @$_COOKIE['user_id'];
        return $this->hasOne(WishList::class, 'subproduct_id')->where('user_id', $user_id);
    }
}

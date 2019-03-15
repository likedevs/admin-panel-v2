<?php

namespace App\Models;

use App\Base as Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'set_id', 'promotion_id', 'alias', 'position', 'price', 'actual_price', 'price_lei', 'actual_price_lei', 'discount', 'hit', 'recomended', 'stock', 'code', 'video', 'discount_update'];

    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function category()
    {
        return $this->hasOne(ProductCategory::class, 'id', 'category_id');
    }

    public function translation()
    {
        return $this->hasOne(ProductTranslation::class)->where('lang_id', self::$lang);
    }

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function mainImage()
    {
        return $this->hasOne(ProductImage::class, 'product_id')->orderBy('main', 'desc');
    }

    public function setImage($setId)
    {
         return $this->hasOne(SetProductImage::class, 'product_id')->where('set_id', $setId);
    }

    public function setImages()
    {
        return  $this->hasMany(SetProductImage::class, 'product_id')->inRandomOrder();
    }

    public function images()
    {
         return $this->hasMany(ProductImage::class, 'product_id')->orderBy('first', 'desc');
    }

    public function inCart()
    {
        return $this->hasOne(Cart::class, 'product_id')->where('user_id', @$_COOKIE['user_id']);
    }

    public function inWishList()
    {
        $user_id = auth('persons')->id() ? auth('persons')->id() : @$_COOKIE['user_id'];
        return $this->hasOne(WishList::class, 'product_id')->where('user_id', $user_id);
    }

    public function similar()
    {
        return $this->hasMany(ProductSimilar::class);
    }

    public function subproducts()
    {
        return $this->hasMany(SubProduct::class);
    }

    public function subproductById($id)
    {
        return $this->hasOne(SubProduct::class)->where('id', $id);
    }

    public function property()
    {
        return $this->hasMany(SubProductProperty::class, 'product_category_id', 'category_id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'product_id', 'id');
    }

    public function set()
    {
        return $this->hasOne(Set::class, 'id', 'set_id');
    }

    public function sets()
    {
        return $this->belongsToMany(Set::class, 'set_product');
    }
}

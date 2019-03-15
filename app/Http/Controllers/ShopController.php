<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lang;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\PropertyCategory;
use App\Models\ProductProperty;
use App\Models\Brand;
use App\Models\PropertyValue;
use App\Models\SubProductProperty;
use App\Models\SubproductCombination;
use App\Models\SubProduct;
use App\Models\UserField;
use App\Models\Country;
use App\Models\Region;
use App\Models\City;
use App\Models\Page;
use App\Models\SetProducts;
use App\Models\FrontUser;

class ShopController extends Controller
{
    public static $productList = [];

    // check if item exists
    protected function _ifExists($object){
        if (is_null($object)) {
            return redirect()->route('404')->send();
        }
    }

    // get SEO data for a page
    protected function _getSeo($page){
        $seo['seo_title'] = $page->translationByLanguage($this->lang->id)->first()->seo_title ?? $page->translationByLanguage($this->lang->id)->first()->name;
        $seo['seo_keywords'] = $page->translationByLanguage($this->lang->id)->first()->meta_keywords ?? $page->translationByLanguage($this->lang->id)->first()->name;
        $seo['seo_description'] = $page->translationByLanguage($this->lang->id)->first()->meta_description ?? $page->translationByLanguage($this->lang->id)->first()->name;

        return $seo;
    }

    // get SEO data for a page
    protected function _getSeoFromPage($page){
        $seo['seo_title'] = $page->translationByLanguage($this->lang->id)->first()->meta_title ?? $page->translationByLanguage($this->lang->id)->first()->title;
        $seo['seo_keywords'] = $page->translationByLanguage($this->lang->id)->first()->meta_keywords ?? $page->translationByLanguage($this->lang->id)->first()->name;
        $seo['seo_description'] = $page->translationByLanguage($this->lang->id)->first()->meta_description ?? $page->translationByLanguage($this->lang->id)->first()->name;

        return $seo;
    }

    protected function getProperties($category_id)
    {
        $properties = [];
        $category = ProductCategory::where('id', $category_id)->first();

        if (!is_null($category)) {
            $properties = array_merge($properties, $this->getPropertiesList($category->id));
            $category1 = ProductCategory::where('parent_id', $category->id)->pluck('id')->toArray();
            if (count($category1) > 0) {
                $properties = array_merge($properties, $this->getPropertiesListByCats($category1));
                $category2 = ProductCategory::whereIn('parent_id', $category1)->pluck('id')->toArray();
                if (count($category2) > 0) {
                    $properties = array_merge($properties, $this->getPropertiesListByCats($category2));
                    $category3 = ProductCategory::whereIn('parent_id', $category2)->pluck('id')->toArray();
                    if (count($category3) > 0) {
                        $properties = array_merge($properties, $this->getPropertiesList($category3));
                    }
                }
            }
        }else{
            $categoriesAll = ProductCategory::pluck('id')->toArray();
            $properties = array_merge($properties, $this->getPropertiesListByCats($categoriesAll));
        }


        $properties = array_unique($properties);


        return ProductProperty::with('translationByLanguage')
                            ->where('filter', 1)
                            ->with('multidata')
                            ->whereIn('id', $properties)
                            ->get();
    }

    protected function getPropertiesList($categoryId)
    {
        $propertiesArr = [];
        $properties = PropertyCategory::where('category_id', $categoryId)->get();
        if (!empty($properties)) {
            foreach ($properties as $key => $property) {
                $propertiesArr[] = $property->property_id;
            }
        }

        return $propertiesArr;
    }

    protected function getPropertiesListByCats($cats)
    {
        $propertiesArr = [];
        $properties = PropertyCategory::whereIn('category_id', $cats)->get();
        if (!empty($properties)) {
            foreach ($properties as $key => $property) {
                $propertiesArr[] = $property->property_id;
            }
        }

        return $propertiesArr;
    }

    /***************************************************************************
     *                           FILTER METHODS
    ***************************************************************************/

     /**
      *  sort by category
      */
     public function filter(Request $request)
     {
         if (@$_COOKIE['filter']) {
             $filter = unserialize(@$_COOKIE['filter']);
             if (is_array($filter['categories'])) {
                 if (!in_array($request->get('value'), $filter['categories'])) {
                     $filter['categories'][$request->get('value')] = $request->get('value');
                 }else{
                     unset($filter['categories'][$request->get('value')]);
                 }
             }
             setcookie('filter', serialize($filter), time() + 10000000, '/');
             $filterId = $filter;
         }

         $products = $this->_getProductList($filterId, $request->get('category_id'));
         $brands   = $this->_getBrandsList($filterId);
         $subcategories = ProductCategory::where('parent_id', $request->get('category_id'))->get();
         $properties = $this->getProperties($request->get('category_id'));
         $category = ProductCategory::where('id', $request->get('category_id'))->first();

         self::$productList = $products->pluck('id')->toArray();
         $products = $this->getProductsByParams($filter);

         $data['products'] = view('front.filters.productToFilter', compact('products'))->render();
         $data['filter'] = view('front.filters.categoryFilter', compact('subcategories', 'brands', 'category', 'filter', 'properties', 'products'))->render();
         $data['url'] = http_build_query($filter, 'myvar_');

         return json_encode($data);
     }

     /**
      * Sort by brand
      */
     public function filterBrand(Request $request)
     {
         if (@$_COOKIE['filter']) {
             $filter = unserialize(@$_COOKIE['filter']);
             if (is_array($filter['brands'])) {
                 if (!in_array($request->get('value'), $filter['brands'])) {
                     $filter['brands'][$request->get('value')] = $request->get('value');
                 }else{
                     unset($filter['brands'][$request->get('value')]);
                 }
             }
             setcookie('filter', serialize($filter), time() + 10000000, '/');
             $filterId = $filter;
         }

         $products = $this->_getProductList($filterId, $request->get('category_id'));
         $brands   = $this->_getBrandsList($filterId);
         $subcategories = ProductCategory::where('parent_id', $request->get('category_id'))->get();
         $properties = $this->getProperties($request->get('category_id'));
         $category = ProductCategory::where('id', $request->get('category_id'))->first();;

         self::$productList = $products->pluck('id')->toArray();
         $products = $this->getProductsByParams($filter);

         // dd($products);

         $data['products'] = view('front.filters.productToFilter', compact('products'))->render();
         $data['filter'] = view('front.filters.categoryFilter', compact('subcategories', 'brands', 'category', 'filter', 'properties', 'products'))->render();
         $data['url'] = http_build_query($filter, 'myvar_');

         return json_encode($data);
     }

     /**
      * Sort by properties
      */
     public function filterProperty(Request $request)
     {
         if (@$_COOKIE['filter']) {
             $filter = unserialize(@$_COOKIE['filter']);
             if (is_array($filter['properties'])) {
                 if (array_key_exists($request->get('name'), $filter['properties'])) {
                     if (!in_array($request->get('value'), @$filter['properties'][$request->get('name')])) {
                         $filter['properties'][$request->get('name')][$request->get('value')] = $request->get('value');
                     }else{
                         unset($filter['properties'][$request->get('name')][$request->get('value')]);
                     }
                 }else{
                     $filter['properties'][$request->get('name')][$request->get('value')] = $request->get('value');
                 }
             }
             setcookie('filter', serialize($filter), time() + 10000000, '/');
             $filterId = $filter;
         }

         $products = $this->_getProductList($filterId, $request->get('category_id'));
         $brands   = $this->_getBrandsList($filterId, $request->get('category_id'));
         $subcategories = ProductCategory::where('parent_id', $request->get('category_id'))->get();
         $properties = $this->getProperties($request->get('category_id'));
         $category = ProductCategory::where('id', $request->get('category_id'))->first();;


         self::$productList = $products->pluck('id')->toArray();
         $products = $this->getProductsByParams($filter);

         $data['products'] = view('front.filters.productToFilter', compact('products'))->render();
         // $data['filter'] = view('front.filters.categoryFilter', compact('subcategories', 'brands', 'category', 'filter', 'properties', 'products'))->render();
         $data['url'] = http_build_query($filter, 'myvar_');

         return json_encode($data);
     }

     /**
      * Sort by price
      */
     public function filterPrice(Request $request)
     {
         if (@$_COOKIE['filter']) {
             $filter = unserialize(@$_COOKIE['filter']);
             if (is_array($filter['price'])) {
                 $filter['price']['from'] = $request->get('from');
                 $filter['price']['to'] = $request->get('to');

             }
             setcookie('filter', serialize($filter), time() + 10000000, '/');
             $filterId = $filter;
         }

         $products = $this->_getProductList($filterId, $request->get('category_id'));
         $brands   = $this->_getBrandsList($filterId);
         $subcategories = ProductCategory::where('parent_id', $request->get('category_id'))->get();
         $properties = $this->getProperties($request->get('category_id'));
         $category = ProductCategory::where('id', $request->get('category_id'))->first();;

         self::$productList = $products->pluck('id')->toArray();
         $products = $this->getProductsByParams($filter);

         $data['products'] = view('front.filters.productToFilter', compact('products'))->render();
         // $data['filter'] = view('front.filters.categoryFilter', compact('subcategories', 'brands', 'category', 'filter', 'properties', 'products'))->render();
         $data['url'] = http_build_query($filter, 'myvar_');

         return json_encode($data);
     }

     /**
      * Limit Filter
      */
      public function filterLimit(Request $request)
      {
          if (@$_COOKIE['filter']) {
              $filter = unserialize(@$_COOKIE['filter']);
                  $filter['limit'] = $request->get('limit');
              setcookie('filter', serialize($filter), time() + 10000000, '/');
              $filterId = $filter;
          }

          $products = $this->_getProductList($filterId, $request->get('category_id'));
          $brands   = $this->_getBrandsList($filterId);
          $subcategories = ProductCategory::where('parent_id', $request->get('category_id'))->get();
          $properties = $this->getProperties($request->get('category_id'));
          $category = ProductCategory::where('id', $request->get('category_id'))->first();;

          self::$productList = $products->pluck('id')->toArray();
          $products = $this->getProductsByParams($filter);

          $data['products'] = view('front.filters.productToFilter', compact('products'))->render();
          $data['filter'] = view('front.filters.categoryFilter', compact('subcategories', 'brands', 'category', 'filter', 'properties', 'products'))->render();
          $data['url'] = http_build_query($filter, 'myvar_');

          return json_encode($data);
      }

      /**
       * Order Filter
       */
      public function filterOrder(Request $request)
      {
          if (@$_COOKIE['filter']) {
              $filter = unserialize(@$_COOKIE['filter']);
                  $filter['order']['order'] = $request->get('order');
                  $filter['order']['field'] = $request->get('field');
              setcookie('filter', serialize($filter), time() + 10000000, '/');
              $filterId = $filter;
          }

          $products = $this->_getProductList($filterId, $request->get('category_id'));
          $brands   = $this->_getBrandsList($filterId);
          $subcategories = ProductCategory::where('parent_id', $request->get('category_id'))->get();
          $properties = $this->getProperties($request->get('category_id'));
          $category = ProductCategory::where('id', $request->get('category_id'))->first();;

          self::$productList = $products->pluck('id')->toArray();
          $products = $this->getProductsByParams($filter);

          $data['products'] = view('front.filters.productToFilter', compact('products'))->render();
          $data['filter'] = view('front.filters.categoryFilter', compact('subcategories', 'brands', 'category', 'filter', 'properties', 'products'))->render();
          $data['url'] = http_build_query($filter, 'myvar_');

          return json_encode($data);
      }


     public function getProductsByParams($filter)
     {
         $filter['properties'] = array_filter($filter['properties']);
         $props = [];
         if (is_array($filter['properties'])) {
             foreach ($filter['properties'] as $propId => $values) {
                 foreach ($values as $key => $value) {
                     $array = PropertyValue::select('product_id')
                                     ->where('value_id', $value)
                                     ->where('property_id', $propId)
                                     ->whereIn('product_id', self::$productList)
                                     ->pluck('product_id')->toArray();

                     $props = array_merge($props, $array);
                 }
                 self::$productList = $props;
                 $props = [];
             }
         }

          return Product::whereIn('id', self::$productList)
                          ->when(count($filter['order']) > 0, function ($query) use ($filter) {
                                  return $query->orderBy($filter['order']['field'], $filter['order']['order']);
                              })
                              ->orderBy('position', 'asc')->paginate(9);
     }

     public function getProductsByParamsAll()
     {
          return Product::whereIn('id', self::$productList)->get();
     }

     // get Products list by filters
     protected function _getProductList($filterId, $catId){
         $products =   Product::when(count($filterId['categories']) > 0, function ($query) use ($filterId) {
                         $subcats = ProductCategory::whereIn('parent_id', $filterId['categories'])->pluck('id')->toArray();
                         $subcatsLast = ProductCategory::whereIn('parent_id', $subcats)->pluck('id')->toArray();
                         $cats = array_merge($subcats, $filterId['categories'], $subcatsLast);
                         return $query->whereIn('category_id', array_filter($cats));
                     })
                 ->when(count($filterId['categories']) == 0, function ($query) use ($catId) {
                         $subcats = ProductCategory::where('parent_id', $catId)->pluck('id')->toArray();
                         $subcatsLast = ProductCategory::whereIn('parent_id', $subcats)->pluck('id')->toArray();
                         $cats = array_merge($subcats,  $subcatsLast, [$catId]);
                         return $query->whereIn('category_id', array_filter($cats));
                     })
                 ->when(count($filterId['price']) > 0, function ($query) use ($filterId) {
                         return $query->where('actual_price_lei', '>=', $filterId['price']['from'])->where('actual_price_lei', '<=', $filterId['price']['to']);
                     })
                 ->when(count($filterId['limit']) > 0, function ($query) use ($filterId) {
                         return $query->limit($filterId['limit']);
                     })
                 ->get();

        return $products;
     }


     protected function _getBrandsList($filterId){
         return true;
         $productsByBrands = Product::when(!empty($filterId['categories']), function ($query) use ($filterId) {
                                     return $query->whereIn('category_id', $filterId['categories']);
                                 })->pluck('brand_id')->toArray();

         array_push($productsByBrands, $filterId['brands']);

         return  Brand::where('parent_id', '!=', 0)->whereIn('id', array_filter($productsByBrands))->get();
     }

     /**
      * Reset all filtres
      */
     public function filterReset()
     {
         $filter['categories'] = [];
         $filter['brands'] = [];
         $filter['price'] = [];
         $filter['properties'] = [];

         setcookie('filter', serialize($filter), time() + 10000000, '/');

         $url = url()->previous();
         $url = strtok($url, '?');
         return redirect($url);
     }

}

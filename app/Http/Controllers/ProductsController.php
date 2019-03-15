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
use App\Models\ProductSimilar;
use App\Models\UserField;
use App\Models\Country;
use App\Models\Region;
use App\Models\City;
use App\Models\Page;
use App\Models\Set;
use App\Models\SetProducts;
use App\Models\FrontUser;


class ProductsController extends ShopController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     *  Single Product page
     */
    public function getProductSingle($slug, $subcategory, $productSlug)
    {
        $category = ProductCategory::where('alias', $slug)->first();
        $this->_ifExists($category);

        if ($subcategory != 'null') {
            $subcategory = ProductCategory::where('alias', $subcategory)->where('parent_id', $category->id)->first();
        }else{
            $subcategory = $category;
        }

        $product = Product::where('alias', $productSlug)->first();
        $this->_ifExists($product);

        $filter = [
                    0 => [ 'productId' => 0, 'valueId' => 0, 'propertyId' => 0 ],
                    1 => [ 'productId' => 0, 'valueId' => 0, 'propertyId' => 0 ],
                    2 => [ 'productId' => 0, 'valueId' => 0, 'propertyId' => 0 ],
                ];

        setcookie('subprods', serialize($filter), time() + 10000000, '/');
        $dependebleProps = SubProductProperty::where('product_category_id', $product->category_id)->where('status', 'dependable')->where('show_property', 1)->get();

        $products = Product::where('category_id', $subcategory->id)->get();

        $productsSets = $product->sets()->pluck('set_id')->toArray();

        $similarCategs = ProductSimilar::where('product_id', $product->id)->pluck('category_id')->toArray();
        $similarProducts = Product::whereIn('category_id', $similarCategs)->limit(5)->pluck('id')->toArray();

        $setsId = SetProducts::whereIn('set_id', $productsSets)->pluck('product_id')->toArray();

        $allProds = array_merge($setsId, $similarProducts);

        $wearWith = Product::whereIn('id', $allProds)->where('id', '!=', $product->id)->limit(12)->get();

        $collections = $product->sets()->pluck('collection_id')->toArray();
        $similarSets =  Set::whereIn('collection_id', $collections)->get();
        $seoData = $this->_getSeo($product);

        return view('front.products.product', compact('seoData', 'category', 'product', 'products', 'wearWith', 'similarSets', 'dependebleProps'));
    }

    /**
     * Category page, first level
     */
    public function categoriesList(Request $request, $slug)
    {
        $category = ProductCategory::where('alias', $slug)->first();

        $this->_ifExists($category);

        $filter['categories'] = $request->get('categories') ?? [];
        $filter['brands'] = $request->get('brands') ?? [];
        $filter['properties'] = $request->get('properties') ?? [];
        $filter['price'] = $request->get('price') ?? [];
        $filter['limit'] = $request->get('limit') ?? [];
        $filter['order'] = $request->get('order') ?? [];

        setcookie('filter', serialize($filter), time() + 10000000, '/');

        $subcategories  = ProductCategory::where('parent_id', $category->id)->get();
        $properties     = $this->getProperties($category->id);

        $products       = $this->_getProductList($filter, $category->id);
        $seoData        = $this->_getSeo($category);

        self::$productList = $products->pluck('id')->toArray();

        $filterSubprods = [];

        setcookie('subprods', serialize($filterSubprods), time() + 10000000, '/');

        $products = $this->getProductsByParams($filter);
        $dependebleProps = SubProductProperty::where('product_category_id', $category->id)->where('status', 'dependable')->where('show_property', 1)->get();
        $categoryId = $category->id;

        $productsAll = $this->getProductsByParamsAll();

        if ($request->ajax()) {
           $lastItem = "false";
           $url = $products->nextPageUrl();
           $last = $products->lastPage();
           $current = $products->currentPage();

           if (intval($last) == intval($current)) {
               $lastItem = 'true';
           }

           $view = view('front.loadMore.categoryProducts', compact('products', 'url'))->render();
           return json_encode(['html' => $view, 'url' => $url, 'last' => $lastItem]);
        }

        return view('front.products.categoriesList', compact('seoData', 'filter', 'categoryId', 'category', 'subcategories', 'products', 'productsAll', 'properties', 'dependebleProps'));
    }

    /**
     * Subcategory page, second level
     */
    public function subcategoriesList(Request $request, $slug, $subcategorySlug)
    {
        $category = ProductCategory::where('alias', $slug)->first();
        $this->_ifExists($category);

        $subcategory = ProductCategory::where('alias', $subcategorySlug)->where('parent_id', $category->id)->first();
        if (is_null($subcategory)) {
            return $this->getProductSingle($slug, 'null', $subcategorySlug);
        }

        $filter['categories'] = $request->get('categories') ?? [];
        $filter['brands'] = $request->get('brands') ?? [];
        $filter['properties'] = $request->get('properties') ?? [];
        $filter['price'] = $request->get('price') ?? [];
        $filter['limit'] = $request->get('limit') ?? [];
        $filter['order'] = $request->get('order') ?? [];

        setcookie('filter', serialize($filter), time() + 10000000, '/');

        $subcategories  = ProductCategory::where('parent_id', $subcategory->id)->get();
        // $brands         = $this->_getBrandsList($filter);
        $products       = $this->_getProductList($filter, $subcategory->id);

        $properties     = $this->getProperties($category->id);

        $seoData = $this->_getSeo($category);

        self::$productList = $products->pluck('id')->toArray();

        $filterSubprods = [];

        setcookie('subprods', serialize($filterSubprods), time() + 10000000, '/');

        $products = $this->getProductsByParams($filter);
        $dependebleProps = SubProductProperty::where('product_category_id', $subcategory->id)->where('status', 'dependable')->where('show_property', 1)->get();
        $categoryId = $subcategory->id;

        if ($request->ajax()) {
            $lastItem = "false";
            $url = $products->nextPageUrl();
            $last = $products->lastPage();
            $current = $products->currentPage();

            if (intval($last) == intval($current)) {
                $lastItem = 'true';
            }

           $url = $products->nextPageUrl();
           $view = view('front.loadMore.categoryProducts', compact('products', 'url'))->render();

           return json_encode(['html' => $view, 'url' => $url, 'last' => $lastItem]);
        }

        return view('front.products.subcategoriesList', compact('seoData', 'filter', 'categoryId', 'brands', 'category', 'subcategory', 'subcategories', 'products', 'properties', 'dependebleProps'));
    }

    /**
     * Product list without categories
     */
    public function productsList(Request $request)
    {
        $category = Page::where('alias', 'shop')->first();
        $this->_ifExists($category);

        $filter['categories'] = $request->get('categories') ?? [];
        $filter['brands'] = $request->get('brands') ?? [];
        $filter['properties'] = $request->get('properties') ?? [];
        $filter['price'] = $request->get('price') ?? [];
        $filter['limit'] = $request->get('limit') ?? [];
        $filter['order'] = $request->get('order') ?? [];

        setcookie('filter', serialize($filter), time() + 10000000, '/');

        $subcategories  = ProductCategory::where('parent_id', 0)->get();
        $brands         = $this->_getBrandsList($filter);
        $properties     = $this->getProperties(0);

        $products       = $this->_getProductList($filter, 0);
        $seoData        = $this->_getSeo($category);

        self::$productList = $products->pluck('id')->toArray();

        $filterSubprods = [];

        setcookie('subprods', serialize($filterSubprods), time() + 10000000, '/');

        $products = $this->getProductsByParams($filter);
        $dependebleProps = SubProductProperty::where('product_category_id', $category->id)->where('status', 'dependable')->where('show_property', 1)->get();

        return view('front.products.categoriesList', compact('seoData', 'filter', 'brands', 'category', 'subcategories', 'products', 'properties', 'dependebleProps'));
    }

    /**
     * Product list with discount
     */
    public function discount(Request $request)
    {
        $category = Page::where('alias', 'shop')->first();
        $this->_ifExists($category);
        $filterSubprods = [];
        setcookie('subprods', serialize($filterSubprods), time() + 10000000, '/');

        $seoData = $this->_getSeoFromPage($category);

        // get products with discount
        $products = Product::where('discount', '>', '0')->orderBy('discount_update', 'desc')->paginate(16);

        if ($request->ajax()) {
            $lastItem = "false";
            $url = $products->nextPageUrl();
            $last = $products->lastPage();
            $current = $products->currentPage();

            if (intval($last) == intval($current)) {
                $lastItem = 'true';
            }

           $view = view('front.loadMore.prodcutListsOutlet', compact('products', 'url'))->render();

           return json_encode(['html' => $view, 'url' => $url, 'last' => $lastItem]);
        }
        return view('front.products.outlet', compact('seoData', 'category', 'products'));
    }

    public function arrival(Request $request)
    {
        $category = Page::where('alias', 'shop')->first();
        $this->_ifExists($category);
        $filterSubprods = [];
        setcookie('subprods', serialize($filterSubprods), time() + 10000000, '/');

        $seoData = $this->_getSeoFromPage($category);

        // get products with discount
        // $products = Product::where('created_at',  '>=',  date('Y-m-d', strtotime('-15 days')))->paginate(16);
        $products = Product::orderBy('created_at', 'asc')->paginate(16);

        if ($request->ajax()) {
            $lastItem = "false";
            $url = $products->nextPageUrl();
            $last = $products->lastPage();
            $current = $products->currentPage();

            if (intval($last) == intval($current)) {
                $lastItem = 'true';
            }

           $view = view('front.loadMore.prodcutListsArival', compact('products', 'url'))->render();

           return json_encode(['html' => $view, 'url' => $url, 'last' => $lastItem]);
        }

        return view('front.products.arrival', compact('seoData', 'category', 'products'));
    }

    /**
     *  ajax response, get subproduct on single product page
     */
    public function getSubproduct(Request $request)
    {
        if (@$_COOKIE['subprods']) {
            $filter = unserialize(@$_COOKIE['subprods']);
                if ($request->get('value') != $filter[$request->get('key')]['valueId']) {
                    $filter[$request->get('key')] = [
                        'productId' => $request->get('productId'),
                        'valueId' => $request->get('value'),
                        'propertyId' => $request->get('name'),
                    ];

                }else{
                    $filter[$request->get('key')] = [ 'productId' => 0, 'valueId' => 0, 'propertyId' => 0 ];
                }

            setcookie('subprods', serialize($filter), time() + 10000000, '/');
        }

        if (count($filter) > 0) {
            $combinations =  SubproductCombination::where('case_1', $filter[0]['valueId'])
                                                ->where('case_2', $filter[1]['valueId'])
                                                ->where('case_3', $filter[2]['valueId'])
                                                ->pluck('id')->toArray();

            $subproduct = SubProduct::where('product_id', $request->get('productId'))->whereIn('combination_id', $combinations)->where('active', 1)->where('stock', '>', 0)->first();
            $product = Product::where('id', $request->get('productId'))->first();

            if (count($combinations) == 0) {
                $subproduct = $product;
            }

            $keyProp= $request->get('key');
            $currentProp = $request->get('name');
            $currentVal = $request->get('value');

            $dependebleProps = SubProductProperty::where('product_category_id', $product->category_id)->where('status', 'dependable')->where('show_property', 1)->get();
            $images = ProductImage::where('product_id', $product->id)->get();

            $data = view('front.products.subproduct', compact('product', 'subproduct', 'dependebleProps', 'images', 'filter', 'keyProp', 'currentProp', 'currentVal'))->render();
            return json_encode($data);
        }
    }

    /**
     *  ajax response, get subproduct on category page
     */
    public function subproductListSingle(Request $request)
    {
        $subproduct = Subproduct::where('product_id', $request->get('productId'))
                                ->whereRaw('json_contains(combination, \'{"'.$request->get('name').'": '.$request->get('value').'}\')')
                                // ->where('active', 1)
                                // ->where('stock', '>', 0)
                                ->first();

        if (!is_null($subproduct)) {
            $product = Product::find($request->get('productId'));
            $set = Set::find($request->get('set'));

            if (@$_COOKIE['subprods']) {
                $filter = unserialize(@$_COOKIE['subprods']);
                $filter[$request->get('set')][$request->get('productId')] = [
                    'productId' => $request->get('productId'),
                    'valueId' => $request->get('value'),
                    'propertyId' => $request->get('name'),
                    'subproductId' => $subproduct->id,
                ];

                setcookie('subprods', serialize($filter), time() + 10000000, '/');
            }

            $product = Product::find($request->get('productId'));

            $data['productsSet'] = '';
            if ($request->get('set')) {
                $data['productsSet'] = view('front.collections.productsSet', compact('filter', 'set', 'product'))->render();
            }

            $data['productCategory'] = view('front.products.subproduct', compact('filter', 'product', 'subproduct'))->render();
            $data['singleProductPage'] = view('front.products.subproductSingle', compact('filter', 'product', 'subproduct'))->render();

            return json_encode($data);
        }
        return false;

        // $set = Set::find($request->get('setId'));
        // if (count($combinations) == 0) {
        //     $data = view('front.collections.productBlock', compact('product', 'set', 'dependebleProps', 'images', 'filter', 'keyProp', 'currentProp', 'currentVal', 'userfields', 'userdata', 'countries', 'regions', 'cities'))->render();
        //     return json_encode($data);
        // }

    }

    public function getSubproductList(Request $request)
    {
        $subproduct = Subproduct::where('product_id', $request->get('productId'))
                                ->whereRaw('json_contains(combination, \'{"'.$request->get('name').'": '.$request->get('value').'}\')')
                                // ->where('active', 1)
                                // ->where('stock', '>', 0)
                                ->first();

        if (!is_null($subproduct)) {
            $product = Product::find($request->get('productId'));
            $set = Set::find($request->get('set'));
            if (@$_COOKIE['subprods']) {
                $filter = unserialize(@$_COOKIE['subprods']);
                $filter[$request->get('set')][$request->get('productId')] = [
                    'productId' => $request->get('productId'),
                    'valueId' => $request->get('value'),
                    'propertyId' => $request->get('name'),
                    'subproductId' => $subproduct->id,
                ];

                setcookie('subprods', serialize($filter), time() + 10000000, '/');
            }

            $data = view('front.collections.productsSetList', compact('filter', 'set'))->render();
            return json_encode($data);
        }
        return false;
    }


    public function getSubproductListWishList(Request $request)
    {
        if (@$_COOKIE['subprods']) {
            $filter = unserialize(@$_COOKIE['subprods']);
                $filter[$request->get('productId').$request->get('key')] = [
                    'productId' => $request->get('productId'),
                    'valueId' => $request->get('value'),
                    'propertyId' => $request->get('name'),
                ];

            setcookie('subprods', serialize($filter), time() + 10000000, '/');
        }

        if (count($filter) > 0) {
            $combinations =  SubproductCombination::where('case_1', @$filter[$request->get('productId').'0']['valueId'] ?? 0)
                                                ->where('case_2', @$filter[$request->get('productId').'1']['valueId'] ?? 0)
                                                ->where('case_3', @$filter[$request->get('productId').'2']['valueId'] ?? 0)
                                                ->pluck('id')->toArray();

            $subproduct = SubProduct::where('product_id', $request->get('productId'))
                                    ->whereIn('combination_id', $combinations)
                                    ->where('active', 1)
                                    ->first();

            $product = Product::where('id', $request->get('productId'))->first();

            $keyProp= $request->get('key');
            $currentProp = $request->get('name');
            $currentVal = $request->get('value');

            $dependebleProps = SubProductProperty::where('product_category_id', $product->category_id)->where('status', 'dependable')->where('show_property', 1)->get();
            $images = ProductImage::where('product_id', $product->id)->get();

            if (count($combinations) == 0) {
                $data = view('front.inc.wishListProducts', compact('product', 'dependebleProps', 'images', 'filter', 'keyProp', 'currentProp', 'currentVal'))->render();
                return json_encode($data);
            }

            $data = view('front.inc.wishListSubproducts', compact('product', 'subproduct', 'dependebleProps', 'images', 'filter', 'keyProp', 'currentProp', 'currentVal'))->render();
            return json_encode($data);
        }
    }

}

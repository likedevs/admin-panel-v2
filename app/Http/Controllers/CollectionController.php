<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lang;
use App\Models\Product;
use App\Models\Collection;
use App\Models\Set;


class CollectionController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Subcategory page, second level
     */
    public function getProductsCategoriesSubcategories(Request $request, $slug, $subcategory)
    {
        $category = ProductCategory::where('alias', $slug)->first();
        $this->_ifExists($category);

        $subcategory = ProductCategory::where('alias', $subcategory)->where('parent_id', $category->id)->first();
        $this->_ifExists($subcategory);

        $subcategories  = ProductCategory::where('parent_id', $subcategory->id)->get();
        $products = Product::where('category_id', $subcategory->id)->get();
        $seoData = $this->_getSeo($category);

        return view('front.collections.subcategoriesList', compact('seoData', 'filter', 'category', 'subcategory', 'subcategories', 'products', 'properties', 'dependebleProps'));
    }

    /**
     * Category page, first level
     */
    public function getProductsCategories(Request $request, $slug)
    {
        // dd($slug);
        $collection = Collection::where('alias', $slug)->first();
        // dd($collection);
        $seoData  = $this->_getSeo($collection);
        $subproducts = [];

        setcookie('subprods', serialize($subproducts), time() + 10000000, '/');
        return view('front.collections.collectionList', compact('collection', 'seoData'));
    }

    // get SEO data for a page
    private function _getSeo($page){
        if (!is_null($page->translation($this->lang->id)->first())) {
            $seo['seo_title'] = $page->translation($this->lang->id)->first()->seo_title ?? $page->translation($this->lang->id)->first()->name ;
            $seo['seo_keywords'] = $page->translation($this->lang->id)->first()->seo_keywords ?? $page->translation($this->lang->id)->first()->name ;
            $seo['seo_description'] = $page->translation($this->lang->id)->first()->seo_description ?? $page->translation($this->lang->id)->first()->name ;
        }else{
            $seo['seo_title'] = 'Julia Allert Title';
            $seo['seo_keywords'] = 'Julia Allert Descrition';
            $seo['seo_description'] = 'Julia Allert Keywords';
        }


        return $seo;
    }

    private function _ifExists($object){
        if (is_null($object)) {
            return redirect()->route('404');
        }
    }

    public function getSet($collection, $set)
    {
        $set = Set::where('alias', $set)->first();

        $subproducts = [];
        setcookie('subprods', serialize($subproducts), time() + 10000000, '/');

        $collection = Collection::find($set->collection_id);

        $similarSets = Set::where('collection_id', $collection->id)->where('id', '!=', $set->id)->where('active', 1)->get();

        $seoData = $this->_getSeo($set);

        return view('front.collections.set', compact('seoData', 'set', 'similarSets'));
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lang;
use App\Models\Product;
use App\Models\Brand;


class BrandsController extends Controller
{
    public function index() {

    }

    public function getBrands($slug, $subcategory, $productSlug)
    {
        $category = Brand::where('alias', $slug)->first();
        if (is_null($category)) {
            return redirect()->route('404');
        }

        $subcategory = Brand::where('alias', $subcategory)->where('parent_id', $brand->id)->first();
        if (is_null($subcategory)) {
            return redirect()->route('404');
        }

        $product = Product::where('alias', $productSlug)->first();
        if (is_null($product)) {
            return redirect()->route('404');
        }

        if (view()->exists('front/products/product')) {
            $products = Product::where('category_id', $subcategory->id)->get();
            $sucbategories = Brand::where('parent_id', $subcategory->id)->get();
            $seoData = $this->getSeo($category);
            return view('front.products.product', compact('seoData', 'category', 'subcategory', 'subcategories', 'product', 'products'));
        }else{
            echo "view for ". $category->translationByLanguage($this->lang->id)->first()->name ." is not found";
        }
    }

    public function getBrandsCategoriesSubcategories(Request $request, $slug, $subcategory)
    {
        $limit = $request->get('limit') ?? 12;
        $brand = Brand::where('alias', $slug)->first();
        if (is_null($brand)) {
            return redirect()->route('404');
        }

        $subcategory = Brand::where('alias', $subcategory)->where('parent_id', $brand->id)->first();
        if (is_null($subcategory)) {
            return redirect()->route('404');
        }

        if (view()->exists('front/brands/subcategoriesList')) {
            $products = Product::where('brand_id', $subcategory->id)->limit(12)->get();
            $sucbategories = Brand::where('parent_id', $subcategory->id)->get();
            $seoData = $this->getSeo($brand);
            return view('front.brands.subcategoriesList', compact('seoData', 'brand', 'subcategory', 'subcategories', 'products'));
        }else{
            echo "view for ". $category->translationByLanguage($this->lang->id)->first()->name ." is not found";
        }
    }

    public function getBrandsCategories($slug)
    {
        $brand = Brand::where('alias', $slug)->first();
        if (is_null($brand)) {
            return redirect()->route('404');
        }

        $subcategories = Brand::where('parent_id', $brand->id)->pluck('id');

        if (view()->exists('front/brands/categoriesList')) {
            $products = Product::where('brand_id', $brand->id)->orWhereIn('brand_id', $subcategories)->get();
            $subcategories = Brand::where('parent_id', $brand->id)->get();
            $seoData = $this->getSeo($brand);
            return view('front.brands.categoriesList', compact('seoData', 'brand', 'subcategories', 'products'));
        }else{
            echo "view for ". $category->translationByLanguage($this->lang->id)->first()->name ." is not found";
        }
    }

    // get SEO data for a page
    private function getSeo($page){
        $seo['seo_title'] = $page->translationByLanguage($this->lang->id)->first()->meta_title;
        $seo['seo_keywords'] = $page->translationByLanguage($this->lang->id)->first()->meta_keywords;
        $seo['seo_description'] = $page->translationByLanguage($this->lang->id)->first()->meta_description;

        return $seo;
    }

}

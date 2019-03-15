<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lang;
use App\Models\Product;
use App\Models\Solution;


class SolutionsController extends Controller
{

    public function getSolutionssCategory($slug)
    {
        $solution = Solution::where('alias', $slug)->first();
        if (is_null($solution)) {
            return redirect()->route('404');
        }

        if (view()->exists('front/solutions/categoriesList')) {
            $products = Product::where('solution_id', $solution->id)->get();
            $seoData = $this->getSeo($solution);
            return view('front.solutions.categoriesList', compact('seoData', 'solution', 'products'));
        }else{
            echo "view for ". $solution->translationByLanguage($this->lang->id)->first()->name ." is not found";
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

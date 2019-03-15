<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Set;
use App\Models\Promocode;
use App\Models\UserField;

class PagesController extends Controller
{
    public function index()
    {
        $page = Page::where('alias', 'home')->with('translation')->first();

        if (is_null($page)) {
            return redirect()->route('404');
        }
        
        $seoData = $this->getSeo($page);

        return view('front.home', compact('seoData', 'page', 'sets'));
    }

    public function getPages($slug)
    {
        $page = Page::where('alias', $slug)->first();
        if (is_null($page)) {
            return redirect()->route('404');
        }

        if (view()->exists('front/pages/'.$slug)) {
            $seoData = $this->getSeo($page);
            return view('front.pages.'.$slug, compact('seoData', 'page'));
        }else{
            $seoData = $this->getSeo($page);
            return view('front.pages.default', compact('seoData', 'page'));
        }
    }

    // get SEO data for a page
    private function getSeo($page){
        $seo['seo_title'] = $page->translation($this->lang->id)->first()->meta_title ?? $page->translation($this->lang->id)->first()->title;
        $seo['seo_keywords'] = $page->translation($this->lang->id)->first()->meta_keywords ?? $page->translation($this->lang->id)->first()->title;
        $seo['seo_description'] = $page->translation($this->lang->id)->first()->meta_description ?? $page->translation($this->lang->id)->first()->title;

        return $seo;
    }

    public function get404()
    {
        return view('front.404');
    }

    public function wellcome()
    {
        $userfields = UserField::where('in_register', 1)->get();

        return view('front.pages.wellcome', compact('userfields'));
    }

    public function getPromocode($promocodeId) {
        // dd($promocodeId);
      $promocode = Promocode::find($promocodeId);

      if(count($promocode) > 0) {
          session(['promocode' => $promocode]);
          return redirect()->route('home');
      }
  }

}

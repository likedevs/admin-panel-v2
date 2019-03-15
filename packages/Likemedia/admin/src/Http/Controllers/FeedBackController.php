<?php

namespace Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use App\Models\FeedBack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedBackController extends Controller
{
    public function index()
    {
        $feedbacks = FeedBack::get();
        $feedbacksNew = FeedBack::where('status', 'new')->get();
        $feedbacksProcesed = FeedBack::where('status', 'procesed')->get();
        $feedbacksCloose = FeedBack::where('status', 'cloose')->get();

        return view('admin::admin.feedBack.index', compact('feedbacks', 'feedbacksNew', 'feedbacksProcesed', 'feedbacksCloose'));
    }

    public function create()
    {
        $galleries = Gallery::get();

        return view('admin::admin.pages.create', compact('galleries'));
    }

    public function store(Request $request)
    {
        $toValidate = [];
        foreach ($this->langs as $lang){
            $toValidate['title_'.$lang->lang] = 'required|max:255';
            $toValidate['slug_'.$lang->lang] = 'required|unique:pages_translation,slug|max:255';
        }

        $validator = $this->validate($request, $toValidate);

        $page = new Page();
        $page->alias = request('alias');
        $page->active = 1;
        $page->position = 1;
        $page->gallery_id = request('gallery_id');
        $page->save();

        foreach ($this->langs as $lang):
            $page->translations()->create([
                'lang_id' => $lang->id,
                'slug' => request('slug_' . $lang->lang),
                'title' => request('title_' . $lang->lang),
                'body' => request('body_' . $lang->lang),
                'image' => 'tmp',
                'meta_title' => request('meta_title_' . $lang->lang),
                'meta_keywords' => request('meta_keywords_' . $lang->lang),
                'meta_description' => request('meta_description_' . $lang->lang)
            ]);
        endforeach;

        Session::flash('message', 'New item has been created!');

        return redirect()->route('pages.index');
    }

    public function edit($id)
    {
        $feedBack = FeedBack::findOrFail($id);
        if ($feedBack->status == 'new') {
            $feedBack->status = 'procesed';
            $feedBack->save();
        }

        return view('admin::admin.feedBack.edit', compact('feedBack'));
    }

    public function update(Request $request, $id)
    {
        $toValidate['first_name'] = 'required|max:255';
        $toValidate['second_name'] = 'required|max:255';
        $toValidate['email'] = 'required|max:255|email';

        $validator = $this->validate($request, $toValidate);

        $feedback = FeedBack::findOrFail($id);
        $feedback->first_name = request('first_name');
        $feedback->second_name = request('second_name');
        $feedback->email = request('email');
        $feedback->phone = request('phone');
        $feedback->subject = request('subject');
        $feedback->message = request('message');
        $feedback->additional_1 = request('additional_1');
        $feedback->additional_2 = request('additional_2');
        $feedback->additional_3 = request('additional_3');

        $feedback->save();

        return redirect()->back();
    }

    public function changeStatus($id, $status)
    {
        $feedback = FeedBack::findOrFail($id);
        $feedback->status = $status;
        $feedback->save();

        return redirect()->back();
    }


    public function destroy($id)
    {
        $page = Page::findOrFail($id);

        if (file_exists('/images/pages' . $page->image)) {
            unlink('/images/pages' . $page->image);
        }

        $page->delete();
        $page->translations()->delete();

        session()->flash('message', 'Item has been deleted!');

        return redirect()->route('pages.index');
    }


}

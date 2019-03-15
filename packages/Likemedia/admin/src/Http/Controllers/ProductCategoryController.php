<?php

namespace Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\ProductCategory;
use App\Models\ProductCategoryTranslate;
use App\Models\Product;
use App\Models\PropertyGroup;
use App\Models\PropertyCategory;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $menus = ProductCategory::where('level', 1)->orderBy('position', 'desc')->get();
        $categories = ProductCategory::with('translation')->get();
        $general = json_decode(file_get_contents(storage_path('globalsettings.json')), true)['changeCategory'];

        return view('admin::admin.productCategories.index', compact('menus', 'categories', 'general'));
    }

    public function create()
    {
        $menus = ProductCategory::with('translation')->get();

        return view('admin::admin.menus.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $toValidate['alias'] =  'required|unique:product_categories_,alias|max:255';

        foreach ($this->langs as $lang){
            // $toValidate['name_'.$lang->lang] = 'required|max:255';
        }

        $validator = $this->validate($request, $toValidate);

        $productCategory = new ProductCategory();

        $productCategory->parent_id = $request->parent_id;
        $productCategory->alias = $request->alias;
        $productCategory->save();

        foreach ($this->langs as $lang):
            $menu->translations()->create([
                'lang_id' => $lang->id,
                'name' => request('name_' . $lang->lang),
            ]);
        endforeach;

        session()->flash('message', 'New item has been created!');

        return redirect()->back();
    }

    public function edit($id)
    {
        $menuItem = ProductCategory::with('translations')->findOrFail($id);
        $pages = Product::with('translation')->get();
        $groups = PropertyGroup::get();

        return view('admin::admin.productCategories.edit', compact('menuItem', 'pages', 'groups'));
    }

    public function update(Request $request, $id)
    {
        $productCategory = ProductCategory::findOrFail($id);
        $on_home    = 0;
        $active     = 0;
        $name_image = $request->get('old_image') ?? null;
        $name_image_mob = $request->get('old_image_mob') ?? null;

        if ($request->get('on_home') == 'on') {
            $on_home = 1;
        }

        if ($request->get('active') == 'on') {
            $active = 1;
        }

        if($file = $request->file('image')){
            $uniqueId = uniqid();
            $name_image = $uniqueId.$file->getClientOriginalName();
            $image_resize = Image::make($file->getRealPath());
            $product_image_size = json_decode(file_get_contents(storage_path('globalsettings.json')), true)['crop']['product'];

            $image_resize->save(public_path('images/categories/og/' .$name_image), 75);
            $image_resize->resize(672, 480)->save('images/categories/sm/' .$name_image, 85);

            if ($productCategory->image) {
                @unlink(public_path('images/categories/og/'.$productCategory->image));
                @unlink(public_path('images/categories/sm/'.$productCategory->image));
            }
        }

        if($file = $request->file('image_mob')){
            $uniqueId = uniqid();
            $name_image_mob = $uniqueId.$file->getClientOriginalName();
            $image_resize = Image::make($file->getRealPath());
            $product_image_size = json_decode(file_get_contents(storage_path('globalsettings.json')), true)['crop']['product'];

            $image_resize->save(public_path('images/categories/og/' .$name_image_mob), 75);
            $image_resize->resize(672, 480)->save('images/categories/sm/' .$name_image_mob, 85);

            if ($productCategory->image_mob) {
                @unlink(public_path('images/categories/og/'.$productCategory->image_mob));
                @unlink(public_path('images/categories/sm/'.$productCategory->image_mob));
            }
        }

        $productCategory->on_home = $on_home;
        $productCategory->active = $active;
        $productCategory->image = $name_image;
        $productCategory->image_mob = $name_image_mob;
        $productCategory->alias = request('alias');
        $productCategory->save();

        foreach ($this->langs as $lang):
            $productCategory->translations()->where('product_category_id', $id)->where('lang_id', $lang->id)->update([
                'name' => request('name_' . $lang->lang),
                'description' => request('description_' . $lang->lang),
                'seo_text' => request('seo_text_' . $lang->lang),
                'seo_title' => request('seo_title_' . $lang->lang),
                'seo_description' => request('seo_description_' . $lang->lang),
                'seo_keywords' => request('seo_keywords_' . $lang->lang),
            ]);
        endforeach;

        $properties = request('properties');
        $allItems = [];

        if (!empty($properties)) {
            foreach ($properties as $key => $property) {
                $allItems[] = $property;
                $productProperty = PropertyCategory::where('property_id', $property)->where('category_id', $id)->first();

                if (!is_null($productProperty)) {
                    PropertyCategory::where('id', $productProperty->id)->update([
                        'property_id' => $property,
                        'category_id' => $id
                    ]);
                }else{
                    PropertyCategory::create([
                        'property_id' => $property,
                        'category_id' => $id
                    ]);
                }
            }
        }

        PropertyCategory::where('category_id', $id)->whereNotIn('property_id', $allItems)->delete();

        session()->flash('message', 'New item has been created!');

        return redirect()->back();

    }

    public function destroy(Request $request, $id)
    {
        if($id == 0){
            $id = $request->parent_id;
            $pproducts = Product::where('category_id', $id)->get();

            $addToId = $request->add;
            if (!empty($pproducts)) {
                if ($addToId != 0) {
                    if (!empty($pproducts)) {
                        foreach ($pproducts as $key => $pproduct) {
                            Product::where('id', $pproduct->id)->update([
                                'category_id' => $addToId,
                            ]);
                        }
                    }
                }else{
                    foreach ($pproducts as $key => $pproduct) {
                        Product::where('id', $pproduct->id)->delete();
                    }
                }
            }
        }

        $menu = ProductCategory::findOrFail($id);

        if ($request->get('with_children') == 'on') {
          // level 1
          if (!is_null($menu)) {
              $parent = $this->deleteOneMenuItem($menu, (int)$id);
              // level 2
              $submenus1 = ProductCategory::where('parent_id', $id)->get();
              if (!empty($submenus1)) {
                  foreach ($submenus1 as $submenu1) {
                      $parent = $this->deleteOneMenuItem($submenu1, $parent);
                      // level 3
                      $submenus2 = ProductCategory::where('parent_id', $submenu1->id)->get();
                      if (!empty($submenus2)) {
                          foreach ($submenus2 as $key => $submenus2->id) {
                              $parent = $this->deleteOneMenuItem($submenu2, $parent);
                              // level 3
                              $submenus3 = ProductCategory::where('parent_id', $submenu2->id)->get();
                              if (!empty($submenus3)) {
                                  foreach ($submenus3 as $key => $submenus3) {
                                      $parent = $this->deleteOneMenuItem($submenu3, $parent);
                                      // level 4
                                      $submenus = ProductCategory::where('parent_id', $submenu->id)->get();
                                      if (!empty($submenus)) {
                                          foreach ($submenus as $key => $submenus) {
                                              $parent = $this->deleteOneMenuItem($submenu, $parent);
                                          }
                                      }
                                  }
                              }
                          }
                      }
                  }
              }
          }

        }

        $menu->delete();
        $menu->translations()->delete();

        return redirect()->back();
    }


    public function deleteOneMenuItem($menu, $id)
    {
        $menu = ProductCategory::findOrFail($id);
        $menu->delete();
        $menu->translations()->delete();
        return $menu;
    }

    public function partialSave(Request $request)
    {
        $toValidate['alias'] = 'required|max:255|unique:product_categories,alias';

        foreach ($this->langs as $lang){
            $toValidate['name_'.$lang->lang] = 'required|max:255';
        }

        $validator = $this->validate($request, $toValidate);

        $category = new ProductCategory();
        $category->parent_id = $request->parent_id;
        $category->alias = $request->alias;
        $category->save();

        foreach ($this->langs as $lang):
            $category->translations()->create([
                'lang_id' => $lang->id,
                'name' => request('name_' . $lang->lang),
            ]);
        endforeach;

        session()->flash('message', 'New item has been created!');

        return redirect()->route('product-categories.index');
    }

    public function change()
    {
        $list = Input::get('list');
        $positon = 1;
        $response = true;
        $parentId = 0;
        $childId = 0;

        if (!empty($list)) {
            foreach ($list as $key => $value) {
                $positon++;
                ProductCategory::where('id', $value['id'])->update(['parent_id' => 0, 'position' => $positon]);
                if (array_key_exists('children', $value)) {
                    foreach ($value['children'] as $key1 => $value1) {
                        if (!checkProducts($value['id'])) {
                            $positon++;
                            ProductCategory::where('id', $value1['id'])->update(['parent_id' => $value['id'], 'position' => $positon]);
                        }else{
                            dd('vdz');
                            $response = false;
                            $parentId = $value['id'];
                            $childId = $value1['id'];
                        }
                        if (array_key_exists('children', $value1)) {
                            foreach ($value1['children'] as $key2 => $value2) {
                                if (!checkProducts($value1['id'])) {
                                    $positon++;
                                    ProductCategory::where('id', $value2['id'])->update(['parent_id' => $value1['id'], 'position' => $positon]);
                                }else{
                                    $response = false;
                                    $parentId = $value1['id'];
                                    $childId = $value2['id'];
                                }
                                if (array_key_exists('children', $value2)) {
                                    foreach ($value2['children'] as $key3 => $value3) {
                                        if (!checkProducts($value2['id'])) {
                                            $positon++;
                                            ProductCategory::where('id', $value3['id'])->update(['parent_id' => $value2['id'], 'position' => $positon]);
                                        }else{
                                            $response = false;
                                            $parentId = $value2['id'];
                                            $childId = $value3['id'];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return  json_encode (['text' => SelectProductCategoriesTree($this->lang->id, 0, $curr_id=null), 'message' => $response, 'parentId' =>  $parentId, 'childId' => $childId]);
    }

    public function movePosts(Request $request)
    {
        $category = new ProductCategory();
        $category->parent_id = $request->parent_id;
        $category->save();

        foreach ($this->langs as $lang):
            $category->translations()->create([
                'lang_id' => $lang->id,
                'name' => request('name_' . $lang->lang),
                'slug' => request('slug_' . $lang->lang),
            ]);
        endforeach;

        $posts = Product::where('category_id', $request->parent_id)->get();

        $addToId = $category->id;

        if ($request->add != 0) {
            $addToId = $request->add;
        }

        if (!empty($posts)) {
            foreach ($posts as $key => $post) {
                Product::where('id', $post->id)->update([
                    'category_id' => $addToId,
                ]);
            }
        }

        session()->flash('message', 'New item has been created!');

        return redirect()->route('product-categories.index');
    }

    private function uploadImg($file)
    {
        $uniqueId = uniqid();

        $name = $uniqueId.$file->getClientOriginalName();

        $image_resize = Image::make($file->getRealPath());

        $product_image_size = json_decode(file_get_contents(storage_path('globalsettings.json')), true)['crop']['product'];

        $image_resize->save(public_path('images/categories/og/' .$name), 75);

        $image_resize->resize($product_image_size[2]['smfrom'], $product_image_size[2]['smto'])->save('images/categories/sm/' .$name, 85);

        return $name;
    }
}

<?php

namespace Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AutoAlt;
use App\Models\ProductCategoryTranslation;
use App\Models\ProductCategory;
use App\Models\PropertyCategory;
use App\Models\ProductProperty;
use App\Models\Brand;
use App\Models\Set;
use App\Models\SetGallery;
use App\Models\Collection;
use App\Models\SetProducts;
use App\Models\Promotion;
use App\Models\Product;
use App\Models\PropertyValue;
use App\Models\PropertyValueTranslation;
use App\Models\ProductTranslation;
use App\Models\ProductImage;
use App\Models\ProductImageTranslation;
use App\Models\GalleryImageTranslation;
use App\Models\SubProductProperty;
use App\Models\PropertyMultiData;
use App\Models\SubproductCombination;
use App\Models\SubProduct;
use App\Models\Autometa;
use App\Models\AutoMetaCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Intervention\Image\ImageManagerStatic as Image;
use Excel;


class QuickUploadController extends Controller
{
    public function index(Request $request)
    {
        $allCategories = ProductCategory::pluck('parent_id')->toArray();
        $categories = ProductCategory::whereNotIn('id', $allCategories)->orderBy('position', 'asc')->get();
        $brands = Brand::get();
        $sets = Set::get();
        $collections = Collection::get();
        $promotions = Promotion::get();
        $products = Product::where('category_id', $request->get('category'))->orderBy('id', 'desc')->paginate(12);
        $properties = $this->getProperties($request->get('category'));
        $category = ProductCategory::find($request->get('category'));

        if ($request->ajax()) {
            $lastItem = "false";
            $url = $products->nextPageUrl();
            $last = $products->lastPage();
            $current = $products->currentPage();

            if (intval($last) == intval($current)) {
                $lastItem = 'true';
            }

            $view = view('admin::admin.quickUpload.productsMore', compact('products', 'sets', 'collections', 'categories', 'category', 'properties'))->render();
            $url = $products->nextPageUrl();
            return response()->json(['html'=>$view, 'url'=>$url, 'lastItem' => $lastItem]);
        }

        return view('admin::admin.quickUpload.index', compact('products', 'categories', 'category', 'brands', 'sets', 'collections', 'promotions', 'properties'));
    }

    public function saveProducts(Request $request)
    {
        $id     = json_decode($request->get('id'));
        $catId  = json_decode($request->get('catID'));
        $name   = json_decode($request->get('name'));
        $body   = json_decode($request->get('body'));
        $price  = json_decode($request->get('price'));
        $price_lei  = $request->get('price_lei');
        $brand  = json_decode($request->get('brand'));
        $promo  = json_decode($request->get('promo'));
        $code  = $request->get('code');
        $stock  = json_decode($request->get('stock'));
        $discount = json_decode($request->get('discount'));
        $video = $request->get('video');
        $props  = json_decode($request->get('props'));
        $propsText  = json_decode($request->get('propsText'));

        if (strlen(get_object_vars($name)[1]) > 0) {

        $product = Product::select('id')->where('id', $id)->first();

        if (!is_null($product)) {
            Product::where('id', $id)->update([
                        'price_lei' => strlen($price_lei) > 0 ? $price_lei : null,
                        'price' => strlen($price) > 0 ? $price : null,
                        'actual_price' => strlen($price) > 0 ? $price - ($price * $discount / 100) : null,
                        'actual_price_lei' => strlen($price_lei) > 0 ? $price_lei - ($price_lei * $discount / 100) : null,
                        'discount' => strlen($discount) > 0 ? $discount : null,
                        'code' => strlen($code) > 0 ? $code : null,
                        'stock' => strlen($stock) > 0 ? $stock : null,
                        'video' => $video,
                        'promotion_id' => $promo,
                    ]);

            $products = Product::select('id')->where('id', $id)->get();

            if (!empty($products)) {
                foreach ($products as $key => $product) {
                    foreach ($name as $langId => $value) {
                        ProductTranslation::where('product_id', $product->id)->where('lang_id', $langId)->update([
                            'name' => $name->$langId,
                            'body' => $body->$langId,
                        ]);
                    }
                }
            }

            $product = Product::where('id', $id)->first();
            SetProducts::where('product_id', $product->id)->delete();
            if (count(json_decode($request->get('set'))) > 0) {
                foreach (json_decode($request->get('set')) as $key => $set) {
                    SetProducts::create([
                        'set_id' => $set,
                        'product_id' => $product->id,
                    ]);
                }
            }


            if (count($product->subproducts()) > 0) {
                foreach ($product->subproducts()->get() as $key => $subproduct) {
                    $subproduct->update([
                        'price' => strlen($product->price) > 0 ? $product->price : $subproduct->price,
                        'price_lei' => strlen($product->price_lei) > 0 ? $product->price_lei : $subproduct->price_lei,
                        'actual_price' => strlen($product->actual_price) > 0 ? $product->actual_price : $subproduct->price - ($subproduct->price * $subproduct->discount / 100),
                        'actual_price_lei' => strlen($product->actual_price_lei) > 0 ? $product->actual_price_lei : $subproduct->price_lei - ($subproduct->price_lei * $subproduct->discount / 100),
                        'discount' => strlen($product->discount) > 0 ? $product->discount : $subproduct->discount,
                        'stock' => strlen($product->stock) > 0 ? $product->stock : $subproduct->stock,
                    ]);
                }
            }

            $this->saveProperties(get_object_vars($props), $id);
            $this->savePropertiesText(get_object_vars($propsText), $id);
        }else{
            $name = get_object_vars($name);
            $body = get_object_vars($body);

            $product = new Product();

            $product->category_id = $catId;
            $product->promotion_id = $promo;
            $product->alias = str_slug($name[1]);
            $product->price = $price ?? 0;
            $product->code = $code ?? 0;
            $product->stock = $stock ?? 0;
            $product->video = $video ?? 0;
            $product->discount = $discount ?? 0;
            $product->actual_price = $price ?? 0 - ($price ?? 0 * $discount ?? 0);

            $product->save();

            foreach ($this->langs as $lang):
                $product->translations()->create([
                    'lang_id' => $lang->id,
                    'name' => $name[$lang->id],
                    'body' => $body[$lang->id],
                    'alias' => str_slug($name[$lang->id]),
                ]);
            endforeach;

            $this->saveProperties(get_object_vars($props), $product->id);
            $this->savePropertiesText(get_object_vars($propsText), $product->id);

            $this->generateSubprodusesForProduct($product);

            // if (array_key_exists('subprod', $data)) {
            //     if ($data['subprod']) {
            //         foreach ($data['subprod'] as $key => $subprod) {
            //             $product->subproducts()->where('id', $key)->update([
            //                 // 'price' => @$subprod['price'],
            //                 // 'price_lei' => @$subprod['price_lei'],
            //                 // 'actual_price' => @$subprod['price'] - (@$subprod['price'] * @$subprod['discount'] / 100),
            //                 // 'actual_price_lei' => @$subprod['price_lei'] - (@$subprod['price_lei'] * @$subprod['discount'] / 100),
            //                 // 'discount' => @$subprod['discount'],
            //                 // 'stock' => @$subprod['stock'],
            //
            //                 'price' => strlen($product->price) > 0 ? $product->price : @$subprod['price'],
            //                 'price_lei' => strlen($product->price_lei) > 0 ? $product->price_lei : @$subprod['price_lei'],
            //                 'actual_price' => strlen($product->price) > 0 ? $product->price - ($product->price * $product->discount / 100) : @$subprod['price'] - (@$subprod['price'] * @$subprod['discount'] / 100),
            //                 'actual_price_lei' => strlen($product->price_lei) > 0 ? $product->price_lei - ($product->price_lei * $product->discout / 100) : @$subprod['price_lei'] - (@$subprod['price_lei'] * @$subprod['discount'] / 100),
            //                 'discount' => strlen($product->discount) > 0 ? $product->discount : @$subprod['discount'],
            //                 'stock' => strlen($product->stock) > 0 ? $product->stock : @$subprod['stock'],
            //             ]);
            //         }
            //     }
            // }
        }
    }else{
        return 'false';
    }
        $categories = ProductCategory::select('id')->get();
        $brands = Brand::select('id')->get();
        $sets = Set::select('id')->get();
        $collections = Collection::get();
        $promotions = Promotion::select('id')->get();
        $products = Product::where('category_id', $catId)->orderBy('id', 'desc')->paginate(12);
        $properties = $this->getProperties($catId);

        return view('admin::admin.quickUpload.toClone', compact('products', 'categories', 'brands', 'sets', 'collections', 'promotions', 'properties'))->render();
    }


    public function saveProperties($properties, $productId)
    {
        $propertyValues = PropertyValue::select('id')->where('product_id', $productId)->get();

        if (!empty($propertyValues)) {
            foreach ($propertyValues as $key => $propertyValue) {
                PropertyValue::where('id', $propertyValue->id)->delete();
                PropertyValueTranslation::where('property_values_id', $propertyValue->id)->delete();
            }
        }

        if (!empty($properties)) {
            foreach ($properties as $key => $property) {
                $propertyValues = PropertyValue::create([
                    'property_id' => $key,
                    'product_id' => $productId,
                    'value_id' => $property
                ]);

                if (is_array($property)) {
                    foreach ($property as $key => $value) {
                        if (is_array($value)) {
                            $items = [];
                            foreach ($value as $key => $checkboxItem) {
                                $items[] = $checkboxItem;
                            }
                            $value = json_encode($items);
                        }
                        PropertyValueTranslation::create([
                            'property_values_id' => $propertyValues->id,
                            'lang_id' => $key,
                            'value' => $value
                        ]);
                    }
                }else{
                    PropertyValueTranslation::create([
                        'property_values_id' => $propertyValues->id,
                        'lang_id' => 0,
                        'value' => $property
                    ]);
                }
            }
        }
    }

    public function savePropertiesText($properties, $productId)
    {
        $propsArr = [];
        if (count($properties) > 0) {
            foreach ($properties as $key => $property) {
                $arr = explode('|', $key);
                $propsArr[$arr[0]][$arr[1]] = $property;
            }
        }

        $properties = $propsArr;

        $propertyValues = PropertyValue::where('product_id', $productId)->whereIn('property_id', array_keys($properties))->get();

        if (!empty($propertyValues)) {
            foreach ($propertyValues as $key => $propertyValue) {
                PropertyValue::where('id', $propertyValue->id)->delete();
                PropertyValueTranslation::where('property_values_id', $propertyValue->id)->delete();
            }
        }

        if (!empty($properties)) {
            foreach ($properties as $key => $property) {
                $propertyValues = PropertyValue::create([
                    'property_id' => $key,
                    'product_id' => $productId,
                    'value_id' => 0
                ]);

                if (is_array($property)) {

                    foreach ($property as $key => $value) {
                        if (is_array($value)) {
                            $items = [];
                            foreach ($value as $key => $checkboxItem) {
                                $items[] = $checkboxItem;
                            }
                            $value = json_encode($items);
                        }
                        PropertyValueTranslation::create([
                            'property_values_id' => $propertyValues->id,
                            'lang_id' => $key,
                            'value' => $value
                        ]);
                    }
                }else{
                    $propertyValues = PropertyValue::create([
                        'property_id' => $key,
                        'product_id' => $productId,
                        'value_id' => $property
                    ]);

                    PropertyValueTranslation::create([
                        'property_values_id' => $propertyValues->id,
                        'lang_id' => 0,
                        'value' => $property
                    ]);
                }
            }
        }
    }

    public function getProperties($category_id)
    {
        $properties = [];
        $category = ProductCategory::select('id')->where('id', $category_id)->first();

        if (!is_null($category)) {
            $properties = array_merge($properties, $this->getPropertiesList($category->id));
            $category1 = ProductCategory::select('id')->where('id', $category->id)->first();
            if (!is_null($category1)) {
                $properties = array_merge($properties, $this->getPropertiesList($category1->id));
                $category2 = ProductCategory::select('id')->where('id', $category1->id)->first();
                if (!is_null($category2)) {
                    $properties = array_merge($properties, $this->getPropertiesList($category2->id));
                    $category3 = ProductCategory::select('id')->where('id', $category2->id)->first();
                    if (!is_null($category3)) {
                        $properties = array_merge($properties, $this->getPropertiesList($category3->id));
                    }
                }
            }
        }
        $properties = array_merge($properties, $this->getNoCategoryProperties());

        $properties = array_unique($properties);

        $ret = ProductProperty::with('translation'
                            ->with('multidata')
                            ->whereIn('id', $properties)
                            ->get();

        return $ret;
    }

    public function getPropertiesList($categoryId)
    {
        $propertiesArr = [];
        $properties = PropertyCategory::select('property_id')->where('category_id', $categoryId)->get();
        if (!empty($properties)) {
            foreach ($properties as $key => $property) {
                $propertiesArr[] = $property->property_id;
            }
        }

        return $propertiesArr;
    }

    public function getNoCategoryProperties()
    {
        $noCatGroup = 14;
        $propertiesArr = [];
        $properties = ProductProperty::select('id')->where('group_id', $noCatGroup)->get();
        if (!empty($properties)) {
            foreach ($properties as $key => $property) {
                $propertiesArr[] = $property->id;
            }
        }

        return $propertiesArr;
    }

    public function uploadFiles(Request $request)
    {
        $productItem = Product::where('id', $request->get('product_id'))->first();

        if (!is_null($productItem)) {

        $product = $request->get('product_id');

        if($files=$request->file('file')){
            foreach($files as $key => $file){
                $uniqueId = uniqid();
                $name = $uniqueId.$file->getClientOriginalName();

                $image_resize = Image::make($file->getRealPath());

                $product_image_size = json_decode(file_get_contents(storage_path('globalsettings.json')), true)['crop']['product'];

                $image_resize->save(public_path('images/products/og/' .$name), 75);

                $image_resize->resize($product_image_size[0]['bgfrom'], $product_image_size[0]['bgto'])->save(public_path('images/products/bg/' .$name), 75);

                $image_resize->resize($product_image_size[1]['mdfrom'], $product_image_size[1]['mdto'])->save(public_path('images/products/md/' .$name), 75);

                $image_resize->resize($product_image_size[2]['smfrom'], $product_image_size[2]['smto'])->save(public_path('images/products/sm/' .$name), 85);

                $images[] = $name;

                $image = ProductImage::create( [
                    'product_id' =>  $product,
                    'src' =>  $name,
                    'main' => 0,
                ]);

                foreach ($this->langs as $lang){
                  $category_id = Product::where('id', $product)->pluck('category_id');
                  $autoAlt = AutoAlt::where('cat_id', $category_id)->where('lang_id', $lang->id)->pluck('keywords')->toArray();

                  if(count($autoAlt) == 0) {
                    ProductImageTranslation::create( [
                        'product_image_id' => $image->id,
                        'lang_id' =>  $lang->id,
                        'alt' => $request->text[$lang->id][$key],
                        'title' => $request->text[$lang->id][$key],
                    ]);
                  }

                  if(count($autoAlt) > 0) {
                    if (count($autoAlt) == 1) {
                        ProductImageTranslation::create( [
                            'product_image_id' => $image->id,
                            'lang_id' =>  $lang->id,
                            'alt' => $autoAlt[0],
                            'title' => $autoAlt[0],
                        ]);
                    } else {
                      ProductImageTranslation::create( [
                          'product_image_id' => $image->id,
                          'lang_id' =>  $lang->id,
                          'alt' => $autoAlt[array_rand($autoAlt)],
                          'title' => $autoAlt[array_rand($autoAlt)],
                      ]);
                    }
                  }
                }
            }
        }

     }

     $product = $productItem;
     return view('admin::admin.quickUpload.imagesLiveUpdate', compact('product'))->render();

    }

    public function uploadSubproductFiles(Request $request)
    {
        $input = $request->all();
        $product = $request->get('id');
        $images=array();
        if($files = $request->file('subprod_image')){
            foreach($files as $key => $image){
                $imageName = time() . '-' . $image->getClientOriginalName();
                $image_resize = Image::make($image->getRealPath());

                $product_image_size = json_decode(file_get_contents(storage_path('globalsettings.json')), true)['crop']['product'];

                $image_resize->save(public_path('images/subproducts/og/' .$imageName), 75);

                $image_resize->resize($product_image_size[0]['bgfrom'], $product_image_size[0]['bgto'])->save('images/subproducts/bg/' .$imageName, 75);

                $image_resize->resize($product_image_size[1]['mdfrom'], $product_image_size[1]['mdto'])->save('images/subproducts/md/' .$imageName, 75);

                $image_resize->resize($product_image_size[2]['smfrom'], $product_image_size[2]['smto'])->save('images/subproducts/sm/' .$imageName, 85);

                $image = ProductImage::create( [
                    'product_id' =>  0,
                    'src' =>  $imageName,
                    'main' => 1,
                ]);

               SubProduct::where('product_id', $product)->where('combination', 'like', '%:' . $key . '%')->update([
                   'product_image_id' => $image->id,
               ]);

                foreach ($this->langs as $lang){
                    ProductImageTranslation::create( [
                        'product_image_id' => $image->id,
                        'lang_id' =>  $lang->id,
                        'alt' => $request->get('alt_')[$lang->id][$key],
                        'title' => $request->get('title_')[$lang->id][$key],
                    ]);
                    $category_id = Product::where('id', $product)->pluck('category_id');
                    // $autoAlt = AutoAlt::where('cat_id', $category_id)->pluck('keywords')->toArray();

                    // if(count($autoAlt) > 0) {
                    //   if (count($autoAlt) == 1) {
                    //       ProductImageTranslation::create( [
                    //           'product_image_id' => $image->id,
                    //           'lang_id' =>  $lang->id,
                    //           'alt' => $autoAlt[0],
                    //           'title' => $autoAlt[0],
                    //       ]);
                    //   } else {
                    //     ProductImageTranslation::create( [
                    //         'product_image_id' => $image->id,
                    //         'lang_id' =>  $lang->id,
                    //         'alt' => $autoAlt[array_rand($autoAlt)],
                    //         'title' => $autoAlt[array_rand($autoAlt)],
                    //     ]);
                    //   }
                    // } else {
                      ProductImageTranslation::create( [
                          'product_image_id' => $image->id,
                          'lang_id' =>  $lang->id,
                          'alt' => $request->text[$lang->id][$key],
                          'title' => $request->text[$lang->id][$key],
                      ]);
                    // }
                }
            }
        }

         // delete oldImages
         $subproductsImages = SubProduct::pluck('product_image_id')->toArray();
         $allImages = ProductImage::whereNotIn('id', $subproductsImages)->where('product_id', 0)->get();
         // if (count($allImages) > 0) {
         //     foreach ($allImages as $key => $image) {
         //         if (file_exists(public_path('images/subproducts/bg/'.$image->src))) {
         //             unlink(public_path('images/subproducts/bg/'.$image->src));
         //         }
         //         if (file_exists(public_path('images/subproducts/og/'.$image->src))) {
         //             unlink(public_path('images/subproducts/og/'.$image->src));
         //         }
         //         if (file_exists(public_path('images/subproducts/md/'.$image->src))) {
         //             unlink(public_path('images/subproducts/md/'.$image->src));
         //         }
         //         if (file_exists(public_path('images/subproducts/sm/'.$image->src))) {
         //             unlink(public_path('images/subproducts/sm/'.$image->src));
         //         }
         //         ProductImageTranslation::where('product_image_id', $image->id)->delete();
         //         ProductImage::where('id', $image->id)->delete();
         //     }
         // }

         $productItem = Product::where('id', $request->get('id'))->first();
         $category = ProductCategory::find($productItem->category_id);
         $product = $productItem;
         // dd($category);
         return view('admin::admin.quickUpload.imagesLiveSubproduct', compact('product', 'category'))->render();

    }

    public function downloadCSV(Excel $excel, $id)
    {
        $category = ProductCategory::where('id', $id)->first();

        if (!is_null($category)) {
            $filename = "categories.csv";
            $handle = fopen($filename, 'w+');
            fprintf($handle, "\xEF\xBB\xBF");

            // default fields
            $data = ['Сategorie/Категория', 'Сode', 'Title (en)', 'Title (ro)', 'Description (en)', 'Description (ro)', 'Price Euro', 'Price Lei', 'Discount', 'Stock', 'Video', 'Set'];
            $dataImage = ['Image-1 (name)', 'Image-2 (name)', 'Image-3 (name)', 'Image-4 (name)', 'Image-5 (name)'];

            $propertiesId = PropertyCategory::where('category_id', $category->id)->pluck('property_id')->toArray();
            $properties = ProductProperty::whereIn('id', $propertiesId)->get();

            if (count($properties) > 0) {
                foreach ($properties as $key => $property) {
                    if (($property->type == 'select') || ($property->type == 'checkbox')) {
                        array_push($data, $property->key.' ('. $property->id .') '.$property->translation()->first()->unit);
                    }else{
                        array_push($data, $property->key.' (en) ');
                        array_push($data, $property->key.' (ro)');
                    }
                }
            }

            $data = array_merge($data, $dataImage);

            $sets = Set::get();
            $setString = '';

            if (count($sets)) {
                foreach ($sets as $key => $set) {
                    $setString .= $set->translation()->first()->name.'( '.$set->id.' ), ';
                }
            }

            // default values
            $values = [$category->translation()->first()->name, 'string', 'стриг', 'стриг', 'стриг', 'стриг', 'int (euro)', 'int (lei)', 'int (%)', 'int', 'youtube video id', $setString ];

            if (count($properties) > 0) {
                foreach ($properties as $key => $property) {
                    if (($property->type == 'select') || ($property->type == 'checkbox')) {
                        $multidatas = $property->multidata;
                        if (count($multidatas) > 0) {
                            $ret = '';
                            foreach ($multidatas as $key => $multidata) {
                                $ret .= $multidata->translation()->first()->value.'( '.$multidata->id.' ), ';
                            }
                        }
                        array_push($values, $ret);
                    }else{
                        array_push($values, '');
                        array_push($values, '');
                    }
                }
            }

            $valueImage = ['/', '/', '/', '/', '/'];
            $values = array_merge($values, $valueImage);

            fputcsv($handle, $data, ';', '"');
            fputcsv($handle, $values, ';', '"');

            fclose($handle);

            $headers = array(
                "Content-type" => "text/csv;  charset=UTF-8",
                "Content-Disposition" => "attachment; filename=file.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );

            return response()->download($filename, 'categories.csv', $headers);
        }
    }

    public function uploadCSV(Request $request)
    {
        $handle = fopen($request->file('file')->getRealPath(), "r");
        $header = true;

        $category = ProductCategory::find($request->get('categoryId'));
        $propertiesId = PropertyCategory::where('category_id', $request->get('categoryId'))->pluck('property_id')->toArray();
        $properties = ProductProperty::whereIn('id', $propertiesId)->get();

        while ($row = fgetcsv($handle, 0, ",")) {
            if ($header) {
                $header = false;
            } else {

                $row = explode(';', $row[0]);
                if (count($row) > 15) {
                    // dd($row);

                    // $row = array_map("utf8_encode", $row); //added
                    // echo "<pre>";
                    // print_r ($row);
                    // echo $row[5];
                    // echo "<br>";

                    $product = new Product();
                    $product->category_id = $request->get('categoryId');
                    $product->alias = str_slug(mb_convert_encoding($row[2], 'utf8', 'cp1251'));
                    $product->stock = mb_convert_encoding($row[8], 'utf8', 'cp1251');
                    $product->price = mb_convert_encoding($row[6], 'utf8', 'cp1251');
                    $product->price_lei = mb_convert_encoding($row[7], 'utf8', 'cp1251');
                    $product->discount = mb_convert_encoding($row[8], 'utf8', 'cp1251');
                    $product->actual_price = mb_convert_encoding($row[6], 'utf8', 'cp1251') - (mb_convert_encoding($row[6], 'utf8', 'cp1251') * mb_convert_encoding($row[8], 'utf8', 'cp1251') / 100);
                    $product->actual_price_lei = mb_convert_encoding($row[7], 'utf8', 'cp1251') - (mb_convert_encoding($row[7], 'utf8', 'cp1251') * mb_convert_encoding($row[8], 'utf8', 'cp1251') / 100);
                    $product->code = mb_convert_encoding($row[1], 'utf8', 'cp1251');
                    $product->stock = mb_convert_encoding($row[9], 'utf8', 'cp1251');
                    $product->video = mb_convert_encoding($row[10], 'utf8', 'cp1251');
                    $product->save();

                    $setsArr = explode('#',mb_convert_encoding($row[11], 'utf8', 'cp1251'));
                    if (count($setsArr) > 0) {
                        foreach ($setsArr as $key => $value) {
                            SetProducts::create([
                                'set_id' => $value,
                                'product_id' => $product->id,
                            ]);
                        }
                    }

                    foreach ($this->langs as $lang):
                        if ($lang->id == 1) {
                            $product->translations()->create([
                                'lang_id' => $lang->id,
                                'name' => mb_convert_encoding($row[2], 'cp1251', 'utf8'),
                                'body' => mb_convert_encoding($row[4], 'utf8', 'cp1251'),
                                'alias' => str_slug(mb_convert_encoding($row[2], 'utf8', 'cp1251')),
                            ]);
                        }else{
                            $product->translations()->create([
                                'lang_id' => $lang->id,
                                'name' => $row[3],
                                'body' => $row[5],
                                'alias' => str_slug(mb_convert_encoding($row[3], 'utf8', 'cp1251')),
                            ]);
                        }
                    endforeach;

                    $isAutometas = AutoMetaCategory::join('autometas', 'autometa_categories.autometa_id', 'autometas.meta_id')
                                                  ->where('category_id', $request->category_id)
                                                  ->where('type', 2)
                                                  ->pluck('autometa_id');

                    $lang_arr = [];

                    if(count($isAutometas) > 0) {
                        foreach ($isAutometas as $isAutometa) {
                          $autometa = Autometa::where('meta_id', $isAutometa)->firstOrFail();
                          $productInfo = ProductTranslation::where('lang_id', $autometa->lang_id)->where('product_id', $product->id)->firstOrFail();

                          $prodName = $productInfo->name;
                          $catName = ProductCategoryTranslation::where('product_category_id', $request->category_id)->where('lang_id', $autometa->lang_id)->firstOrFail()->name;

                          $productInfo->description = $autometa->generateMeta($prodName, $catName, 'product_description');
                          $productInfo->seo_title = $autometa->generateMeta($prodName, $catName, 'title');
                          $productInfo->seo_description = $autometa->generateMeta($prodName, $catName, 'description');
                          $productInfo->seo_keywords = $autometa->generateMeta($prodName, $catName, 'keywords');
                          $productInfo->save();

                          foreach ($this->langs as $lang) {
                            if($lang->id == $autometa->lang_id) {
                              array_push($lang_arr, $lang->lang);
                            }
                          }

                      }
                  }

                    $i = 12;
                    if (count($properties) > 0) {
                        foreach ($properties as $key => $property) {

                            if (($property->type == 'select') || ($property->type == 'checkbox')) {
                                $arr = explode('#', $row[$i]);
                                // dd($arr);
                                if (is_array($arr)) {
                                    $property = PropertyValue::create([
                                        'product_id' => $product->id,
                                        'property_id' => $arr[0],
                                        'value_id' => $arr[1],
                                    ]);
                                    PropertyValueTranslation::create([
                                        'property_values_id' => $property->id,
                                        'lang_id' => 0,
                                        'value' => $arr[1],
                                    ]);
                                }
                                $i++;
                            }else{
                                $property = PropertyValue::create([
                                    'product_id' => $product->id,
                                    'property_id' => $property->id,
                                    'value_id' => 0,
                                ]);

                                foreach ($this->langs as $lang){
                                    if ($lang->id == 1) {
                                        PropertyValueTranslation::create([
                                            'property_values_id' => $property->id,
                                            'lang_id' => $lang->id,
                                            'value' => $row[$i],
                                        ]);
                                    }else {
                                        PropertyValueTranslation::create([
                                            'property_values_id' => $property->id,
                                            'lang_id' => $lang->id,
                                            'value' => $row[$i + 1],
                                        ]);
                                    }
                                }

                                $i = $i + 2;
                            }
                        }
                    }

                    for ($c=$i; $c < ($i+5) ; $c++) {
                        $image = ProductImage::create( [
                            'product_id' =>  $product->id,
                            'src' =>  str_replace('/', '', $category->alias.$row[$c]),
                            'main' => 0,
                        ]);

                        foreach ($this->langs as $lang){
                            ProductImageTranslation::create( [
                                'product_image_id' => $image->id,
                                'lang_id' =>  $lang->id,
                                'alt' => '',
                                'title' => '',
                            ]);
                        }
                    }
    }
            }
        }
        // dd('inv');

        fclose ($handle);

        $category = ProductCategory::find($request->categoryId);
        $this->generateSubproduses($category);

        return redirect()->back();
    }

    public function generateSubprodusesForProduct($product)
    {
        // if(count($category->products()->get()) > 0) {
            // SubproductCombination::where('category_id', $category->id)->delete();

            // foreach ($category->products()->get() as $product) {
              $category = ProductCategory::find($product->category_id);
              $subproducts = $product->subproducts()->get();

              // get properties only 3 cases
              $categoryProperties = SubProductProperty::where('product_category_id', $category->id)
                                                    ->where('status', 'dependable')
                                                    ->where('show_property', 1)
                                                    ->limit(3)
                                                    ->get();

              if (count($categoryProperties) > 0) {
                  foreach ($categoryProperties as $key => $categoryProperty) {
                      $propCase[$key] = $categoryProperty->property_id;
                  }
              }

                $x = 'A';
                $propValues_1 = PropertyMultiData::where('property_id', @$propCase[0])->get();
                if (count($propValues_1) > 0) {
                    foreach ($propValues_1 as $key => $propValue_1) {

                        $propValues_2 = PropertyMultiData::where('property_id', @$propCase[1])->get();
                        if (count($propValues_2) > 0) {
                            foreach ($propValues_2 as $key => $propValue_2) {

                                $propValues_3 = PropertyMultiData::where('property_id', @$propCase[2])->get();
                                if (count($propValues_3) > 0) {
                                    foreach ($propValues_3 as $key => $propValue_3) {
                                        $this->setCombinations($category, $propValue_1, $propValue_2, $propValue_3, $product, $x);
                                        $x++;
                                    }
                                }else{
                                    $this->setCombinations($category, $propValue_1, $propValue_2, 0, $product, $x);
                                    $x++;
                                }
                            }
                        }else{
                            $this->setCombinations($category, $propValue_1, 0, 0, $product, $x);
                            $x++;
                        }
                    }
                }

                $getCombinations = SubproductCombination::where('category_id', $category->id)->pluck('id')->toArray();
                $product->subproducts()->where('product_id', $product->id)->whereNotIn('combination_id', $getCombinations)->delete();
            // }
        // }
    }

    public function generateSubproduses($category)
    {
        if(count($category->products()->get()) > 0) {
            // SubproductCombination::where('category_id', $category->id)->delete();

            foreach ($category->products()->get() as $product) {
              $subproducts = $product->subproducts()->get();

              // get properties only 3 cases
              $categoryProperties = SubProductProperty::where('product_category_id', $category->id)
                                                    ->where('status', 'dependable')
                                                    ->where('show_property', 1)
                                                    ->limit(3)
                                                    ->get();

              if (count($categoryProperties) > 0) {
                  foreach ($categoryProperties as $key => $categoryProperty) {
                      $propCase[$key] = $categoryProperty->property_id;
                  }
              }

                $x = 'A';
                $propValues_1 = PropertyMultiData::where('property_id', @$propCase[0])->get();
                if (count($propValues_1) > 0) {
                    foreach ($propValues_1 as $key => $propValue_1) {

                        $propValues_2 = PropertyMultiData::where('property_id', @$propCase[1])->get();
                        if (count($propValues_2) > 0) {
                            foreach ($propValues_2 as $key => $propValue_2) {

                                $propValues_3 = PropertyMultiData::where('property_id', @$propCase[2])->get();
                                if (count($propValues_3) > 0) {
                                    foreach ($propValues_3 as $key => $propValue_3) {
                                        $this->setCombinations($category, $propValue_1, $propValue_2, $propValue_3, $product, $x);
                                        $x++;
                                    }
                                }else{
                                    $this->setCombinations($category, $propValue_1, $propValue_2, 0, $product, $x);
                                    $x++;
                                }
                            }
                        }else{
                            $this->setCombinations($category, $propValue_1, 0, 0, $product, $x);
                            $x++;
                        }
                    }
                }

                $getCombinations = SubproductCombination::where('category_id', $category->id)->pluck('id')->toArray();
                $product->subproducts()->where('product_id', $product->id)->whereNotIn('combination_id', $getCombinations)->delete();
            }
        }
    }

    private function setCombinations($category, $propValue_1, $propValue_2, $propValue_3, $product, $x)
    {
        // dd($propValue_2);
        $combination = SubproductCombination::create([
            'category_id' => $category->id,
            'case_1' => $propValue_1 ? $propValue_1->id : 0 ,
            'case_2' => $propValue_2 ? $propValue_2->id : 0 ,
            'case_3' => $propValue_3 ? $propValue_3->id : 0 ,
        ]);

        $subproduct = $product->subproducts()->where('product_id', $product->id)->where('code', $product->id.'-'.$x)->first();

        $combinationJSON = [
            $propValue_1 ? $propValue_1->property_id : 0 => $propValue_1 ? $propValue_1->id : 0,
            $propValue_2 ? $propValue_2->property_id : 0 => $propValue_2 ? $propValue_2->id : 0,
            $propValue_3 ? $propValue_3->property_id : 0 => $propValue_3 ? $propValue_3->id : 0,
        ];


        if (!is_null($subproduct)) {
            $subprod = $product->subproducts()->where('id', $subproduct->id)->update([
                'combination_id' => $combination->id,
                'combination' => json_encode($combinationJSON),
                'stock' => $product->stock,
                'price' => $product->price,
                'price_lei' => $product->price_lei,
                'actual_price' => $product->actual_price,
                'actual_price_lei' => $product->actual_price_lei,
                'discount' => $product->discount,
            ]);
        }else{
            $subprod = $product->subproducts()->create([
                'code' => $product->id.'-'.$x,
                'combination_id' => $combination->id,
                'combination' => json_encode($combinationJSON),
                'stock' => $product->stock,
                'price' => $product->price,
                'price_lei' => $product->price_lei,
                'actual_price' => $product->actual_price,
                'actual_price_lei' => $product->actual_price_lei,
                'discount' => $product->discount,
            ]);
        }
    }

    public function uploadImages(Request $request)
    {
        $input = $request->all();

        $category = ProductCategory::where('id', $request->categoryId)->first();
        $images=array();
        if($files=$request->file('images')){
            foreach($files as $key => $file){

                $uniqueId = $category->alias;

                $name = $uniqueId.$file->getClientOriginalName();

                $image_resize = Image::make($file->getRealPath());

                $product_image_size = json_decode(file_get_contents(storage_path('globalsettings.json')), true)['crop']['product'];

                $image_resize->save(public_path('images/products/og/' .$name), 75);

                $image_resize->resize($product_image_size[0]['bgfrom'], $product_image_size[0]['bgto'])->save('images/products/bg/' .$name, 75);

                $image_resize->resize($product_image_size[1]['mdfrom'], $product_image_size[1]['mdto'])->save('images/products/md/' .$name, 75);

                $image_resize->resize($product_image_size[2]['smfrom'], $product_image_size[2]['smto'])->save('images/products/sm/' .$name, 85);

                $images[] = $name;

            }
        }
        return redirect()->back();
    }

    public function uploadSubproducts(Request $request)
    {
        $product = Product::find($request->get('productId'));

        if (!is_null($product)) {
            $form = $request->get('form');
            $data = array();
            parse_str($form, $data);

            $product->subproducts()->update([ 'active' => 0,]);

            if (array_key_exists('subproduct_active', $data)) {
                if ($data['subproduct_active']) {
                    foreach ($data['subproduct_active'] as $key => $activeItem) {
                        $product->subproducts()->where('id', $activeItem)->update([
                            'active' => 1,
                        ]);
                    }
                }
            }

            if (array_key_exists('subprod', $data)) {
                if ($data['subprod']) {
                    foreach ($data['subprod'] as $key => $subprod) {
                        $product->subproducts()->where('id', $key)->update([
                            // 'price' => @$subprod['price'],
                            // 'price_lei' => @$subprod['price_lei'],
                            // 'actual_price' => @$subprod['price'] - (@$subprod['price'] * @$subprod['discount'] / 100),
                            // 'actual_price_lei' => @$subprod['price_lei'] - (@$subprod['price_lei'] * @$subprod['discount'] / 100),
                            // 'discount' => @$subprod['discount'],
                            // 'stock' => @$subprod['stock'],

                            'price' => strlen($product->price) > 0 ? $product->price : @$subprod['price'],
                            'price_lei' => strlen($product->price_lei) > 0 ? $product->price_lei : @$subprod['price_lei'],
                            'actual_price' => strlen($product->actual_price) > 0 ? $product->actual_price : @$subprod['price'] - (@$subprod['price'] * @$subprod['discount'] / 100),
                            'actual_price_lei' => strlen($product->actual_price_lei) > 0 ? $product->actual_price_lei : @$subprod['price_lei'] - (@$subprod['price_lei'] * @$subprod['discount'] / 100),
                            'discount' => strlen($product->discount) > 0 ? $product->discount : @$subprod['discount'],
                            'stock' => strlen($product->stock) > 0 ? $product->stock : @$subprod['stock'],
                        ]);
                    }
                }
            }
        }
    }

    public function updateSubproducts(Request $request)
    {
        $product = Product::find($request->get('productId'));

        return view('admin::admin.quickUpload.subproductsUpdate', compact('product'))->render();
    }

    public function upadteSetProduct(Request $request)
    {
        $productId = $request->get('productId');
        $data = array();
        parse_str($request->get('form'), $data);

        SetProducts::where('product_id', $productId)->delete();

        if (array_key_exists('set_id', $data)) {
            foreach ($data['set_id'] as $key => $set) {
                SetProducts::create([
                    'set_id' => $set,
                    'product_id' => $productId,
                ]);
            }
        }
    }

    public function upadteCollectionProduct(Request $request)
    {
        $productId = $request->get('productId');
        $data = array();
        parse_str($request->get('form'), $data);

        if (array_key_exists('collection_id', $data)) {

            $product = Product::find($productId);

            foreach ($data['collection_id'] as $key => $collectionId) {
                $set = new Set();
                $set->collection_id = $collectionId;
                $set->alias = $product->alias;
                $set->price = $product->price;
                $set->price_lei = $product->price_lei;
                $set->position = 0;
                $set->active = 1;
                $set->save();

                $set->code = 'Set-'.$set->id;
                $set->save();

                foreach ($this->langs as $lang):
                    $set->translations()->create([
                        'lang_id' => $lang->id,
                        'name' => $product->translation()->first()->name,
                    ]);
                endforeach;

                SetProducts::create([
                    'set_id' => $set->id,
                    'product_id' => $product->id,
                ]);

                $productImages = ProductImage::where('product_id', $product->id)->get();

                if (count($productImages) > 0) {
                    foreach ($productImages as $key => $productImage) {
                        SetGallery::create([
                            'set_id' => $set->id,
                            'type' => 'photo',
                            'src' => $productImage->src
                        ]);
                        $ogFile = copy(public_path('images/products/og/' .$productImage->src), public_path('images/sets/og/' .$productImage->src));
                        $bgFile = copy(public_path('images/products/bg/' .$productImage->src), public_path('images/sets/bg/' .$productImage->src));
                        $mdFile = copy(public_path('images/products/md/' .$productImage->src), public_path('images/sets/md/' .$productImage->src));
                        $smFile = copy(public_path('images/products/sm/' .$productImage->src), public_path('images/sets/sm/' .$productImage->src));
                    }
                }
            }
        }

    }

}

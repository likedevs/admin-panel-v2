@extends('admin::admin.app')
@include('admin::admin.nav-bar')
@section('content')

<nav aria-label="breadcrumb"></nav>

<div class="list-content">
<div class="row page-actions">
    <div class="col-md-7">
        <ul>
            <li>
                <form action="{{ url('/back/quick-upload') }}" method="GET">
                    <div class="col-md-1">
                        <label>Categorie</label>
                    </div>
                    <div class="col-md-4">
                        <input type="hidden" class="cat-id" value="{{ Request::get('category') }}">
                        <select name="category" class="form-control category-select">
                            <option value="0">---</option>
                            @if (count($categories) > 0)
                            @foreach($categories as $categoryItem)
                            <option {{ $categoryItem->id == Request::get('category') ? 'selected' : '' }} value="{{ $categoryItem->id }}">{{ $categoryItem->translation()->first()->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                <div class="col-md-1">
                    <input type="submit" class="btn btn-primary" data="redirect-cat" value=" Go">
                </div>
                <div class="col-md-3">
                    <a href="{{ url('back/quick-upload/download/'.Request::get('category')) }}" class="btn btn-primary"> Download CSV template</a>
                </div>
                </form>

                <form action="{{ url('back/quick-upload/upload') }}" method="post" enctype="multipart/form-data">
                    <div class="col-md-2">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="categoryId" value="{{ Request::get('category') }}">
                        <label for="">Upload CSV with products</label>
                        <input type="file" name="file">
                        {{-- <a href="{{ url('back/quick-upload/upload/'.Request::get('category')) }}" class="btn btn-primary">Upload CSV with products</a> --}}
                    </div>
                    <div class="col-md-1">
                        <input type="submit" class="btn btn-primary" data="redirect-cat" value=" Go">
                    </div>
                </form>
            </li>
        </ul>
    </div>
    <form action="{{ url('back/upload-files/upload-images') }}" method="post" enctype="multipart/form-data">
        <div class="col-md-1 text-right">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="categoryId" value="{{ Request::get('category') }}">
            <label for="">Choose images</label>
            <input type="file" name="images[]" multiple/>
        </div>
        <div class="col-md-1">
            <input type="submit" class="btn btn-primary" data="redirect-cat" value=" Go">
        </div>
    </form>

    <div class="col-md-3 text-right">
        <input type="button"  class="btn btn-primary save-upload"  value="Save & Add">
        <a href="{{ url('back/products/category/'.Request::get('category')) }}" class="btn btn-primary">Back</a>
    </div>
</div>
<hr>
<div class="card">
    <div class="card-block scrollX">
        <table class="table table-bordered centred ajax-response">
            <thead>
                <tr>
                    <th class="width-auto">#</th>
                    <th class="width-auto">Lang</th>
                    <th class="width-auto">Code</th>
                    <th>Titlu <small>*required</small> </th>
                    <th>Descriere</th>
                    <th class="width-auto">Pret EUR</th>
                    <th class="width-auto">Pret LEI</th>
                    <th class="width-auto">Discount</th>
                    <th class="width-auto">Stock</th>
                    <th>Video</th>
                    <th>Set</th>
                    @if (!empty($properties))
                    @foreach ($properties as $key => $property)
                        <th>{{ $property->translation->first()->name }}</th>
                    @endforeach
                    @endif
                    <th>Imagini</th>
                    <th>Subproduse</th>
                    <th>Imagini Subproduse</th>
                </tr>
            </thead>
            <tbody>
                <tbody class="item-row">
                    @foreach ($langs as $keyLang => $oneLang)
                    @if ($keyLang == 0)
                    <tr>
                        <td rowspan="2"  class="width-auto"><small><i>new</i></small></td>
                        <td  class="width-auto">{{ $oneLang->lang }}</td>
                        <td  rowspan="2" class="width-auto">
                            <input type="text" class="input-code" data-lang="{{ $oneLang->id }}" value="">
                        </td>
                        <td>
                            <input type="text" class="input-name" data-lang="{{ $oneLang->id }}" value="">
                        </td>
                        <td>
                            <input type="text" class="input-body" data-lang="{{ $oneLang->id }}" value="">
                        </td>
                        <td rowspan="2" class="width-auto">
                            <input type="number" class="input-price" value="">
                        </td>
                        <td rowspan="2" class="width-auto">
                            <input type="number" class="input-price_lei" value="">
                        </td>
                        <td rowspan="2" class="width-auto">
                            <input type="number" class="input-discount" value="">
                        </td>
                        <td rowspan="2" class="width-auto">
                            <input type="number" class="input-stock" value="">
                        </td>
                        <td rowspan="2" class="width-auto">
                            <input type="text" class="input-video" value="">
                        </td>
                        <td rowspan="2" class="width-auto">
                            {{-- <select name="input-set_id[]" class="form-control input-set_id" multiple>
                                <option value="0">---</option>
                                @if (!empty($sets)))
                                @foreach ($sets as $key => $set)
                                    <option value="{{ $set->id}}">{{ $set->translation($lang->id)->first()->name }}</option>
                                @endforeach
                                @endif
                            </select> --}}

                            {{-- <button type="button" class="btn btn-primary btn-sm"> <i class="fa fa-list"></i> Seturi/Collectii</button> --}}
                        </td>
                        @if (!empty($properties))
                        @foreach ($properties as $key => $property)
                            @if (($property->type == 'select') || ($property->type == 'checkbox'))
                                <td rowspan="2">
                                    <select name="prop[{{ $property->id }}]" class="form-control prop-input" data-id="{{ $property->id }}">
                                        <option value="0">---</option>
                                        @if (!empty($property->multidata)))
                                        @foreach ($property->multidata as $key => $multidata)
                                        <?php $value = getMultiDataList($multidata->id, 1); ?>
                                        <option value="{{ $value->property_multidata_id }}" {{ getPropertiesData(Request::segment(3), $property->id) ==  $value->property_multidata_id ? 'selected' : ''  }}>{{ $value->name}} {{ $property->translationByLanguage($lang->id)->first()->unit }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </td>
                            @else
                                <td>
                                    <input type="text" class="input-prop-text" data-id="{{ $property->id.'|'.$oneLang->id }}" value="">
                                </td>
                            @endif
                        @endforeach
                        @endif
                        <td rowspan="2">
                            <small>Imaginele va fi posibila dupa salvarea produsului</small>
                        </td>
                        <td rowspan="2">
                            <small>Subprodusele vor fi generate dupa salvarea produsului</small>
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td  class="width-auto">{{ $oneLang->lang }}</td>
                        <td>
                            <input type="text" class="input-name" data-lang="{{ $oneLang->id }}" value="">
                        </td>
                        <td>
                            <input type="text" class="input-body" data-lang="{{ $oneLang->id }}" value="">
                        </td>
                        @if (!empty($properties))
                        @foreach ($properties as $key => $property)
                            @if (($property->type == 'select') || ($property->type == 'checkbox'))
                            @else
                                <td>
                                    <input type="text" class="input-prop-text" data-id="{{ $property->id.'|'.$oneLang->id }}" value="">
                                </td>
                            @endif
                        @endforeach
                        @endif
                    </tr>
                    @endif
                    @endforeach
                </tbody>
                @if (!empty($products))
                @foreach ($products as $key => $product)
                @if (!empty($langs))
                @foreach ($langs as $keyLang => $oneLang)
                @if ($keyLang == 0)
                <tbody class="item-row" data-id={{ $product->id }}>
                <tr>
                    <td rowspan="2"  class="width-auto">{{ $product->id }}</td>
                    <td  class="width-auto">{{ $oneLang->lang }}</td>
                    <td  rowspan="2" class="width-auto">
                        <input type="text" class="input-code" data-lang="{{ $oneLang->id }}" value="{{ $product->code }}">
                    </td>
                    <td>
                        <input type="text" class="input-name" data-lang="{{ $oneLang->id }}" value="{{ $product->translationByLanguage($oneLang->id)->first()->name }}">
                    </td>
                    <td>
                        <input type="text" class="input-body" data-lang="{{ $oneLang->id }}" value="{{ $product->translationByLanguage($oneLang->id)->first()->body }}">
                    </td>
                    <td rowspan="2" class="width-auto">
                        <input type="number" class="input-price" value="{{ $product->price }}">
                    </td>
                    <td rowspan="2" class="width-auto">
                        <input type="number" class="input-price_lei" value="{{ $product->price_lei }}">
                    </td>
                    <td rowspan="2" class="width-auto">
                        <input type="number" class="input-discount" value="{{ $product->discount }}">
                    </td>
                    <td rowspan="2" class="width-auto">
                        <input type="number" class="input-stock" value="{{ $product->stock }}">
                    </td>
                    <td rowspan="2" class="width-auto">
                        <input type="text" class="input-video" value="{{ $product->video }}">
                    </td>
                    <td rowspan="2" class="width-auto">
                        {{-- <select name="input-set_id[]" class="form-control input-set_id" multiple>
                            <option value="0">---</option>
                            @if (!empty($sets)))
                            @foreach ($sets as $key => $set)
                                <option value="{{ $set->id }}" {{ in_array($set->id ,$product->sets()->pluck('set_id')->toArray()) ? 'selected' : '' }}>{{ $set->translation($lang->id)->first()->name }}</option>
                            @endforeach
                            @endif
                        </select> --}}
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#set-modal{{ $product->id }}"> <i class="fa fa-list"></i> Seturi/Collectii</button>
                        @include('admin::admin.quickUpload.setsModal', ['product' => $product])

                    </td>
                    @if (!empty($properties))
                    @foreach ($properties as $key => $property)
                        @if (($property->type == 'select') || ($property->type == 'checkbox'))
                            <td rowspan="2">
                                <select name="prop[{{ $property->id }}]" class="form-control prop-input" data-id="{{ $property->id }}">
                                    <option value="0">---</option>
                                    @if (!empty($property->multidata)))
                                    @foreach ($property->multidata as $key => $multidata)
                                    <?php $value = getMultiDataList($multidata->id, 1); ?>
                                    <option value="{{ $value->property_multidata_id }}" {{ getPropertiesData($product->id, $property->id) ==  $value->property_multidata_id ? 'selected' : ''  }}>{{ $value->name}} {{ $property->translationByLanguage($lang->id)->first()->unit }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </td>
                        @else
                            <td>
                                <input type="text" class="input-prop-text" data-id="{{ $property->id.'|'.$oneLang->id }}" value="{{ getPropertiesDataByLang($product->id, $property->id, $oneLang->id) }}">
                            </td>
                        @endif
                    @endforeach
                    @endif
                    <td rowspan="2">
                        <button type="button" name="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#gallery-modal{{ $product->id }}"> <i class="fa fa-image"></i> Imagini</button>
                        <p>{{ count($product->images) }}</p>
                        @include('admin::admin.quickUpload.galleryModal', ['product' => $product])
                    </td>
                    <td rowspan="2">
                        <button type="button" name="button" class="btn btn-primary btn-sm subproducts-btn subprod-action" data-toggle="modal" data-target="#subproducts-modal{{ $product->id }}"  data-product="{{ $product->id }}"> <i class="fa fa-image"></i> Subproduse</button>
                        <p>{{ count($product->subproducts) }}</p>
                        @include('admin::admin.quickUpload.subproductsModal', ['product' => $product])
                    </td>
                    <td rowspan="2">
                        <button type="button" name="button" class="btn btn-primary btn-sm subproducts-btn" data-toggle="modal" data-target="#subproducts-images-modal{{ $product->id }}"> <i class="fa fa-image"></i> Imagini Subproduse</button>
                        <p> - </p>
                        @include('admin::admin.quickUpload.subproductsImagesModal', ['product' => $product])
                    </td>
                </tr>
                @else
                <tr>
                    <td  class="width-auto">{{ $oneLang->lang }}</td>
                    <td>
                        <input type="text" class="input-name" data-lang="{{ $oneLang->id }}" value="{{ $product->translationByLanguage($oneLang->id)->first()->name }}">
                    </td>
                    <td>
                        <input type="text" class="input-body"  data-lang="{{ $oneLang->id }}" value="{{ $product->translationByLanguage($oneLang->id)->first()->body }}">
                    </td>
                    @if (!empty($properties))
                    @foreach ($properties as $key => $property)
                        @if (($property->type == 'select') || ($property->type == 'checkbox'))
                        @else
                            <td>
                                <input type="text" class="input-prop-text" data-id="{{ $property->id.'|'.$oneLang->id }}" value="{{ getPropertiesDataByLang($product->id, $property->id, $oneLang->id) }}">
                            </td>
                        @endif
                    @endforeach
                    @endif
                </tr>
                </tbody>
                @endif
                @endforeach
                @endif
                @endforeach
                @endif
                <tbody class="new-row"></tbody>
            </tbody>

        </table>
        <button type="button" name="button" class="btn btn-primary save-upload"><i class="fa fa-plus"></i> save & add</button>
        @if ($products->nextPageUrl())
            <button type="button" name="button" class="btn btn-primary load-more" data-next="{{ $products->nextPageUrl() }}"><i class="fa fa-caret-down"></i> view more</button>
        @endif
    </div>
</div>

<style media="screen">
.app, .header{
    padding-left: 0;
    left: 0;
}
.centred td, th{
    text-align: center;
    vertical-align: middle !important;
    padding: 0 !important;
    min-width: 200px;
}
.width-auto{
    min-width: 50px !important;
}
.centred input{
    display: block;
    width: 100%;
    min-height: 40px;
    margin: 0;
    border: none;
    padding: 2px 5px;
}
.centred select{
    display: block;
}
.scrollX{
    overflow-y: scroll;
}
tbody {
    overflow-x: auto;
}
.item-row{
    border-bottom: 2px solid #85CE36;
    overflow: hidden;
}
#loading-image{
     background-color: rgba(255, 255, 255, 0.3);
     position: fixed;
     width: 100%;
     height: 100%;
     top: 0;
     left: 0;
     bottom: 0;
     right: 0;
     z-index: 999;
     transition: 0.3s ease;
     display: none;
     text-align: center;
     height: 100vh;
}
#loading-image img{
    display: block;
    position: absolute;
    left: 50%;
    top: 50%;
    margin-left: -50px;
    margin-top: -50px;
    width: 100px;
}
#loading-image p{
    display: block;
    position: absolute;
    left: 50%;
    top: 50%;
    margin-left: -150px;
    margin-top: -150px;
    width: 300px;
    text-align: center;
    font-size: 20px;
}
.changed{
    border-left: 5px solid #27ae60;
}
.fixed{
    position: fixed;
    width: 100%;
    z-index: 999;
    top: 0;
    background-color: #f0f3f6;
    box-shadow: 1px 1px 5px rgba(126, 142, 159, 0.1);
}
label{
    margin-top: 10px;
}
select.form-control:not([size]):not([multiple]){
    height: 34px;
}
.input-left input{
    text-align: left;
    display: none;
}
.message-sub:empty
{
   padding:0;
}
.message-sub{
    z-index: 999;
    font-weight: bold;
    background-color: #85CE36;
    color: #FFF !important;
    padding: 20px;
    border-radius: 5px;
    border: 1px solid #FFF;
}
.fixed-btns{
    top: 0px;
}
</style>
<div id="loading-image"><img src="{{ asset('fronts/img/preloader.gif') }}" alt="">
    <p>please wait ...</p>
</div>

@stop
@section('footer')
<footer>
    @include('admin::admin.footer')
    <script src="{{ asset('admin/js/quick-upload.js?'.uniqid()) }}"></script>

    <script>
        function preview_image(){
            var total_file=document.getElementById("upload_file").files.length;
            for(var i=0; i < total_file; i++){
                $('#image_preview').append(
                    "<div class='row append'><div class='col-md-12'><img src='"+URL.createObjectURL(event.target.files[i])+"'alt=''></div><div class='col-md-12'>@foreach ($langs as $key => $lang)<label for=''>Alt[{{ $lang->lang }}]</label><input type='text' name='alt[{{ $lang->id }}][]'><label for=''>Title[{{ $lang->lang }}]</label><input type='text' name='title[{{ $lang->id }}][]'>@endforeach </div><hr><br>"
                );
            }
        }

        $().ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });


            $(document).on('click', '.delete-btn', function(){
                $id = $(this).attr('data-id');
                $productId = $(this).attr('data');

                $.ajax({
                    type: "POST",
                    url: '/back/products/gallery/delete',
                    data: {
                        id: $id,
                        productId: $productId,
                    },
                    success: function(data) {
                        // $(this).parent().hide();
                        // $(this).parent().prev().hide();
                    }
                });

                $(this).parent().hide();
                $(this).parent().prev().hide();
            });

        });
    </script>
</footer>

<script>

</script>

@stop

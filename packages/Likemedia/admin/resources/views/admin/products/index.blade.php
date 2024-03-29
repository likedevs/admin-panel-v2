@extends('admin::admin.app')
@include('admin::admin.nav-bar')
@include('admin::admin.left-menu')
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/back') }}">Control Panel</a></li>
        <li class="breadcrumb-item active" aria-current="page">Produse</li>
    </ol>
</nav>
<div class="title-block">
    <h3 class="title"> Produse
        @if (!is_null($category))
            @if (!is_null($category->translation->first()))
                [ {{ $category->translation->first()->name }} ]
            @endif
        @endif
    </h3>
    @include('admin::admin.list-elements', [
    'actions' => [
        trans('variables.add_element') => route('products.create', ['category' => Request::segment(4)]),
        "Auto Upload" => route('quick-upload.index', ['category' => Request::segment(4)]),
        "All products" => url('back/products'),
    ]
    ])
</div>


@if(count($products))
<div class="card">
    <div class="card-block">
        <table class="table table-hover table-striped" id="tablelistsorter">
            <thead>
                <tr>
                    <th>#</th>
                    <th>cod</th>
                    <th>{{trans('variables.title_table')}}</th>
                    <th class="text-center">Images</th>
                    <th>{{trans('variables.position_table')}}</th>
                    <th>{{trans('variables.edit_table')}}</th>
                    <th>{{trans('variables.delete_table')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $key => $product)
                <tr id="{{ $product->id }}">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $product->code}}</td>

                    <td>
                        @if (!is_null($product->translation->first()))
                            {{ $product->translation()->first()->name }}
                        @endif
                    </td>
                    <td class="text-center">
                        {{ count($product->images()->get()) }}
                    </td>
                    <td class="dragHandle" nowrap style="cursor: move;">
                        <a class="top-pos" href=""><i class="fa fa-arrow-up"></i></a>
                        <a class="bottom-pos" href=""><i class="fa fa-arrow-down"></i></a>
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product->id).'?category='.$product->category_id }}">
                        <i class="fa fa-edit"></i>
                        </a>
                    </td>
                    <td class="destroy-element">
                        <form action="{{ route('products.destroy', $product->id) }}" method="post">
                            {{ csrf_field() }} {{ method_field('DELETE') }}
                            <button type="submit" class="btn-link">
                            <a>
                            <i class="fa fa-trash"></i>
                            </a>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan=7></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@else
<div class="empty-response">{{trans('variables.list_is_empty')}}</div>
@endif
@stop
@section('footer')
<footer>
    @include('admin::admin.footer')
</footer>
@stop

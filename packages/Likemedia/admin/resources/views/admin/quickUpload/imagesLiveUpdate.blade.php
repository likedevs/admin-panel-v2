<div class="col-md-4">
    Upload  images
    <form  action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
              <label for="upload">choice images</label>
              <input name="file[]" type="file" multiple/>
              <input name="product_id" type="hidden" value="{{ $product->id }}"/>
              <hr>
        </div>
        <input type="submit" class="btn btn-primary save-images-btn" value="Salveaza" id="#upload" data="{{ $product->id }} ">
    </form>
</div>
<div class="col-md-8 ">
      <div class="col-md-12">
          Gallery
      </div><hr>
    @if (count($product->images) > 0)
        @foreach ($product->images as $key => $image)
            <div class="col-md-6">
                <div class="row image-list">
                    <div class="col-md-5">
                        <img src="/images/products/og/{{ $image->src }}" alt="" class="{{ $image->main == 1 ? 'main-image' : '' }}" style="height: 100px; width: auto;">
                    </div>
                    <div class="col-md-1">
                        <a href="#" class="delete-btn" data-id="{{ $image->id }}" data="{{ $product->id }}"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<div class="modal fade" id="set-modal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
       <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        <h5 class="modal-title" id="exampleModalLabel">Seturi / Colectii - {{ $product->translationByLanguage(1)->first()->name }}</h5>
      </div>
       <div class="modal-body">
           <div class="form-group text-left input-left">
               <div class="row">
               <div class="col-md-6">

                   <h3>Seturi</h3>
                       <form class="">
                           @foreach($sets as $set)
                             <div class="col-md-12">
                                 <label>
                                     <input class="checkbox" type="checkbox" name="set_id[]" value="{{ $set->id }}" class="setCheckbox" {{ !is_null($set->setProduct($product->id)->first()) ? 'checked' : '' }}>
                                     <span>
                                         {{ $set->translation()->first()->name }}
                                     </span>
                                 </label>
                             </div>
                           @endforeach

                           <div class="modal-footer fixed-btns">
                               <small class="text-danger message-sub"></small>
                               <button type="button" class="btn btn-primary submitSetProduct" data-product="{{ $product->id }}" data-form="subproductsFrom{{$product->id}}">Save Changes</button>
                           </div>
                       </form>
                   </div>
                   <div class="col-md-6">

                       <h3>Colectii</h3>
                           <small class="text-danger text-center">Bifand una sau mai multe colectii, vor fi create seturi care vor contine produsul dat.</small>
                           <form class="">
                               @foreach($collections as $set)
                                 <div class="col-md-12">
                                     <label>
                                         <input class="checkbox" type="checkbox" name="collection_id[]" value="{{ $set->id }}" class="setCheckbox">
                                         <span>
                                             {{ $set->translation()->first()->name }}
                                         </span>
                                     </label>
                                 </div>
                               @endforeach

                               <div class="modal-footer fixed-btns">
                                   <small class="text-danger message-sub"></small>
                                   <button type="button" class="btn btn-primary submitCollectionProduct" data-product="{{ $product->id }}" data-form="subproductsFrom{{$product->id}}">Save Changes</button>
                               </div>
                           </form>
                       </div>
               </div>
           </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
      </div>
    </div>
  </div>
</div>

@if (Session::has('message'))
<div class="modal" id="onloadModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('fronts/img/icons/closeModalMenu.png') }}" alt=""></button>
            </div>
            <div class="modal-body">
                <p class="text-center">{{ Session::get('message') }}</p>
            </div>
        </div>
    </div>
</div>
@endif

@if (Session::has('messageStok'))
<div class="modal" id="onloadModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('fronts/img/icons/closeModalMenu.png') }}" alt=""></button>
            </div>
            <div class="modal-body">
                <p class="text-center">{{ Session::get('messageStok') }}</p>
            </div>
        </div>
    </div>
</div>
@endif

@if (Session::has('stockError'))
<div class="modal" id="onloadModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('fronts/img/icons/closeModalMenu.png') }}" alt=""></button>
            </div>
            <div class="modal-body">
                @php
                    $erorProduct = (array) json_decode(Session::get('stockError'))
                @endphp
                <p class="text-center">
                    Produsul {{ $erorProduct['name'] }} nu mai este in stoc. Continuati checkout fara el, iar produsul sa-l mutam in Favorites?
                </p>
            </div>
            <div class="modal-footer">
                <input type="button" name="" value="DA">
                <input type="button" data-dismiss="modal"  name="" value="NU">
            </div>
        </div>
    </div>
</div>
@endif

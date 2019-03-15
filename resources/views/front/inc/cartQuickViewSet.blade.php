
<div class="row justify-content-center cartBl">
    <div class="col-12 text-right">
        Shoping Cart ({{ count($cartProducts) + count($cartSets) }})
    </div>

        <div class="col-lg-4 col-6">
            @if ($set->mainPhoto()->first())
            <img src="{{ asset('/images/sets/md/'.$set->mainPhoto()->first()->src ) }}" alt="">
            @else
            <img src="/images/no-image.png">
            @endif
        </div>
        <div class="col-lg-6 col-6 descrItemCart">
          <div>{{ $set->translation($lang->id)->first()->name }}</div>
          {{-- <div>Pret: <b>{{ $set->price_lei }} Lei</b></div> --}}
        </div>
</div>

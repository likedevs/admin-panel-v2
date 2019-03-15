<?php
      $amount = 0;
      $descountTotal = 0;
?>
@if (!empty($cartProducts))
    @foreach ($cartProducts as $key => $cartProduct)
        @if ($cartProduct->product)
        <?php $price = $cartProduct->product->price_lei - ($cartProduct->product->price_lei * $cartProduct->product->discount / 100); ?>
        @if ($price)
            <?php
                $amount +=  $price * $cartProduct->qty;
                $descountTotal += ($cartProduct->product->price_lei -  ($cartProduct->product->price_lei - ($cartProduct->product->price_lei * $cartProduct->product->discount / 100))) * $cartProduct->qty;
            ?>
        @endif
        @endif
    @endforeach
@endif
<div class="col-12">
    <p>Primim cheș, carduri Visa sau MasterCard</p>
</div>
<div class="col-12">
    <div class="row resum">
        <div class="col-auto"> produse cu reducere</div>
        <div class="col line"></div>
        <div class="col-3">
            {{ $amount }} lei
        </div>
    </div>
    <div class="row resum">
        <div class="col-auto">livrare</div>
        <div class="col line"></div>
        <div class="col-3">
            25,00 lei
        </div>
    </div>
</div>
<div class="col-12">
    <div class="row totalToPay justify-content-end">
        <div class="col-auto" style="padding-right: 20px;">
            Total spre plată:
        </div>
        <div class="col-3">
            {{ $amount + 25 }} lei
        </div>
    </div>
</div>

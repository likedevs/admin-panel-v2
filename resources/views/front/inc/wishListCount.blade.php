@if (count($wishListProducts) !== 0 || count($wishListSets) !== 0)
  <li class="modalButton4 iconWishAdded">
    <div>{{ count($wishListProducts) + count($wishListSets) }}</div>
  </li>
@else
  <li class="modalButton4">
  </li>
@endif

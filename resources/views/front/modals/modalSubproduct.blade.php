@if (!is_null($subproduct))
<div class="modal" id="modalToCart">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adăugat în coș</h4>
                <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('fronts/img/icons/closeModalMenu.png') }}" alt=""></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3 modal-image">
                        @if ($subproduct->image)
                        <img src="{{ asset('/images/subproducts/'.$subproduct->image ) }}">
                        @else
                            @if ($product->mainImage()->first())
                            <img src="{{ asset('images/products/og/'.$product->mainImage()->first()->src ) }}">
                            @else
                            <img src="{{ asset('/upfiles/no-image.png') }}">
                            @endif
                        @endif
                    </div>
                    <div class="col-7">
                        <div class="row">
                            <div class="col-12">
                                {{ $product->translationByLanguage($lang->id)->first()->name }}
                            </div>
                            <div class="col-8">
                                @if ($subproduct->stock > 0)
                                    <select class="changeQtyProduct" data-subprod="{{ $subproduct->id }}" data-prod="{{ $product->id }}">
                                        @for ($i = 1; $i <= $subproduct->stock; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                @endif
                                {{-- <div class="plusminus">
                                    <input type="text" id="niti" name="number" value="{{ $subproduct->cart ? $subproduct->cart->qty : '1' }}">
                                    <div class="minus" data-subprod="{{ $subproduct->id }}" data-prod="{{ $product->id }}"></div>
                                    <div class="plus" data-subprod="{{ $subproduct->id }}" data-prod="{{ $product->id }}"></div>
                                </div> --}}
                            </div>
                            <div class="col-12">
                                <div class="price">
                                    <span>{{ $subproduct->price - ($subproduct->price * $subproduct->discount / 100) }} lei</span>
                                    <span>{{ $subproduct->price }} lei</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6" style="margin-top: 20px;">
                        <div class="btnDark" data-dismiss="modal">
                            Continue shopping
                        </div>
                    </div>
                    <div class="col-6" style="margin-top: 20px;">
                        <div class="btnLight">
                            <a href="{{ url($lang->lang.'/cart') }}">View Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="modalClick">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cumpara in one click</h4>
                <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('fronts/img/icons/closeModalMenu.png') }}" alt=""></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3">
                        <img src="{{ asset('fronts/img/products/cartPr1.png') }}" alt="">
                    </div>
                    <div class="col-7">
                        <div class="row">
                            <div class="col-12">
                                Rochie Dama knolk my heart dress Green…
                            </div>
                            <div class="col-6">
                                <select name="selectSize" id="">
                                    Size
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <div class="plusminus">
                                    <input type="text" id="niti" name="number" value="1">
                                    <div class="minus"></div>
                                    <div class="plus"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="price">
                                    <span>120 lei</span>
                                    <span>120 lei</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row promoCod">
                            <div class="col-7">
                                <input type="text" placeholder="Promo cod">
                            </div>
                            <div class="col-5">
                                <div class="btnWhite">
                                    Aplică
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="margin: 15px 0;">
                        <div class="oneClickDropOpen">
                            <form>
                                <h6>Detalii livrare comanda</h6>
                                <div class="row">
                                    <div class="col-12">
                                        <input type="text" placeholder="Nume Prenume*" required>
                                        <input type="text" placeholder="Telefon*" required>
                                        <input type="text" placeholder="Email*" required>
                                    </div>
                                </div>
                                <h6>Regiunea*</h6>
                                <div class="row">
                                    <div class="col-12">
                                        <select name="selectCountry" id="">
                                            <option value="MD">Moldova</option>
                                            <option value="RU">Rusia</option>
                                            <option value="RO">Romania</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <select name="selectVil" id="">
                                            <option value="MD">Causeni</option>
                                            <option value="RU">Straseni</option>
                                            <option value="RO">Leova</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" placeholder="localitatea" required>
                                    </div>
                                </div>
                                <h6>Doresc Livrarea comenzii prin</h6>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optradio">
                                                <div class="lab">Livrare prin curier rapind</div>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optradio">
                                                <div class="lab">Ridicare in showroom</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <h6>Doresc sa platesc</h6>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optradio2">
                                                <div class="lab">Prin Card</div>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optradio2">
                                                <div class="lab">Prin Paypal</div>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optradio2">
                                                <div class="lab">Prin Ordin de plată  (Cash la livrare)</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <h6>Vrei sa primesti ofertele noastre?</h6>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="optradio">
                                                <div class="lab">Am citit si sunt deacord cu colectarea si procesarea datelor mele personale impreuna cu <a href="#">termenii si conditiile magazinului.</a> </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <h6>Ce vom face cu datele personale?</h6>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="optradio">
                                                <div class="lab">Am citit si sunt deacord cu colectarea si procesarea datelor mele personale impreuna cu <a href="#">termenii si conditiile magazinului.</a> </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-8">
                                        <div class="btnDark">
                                            <input type="submit" value="Trimite Comanda">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

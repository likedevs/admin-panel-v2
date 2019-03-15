@if (Session::has('message'))
    <div class="modal onBuyModal" id="onLoad">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="row contentClick justify-content-center">

                    <div class="row justify-content-between formHeader">
                        <div class="text-right pull-right" style="text-align: right; width: 95%;">
                            <button type="button" class="close" style="float: right;" data-dismiss="modal"><img src="{{ asset('fronts/img/icons/close.png') }}" alt=""></button>
                        </div>
                        <div class="" style="text-align: right; width: 80%; margin: 20px auto;">
                            <h4 class="text-center">{{ Session::get('message') }}</h4>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endif

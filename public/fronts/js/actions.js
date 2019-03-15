$().ready(function(){
    $('.drop-btn').click(function(e){
        e.preventDefault;
        $('.dropdown-min').slideUp();
        $('.drop-btn').removeClass('active');
        $dropDown = $(this).next().next('.dropdown-min');
        if ($dropDown.hasClass('open')) {
            $dropDown.removeClass('open');
            $(this).removeClass('active');
            $dropDown.slideUp();
        }else{
            $dropDown.addClass('open');
            $(this).addClass('active');
            $dropDown.slideDown();
        }
    });
});


// Ajax queries
$.ajaxSetup({
    headers: {
        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
    }
});

const lang = '/' + $('html')[0].lang;

$(document).on('click', '.modalToCart', function(event){
    event.preventDefault();
    $id = $(this).attr('data-id');
    $qty = $('.' + $(this).attr('data-qty')).val();

    $.ajax({
        type: "POST",
        url: lang + '/addToCart',
        data: {
            id : $id,
            qty : $qty,
        },
        success: function(data) {
            var res = JSON.parse(data);
            $('.cart-area').html(res.cartBox);
            $('.nrProducts').html(res.cartCount);
            $('.cartPop').toggle(500);
            $('.cartPop').html(res.cartQuick);

            setTimeout(function(){
                $('.cartPop').toggle(500);
            }, 2000);
        }
    });
})

$(document).on('click', '.setToCart', function(event){
    event.preventDefault();
    $prodsId = $(this).attr('data-products');
    $setId = $(this).attr('data-id');
    $setPrice = $(this).attr('data-price');

    $.ajax({
        type: "POST",
        url: lang + '/addSetToCart',
        data: {
            setId : $setId,
            prodsId : $prodsId,
            setPrice : $setPrice,
        },
        success: function(data) {
            var res = JSON.parse(data);
            $('.cart-area').html(res.cartBox);
            $('.nrProducts').html(res.cartCount);
            $('.cartPop').toggle(500);
            $('.cartPop').html(res.cartQuick);

            setTimeout(function(){
                $('.cartPop').toggle(500);
            }, 2000);
        }
    });
})

$(document).on('change', '.changeQty', function(event){
    event.preventDefault();
    $id = $(this).attr('data-id');
    $val = $(this).val();

    $.ajax({
        type: "POST",
        url: lang + '/cartQty/changeQty',
        data: {
            id: $id,
            value: $val,
        },
        success: function(data) {
            var res = JSON.parse(data);
            $('.responseCartBlock').html(res.block);
            $('.responseCartSummary').html(res.summary);
            $('.cart-area').html(res.cartBox);
            $('.nrProducts').html(res.cartCount);
        }
    });
})


$(document).on('change', '.changeQtyProduct', function(event){
    $id = 0;
    $subproduct = $(this).attr('data-subprod');
    $product = $(this).attr('data-prod');
    $val = $(this).val();

    $.ajax({
        type: "POST",
        url: lang + '/cartQty/changeQty',
        data: {
            id: $id,
            subprod: $subproduct,
            prod: $product,
            value: $val,
        },
        success: function(data) {
            var res = JSON.parse(data);
            $('.responseCartBlock').html(res.block);
            $('.responseCartSummary').html(res.summary);
            $('.cart-area').html(res.cartBox);
            $('.nrProducts').html(res.cartCount);
        }
    });
})

$(document).on('change', '.changeQtySet', function(event){
    $id = $(this).attr('data-id');
    $val = $(this).val();

    $.ajax({
        type: "POST",
        url: lang + '/cartQty/changeQtySet',
        data: {
            id: $id,
            value: $val,
        },
        success: function(data) {
            var res = JSON.parse(data);
            $('.responseCartBlock').html(res.block);
            $('.responseCartSummary').html(res.summary);
            $('.cart-area').html(res.cartBox);
            $('.nrProducts').html(res.cartCount);
        }
    });
})

$(document).on('click', '.plus', function(event){
    event.preventDefault();
    $id = $(this).attr('data-id');
    $subproduct = $(this).attr('data-subprod');
    $product = $(this).attr('data-prod');

    $.ajax({
        type: "POST",
        url: lang + '/cartQty/plus',
        data: {
            id: $id,
            subprod: $subproduct,
            prod: $product,
        },
        success: function(data) {
            var res = JSON.parse(data);
            $('.responseCartBlock').html(res.block);
            $('.responseCartSummary').html(res.summary);
            $('.cart-area').html(res.cartBox);
            $('.nrProducts').html(res.cartCount);
        }
    });
})

$(document).on('click', '.minus', function(event){
    event.preventDefault();
    $id = $(this).attr('data-id');
    $subproduct = $(this).attr('data-subprod');
    $product = $(this).attr('data-prod');

    $.ajax({
        type: "POST",
        url: lang + '/cartQty/minus',
        data: {
            id: $id,
            subprod: $subproduct,
            prod: $product,
        },
        success: function(data) {
            var res = JSON.parse(data);
            $('.responseCartBlock').html(res.block);
            $('.responseCartSummary').html(res.summary);
            $('.cart-area').html(res.cartBox);
            $('.nrProducts').html(res.cartCount);
        }
    });
})

$(document).on('click', '.remSetCart', function(event){
    event.preventDefault();
    $id = $(this).attr('data-id');

    $.ajax({
        type: "POST",
        url: lang + '/removeSetCart',
        data: {
            id: $id,
        },
        success: function(data) {
            var res = JSON.parse(data);
            $('.responseCartBlock').html(res.block);
            $('.responseCartSummary').html(res.summary);
            $('.cart-area').html(res.cartBox);
            $('.nrProducts').html(res.cartCount);
        }
    });
})

$(document).on('click', '.remItemCart', function(event){
    event.preventDefault();
    $id = $(this).attr('data-id');

    $.ajax({
        type: "POST",
        url: lang + '/removeItemCart',
        data: {
            id: $id,
        },
        success: function(data) {
            var res = JSON.parse(data);
            $('.responseCartBlock').html(res.block);
            $('.responseCartSummary').html(res.summary);
            $('.cart-area').html(res.cartBox);
            $('.nrProducts').html(res.cartCount);
        }
    });
})

$(document).on('click', '#remAllItems', function(event){
    event.preventDefault();
    $id = $(this).attr('data-id');

    $.ajax({
        type: "POST",
        url: lang + '/removeAllItemCart',
        data: {
            id: $id,
        },
        success: function(data) {
            var res = JSON.parse(data);
            $('.responseCartBlock').html(res.block);
            $('.responseCartSummary').html(res.summary);
            $('.cart-area').html(res.cartBox);
            $('.nrProducts').html(res.cartCount);
        }
    });
})

$(document).on('change', '.filter-checkbox-category', function(event){
    $name = $(this).attr('name');
    $value = $(this).attr('value');
    $category = $('.category-id').val();

    $.ajax({
        type: "POST",
        url: lang + '/filter',
        data:{
            name: $name, value: $value, category_id: $category,
        },
        beforeSend: function(){
            $('#loading-image').show();
        },
        complete: function(){
           $('#loading-image').hide();
        },
        success: function(data) {
            var res = JSON.parse(data);
            $('.responseProducts').html(res.products);
            $('.filter-bind').html(res.filter);

            window.history.pushState({}, "Title", "?"+res.url);
        }
    });
})

$(document).on('change', '.filter-checkbox-brand', function(event){
    $name = $(this).attr('name');
    $value = $(this).attr('value');
    $category = $('.category-id').val();

    $.ajax({
        type: "POST",
        url: lang + '/filter/brands',
        data:{
            name: $name, value: $value, category_id: $category,
        },
        beforeSend: function(){
            $('#loading-image').show();
        },
        complete: function(){
           $('#loading-image').hide();
        },
        success: function(data) {
            var res = JSON.parse(data);
            $('.responseProducts').html(res.products);
            $('.filter-bind').html(res.filter);

            window.history.pushState({}, "Title", "?"+res.url);
        }
    });
})

$(document).on('change', '.filter-checkbox-property', function(event){
    $name = $(this).attr('name');
    $value = $(this).attr('value');
    $category = $('.category-id').val();

    $.ajax({
        type: "POST",
        url: lang + '/filter/property',
        data:{
            name: $name, value: $value, category_id: $category,
        },
        beforeSend: function(){
            $('#loading-image').show();
        },
        complete: function(){
           $('#loading-image').hide();
        },
        success: function(data) {
            var res = JSON.parse(data);
            $('.responseProducts').html(res.products);
            $('.filter-bind').html(res.filter);

            window.history.pushState({}, "Title", "?"+res.url);
        }
    });
})

$(document).on('click', '.filter-checkbox-property', function(event){
    $name = $(this).attr('name');
    $value = $(this).attr('value');
    $category = $('.category-id').val();

    $.ajax({
        type: "POST",
        url: lang + '/filter/property',
        data:{
            name: $name, value: $value, category_id: $category,
        },
        beforeSend: function(){
            $('#loading-image').show();
        },
        complete: function(){
           $('#loading-image').hide();
        },
        success: function(data) {
            var res = JSON.parse(data);
            $('.responseProducts').html(res.products);
            $('.filter-bind').html(res.filter);

            window.history.pushState({}, "Title", "?"+res.url);
        }
    });
})

$(document).on('click', '.remove-icon', function(event){
    $name = $(this).attr('name');
    $value = $(this).attr('value');
    $category = $('.category-id').val();

    $.ajax({
        type: "POST",
        url: lang + '/filter/property',
        data:{
            name: $name, value: $value, category_id: $category,
        },
        beforeSend: function(){
            $('#loading-image').show();
        },
        complete: function(){
           $('#loading-image').hide();
        },
        success: function(data) {
            var res = JSON.parse(data);
            $('.responseProducts').html(res.products);
            $('.filter-bind').html(res.filter);

            window.history.pushState({}, "Title", "?"+res.url);
        }
    });
})

$(document).on('click', '#sendPrice', function(event){
    $from = $('#curent-price-from').val();
    $to = $('#curent-price-to').val();
    $category = $('.category-id').val();

    $.ajax({
        type: "POST",
        url: lang + '/filter/price',
        data:{
            from: $from, to: $to, category_id: $category,
        },
        beforeSend: function(){
            $('#loading-image').show();
        },
        complete: function(){
           $('#loading-image').hide();
        },
        success: function(data) {
            var res = JSON.parse(data);
            $('.responseProducts').html(res.products);
            $('.filter-bind').html(res.filter);

            window.history.pushState({}, "Title", "?"+res.url);
        }
    });
})

$(document).on('click', '.limit-products', function(event){
    $limit = $(this).attr('data');
    $category = $('.category-id').val();

    console.log($limit);
    $.ajax({
        type: "POST",
        url: lang + '/filter/limit',
        data:{
            limit: $limit, category_id: $category,
        },
        beforeSend: function(){
            $('#loading-image').show();
        },
        complete: function(){
           $('#loading-image').hide();
        },
        success: function(data) {
            var res = JSON.parse(data);
            $('.responseProducts').html(res.products);
            $('.filter-bind').html(res.filter);

            window.history.pushState({}, "Title", "?"+res.url);
        }
    });
    return false;
})

$(document).on('change', '.order-products', function(event){
    $element = $(this).find('option:selected');
    $order = $element.val();
    $field = $element.attr('data');
    $category = $('.category-id').val();

    $.ajax({
        type: "POST",
        url: lang + '/filter/order',
        data:{
            order: $order, field: $field, category_id: $category,
        },
        beforeSend: function(){
            $('#loading-image').show();
        },
        complete: function(){
           $('#loading-image').hide();
        },
        success: function(data) {
            var res = JSON.parse(data);
            $('.responseProducts').html(res.products);
            $('.filter-bind').html(res.filter);

            window.history.pushState({}, "Title", "?"+res.url);
        }
    });
    return false;
})

$(window).on('load',function(){
    $('#onLoad').modal('show');
});

$('.search-field').on('keyup', function(){
    var val = $(this).val();
    if (val.length > 2) {
        $.ajax({
            type: "POST",
                url: lang + '/search/autocomplete',
            data:{
                value: val,
            },
            success: function(data) {
                var res = JSON.parse(data);
                $('.autocomplete').html(res);
            }
        });
    }else{
        $('.autocomplete').html('');
    }
})

$(document).on('click', '.subproductItem', function(event){
    if ($(this).attr('checked')) {
        $(this).prop('checked', false);
        $action = 'unchecked';
    }else{
        $(this).prop('checked', true);
        $action = 'checked';
    }

    $value = $(this).attr('value');
    $name = $(this).attr('data-name');
    $product = $(this).attr('data');
    $key = $(this).attr('data-key');

    $.ajax({
        type: "POST",
            url: lang + '/change/subproduct',
        data: { value : $value, name : $name, productId : $product, key : $key , action: $action},
        success: function(data) {
            var res = JSON.parse(data);
            $('.response').html(res);
        }
    });
});

$(document).on('change', '.subproductSelect', function(event){
    $value = $(this).find(":selected").attr('value');
    $name = $(this).find(":selected").attr('data-name');
    $product = $(this).find(":selected").attr('data');
    $key = $(this).find(":selected").attr('data-key');

    $this = $(this);

    $.ajax({
        type: "POST",
            url: lang + '/change/subproductList',
        data: { value : $value, name : $name, productId : $product, key : $key},
        success: function(data) {
            var res = JSON.parse(data);
            $this.parents('.response-item').html(res);
        }
    });
});

$(document).on('click', '.subproductSingle', function(event){
    if ($(this).attr('checked')) {
        $(this).prop('checked', false);
        $action = 'unchecked';
    }else{
        $(this).prop('checked', true);
        $action = 'checked';
    }

    $value = $(this).attr('value');
    $name = $(this).attr('data-name');
    $product = $(this).attr('data');
    $key = $(this).attr('data-key');
    $set = $(this).attr('data-set');

    $this = $(this);

    $.ajax({
        type: "POST",
            url: lang + '/change/subproductListSingle',
        data: { value : $value, name : $name, productId : $product, key : $key, set: $set},
        success: function(data) {
            var res = JSON.parse(data);

            $this.parents('.response-subproduct').html(res.productCategory);
            $this.parents('.response-item').html(res.productsSet);
            $('.response-single-item').html(res.singleProductPage);
            setChekedValue();
            setChekedValueOneItem();
        }
    });
});

$(document).on('click', '.subproductListItem', function(event){
    if ($(this).attr('checked')) {
        $(this).prop('checked', false);
        $action = 'unchecked';
    }else{
        $(this).prop('checked', true);
        $action = 'checked';
    }

    $value = $(this).attr('value');
    $name = $(this).attr('data-name');
    $product = $(this).attr('data');
    $key = $(this).attr('data-key');
    $set = $(this).attr('data-set');

    $this = $(this);

    $.ajax({
        type: "POST",
            url: lang + '/change/subproductList',
        data: { value : $value, name : $name, productId : $product, key : $key, set: $set},
        success: function(data) {
            var res = JSON.parse(data);
            $this.parents('.response-item').html(res);
            setChekedValueOneItem();
            setChekedValue();
        }
    });
});

function setChekedValueOneItem() {
    var baci = document.getElementsByClassName('fucked');
     for(var i=0; i<baci.length; i++){
       if($(baci[i]).prop('checked')){
         var baga = $(baci[i]).next('.sizeCheckmark').children('.dat').text();
             $(baci[i]).parents('.searchImg').children('.selSize').text(baga);
             $(baci[i]).parents('.searchImg').children('.selSize').removeClass('select-none')
      }
    }
}

$(document).on('click', '.promocodeAction', function(event){
    $promocode = $('.codPromo').val();
    $amount = $('.amount').text();

    $.ajax({
        type: "POST",
            url: lang + '/cart/set/promocode',
        data: { promocode : $promocode, amount: $amount },
        success: function(data) {
            var res = JSON.parse(data);
            if (data == 'false') {
                $('.invalid-feedback').show();
            }
            $('.responseCartBlock').html(res.block);
            $('.responseCartSummary').html(res.summary);
            $('.cart-area').html(res.cartBox);
            $('.nrProducts').html(res.cartCount);
        }
    });
});

$(document).on('click', '.removePromoCode', function(event){
    $promocode = $('.codPromo').val();
    $amount = $('.amount').text();

    $.ajax({
        type: "POST",
            url: lang + '/cart/remove/promocode',
        data: { promocode : $promocode, amount: $amount },
        success: function(data) {
            var res = JSON.parse(data);
            if (data == 'false') {
                $('.invalid-feedback').show();
            }
            $('.responseCartBlock').html(res.block);
            $('.responseCartSummary').html(res.summary);
            $('.cart-area').html(res.cartBox);
            $('.nrProducts').html(res.cartCount);
        }
    });
});

$(document).on('change', '.filterCountries', function(){
    let value = $(this).val();
    let address_id = $(this).data('id');
    $.ajax({
        type: "POST",
        url: lang + '/cabinet/filterCountries',
        data: { value: value },
        success: function(data) {
            let res = JSON.parse(data);
            if(address_id) {
                $('.filterRegions[data-id=' + address_id +']').html('<option selected disabled>Выберите регион</option>');
                $('.filterRegions[data-id=' + address_id +']').append(res.regions);
            } else {
                $('.filterRegions').html("<option selected disabled>Выберите регион</option>");
                $('.filterRegions').append(res.regions);
            }
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
});

$(document).on('change', '.filterRegions', function(){
    let value = $(this).val();
    let address_id = $(this).data('id');
    $.ajax({
        type: "POST",
        url: lang + '/cabinet/filterRegions',
        data: { value: value },
        success: function(data) {
            let res = JSON.parse(data);
            if(address_id) {
                $('.filterCities[data-id=' + address_id + ']').html('<option selected disabled>Выберите город</option>');
                $('.filterCities[data-id=' + address_id + ']').append(res.cities);
            } else {
                $('.filterCities').html('<option selected disabled>Выберите город</option>');
                $('.filterCities').append(res.cities);
            }
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
});

$(document).on('change', '.filterCountriesCart', function(){
    let value = $(this).val();
    let address_id = $(this).data('id');
    $.ajax({
        type: "POST",
        url: lang + '/filterCountries',
        data: { value: value },
        success: function(data) {
            let res = JSON.parse(data);
            if(address_id) {
                $('.filterRegionsCart[data-id=' + address_id +']').html('<option selected disabled>Выберите регион</option>');
                $('.filterRegionsCart[data-id=' + address_id +']').append(res.regions);
            } else {
                $('.filterRegionsCart').html("<option selected disabled>Выберите регион</option>");
                $('.filterRegionsCart').append(res.regions);
            }
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
});

$(document).on('change', '.filterRegionsCart', function(){
    let value = $(this).val();
    let address_id = $(this).data('id');
    $.ajax({
        type: "POST",
        url: lang + '/filterRegions',
        data: { value: value },
        success: function(data) {
            let res = JSON.parse(data);
            if(address_id) {
                $('.filterCitiesCart[data-id=' + address_id + ']').html('<option selected disabled>Выберите город</option>');
                $('.filterCitiesCart[data-id=' + address_id + ']').append(res.cities);
            } else {
                $('.filterCitiesCart').html('<option selected disabled>Выберите город</option>');
                $('.filterCitiesCart').append(res.cities);
            }
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
});

let changeLang = function(lang) {
    $.ajax({
        type: "POST",
        url: lang + '/changeLang',
        data: { lang: lang },
        success: function(data) {

        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
}

$(document).on('click', '.moveFromCartToWishList', function(e){
    e.preventDefault();
    let product_id = $(this).data('product_id');
    let subproduct_id = $(this).data('subproduct_id');
    $.ajax({
        type: "POST",
        url: lang + '/moveFromCartToWishList',
        data: { product_id: product_id, subproduct_id: subproduct_id },
        success: function(data) {
            let res = JSON.parse(data);
            $('.responseCartBlock').html(res.block);
            $('.responseCartSummary').html(res.summary);
            $('.cart-area').html(res.cartBox);
            $('.nrProducts').html(res.cartCount);
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
});

$(document).on('click', '.addToWishList', function(e){
    e.preventDefault();
    const productId = $(this).data('product_id');
    $.ajax({
        type: "POST",
        url: lang + '/addToWishList',
        data: { productId },
        success: function(data) {
            let res = JSON.parse(data);
            $('.wish-area').html(res.wishBox);
            $('.wishCount').html(res.wishCount);
            $(this).toggleClass('addedWishList');
            $(".modalOpen4").toggle(500);
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
});

$(document).on('click', '.addSetToWishList', function(e){
    e.preventDefault();
    const setId = $(this).data('set_id');

    $.ajax({
        type: "POST",
        url: lang + '/addSetToWishList',
        data: { setId },
        success: function(data) {
            let res = JSON.parse(data);
            $('.wish-area').html(res.wishBox);
            $('.wishCount').html(res.wishCount);
            $(this).toggleClass('addedWishList');
            $(".modalOpen4").toggle(500);
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
});

$(document).on('change', 'select[name="subproductSize"]', function(e) {
    const subproductId = $(this).val();
    const wishListId = $(this).data('id');
    const object = $(this);
    $.ajax({
        type: "POST",
        url: lang + '/changeSubproductSizeWishList',
        data: {subproductId, wishListId},
        success: function(data) {
            const res = JSON.parse(data);
            object.closest('.wishProduct').find('.txtWish').css('display', 'block');
            object.closest('.wishProduct').find('.stock').html(res.subproduct.stock);
            object.closest('.wishProduct').find('.code').html(res.subproduct.code);
            object.closest('.wishProduct').find('.price').html(res.subproduct.price_lei);
        }
    });

    e.preventDefault();
});

$(document).on('click', '.removeItemWishList', function(e){
    e.preventDefault();
    let id = $(this).data('id');
    $.ajax({
        type: "POST",
        url: lang + '/removeItemWishList',
        data: { id: id },
        success: function(data) {
            let res = JSON.parse(data);
            $('.wishListBlock').html(res.wishListBlock);
            $('.wish-area').html(res.wishBox);
            $('.wishCount').html(res.wishCount);
            $('.addToWish[data-product_id='+productId+']').removeClass('addedWishList');
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
});

$(document).on('click', '.removeSetWishList', function(e){
    e.preventDefault();
    let id = $(this).data('id');
    $.ajax({
        type: "POST",
        url: lang + '/removeSetWishList',
        data: { id: id },
        success: function(data) {
            let res = JSON.parse(data);
            $('.wishListBlock').html(res.wishListBlock);
            $('.wish-area').html(res.wishBox);
            $('.wishCount').html(res.wishCount);
            $('.addSetToWish[data-set_id='+setId+']').removeClass('addedWishList');
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
});

$(document).on('click', '.moveFromWishListToCart', function(e){
    e.preventDefault();
    let id = $(this).data('id');
    $.ajax({
        type: "POST",
        url: lang + '/moveFromWishListToCart',
        data: { id },
        success: function(data) {
            let res = JSON.parse(data);
            $('.wishListBlock').html(res.wishListBlock);
            $('.wish-area').html(res.wishBox);
            $('.wishCount').html(res.wishCount);
            $('.cart-area').html(res.cartBox);
            $('.nrProducts').html(res.cartCount);
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
});

$(document).on('click', '.moveSetFromWishListToCart', function(e){
    e.preventDefault();
    let id = $(this).data('id');
    $.ajax({
        type: "POST",
        url: lang + '/moveSetFromWishListToCart',
        data: {id},
        success: function(data) {
            let res = JSON.parse(data);
            $('.wishListBlock').html(res.wishListBlock);
            $('.wish-area').html(res.wishBox);
            $('.wishCount').html(res.wishCount);
            $('.cart-area').html(res.cartBox);
            $('.nrProducts').html(res.cartCount);
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
});

$(document).on('change', '.subproductSelectWishList', function(event){
    $value = $(this).find(":selected").attr('value');
    $name = $(this).find(":selected").attr('data-name');
    $product = $(this).find(":selected").attr('data');
    $key = $(this).find(":selected").attr('data-key');
    $this = $(this);

    $.ajax({
        type: "POST",
            url: lang + '/change/subproductListWishList',
        data: { value : $value, name : $name, productId : $product, key : $key},
        success: function(data) {
            var res = JSON.parse(data);
            if (res != false) {
                $this.parents('.response').html(res);
            }
        }
    });
});

$(document).on('click', '.validateForm', function(event){
    event.preventDefault();
    $this = $(this);

    $.ajax({
        type: "POST",
            url: lang + '/cart/validateProducts',
        data: { },
        success: function(data, event) {
            var res = JSON.parse(data);
            if (res != false) {
                $('#validateCartProducts').html(res);
                $('#validateCartProducts').modal('show');
                return false;
            }else{
                $('.orderForm').unbind('submit').submit();
            }
        }
    });
});

$(document).on('click', '.forceSubmit', function(){
    $('.orderForm').unbind('submit').submit();
})

$(document).on('click', '#addMoreBlogs', function(e){
  const count = $('.blogItem').length;
  const categoryId = $(this).data('id');
  $.ajax({
      type: "POST",
      url: lang + '/blogs/addMoreBlogs',
      data: {count: count, categoryId: categoryId},
      success: function(data) {
          const res = JSON.parse(data);
          $('.blogs').html(res.blogs);
      }
  });

  e.preventDefault();
});

$(document).on('click', '.load-more-btn', function(e){
  e.preventDefault();
  var url = $(this).attr('data-url');
  $.ajax({
      type: "GET",
      url: url,
      data: {},
      success: function(data) {
          var res = JSON.parse(data);
          $('.load-more-area').append(res.html);
          $('.load-more-btn').attr('data-url', res.url);

          if (res.last == 'true') {
              $('.load-more-btn').parent().remove();
          }
      }
  });

});

$(document).on('click', '.filterBlogs', function(e){
  const categoryId = $(this).data('id');
  $('#addMoreBlogs').data('id', categoryId);
  $.ajax({
      type: "POST",
      url: lang + '/blogs/filterBlogs',
      data: {categoryId: categoryId},
      success: function(data) {
          const res = JSON.parse(data);
          $('.blogs').html(res.blogs);
      }
  });

  e.preventDefault();
});

//////////////////////////////////////////////

$('select[name="addressMain"').on('change', function(){
    $('.addressInfo').hide().children().attr('disabled', true);
    $('.addressInfo[data-id=' + $(this).val() + ']').children().attr('disabled', false).parent().show();
});

$('.addressInfo').hide().children().attr('disabled', true);
$('.addressInfo[data-id=' + $('select[name="addressMain"').val()  + ']').children().attr('disabled', false).parent().show();

function addReturn(clickedCheckbox) {
    if (clickedCheckbox.checked) {
        if (confirm("Are you sure you want to do this?")) {
            clickedCheckbox.checked = true;
            clickedCheckbox.closest('form').submit();
        } else {
            clickedCheckbox.checked = false;
        }
     } else {
        clickedCheckbox.closest('form').submit();
     }
}

$(document).on('change', '.showPickup', function(){
    $('.pickupBlock').slideToggle();
    $('.deliveryBlock').slideToggle();
})

$(document).on('change', '.showDelivery', function(){
    $('.pickupBlock').slideToggle();
    $('.deliveryBlock').slideToggle();
})

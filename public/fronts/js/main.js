function height(){
  var parent = $('.oneItem');
    for(var i = 0; i < parent.length; i++){
      var man = $(parent[i]).find('.height1').outerHeight();
      var dan = $(parent[i]).find('.collectionAside').outerHeight();
      var dan2 = $(parent[i]).find('.collectionAside');
      if(dan > man){
        dan2.css('height', man);
        $(parent[i]).find('.lifeItemMob').css('height', man - 360);
        $(parent[i]).find('.lifeItemMob').css('overflow', 'hidden');
      }
    }
}
window.onload = function(){
  if(screen.width > 992){
    height();
  }
}

$(function() {
  function listImg(){
    var mainImg = $('img.mainImg'),
        controlImg = $('#controlZoomImg')
    for(var i = 0; i<mainImg.length; i++){
        $( controlImg ).append( '<img src="' + $(mainImg[i]).attr('src') + '" alt="" class="mainImg">' );
    }
  }
  listImg();
    var mainImg = $('img.mainImg');
    var zoomImg = $('img.zoomImg');
    var juliaZoom = $('.julia-zoom');
    var bigParent = $('#cover');
    var controlsMassive = $('#controlZoomImg img.mainImg');
    var srcControl = $('#controlZoomImg img.mainImg');
    var srcMainImg = $('img.zoomImg').attr('src');
    mainImg.click(function() {
        zoomImg.attr('src', $(this).attr('src'));
        for(var i = 0; i<controlsMassive.length; i++){

            if($(srcControl[i]).attr('src') === $('img.zoomImg').attr('src')){
              $(srcControl[i]).addClass('activeMainImg');
            }
            else{
                $(srcControl[i]).removeClass('activeMainImg');
            }
        }
        bigParent.css('display','none');
        juliaZoom.show();
        return false;
    });
    juliaZoom.mousemove(function(e){
        var ham = $(this).find('img.zoomImg').height();
        var vpnHeight = $(document).height();
        var y = -((ham - vpnHeight)/vpnHeight) * e.pageY;

        $(this).css('top', y + "px");
    });
    juliaZoom.click(function(){
        juliaZoom.hide();
         bigParent.css('display','block');
         location.reload();
    });
});



$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});


function setChekedValue() {
    var baci = document.getElementsByClassName('fucked');
     for(var i=0; i<baci.length; i++){
       if($(baci[i]).prop('checked')){
         var baga = $(baci[i]).next('.sizeCheckmark').children('.dat').text();
         $(baci[i]).parents('.lifeDescr').children('.selSize').text(baga);
         $(baci[i]).parents('.lifeDescr').children('.selSize').removeClass('select-none')
      }
    }
}


$(document).on('scroll', function(){
    var header = $('.header');
    var headerHome = $('.headerHome');
      if($(window).scrollTop() < 50){
        header.removeClass('headerHome');
      }
      if($(window).scrollTop() > 50){
          header.addClass('headerHome');
      }
});

$(document).ready(function(){
    $('.bannerSlide').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      arrows: true,
      dots: true,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            arrows: true,
            dots: false
          }
        }
      ]
    });
    var taba = $('.slideCollectionItem')
     for(var i = 0; i<taba.length; i++){

       console.log($(taba[i]))
       if(taba.length < 4){
         $(taba[i]).css('opacity', 1)
       }
     }
});

$(document).ready(function(){
$('.slideMob').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 5000,
  arrows: false,
  dots: true,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        slidesToShow: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        slidesToShow: 1
      }
    }
  ]
});
});

$(document).ready(function(){
$('.slideCollection').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 3000,
  arrows: false,
  dots: true,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        slidesToShow: 1
      }
    }
  ]
});
});
$().ready(function(){
  $('.plus').on('click', function(){
      man = $(this).prev().prev().val();
      man++;
      $(this).prev().prev().val(man);
  });
  $('.minus').on('click', function(){
      men = $(this).prev().val();
      if(men > 1){
      men--;
      $(this).prev().val(men);
    }
  });
  });
  $(document).ready(function(){
    var dat = $('.slideNav');
        for(var i = 0; i < dat.length; i++){
          var gafgaf = $(dat[i]).find('.itemNav.slick-active');
          var gafgaf2 = $(dat[i]).find('.itemNav.slick-slide');
          if(gafgaf2.length > 4){
            gafgaf2.css('visibility', 'hidden');
            gafgaf.css('visibility', 'visible');
          }
        }
    });
  $(document).ready(function(){
    var navSlide = $(".slideNav").children(".slick-track"),
        item = $(".slick-slide")
     for(var i=0; i<navSlide.length; i++){
       var navItem = $(navSlide[i]).children('.slick-slide');
       console.log(navItem)
       // if(navItem.length < 3){
       //   console.log(navItem);
       // }
     }

  });
  $(document).ready(function(){
        $(".foterItem h6").click(function(){
          $(this).next("ul").toggle(500);
          $(this).toggleClass('minusw');
        });
  });
  $(document).ready(function(){
        $(".dropDet").click(function(){
          $('.pad').animate({
            height: "toggle"
          });
          $(this).toggleClass('bcgUp');
        });
  });
  $(document).ready(function(){
    $(document).on('click', '.selSize',function(){
      $(this).next(".lifeItemPop").toggle(500);
    });
    $(document).on('click', ".itemPop3", function(){
      $(this).parent().parent().parent().hide(500);
    });
  });
  $(document).mouseup(function (e)
  {
      var container = $(".lifeItemPop");
      if (!$(".selSize").is(e.target)
          && !container.is(e.target)
          && container.has(e.target).length === 0)
      {
          container.hide(500);
      }
  });
  $(document).on('click', '.open-selects', function(){
      $(".lifeItemPop").toggle(500);
  });

$(document).ready(function(){
  $(".deletItem").click(function(){
    $(this).parents(".cartUserItem").hide();
  });
});
document.addEventListener("DOMContentLoaded", function(event) {
  $(".mainMenu > ul > li").hover(function(){
    $(this).toggleClass('hoverIcon');
  });
  });
function man(){
  $(".submenu2").css('display', 'none');
  $(".submenuButton").removeClass('submenuBcgMinus');
}
      function closeNav(event){
        var n = $(".submenu2").children('ul').children('li').children('a');
        // console.log(event);
        if(event.target.classList.length < 2 && !n.is(event.target)){
          man();
          event.target.classList.add('submenuBcgMinus');
          event.target.children[0].style.display = 'block';
          // console.log(event.target.classList.length)
        }
        else if(event.target.classList.length > 1){
          event.target.classList.remove('submenuBcgMinus');
          event.target.children[0].style.display = 'none';
        }
      }
      $(document).mouseover(function (e)
      {
          var container = $(".kakta");
          if (!container.is(e.target)
              && container.has(e.target).length === 0)
          {
            $(".submenu2").css('display', 'none');
            $(".submenuButton").removeClass('submenuBcgMinus');
          }
      });
$(document).ready(function(){
  $(".denWishSet").click(function(){
    $(this).parent().parent().next(".wishSet").animate({
      height: "toggle"
    });
    $(this).toggleClass('submenuBcgMinus');
  });
});
$(document).ready(function(){
  $(".setDetMobile > div:first-child").click(function(){
    $(this).parent().parent().parent().parent().parent().parent().children(".setDetMobileOpen").animate({
      height: "toggle"
    });
    $(this).toggleClass('submenuBcgMinus');
  });
});
$(document).ready(function(){
  $(".delWish").click(function(){
    $(this).parent().parent().parent().hide();
  });
});
$(document).on('click', '.namSetButton' ,function(){
$(this).parent().parent().parent().parent().children(".detSet").animate({
  height: "toggle"
});
$(this).toggleClass('submenuBcgMinus');
});
$(document).ready(function(){
  $(".deletItem3").click(function(){
    $(this).parent().parent().parent().parent().parent().hide();
  });
});
$(document).ready(function(){
  $(".deletItem2").click(function(){
    $(this).parent().parent().parent().parent().hide();
  });
});
$(document).ready(function(){
  $(".option").click(function(){
    $(this).next(".optionOpen").animate({
      height: "toggle"
    });
    $(this).toggleClass('submenuBcgMinus');
  });
});
$(document).ready(function(){
  $(".chCat").click(function(){
    $(this).next(".chooseCatOpenMob").animate({
      height: "toggle"
    });
  });
  $(".closeModalMenu").click(function(){
    $(this).parent().parent().animate({
      height: "toggle"
    });
  });
  $(".namSetRetur").click(function(){
    $(this).parent().parent().children(".returSetOpen").animate({
      height: "toggle"
    });
    $(this).toggleClass('submenuBcgMinus');
  });
});
$(document).mouseup(function (e)
{
    var container = $(".chooseCatOpenMob");
    if (!$(".chCat").is(e.target)
        && !container.is(e.target)
        && container.has(e.target).length === 0)
    {
        container.hide(500);
    }
});
$(document).ready(function(){
  $(".chCat2").click(function(){
    $(this).next(".chooseCatOpenMob2").animate({
      height: "toggle"
    });
  });
});
$(document).mouseup(function (e)
{
    var container = $(".chooseCatOpenMob2");
    if (!$(".chCat2").is(e.target)
        && !container.is(e.target)
        && container.has(e.target).length === 0)
    {
        container.hide(500);
    }
});

$(document).ready(function(){
  $(".modalButton1").click(function(){
    $(".modalOpen1").toggle(500);
  });
  $(".closeModalMenu1").click(function(){
    $(".modalOpen1").toggle(500);
  });
  $(document).mouseup(function (e)
  {
      var container = $(".modalOpen1");
      if (!$(".modalButton1").is(e.target)
          && !container.is(e.target)
          && container.has(e.target).length === 0)
      {
          container.hide(500);
      }
  });
});
$(document).ready(function(){
  $(document).on('click', ".modalButton4", function(){
    $(".modalOpen4").toggle(500);
  });
  $(document).on('click', '.closeModalMenu5', function(){
    $(".modalOpen4").toggle(500);
  });
  $(document).mouseup(function (e)
  {
      var container = $(".modalOpen4");
      if (!$(".modalButton4").is(e.target)
          && !container.is(e.target)
          && container.has(e.target).length === 0)
      {
          container.hide(500);
      }
  });
});



$(document).ready(function(){
  $(".modalButton2").click(function(){
    $(".modalOpen2").toggle(500);
  });
  $(".closeModalMenu2").click(function(){
    $(".modalOpen2").toggle(500);
  });
});
$(document).mouseup(function (e)
{
    var container = $(".modalOpen2");
    if (!$(".modalButton2").is(e.target)
        && !container.is(e.target)
        && container.has(e.target).length === 0)
    {
        container.hide(500);
    }
});



$(document).ready(function(){
  $(".modalButton3").click(function(){
    $(".modalOpen3").toggle(500);
  });
  $(document).on('click', ".closeModalMenu3", function(){
    $(".modalOpen3").toggle(500);
  });
  $('.slick-current').hover(function() {
    $(".bannerRet").toggle(500);
});
$(document).ready(function(){
  if(screen.width < 992){
    $('.sal').next("ul").hide();
    $(".sal").click(function(){
      $(this).next("ul").animate({
        height: "toggle"
      });
    });
  }
});
$(document).ready(function(){
  if(screen.width < 992){
    $('.bag').next(".radSer").hide();
    $(".bag").click(function(){
      $(this).next(".radSer").animate({
        height: "toggle"
      });
    });
  }
});
  $(document).mouseup(function (e)
  {
      var container = $(".modalOpen3");
      if (!$(".modalButton3").is(e.target)
          && !container.is(e.target)
          && container.has(e.target).length === 0)
      {
          container.hide(500);
      }
  });
});


$(document).ready(function(){
  $(".burger").click(function(){
    $(".submenu6").toggle(500);
  });
  $(".closeModalMenu4").click(function(){
    $(".submenu6").toggle(500);
  });
});

$(document).mouseup(function (e)
{
    var container = $(".submenu6");
    if (!$(".burger").is(e.target)
        && !container.is(e.target)
        && container.has(e.target).length === 0)
    {
        container.hide(500);
    }
});

$(document).ready(function(){
  $(".filtrButton").click(function(){
    $(".filteruDressOpen").animate({
      height: "toggle"
    });
  });
  $(".closeFiltr").click(function(){
    $(".filteruDressOpen").animate({
      height: "toggle"
    });
  });
});
$(document).ready(function(){
  $(".lang").click(function(){
    $(this).next(".langOpen").animate({
      height: "toggle"
    });
  });
});
$(document).mouseup(function (e)
{
    var container = $(".langOpen");
    if (!$(".lang").is(e.target)
        && !container.is(e.target)
        && container.has(e.target).length === 0)
    {
        container.hide();
    }
});

jQuery(document).ready(function($) {
  var contHeight = $('.delivery2');
  var sidebarHeight = $('.delivery1');
  var getContentHeight = contHeight.outerHeight();
  var getSidebarHeight = sidebarHeight.outerHeight();
  if (getContentHeight > getSidebarHeight) {
    sidebarHeight.css('min-height', getContentHeight);
    }
  if (getSidebarHeight > getContentHeight) {
    contHeight.css('min-height', getSidebarHeight);
    }
});
jQuery(document).ready(function($) {
  var contHeight = $('.hft');
  var sidebarHeight = $('.example3');
  var getContentHeight = contHeight.outerHeight();
  var getSidebarHeight = sidebarHeight.outerHeight();
  // console.log(getContentHeight);
    sidebarHeight.css('height', getContentHeight - 400);
});
  if(screen.width > 768){
    $(document).on('mouseenter', '.searchImg', function(){
      $(this).children(".wishBloc").animate({
       height: "toggle"
      });
      $(this).children(".wishBloc").show();
  }).on('mouseleave', '.searchImg', function(){
      $(this).children(".wishBloc").hide();
  });
  }
  else{
    $(".wishBloc").css('display', 'block');
    $(".wishBloc").css('position', 'static');
  }

$(document).ready(function(){
  $(".artImg").click(function(){
    var src = $(this).children('img').attr('src');
    $(this).parent().parent().parent().children('a').children('img').attr('src', src);
  });
});
$(document).ready(function(){
  $(".imgSet").click(function(){
    var src = $(this).children('img').attr('src');
    $(this).parent().parent().parent().parent().parent().parent().children('.bc').children('img').attr('src', src);

  });
});

$(document).ready(function(){
  $(".opt").click(function(){
    $(this).next(".optionFiltrOpen").animate({
      height: "toggle"
    });
    $(this).toggleClass('submenuBcgMinus');
  });
});
$(document).ready(function(){
  $(document).on('click', ".detMob", function(){
    $(this).parent().next(".lifeItemMob").animate({
      height: "toggle"
    });
    $(this).toggleClass('detMobUp');
    if ($(this).hasClass('detMobUp')) {
        $(this).text($(this).data('show'));
    }else{
        $(this).text($(this).data('hidden'));
    }
  });
});
$(document).ready(function(){
  $(".btnBlog").click(function(){
    $(this).next(".blogOptions").animate({
      height: "toggle"
    });
    $(this).toggleClass('submenuBcgMinus');
  });
});
$(document).ready(function(){
  $(".btnFiltr").click(function(){
    $(".filterOpen").show(300);
  });
  $(".closeFiltr2, .closeFiltr").click(function(){
    $(".filterOpen").hide(500);
  });
  $(".filtrCollection, .filtrCollection2").click(function(){
    $(".filterOpen").toggle(300);
  });
});
$(document).ready(function(){
  var galop = $('.oneItem');

 for(var i = 0; i<galop.length; i++){
   console.log($(galop[i]))
   var cam = $(galop[i]).find('div.slidOr');
   var camNav = $(galop[i]).find('div.slideNav');
   cam.addClass('slideOr' + i);
   camNav.addClass('slideNav' + i)
   if (screen.width > 768){
     $('.slideOr' + i).slick({
       slidesToShow: 1,
       slidesToScroll: 1,
       arrows: false,
       dots: false,
       waitForAnimate: false,
       asNavFor: '.slideNav' + i
     });
     $('.slideNav' + i).slick({
       slidesToShow: 3,
       slidesToScroll: 1,
       arrows: true,
       dots: false,
       asNavFor: '.slideOr' + i,
       focusOnSelect: true,
       centerMode: true,
       waitForAnimate: false
     });
   }
   else{
     $('.slideOr' + i).slick({
       slidesToShow: 1,
       slidesToScroll: 1,
       arrows: false,
       dots: false,
       waitForAnimate: false
     });
     $('.slideNav' + i).slick({
       slidesToShow: 3,
       slidesToScroll: 1,
       arrows: true,
       dots: false,
       focusOnSelect: true,
       centerMode: true,
       waitForAnimate: false
     });
   }
 }
});

$(document).on('click', '.cart-alert', function(){
  $(this).parents('.searchImg').find('.product-alert').show();
  $(this).parents('.searchImg').find('.filterSize').effect("shake");
  // $(this).parents('.oneItem').find('.lifeItemMob').css('display', 'bclock');
  $(this).parents('.response-item').find('.select-none').effect("shake");
});
  var gambit = 0;
  var gambit2 = 0;
  $(document).on('click', '#btnTopCart', function(){
      if(gambit < 0){
          gambit += 140;
        $(this).parent().next().find('.wishScrollBlock').css('top', gambit + 'px');

      }
  });
  $(document).on('click', '#btnBottomCart', function(){
    var heightParent = $(this).parent().parent().find('.wishScrollBlock').height();
      var heightChild = $(this).parent().parent().find('.wishScrollBlock').children('.cartMenu').outerHeight();
      if(gambit > -(heightParent - heightChild * 2)){
            gambit -= 140;
        $(this).parent().parent().find('.wishScrollBlock').css('top', gambit + 'px');

      }
  });
  $(document).on('click', '#btnTopWish', function(){
      if(gambit2 < 0){
        gambit2 += 140;
        $(this).parent().next().find('.wishScrollBlock').css('top', gambit2 + 'px');
      }
  });
  $(document).on('click', '#btnBottomWish', function(){
    var heightParent = $(this).parent().parent().find('.wishScrollBlock').height();
      var heightChild = $(this).parent().parent().find('.wishScrollBlock').children('.cartMenu').outerHeight();
      if(gambit2 > -(heightParent - heightChild * 2)){
        gambit2 -= 140;
        $(this).parent().parent().find('.wishScrollBlock').css('top', gambit2 + 'px');

      }
  });

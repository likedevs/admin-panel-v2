$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
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
  dots: true
});
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
$(document).ready(function() {
  $('.slidOr').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    dots: false,
    asNavFor: '.slideNav'
  });
  $('.slideNav').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    asNavFor: '.slidOr',
    centerMode: true,
    focusOnSelect: true
  });
});

$(document).ready(function(){
$('.slideCollection').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  centerMode: true,
  autoplay: true,
  autoplaySpeed: 5000,
  arrows: false,
  dots: true,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        centerMode: true,
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
    $(".selSize").click(function(){
      $(this).next(".lifeItemPop").toggle(500);
    });
    $(".itemPop3").click(function(){
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
$(document).ready(function(){
  $(".deletItem").click(function(){
    $(this).parents(".cartUserItem").hide();
  });
});
$(document).ready(function(){
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

        if(event.target.classList.length < 2 && !n.is(event.target)){
          man();
          event.target.classList.add('submenuBcgMinus');
          event.target.children[0].style.display = 'block';

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
$(document).ready(function(){
  $(".namSetButton").click(function(){
    $(this).parent().parent().parent().parent().children(".detSet").animate({
      height: "toggle"
    });
    $(this).toggleClass('submenuBcgMinus');
  });
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
  $(".modalButton4").click(function(){
    $(".modalOpen4").toggle(500);
  });
  $(".closeModalMenu5").click(function(){
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
  $(".closeModalMenu3").click(function(){
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
  var contHeight = $('.slidesCol');
  var sidebarHeight = $('.lifeStyleAside');
  var getContentHeight = contHeight.outerHeight();
  var getSidebarHeight = sidebarHeight.outerHeight();

  if(screen.width > 992){
    sidebarHeight.css('height', getContentHeight - 20);
  }
});

jQuery(document).ready(function($) {
  var contHeight = $('.hft');
  var sidebarHeight = $('.example3');
  var getContentHeight = contHeight.outerHeight();
  var getSidebarHeight = sidebarHeight.outerHeight();

    sidebarHeight.css('height', getContentHeight - 400);
});
$(document).ready(function(){
  if(screen.width > 768){
    $(".searchImg").hover(function(){
      $(this).children(".wishBloc").animate({
        height: "toggle"
      });
    });
  }
  else{
    $(".wishBloc").css('display', 'block');
    $(".wishBloc").css('position', 'static');
  }
});

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
  $(".detMob").click(function(){
    $(this).parent().next(".lifeItemMob").animate({
      height: "toggle"
    });
    $(this).toggleClass('detMobUp');
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
  var baci = document.getElementsByClassName('fucked');
   for(var i=0; i<baci.length; i++){
     if($(baci[i]).prop('checked')){
       var baga = $(baci[i]).next('.sizeCheckmark').children('.dat').text();
       console.log(baga)
       $(baci[i]).parents('.lifeDescr').children('.selSize').text(baga);
    }
  }
});

  // for(var i=0; i<baci.length; i++){
  //   var tagd = $('.centr').children('.baci');
  //     for(var j=0; j<tagd.length; j++){
  //       console.log(tagd[j])
  //       if(tagd[j].children('.sizeRadio').children('input').attr(':checked')){
  //         console.log('este')
  //       }
  //     }
  // }
$(".zoom").elevateZoom({
  zoomType				: "inner",
  cursor: "crosshair"
});
$(document).ready(function(){
  var x = $('img');
  var y = $('.zoomContainer')
  if(screen.width < 768){
    x.removeAttr('data-zoom-image');
    x.removeClass('zoom');
    y.remove();
  }
});

// $(document).ready(function(){
//       if(screen.width < 768){
//         $('.pad').hide();
//       }
// });

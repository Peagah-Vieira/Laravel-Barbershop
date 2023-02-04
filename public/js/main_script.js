$(document).ready(function(){
    $('.slider').slick({
      arrows:true,
      dots:true,
      slidesToShow: 5,
      slidesToScroll: 3,
      speed: 1000,
      easing: 'ease',
      autoplay: true,
      autoplaySpeed: 2000,
      responsive:[
        {
          breakpoint: 1000,
          settings:{
            slidesToShow: 3
          }
        },  
        {
          breakpoint: 850,
          settings:{
            slidesToShow: 2
          }
        },
        {
          breakpoint: 640,
          settings:{
            slidesToShow: 1
          }
        }
      ]
    });
  });
  
  var btn = $('#button');
  
  $(window).scroll(function() {
    if ($(window).scrollTop() > 1000) {
      btn.addClass('show');
    } else {
      btn.removeClass('show');
    }
  });
  
  btn.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({scrollTop:0}, '300');
  });
  
  
  $(document).ready(function() {
    $('.header_burger').click(function(event) {
      $('.header_burger,.menu').toggleClass('active');
      $('body').toggleClass('lock');
    })
  });
  $('.menu').click(function(){
      $('.header_burger, .menu').removeClass('active');
      $('body').removeClass('lock');
  });
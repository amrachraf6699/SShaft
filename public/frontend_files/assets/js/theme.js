(function ($) {
    
    "use strict";
    if($('section').hasClass('main-slider')) {
        var swiper = new Swiper('.main-slider .swiper-container', {
        slidesPerView: 1,
        loop: true,
        effect: "fade",
        pagination: {
            el: "#main-slider-pagination",
            type: "bullets",
            clickable: true
        },
              autoplay: {
                    delay: 5000
                }
      });
    
        var is_hover = false;
      $('.main-slider').mouseenter(function(){
        swiper.autoplay.stop();
      });
      $('.main-slider').mouseleave(function(){
          console.log('yes');
          setTimeout(() => {
              if (!!$('.quick-modal').parents('.modal').
              filter(function() { return $(this).is(":hover"); }).length) {
                is_hover = true;
              } else {
                is_hover = false;
              }
              if (is_hover) {
                swiper.autoplay.stop();
              } else {
                swiper.autoplay.start();
              }
          },500);
      });
    }

    if ($(".scroll-to-target").length) {
      $(".scroll-to-target").on("click", function () {
        var target = $(this).attr("data-target");
        // animate
        $("html, body").animate({
          scrollTop: $(target).offset().top
        },
          1000
        );

        return false;
      });
    }

    if ($(".contact-form-validated").length) {
      $(".contact-form-validated").validate({
        // initialize the plugin
        rules: {
          name: {
            required: true
          },
          email: {
            required: true,
            email: true
          },
          message: {
            required: true
          },
          subject: {
            required: true
          }
        },
        submitHandler: function (form) {
          // sending value with ajax request
          $.post($(form).attr("action"), $(form).serialize(), function (
            response
          ) {
            $(form).parent().find(".result").append(response);
            $(form).find('input[type="text"]').val("");
            $(form).find('input[type="email"]').val("");
            $(form).find("textarea").val("");
          });
          return false;
        }
      });
    }

    // mailchimp form
    if ($(".mc-form").length) {
      $(".mc-form").each(function () {
        var Self = $(this);
        var mcURL = Self.data("url");
        var mcResp = Self.parent().find(".mc-form__response");

        Self.ajaxChimp({
          url: mcURL,
          callback: function (resp) {
            // appending response
            mcResp.append(function () {
              return '<p class="mc-message">' + resp.msg + "</p>";
            });
            // making things based on response
            if (resp.result === "success") {
              // Do stuff
              Self.removeClass("errored").addClass("successed");
              mcResp.removeClass("errored").addClass("successed");
              Self.find("input").val("");

              mcResp.find("p").fadeOut(10000);
            }
            if (resp.result === "error") {
              Self.removeClass("successed").addClass("errored");
              mcResp.removeClass("successed").addClass("errored");
              Self.find("input").val("");

              mcResp.find("p").fadeOut(10000);
            }
          }
        });
      });
    }

    if ($(".video-popup").length) {
      $(".video-popup").magnificPopup({
        disableOn: 700,
        type: "iframe",
        mainClass: "mfp-fade",
        removalDelay: 160,
        preloader: true,

        fixedContentPos: false
      });
    }

    if ($(".img-popup").length) {
      var groups = {};
      $(".img-popup").each(function () {
        var id = parseInt($(this).attr("data-group"), 10);

        if (!groups[id]) {
          groups[id] = [];
        }

        groups[id].push(this);
      });

      $.each(groups, function () {
        $(this).magnificPopup({
          type: "image",
          closeOnContentClick: true,
          closeBtnInside: false,
          gallery: {
            enabled: true
          }
        });
      });
    }

    function dynamicCurrentMenuClass(selector) {
      let FileName = window.location.href.split("/").reverse()[0];

      selector.find("li").each(function () {
        let anchor = $(this).find("a");
        if ($(anchor).attr("href") == FileName) {
          $(this).addClass("current");
        }
      });
      // if any li has .current elmnt add class
      selector.children("li").each(function () {
        if ($(this).find(".current").length) {
          $(this).addClass("current");
        }
      });
      // if no file name return
      if ("" == FileName) {
        selector.find("li").eq(0).addClass("current");
      }
    }
    if ($(".main-menu__list").length) {
      // dynamic current class
      let mainNavUL = $(".main-menu__list");
      dynamicCurrentMenuClass(mainNavUL);
    }

    if ($(".mobile-nav__container").length) {
      let navContent = document.querySelector(".main-menu").innerHTML;
      let mobileNavContainer = document.querySelector(".mobile-nav__container");
      mobileNavContainer.innerHTML = navContent;
    }
    if ($(".sticky-header__content").length) {
      let navContent = document.querySelector(".main-menu").innerHTML;
      let mobileNavContainer = document.querySelector(".sticky-header__content");
      mobileNavContainer.innerHTML = navContent;
    }

    if ($(".mobile-nav__container .main-menu__list").length) {
      let dropdownAnchor = $(
        ".mobile-nav__container .main-menu__list .dropdown > a"
      );
      dropdownAnchor.each(function () {
        let self = $(this);
        let toggleBtn = document.createElement("BUTTON");
        toggleBtn.setAttribute("aria-label", "dropdown toggler");
        toggleBtn.innerHTML = "<i class='fa fa-angle-down'></i>";
        self.append(function () {
          return toggleBtn;
        });
        self.find("button").on("click", function (e) {
          e.preventDefault();
          let self = $(this);
          self.toggleClass("expanded");
          self.parent().toggleClass("expanded");
          self.parent().parent().children("ul").slideToggle();
        });
      });
    }

    if ($(".mobile-nav__toggler").length) {
      $(".mobile-nav__toggler").on("click", function (e) {
        e.preventDefault();
        $(".mobile-nav__wrapper").toggleClass("expanded");
      });
    }

    if ($(".search-toggler").length) {
      $(".search-toggler").on("click", function (e) {
        e.preventDefault();
        $(".search-popup").toggleClass("active");
      });
    }
    if ($(".odometer").length) {
      $(".odometer").appear(function (e) {
        var odo = $(".odometer");
        odo.each(function () {
          var countNumber = $(this).attr("data-count");
          $(this).html(countNumber);
        });
      });
    }

    if ($(".wow").length) {
      var wow = new WOW({
        boxClass: "wow", // animated element css class (default is wow)
        animateClass: "animated", // animation css class (default is animated)
        mobile: true, // trigger animations on mobile devices (default is true)
        live: true // act on asynchronously loaded content (default is true)
      });
      wow.init();
    }

    if ($("#donate-amount__predefined").length) {
      let donateInput = $("#donate-amount");
      $("#donate-amount__predefined")
        .find("li")
        .on("click", function (e) {
          e.preventDefault();
          let amount = $(this).find("a").text();
          donateInput.val(amount);
          $("#donate-amount__predefined").find("li").removeClass("active");
          $(this).addClass("active");
        });
    }

    $("#accordion .collapse").on("shown.bs.collapse", function () {
      $(this).prev().addClass("active");
    });

    $("#accordion .collapse").on("hidden.bs.collapse", function () {
      $(this).prev().removeClass("active");
    });

    $("#accordion").on("hide.bs.collapse show.bs.collapse", (e) => {
      $(e.target).prev().find("i:last-child").toggleClass("fa-plus fa-minus");
    });




    // window load event

    $(window).on("load", function () {
      if ($(".preloader").length) {
        $(".preloader").fadeOut();
      }
      // swiper slider

      const swiperElm = document.querySelectorAll(".thm-swiper__slider");

      swiperElm.forEach(function (swiperelm) {
        const swiperOptions = JSON.parse(swiperelm.dataset.swiperOptions);
        let thmSwiperSlider = new Swiper(swiperelm, swiperOptions);
      });

      if ($("#testimonials-two__thumb").length) {
        let testimonialsThumb = new Swiper("#testimonials-two__thumb", {
          slidesPerView: 3,
          spaceBetween: 0,
          speed: 1400,
          watchSlidesVisibility: true,
          watchSlidesProgress: true,
          loop: true,
          autoplay: {
            delay: 5000
          }
        });

        let testimonialsCarousel = new Swiper("#testimonials-two__carousel", {
          observer: true,
          observeParents: true,
          speed: 1400,
          mousewheel: true,
          slidesPerView: 1,
          autoplay: {
            delay: 5000
          },
          thumbs: {
            swiper: testimonialsThumb
          }
        });
      }


    });

    // window load event

    $(window).on("scroll", function () {
      if ($(".stricked-menu").length) {
        var headerScrollPos = 130;
        var stricky = $(".stricked-menu");
        if ($(window).scrollTop() > headerScrollPos) {
          stricky.addClass("stricky-fixed");
        } else if ($(this).scrollTop() <= headerScrollPos) {
          stricky.removeClass("stricky-fixed");
        }
      }
    });


    // pop up for  "اهداء تبرع"
    $('#exampleModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient = button.data('whatever') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    });

    /* -- Dashboard menu -- *
    if ($('div').hasClass('.main-dashboard')) {
        const navigationOptions = [
          {
            name: 'البيانات الشخصية',
            color: '#5B37B7'
          },
    
          {
            name: 'سجل التبرعات',
            color: '#72C17C'
          },
    
          {
            name: 'سلة التبرعات',
            color: '#E6A919'
          },
    
          {
            name: 'تسجيل الخروج',
            color: '#1892A6'
          }];
    
        // target all anchor link elements
        const links = document.querySelectorAll('nav a');
    
        // function called in response to a click event on the anchor link
        function handleClick(e) {
          // prevent the default behavior, but most importantly remove the class of .active from those elements with it
          e.preventDefault();
          links.forEach(link => {
            if (link.classList.contains('active')) {
              link.classList.remove('active');
            }
          });
    
    
          const name = this.textContent.trim().toLowerCase();
          const { color } = navigationOptions.find(item => item.name === name);
    
          // retrieve the custom property for the --hover-c property, to make it so that the properties are updated only when necessary
          const style = window.getComputedStyle(this);
          const hoverColor = style.getPropertyValue('--hover-c');
          // if the two don't match, update the custom property to show the hue with the text and the semi transparent background
          if (color !== hoverColor) {
            this.style.setProperty('--hover-bg', `${color}20`);
            this.style.setProperty('--hover-c', color);
          }
    
          // apply the class of active to animate the svg an show the span element
          this.classList.add('active');
    
        }
    
        // function called in response to a click event on the anchor link
        function handleHover(e) {
          // prevent the default behavior, but most importantly remove the class of .active from those elements with it
          links.forEach(link => {
            if (link.classList.contains('hover')) {
              link.classList.remove('hover');
            }
          });
    
    
          const name = this.textContent.trim().toLowerCase();
          const { color } = navigationOptions.find(item => item.name === name);
    
          // retrieve the custom property for the --hover-c property, to make it so that the properties are updated only when necessary
          const style = window.getComputedStyle(this);
          const hoverColor = style.getPropertyValue('--hover-c');
          // if the two don't match, update the custom property to show the hue with the text and the semi transparent background
          if (color !== hoverColor) {
            this.style.setProperty('--hover-bg', `${color}20`);
            this.style.setProperty('--hover-c', color);
          }
    
          // apply the class of active to animate the svg an show the span element
          this.classList.add('hover');
    
        }
    
        // listen for a click event on each and every anchor link
        links.forEach(link => link.addEventListener('click', handleClick));
        links.forEach(link => link.addEventListener('mouseenter', handleHover));
    
        $('.main-dashboard nav a').mouseleave(function(){
          $(this).removeClass('hover');
        });
    }
    /* -- ./Dashboard menu -- */

    /* -- shopping cart -- */
    $('.shopping-cart .count input').each(function(){
      var input_val = $(this).val();
      var one_price = parseInt($(this).parent().siblings('.sub-price').text());
      if (input_val <= 1 ) {
        $(this).siblings('.minus').addClass('none');
      }
      var temp = (input_val * one_price) + ' ر.س';
      $(this).parent().siblings('.sub-total').text(temp);
    });
    function calcTotal() {
      var all_total = 0;
      setTimeout(() => {
        $('.sub-total').each(function(){
          all_total += parseInt($(this).text());
          var temp_all = all_total + ' ر.س';
          $('.all-total').text(temp_all);
        });
      }, 50);
    }
    calcTotal();
    $('.shopping-cart .count .plus').on('click',function(){
      var input_val = $(this).siblings('input').val();
      var one_price = parseInt($(this).parent().siblings('.sub-price').text());
      input_val ++;
      $(this).siblings('input').val(input_val);
      if (input_val > 1 ) {
        $(this).siblings('.minus').removeClass('none');
      }
      var temp = (input_val * one_price) + ' ر.س';
      $(this).parent().siblings('.sub-total').text(temp);
      calcTotal();
    });

    $('.shopping-cart .count .minus').on('click',function(){
      var input_val = $(this).siblings('input').val();
      var one_price = parseInt($(this).parent().siblings('.sub-price').text());
      if (input_val == 2 ) {
        $(this).addClass('none');
        input_val --;
        $(this).siblings('input').val(input_val);
        var temp = (input_val * one_price) + ' ر.س';
        $(this).parent().siblings('.sub-total').text(temp);
        calcTotal();
      } else if(input_val > 2) {
        input_val --;
        $(this).siblings('input').val(input_val);
        var temp = (input_val * one_price) + ' ر.س';
        $(this).parent().siblings('.sub-total').text(temp);
        calcTotal();
      }
    });
    /* -- ./Shopping cart -- */

    /* -- Add Member -- */
    var member_num = 1;
    $('.request-form .member-btn button.delete').addClass('none');
    $('.request-form .member-btn button.add').on('click',function(){
      member_num ++;
      var temp = '<li> <div class="form-group"> <p class="number">الفرد رقم <span>' + member_num +  '</span></p> <div class="form-control"><span>الاسم:</span><input type="text" name="memberName' + member_num +'" placeholder="الاسم"></div><!-- /.form-control --><div class="form-control"><span>رقم الهوية :</span><input type="number" name="memberIdentNum' + member_num + '"  placeholder="رقم الهوية"></div><!-- /.form-control --></div></li>';
      $( temp ).appendTo( ".request-form.form-one .list-group" );
      $('.request-form .member-btn button.delete').removeClass('none');
    });
    $('.request-form .member-btn button.delete').on('click',function(){
      if (member_num == 2) {
        member_num --;
        $('.request-form.form-one .list-group li:last-child').remove();
        $('.request-form .member-btn button.delete').addClass('none');
      } else if (member_num > 2) {
        member_num --;
        $('.request-form.form-one .list-group li:last-child').remove();
      }

    });
    /* -- ./Add Member -- */

  /* -- Another cost to causes home page part -- */
  $('.causes-home .radio-btn li.count input[type="number"]').change(function(){
      var item_cost = $(this).parent().siblings('.another-cost').children('input[type="number"]').val();
      if(item_cost > 0) {
        var item_num = $(this).val();
        var all_total_cost = item_num * item_cost,
            new_temp  = all_total_cost + ' ر.س';

        $(this).parent().parent().siblings('.cause-card__bottom').children('.total').text(new_temp);
      }
    });
    $('.causes-home .radio-btn li input[type="radio"]').on('click',function(){
        $(this).parent().parent().siblings('.cause-card__bottom').children('.total').children('input').val($(this).val());
        $(this).parent().siblings('.count').children('input[type="number"]').val(1);
        if ($(this).parent().hasClass('another-cost')) {
          $('.causes-page .cause-card__bottom span.total input').attr('readonly',false);
        } else {
          $('.causes-page .cause-card__bottom span.total input').attr('readonly',true);
        }
    });
    $('.causes-page .cause-card__bottom span.total input').on('keyup',function(){
      $(this).parents('.cause-card__bottom').siblings('ul').children('.another-cost').children('input').prop('checked','checked');
    })
    /* -- ./Another cost to causes home page part -- */

    /* -- fly to shopping cart -- */
    $('.add-to-cart').on('click', function () {
      var cart = $('.main-shopping-cart').eq(0);
      if ($(window).scrollTop() > 130) {
          cart = $('.main-shopping-cart').eq(1);
      }
      var imgtodrag = $(this).closest('.cause-card').find("img").eq(0);
      if (imgtodrag) {
        var imgclone = imgtodrag.clone().
        offset({
          top: imgtodrag.offset().top,
          left: imgtodrag.offset().left }).

        css({
          'opacity': '0.5',
          'position': 'absolute',
          'z-index': '9999999',
          'height': '150px',
          'width': '150px' }).

        appendTo($('body')).
        animate({
          'top': cart.offset().top + 10,
          'left': cart.offset().left + 10,
          'width': 75,
          'height': 75 },
        1000, 'easeInOutExpo');

        setTimeout(function () {
          cart.addClass("shake");
        }, 1500);
        setTimeout(() => {
          cart.removeClass("shake");
        }, 2500);

        imgclone.animate({
          'width': 0,
          'height': 0 },
        function () {
          $(this).detach();
        });
      }
    });
    $('.main-services .service-block a.add-cart').on('click', function () {
      var cart = $('.main-shopping-cart').eq(0);
      if ($(window).scrollTop() > 130) {
          cart = $('.main-shopping-cart').eq(1);
      }
      var imgtodrag = $(this).closest('.service-block').find("i").eq(0);
      if (imgtodrag) {
        var imgclone = imgtodrag.clone().
        offset({
          top: imgtodrag.offset().top,
          left: imgtodrag.offset().left }).

        css({
          'opacity': '0.8',
          'color' : '#f80',
          'position': 'absolute',
          'z-index': '9999999',
          'font-size' : '40px'
        }).

        appendTo($('body')).
        animate({
          'top': cart.offset().top + 10,
          'left': cart.offset().left + 10,
          'width': 75,
          'height': 75 },
        1000, 'easeInOutExpo');

        setTimeout(function () {
          cart.addClass("shake");
        }, 1500);
        setTimeout(() => {
          cart.removeClass("shake");
        }, 2500);

        imgclone.animate({
          'width': 0,
          'height': 0 },
        function () {
          $(this).detach();
        });
      }
    });
    /* -- ./fly to shopping cart -- */


    /* -- Show/close socail media list on mobile -- */
    $('.socail-links li.whatsapp span').on('click',function(){
      $('.socail-links').toggleClass('open');
    });
    /* -- ./Show/close socail media list on mobile -- */

    $('.alert-msg button').on('click',function(){
      $(this).parents('.alert-msg').removeClass('open');
    });

    $('.templates-area li').on('click',function(){
      if(!$(this).is(':first-child')) {
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
        $(this).children('input').prop('checked','checked');
      }
    });

    $('.templates-area li img').on('click',function(){
      var img_src = $(this).attr('src');
      $('.image-popup img').attr('src',img_src);
      $('.image-popup').addClass('open');
    });
    $('.image-popup .overlay-img').on('click',function(){
      $('.image-popup').removeClass('open');
    });

    $('.main-slider .quick-dontaion button').on('click',function(){
        var input_money_val = $(this).parents('.quick-dontaion').find('input[type="number"]').val();
        var service_id = $(this).data('id');
        var price_value = $(this).data('price_value');
        if(input_money_val > 0 && price_value === 'fixed') {
          $('.quick-modal form input[type="number"]').val(input_money_val);
          $('.quick-modal form input.service-id').val(service_id);
          $('.quick-modal form input[type="number"]').attr('readonly', true);
        }
    });

    $('.shopping-cart thead input[type="checkbox"]').on('click',function(){
      var selected_items = [];
      if($(this).is(':checked')) {
        $(this).parents('table').children('tbody').find('input[type="checkbox"]').each(function(){
          $(this).prop('checked','checked');
          selected_items.push($(this).val());
        });
      } else {
        $(this).parents('table').children('tbody').find('input[type="checkbox"]').each(function(){
          $(this).prop('checked',false);
        });
        selected_items = [];
      }
      $('input[name="ids"]').val(selected_items);
    });

    $('.shopping-cart tbody input[type="checkbox"]').on('click',function(){
      var selected_items = [];
      $('.shopping-cart thead input[type="checkbox"]').prop('checked','checked');
      $('.shopping-cart tbody input[type="checkbox"]').each(function(){
        if (!$(this).is(':checked')) {
          $('.shopping-cart thead input[type="checkbox"]').prop('checked',false);
        } else {
          selected_items.push($(this).val());
        }
      });
      $('input[name="ids"]').val(selected_items);
    });


    $('.service-form .thm-btn').on('click',function(){
      var cost = 0,
          price_amount = 0;
      var count = $(this).parents('.service-form').find('li.count').children('input').val();
        price_amount = $(this).parents('.service-form').find('.radio-btn').children('li.another-cost').children('input[type="number"]').val();
      cost = price_amount * count;
      $('.pay-now-modal .quick-modal .quick-amount input').val(price_amount);
      $('.pay-now-modal .quick-modal input#quantityNum').val(count);
      $('.pay-now-modal .quick-modal input#totalNum').val(cost);
    });


    $('.pay-now-modal .quick-modal input#quantityNum').on('change',function(){
        var input_count = $(this).val(),
            single_price = $(this).parents('.quick-modal').find('.amountNum').val(),
            all_total = single_price * input_count;
       $(this).parents('.quick-modal').find('#totalNum').val(all_total);
    });

    $('.pay-now-modal .quick-modal input.amountNum').on('change',function(){
        var single_price  = $(this).val(),
             input_count  = $(this).parents('.quick-modal').find('#quantityNum').val(),
            all_total = single_price * input_count;
       $(this).parents('.quick-modal').find('#totalNum').val(all_total);
    });

    $('.main-services .service-block a.pay-now').on('click',function(){
        var one_cost = parseInt($(this).parents('.service-block').find('.price-service').text());
         $('.pay-now-modal .quick-modal .quick-amount input').val(one_cost);
          $('.pay-now-modal .quick-modal input#quantityNum').val(1);
          $('.pay-now-modal .quick-modal input#totalNum').val(one_cost);
    });

    // start changes
    /* -- Side Quick Donation -- */
    $.fn.inputFilter = function(inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
        if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
            this.value = "";
        }
        });
    };

    $(".side-donation .number-input").inputFilter(function(value) {
        return /^\d*$/.test(value); });

    $('.side-donation .payment-amount li span').on('click',function(){
        var amount = parseInt($(this).text());
        $('.side-donation .input-payment input').val(amount);
    });
    $('.side-donation .donate-now.toggle-btn').on('click',function(){
        var amount = $('.side-donation .input-payment input').val();
        if (amount > 0) {
        $('.side-donation small.danger').slideUp(500);
        $('.side-donation .second-part').addClass('open');
        $('.side-donation .title .left-block input').val(amount);
        } else {
        $('.side-donation small.danger').slideDown(500);
        var valid_timer = setInterval(() => {
            amount = $('.side-donation .input-payment input').val();
            if (amount > 0) {
            $('.side-donation small.danger').slideUp(500);
            clearInterval(valid_timer);
            }
        }, 1000);
        }
    });
    $('.side-donation .open-donation').on('click',function(){
        if($('.side-donation').hasClass('open')) {
            $('.side-donation .second-part').removeClass('open'); // Change
        $('.side-donation .hidden-part').slideUp(500);
        setTimeout(() => {
            $('.side-donation').removeClass('open');
        }, 500);
        } else {
        $('.side-donation').addClass('open');
        setTimeout(() => {
            $('.side-donation .hidden-part').slideDown(500);
        }, 500);
        }
    });
    /* -- ./Side Quick Donation -- */
    
    /* -- Changes -- */
    // Quick Dontation
    $('.side-donation .title .close-payment').on('click',function(){
        $('.side-donation .second-part').removeClass('open');
    });
    $('.service-form .radio-btn li.count').each(function(){
       var input_val = $(this).children('input').val();
        if (input_val == 1) {
            $(this).find('.minus-btn').addClass('cant');  
        }
    });
    $('.service-form .radio-btn li.count .add-btn').on('click',function(){
        var input_val = $(this).parents('.count').children('input').val();
        if (input_val == 1) {
            $(this).siblings('.minus-btn').removeClass('cant');  
        }
        input_val++;
        $(this).parents('.count').children('input').val(input_val);
    });
    $('.service-form .radio-btn li.count .minus-btn').on('click',function(){
        var input_val = $(this).parents('.count').children('input').val();
        if (input_val > 1) {
            input_val--;
            $(this).parents('.count').children('input').val(input_val);
        }
        if (input_val == 1) {
            $(this).addClass('cant');  
        }
    });
   navigator.saysWho = (() => {
      const { userAgent } = navigator;
      let match = userAgent.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
      let temp;
    
      if (/trident/i.test(match[1])) {
        temp = /\brv[ :]+(\d+)/g.exec(userAgent) || [];
    
        return `IE ${temp[1] || ''}`;
      }
    
      if (match[1] === 'Chrome') {
        temp = userAgent.match(/\b(OPR|Edge)\/(\d+)/);
    
        if (temp !== null) {
          return temp.slice(1).join(' ').replace('OPR', 'Opera');
        }
    
        temp = userAgent.match(/\b(Edg)\/(\d+)/);
    
        if (temp !== null) {
          return temp.slice(1).join(' ').replace('Edg', 'Edge (Chromium)');
        }
      }
    
      match = match[2] ? [ match[1], match[2] ] : [ navigator.appName, navigator.appVersion, '-?' ];
      temp = userAgent.match(/version\/(\d+)/i);
    
      if (temp !== null) {
        match.splice(1, 1, temp[1]);
      }
    
      return match.join(' ');
    })();
    
   if (!navigator.saysWho.toLowerCase().includes('safari')) {
       $('input[name="payment_ways"][value="APPLEPAY"]').parent().remove();
   }
    /* -- ./Changes -- */
    
  })(jQuery);


    <!-- move top -->
   
      <script>
        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function () {
          scrollFunction()
        };
  
        function scrollFunction() {
          if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("movetop").style.display = "block";
          } else {
            document.getElementById("movetop").style.display = "none";
          }
        }
  
        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
          document.body.scrollTop = 0;
          document.documentElement.scrollTop = 0;
        }
      </script>
      <!-- /move top -->
  
    <!-- jQuery and Bootstrap JS -->
    <script src="{{ $web_source }}/js/jquery-3.3.1.min.js"></script>
    <script src="{{ $web_source }}/js/bootstrap.min.js"></script>
  
    <!-- Template JavaScript -->
  
    <!-- stats number counter-->
    <script src="{{ $web_source }}/js/jquery.waypoints.min.js"></script>
    <script src="{{ $web_source }}/js/jquery.countup.js"></script>
    <script>
      $('.counter').countUp();
    </script>
    <!-- //stats number counter -->
  
  
    <!-- testimonials owlcarousel -->
    <script src="{{ $web_source }}/js/owl.carousel.js"></script>
  
    <!-- script for owlcarousel -->
    <script>
      $(document).ready(function () {
        $('.owl-one').owlCarousel({
          loop: true,
          margin: 0,
          nav: false,
          responsiveClass: true,
          autoplay: false,
          autoplayTimeout: 5000,
          autoplaySpeed: 1000,
          autoplayHoverPause: false,
          responsive: {
            0: {
              items: 1,
              nav: false
            },
            480: {
              items: 1,
              nav: false
            },
            667: {
              items: 1,
              nav: false
            },
            1000: {
              items: 1,
              nav: false
            }
          }
        })
      })
    </script>
    <!-- //script for owlcarousel -->
    <!-- //testimonials owlcarousel -->
  
    <!-- script for courses -->
    <script>
      $(document).ready(function () {
        $('.owl-two').owlCarousel({
          loop: true,
          margin: 30,
          nav: false,
          responsiveClass: true,
          autoplay: false,
          autoplayTimeout: 5000,
          autoplaySpeed: 1000,
          autoplayHoverPause: false,
          responsive: {
            0: {
              items: 1,
              nav: false
            },
            480: {
              items: 1,
              nav: false
            },
            667: {
              items: 2,
              nav: false
            },
            1000: {
              items: 3,
              nav: false
            }
          }
        })
      })
    </script>
    <!-- //script for courses -->
  
    <!-- disable body scroll which navbar is in active -->
    <script>
      $(function () {
        $('.navbar-toggler').click(function () {
          $('body').toggleClass('noscroll');
        })
      });
    </script>
    <!-- disable body scroll which navbar is in active -->
  
    <!-- gallery lightbox -->
    <script src="{{ $web_source }}/js/smartphoto.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const sm = new SmartPhoto(".js-img-viwer", {
          showAnimation: false
        });
        // sm.destroy();
      });
    </script>
    <!-- gallery lightbox -->


    <script>
      $(".select_role").on("click" , function(){
          $(".select_role").removeClass("selected");
          $(this).addClass("selected");
          $("#roleInput").val($(this).attr("data-role"));
          $("#select_role_form").trigger("submit");
      });

      $(".downloading_media").on("submit" , function(){
          $(".modal").modal('hide');
          $("#download_media_progress").modal('show');
      });
  </script>
  @yield('script')
  
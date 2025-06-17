<div class="footer py-3 bottom-0 m-0" style="background:#514f57">
  <div class="flex xxsm:flex-wrap xsm:flex-wrap msm:flex-wrap 3xl:mx-52 2xl:mx-28 1xl:mx-28 xl:mx-36 xlg:mx-32 lg:mx-36 xxmd:mx-24 xmd:mx-32 sm:mx-20 msm:mx-16 xsm:mx-10 xxsm:mx-5 justify-between md:mx-28 py-3 pt-4">
    
    <!-- Quick Links Dropdown -->
    <div class="flex justify-between items-center sm:items-left w-auto">
      <ul class="flex lg:flex-row xmd:flex-row md:flex-row md:text-xs md:-space-x-3 sm:flex-row msm:flex-row xsm:flex-col xxsm:flex-col msm:space-x-3 sm:space-x-2 lg:space-x-10 md:mt-0">
        <li class="mt-2">
          <a href="{{ url('/') }}" class="md:px-3 capitalize font-poppins font-normal text-base leading-6 text-white">{{ __('Home') }}</a>
        </li>
       @php
            $isWebUser = Auth::check();
        @endphp
        
        @if ($isWebUser)
            <a href="{{ url('/organization/home') }}"
               class="nav-link md:px-1 capitalize font-poppins font-normal text-base leading-6 text-white"
               >
                {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
            </a>
        @else
            <li class="mt-2">
                <a href="{{ url('/user/login') }}"
                   class="md:px-3 capitalize font-poppins font-normal text-base leading-6"
                   style="color: #ffffff;"> {{-- White color --}}
                   {{ __('Organiser') }}
                </a>
            </li>
        @endif


        
        <li class="mt-2">
          <a href="{{ url('/partners') }}" class="md:px-3 capitalize font-poppins font-normal text-base leading-6 text-white flex">{{ __('Partners') }}</a>
        </li>
        <li class="mt-2">
          <a href="{{ url('/about') }}" class="md:px-3 capitalize font-poppins font-normal text-base leading-6 text-white flex">{{ __('About Us') }}</a>
        </li>
        
        <li class="mt-2">
          <a href="{{ url('/all-events') }}" class="md:px-3 capitalize font-poppins font-normal text-base leading-6 text-white flex">{{ __('Browse Events') }}</a>
        </li>
        
        <li class="mt-2">
          <a href="{{ url('user/login') }}" class="md:px-3 capitalize font-poppins font-normal text-base leading-6 text-white flex">{{ __('List Your Event') }}</a>
        </li>
        
        <!-- Quick Links Dropdown (Now Opens Upwards) -->
        <li class="mt-2 relative group quick-links">
          <a href="javascript:void(0);" class="md:px-3 capitalize font-poppins font-normal text-base leading-6 text-white flex items-center">
            {{ __('Quick Links') }}
            <img src="{{ asset('images/downwhite.png') }}" class="w-3 h-2 mx-2 rotate-180" alt="">  <!-- Rotate icon upwards -->
          </a>
          <ul class="absolute bottom-full mb-2 left-0 bg-white rounded-md shadow-lg w-56 hidden group-hover:block quick-links-dropdown z-50">
            <li>
              <a href="{{ url('/privacy_policy') }}" class="block px-4 py-2 text-black hover:bg-gray-200">{{ __('Privacy Policy') }}</a>
            </li>
            <li>
              <a href="{{ url('/term-and-condition') }}" class="block px-4 py-2 text-black hover:bg-gray-200">{{ __('Terms & Conditions') }}</a>
            </li>
            <li>
              <a href="{{ url('/refund-and-cancellation-policy') }}" class="block px-4 py-2 text-black hover:bg-gray-200">{{ __('Refund & Cancellation Policy') }}</a>
            </li>
          </ul>
        </li>

        <!-- Dropdown End -->

        <li class="mt-2">
          <a href="{{ url('/all-blogs') }}" class="md:px-3 capitalize font-poppins font-normal text-base leading-6 text-white">{{ __('Blog') }}</a>
        </li>
        <li class="mt-2">
          <a href="{{ url('/contact') }}" class="md:px-3 capitalize font-poppins font-normal text-base leading-6 text-white">{{ __('Contact') }}</a>
        </li>
        <li class="mt-2">
          <a href="{{ url('/user/FAQs') }}" class="md:px-3 capitalize font-poppins font-normal text-base leading-6 text-white">{{ __("FAQ's") }}</a>
        </li>
        <li class="mt-2">
          <a href="{{ url('/landing') }}" class="md:px-3 capitalize font-poppins font-normal text-base leading-6 text-white">{{ __("Landing") }}</a>
        </li>
      </ul>
    </div>

    <!-- Social Media Links -->
    <div class="flex items-center space-x-4">
      <a href="https://www.facebook.com/profile.php?id=61573913758004" target="_blank" class="text-white hover:text-gray-300">
        <i class="fab fa-facebook-f"></i>
      </a>
      <!--<a href="https://twitter.com" target="_blank" class="text-white hover:text-gray-300">-->
      <!--  <i class="fab fa-twitter"></i>-->
      <!--</a>-->
      <a href="https://www.instagram.com/next.happen/" target="_blank" class="text-white hover:text-gray-300">
        <i class="fab fa-instagram"></i>
      </a>
      <a href="https://www.linkedin.com/company/next-happen" target="_blank" class="text-white hover:text-gray-300">
        <i class="fab fa-linkedin-in"></i>
      </a>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    let quickLinks = document.querySelector(".quick-links");
    let dropdownMenu = document.querySelector(".quick-links-dropdown");

    if (quickLinks && dropdownMenu) {
      quickLinks.addEventListener("click", function () {
        dropdownMenu.classList.toggle("hidden");
      });

      // Hide dropdown if clicked outside
      document.addEventListener("click", function (event) {
        if (!quickLinks.contains(event.target) && !dropdownMenu.contains(event.target)) {
          dropdownMenu.classList.add("hidden");
        }
      });
    }
  });
</script>
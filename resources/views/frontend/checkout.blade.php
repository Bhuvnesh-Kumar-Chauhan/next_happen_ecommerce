@extends('frontend.master', ['activePage' => 'checkout'])
@section('title', __('Checkout'))
@section('content')


    <style>
    .pt-14 {
        padding-top: 7.5rem;
    }

    @media (min-width: 1220px) {
        .xl\:mx-36 {
            margin-left: 15rem;
            margin-right: 15rem;
        }
    }
    </style>
    {{-- content --}}
    <div class="pb-20 bg-scroll min-h-screen" style="background-image: url('images/events.png')">
        {{-- scroll --}}
        <div id="stripe_message" class="bg-danger text-white text-center p-2 hidden"></div>
        <div class="mr-4 flex justify-end z-30">
            <a type="button" href="{{ url('#') }}"
                class="scroll-up-button bg-primary rounded-full p-4 fixed z-20  2xl:mt-[49%] xl:mt-[59%] xlg:mt-[68%] lg:mt-[75%] xxmd:mt-[83%] md:mt-[90%]
                xmd:mt-[90%] sm:mt-[117%] msm:mt-[125%] xsm:mt-[160%]">
                <img src="{{ asset('images/downarrow.png') }}" alt="" class="w-3 h-3 z-20">
            </a>
        </div>

        <input type="hidden" name="totalAmountTax" id="totalAmountTax" value="{{ $data->totalAmountTax }}">
        <input type="hidden" name="totalPersTax" id="totalPersTax" value="{{ $data->totalPersTax }}">
        <input type="hidden" name="flutterwave_key" value="{{ \App\Models\PaymentSetting::find(1)->ravePublicKey }}">
        
        <div id="ticketorder">

            @csrf
            <input type="hidden" id="razor_key" name="razor_key"
                value="{{ \App\Models\PaymentSetting::find(1)->razorPublishKey }}">
            <input type="hidden" id="stripePublicKey" name="stripePublicKey"
                value="{{ \App\Models\PaymentSetting::find(1)->stripePublicKey }}">
            <input type="hidden" value="{{ $data->ticket_per_order }}" name="tpo" id="tpo">
            <input type="hidden" value="{{ $data->available_qty }}" name="available" id="available">
            <input type="hidden" name="price" id="ticket_price" value="{{ $data->price }}">

            <input type="hidden" name="tax" id="tax_total" value="{{ $data->type == 'free' ? 0 : $data->tax_total }}">
            <input type="hidden" name="payment" id="payment"
                value="{{ $data->type == 'free' ? 0 : $data->price + $data->tax_total }}">
            @php
                $price = $data->price + $data->tax_total;
                if ($data->currency_code == 'USD' || $data->currency_code == 'EUR' || $data->currency_code == 'INR') {
                    $price = $price * 100;
                }
            @endphp
            <input type="hidden" name="stripe_payment" id="stripe_payment"
                value="{{ $data->type == 'free' ? 0 : $price }}">
            <input type="hidden" name="currency_code" id="currency_code" value="{{ $data->currency_code }}">
            <input type="hidden" name="currency" id="currency" value="{{ $currency }}">
            <input type="hidden" name="payment_token" id="payment_token">
            <input type="hidden" name="ticket_id" id="ticket_id" value="{{ $data->id }}">
            <input type="hidden" name="selectedSeats" id="selectedSeats">
            <input type="hidden" name="selectedSeatsId[]" id="selectedSeatsId">
            <input type="hidden" name="coupon_id" id="coupon_id" value="">
            <input type="hidden" name="coupon_discount" id="coupon_discount" value="0">
            <input type="hidden" name="subtotal" id="subtotal" value="">
            <input type="hidden" name="add_ticket" value="">
            <input type="hidden" class="tax_data" id="tax_data" name="tax_data" value="{{ $data->tax }}">
            <input type="hidden" name="event_id" value="{{ $data->event_id }}">
            <input type="hidden" name="ticketname" id="ticketname" value="{{ $data->name }}">

            <div class="mt-10 3xl:mx-52 2xl:mx-28 1xl:mx-28 xl:mx-36 xlg:mx-32 lg:mx-36 xxmd:mx-24 xmd:mx-32 md:mx-28 sm:mx-20 msm:mx-16 xsm:mx-10 xxsm:mx-5 z-10 relative">
                <div class="flex sm:space-x-6 msm:space-x-0 xxsm:space-x-0 xlg:flex-row lg:flex-col xmd:flex-col xxsm:flex-col">
                    <div class="xlg:w-[35%] xxmd:w-full xxsm:w-full">
                        <div class="flex 3xl:flex-row 2xl:flex-nowrap 1xl:flex-nowrap xl:flex-nowrap xlg:flex-wrap flex-wrap justify-between 3xl:pt-5 xl:pt-5 gap-x-5 xl:w-full xlg:w-full">
                            <div class="">
                                <div class="w-full shadow-lg p-6 rounded-lg flex flex-wrap bg-white mb-6" >
                                    <!-- Event Details -->
                                    <div class="ml-0 sm:ml-6 flex-1 2xl:w-[60%] xl:w-full xlg:w-full xmd:w-full xxmd:w-[80%]" style="background-color: #f9f9f9;">
                                        <p class="font-poppins font-semibold text-2xl leading-8 text-black pb-3">
                                            {{ $data->event->name }}
                                        </p>
                                        <div class="flex justify-between items-start gap-x-5 flex-wrap">

                                            {{-- Price Section --}}
                                            <div>
                                                @if ($data->type == 'paid')
                                                    <p class="font-poppins font-medium text-sm text-danger">
                                                        {{ __('Paid') }}
                                                    </p>
                                                    <p class="font-poppins font-semibold text-3xl text-primary pt-2">
                                                        {{ $data->currency . $data->price }}
                                                    </p>
                                                @else
                                                    <p class="font-poppins font-medium text-sm text-success">
                                                        {{ __('Free') }}
                                                    </p>
                                                @endif
                                            </div>
                                        
                                            @if ($data->seatmap_id == null || $data->module->is_enable == 0)
                                                <div class="pt-0">
                                                    <p class="font-poppins font-medium text-base text-black">
                                                        {{ __('Quantity') }}
                                                    </p>
                                                    <div class="flex flex-row h-10 mt-2 rounded-lg pro-qty">
                                                        <button
                                                            id="dec-{{ $data->id }}"
                                                            data-action="decrement"
                                                            type="button"
                                                            class="qtybtn dec border border-primary bg-primary-light text-primary hover:text-black h-8 w-9 flex items-center justify-center"
                                                        >
                                                            <span class="text-2xl font-thin">−</span>
                                                        </button>
                                        
                                                        <input
                                                            type="number"
                                                            id="quantity"
                                                            name="quantity"
                                                            readonly
                                                            value="1"
                                                            class="bg-primary-light text-center w-12 font-semibold text-md text-primary h-8 focus:outline-none"
                                                        >
                                        
                                                        <button
                                                            id="inc-{{ $data->id }}"
                                                            data-action="increment"
                                                            type="button"
                                                            class="qtybtn inc border border-primary bg-primary-light text-primary hover:text-black h-8 w-9 flex items-center justify-center"
                                                        >
                                                            <span class="text-2xl font-thin">+</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        
                                        </div>
                                        
                                        
                                    </div>
                                
                                    <!-- Pricing and Quantity -->
                                    
                                </div>
                                
                                <div
                                    class="w-full shadow-lg p-5 rounded-lg flex 3xl:flex-nowrap md:flex-wrap xxmd:flex-nowrap sm:flex-wrap msm:flex-wrap xsm:flex-wrap xxsm:flex-wrap bg-white xlg:w-full xmd:w-full 3xl:mb-0 xl:mb-0 xlg:mb-5 xxsm:mb-5" >
                                    
                                        
                                    <style>
                                      .scrollable-content {
                                        max-height: 60vh; /* Modal ke andar scroll ke liye */
                                        overflow-y: auto;
                                        -webkit-overflow-scrolling: touch; /* Mobile ke liye smooth scrolling */
                                        padding: 10px;
                                      }
                                      .bg-primary {
                                            --tw-bg-opacity: 1;
                                            background-color: #dc354b;
                                        }
                                    </style>
                                    
                                    <div class="ml-8 2xl:w-[60%] xl:w-full xlg:w-full xmd:w-full xxmd:w-[80%]" style="background-color: #f9f9f9;">
                                      <!-- Buttons remain same -->
                                      <button id="openTermsModal" class="text-black font-semibold text-lg flex items-center space-x-1 mb-4">
                                        <span>Terms & Conditions</span>
                                        <span>➔</span>
                                      </button>
                                    
                                      <button id="openDisclaimerModal" class="text-black font-semibold text-lg flex items-center space-x-1 mb-6">
                                        <span>Disclaimer</span>
                                        <span>➔</span>
                                      </button>
                                    
                                      <!-- Terms Modal - Perfect Scrollable Version -->
                                      <div id="termsModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden" >
                                        <div class="bg-white rounded-2xl shadow-2xl w-[90%] sm:w-[80%] md:w-[70%] lg:w-[60%] xl:w-[50%] h-[80vh] flex flex-col" style="background-color: #f9f9f9;">
                                          <!-- Header with close button -->
                                          <div class="flex justify-between items-center border-b p-6 sticky top-0 bg-white z-10">
                                            <h2 class="text-2xl font-bold">Terms & Conditions</h2>
                                            <button id="closeTermsModal" class="text-3xl font-bold text-gray-600 hover:text-black -mt-2">&times;</button>
                                          </div>
                                          
                                          <!-- Perfect Scrollable Content Area -->
                                          <div class="flex-1 p-6 scrollable-content">
                                            <div class="text-gray-700 text-left font-poppins font-medium text-base leading-7 space-y-6">
                                              {!! $termsandcondition->first()->description ?? 'No Terms And Conditions At That Time' !!}
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    
                                      <!-- Disclaimer Modal - Same Structure -->
                                      <div id="disclaimerModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden" >
                                        <div class="bg-white rounded-2xl shadow-2xl w-[90%] sm:w-[80%] md:w-[70%] lg:w-[60%] xl:w-[50%] h-[80vh] flex flex-col" style="background-color: #f9f9f9;">
                                          <div class="flex justify-between items-center border-b p-6 sticky top-0 bg-white z-10">
                                            <h2 class="text-2xl font-bold">Disclaimer</h2>
                                            <button id="closeDisclaimerModal" class="text-3xl font-bold text-gray-600 hover:text-black -mt-2">&times;</button>
                                          </div>
                                          
                                          <div class="flex-1 p-6 scrollable-content">
                                            <div class="text-gray-700 text-left font-poppins font-medium text-base leading-7 space-y-4">
                                              {!! $disclaimer->first()->disclaimer ?? 'No Disclaimer At That Time' !!}
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    
                                      <script>
                                        // JavaScript remains same
                                        function setupModal(openButtonId, modalId, closeButtonId) {
                                          const openButton = document.getElementById(openButtonId);
                                          const modal = document.getElementById(modalId);
                                          const closeButton = document.getElementById(closeButtonId);
                                    
                                          openButton.addEventListener("click", () => modal.classList.remove("hidden"));
                                          closeButton.addEventListener("click", () => modal.classList.add("hidden"));
                                          
                                          window.addEventListener("click", (e) => {
                                            if (e.target === modal) modal.classList.add("hidden");
                                          });
                                        }
                                    
                                        setupModal("openTermsModal", "termsModal", "closeTermsModal");
                                        setupModal("openDisclaimerModal", "disclaimerModal", "closeDisclaimerModal");
                                      </script>
                                    </div>

                                </div>
                                
                                @if ($data->seatmap_id != null && $data->module->is_install == 1 && $data->module->is_enable == 1)
                                    @include('seatmap::seatmapView', [
                                        'seat_map' => $data->seat_map,
                                        'rows' => $data->rows,
                                        'seatsByRow' => $data->seatsByRow,
                                        'seatLimit' => $data->ticket_per_order,
                                    ])
                                @endif
                                
                            </div>
                        </div>
                    </div>
                    <style>
                        .py-5 {
                            padding-top: 0.75rem;
                            padding-bottom: 0.75rem;
                        }
                    </style>
                    @if ($data->type == 'paid')

                        <div class="xlg:w-[35%] xxmd:w-full xxsm:w-full">
                            <div class="p-4 bg-white shadow-lg rounded-md space-y-5" style="background-color: #f9f9f9;">
                                <p class="font-poppins font-semibold text-xl leading-8 text-black">
                                    {{ __('Payment Summary') }}</p>
                                <div
                                    class="flex justify-between border border-primary rounded-md py-5 xxsm:flex-wrap sm:flex-nowrap xlg:px-0" style="justify-content: space-end;align-items: center;">
                                    <input type="text" value="" name="coupon_code" id="coupon_code" onchange="couponCodeChange()"
                                        class="focus:outline-none font-poppins font-normal text-base leading-6 text-white-100 ml-5 1xl:w-44 xl:w-36
                                xlg:w-28" style="background-color: #f9f9f9;"
                                        placeholder="{{ __('Coupon Code') }}">
                                    <button type="button" id="apply" name="apply"
                                        class="font-poppins font-medium text-base leading-6 text-primary focus:outline-none mr-5">{{ __('Apply') }}</button>
                                </div>
                                <div class="couponerror"></div>
                                <p class="font-poppins font-semibold text-base leading-6 text-black ">
                                    {{ __('Taxes and Charges') }}</p>
                                <div class="taxes  border border-primary rounded-md p-2">

                                    @foreach ($data->tax as $key => $item)
                                        <input type="hidden" class="amount_type" name="amount_type"
                                            value="{{ $item->amount_type }}">
                                        <div class="flex justify-between">
                                            <p class="font-poppins font-normal text-lg leading-6 text-gray-200 ">
                                                {{ $item->name }}
                                                @if ($item->amount_type == 'percentage')
                                                    ({{ $item->price . '%' }})
                                                @endif
                                            </p>
                                            <p class="font-poppins font-medium text-lg leading-6 text-gray-300">
                                                @if ($item->amount_type == 'percentage')
                                                    @php
                                                        $result = ($data->price * $item->price) / 100;
                                                        $formattedResult = round($result, 2);
                                                    @endphp
                                                    {{ $currency }} {{ $formattedResult }}
                                                @else
                                                    {{ $currency }} {{ $item->price }}
                                                @endif
                                            </p>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="flex justify-between">
                                    <p class="font-poppins font-normal text-lg leading-6 text-gray-200">
                                        {{ __('Total Tax amount') }}</p>
                                    <p class="font-poppins font-medium text-lg leading-6 text-gray-300 totaltax">
                                        {{ $currency }} {{ $data->tax_total }}
                                    </p>
                                </div>
                                <div class="flex justify-between">
                                    <p class="font-poppins font-normal text-lg leading-6 text-gray-200">
                                        {{ __('Tickets amount') }}</p>
                                    <p class="font-poppins font-medium text-lg leading-6 text-gray-300">
                                        {{-- @if ($data->seatmap_id == null) --}}
                                        {{ $currency }} {{ $data->price }}
                                        {{-- @endif --}}
                                    </p>
                                </div>

                                <div class="flex justify-between border-dashed border-b border-gray-light pb-5">
                                    <p class="font-poppins font-normal text-lg leading-6 text-gray-200">
                                        {{ __('Coupon discount') }}</p>
                                    <p class="font-poppins font-medium text-lg leading-6 text-gray-300 discount">00.00</p>
                                </div>
                                <div class="flex justify-between">
                                    <p
                                        class="font-poppins font-semibold text-xl leading-6 text-primary xlg:text-lg 1xl:text-xl">
                                        {{ __('Total amount') }}</p>
                                    <p
                                        class="font-poppins font-semibold text-2xl leading-6 text-primary xlg:text-lg 1xl:text-2xl subtotal">
                                        @if ($data->seatmap_id == null || $data->module->is_enable == 0)
                                            {{ $currency }} {{ $data->price + $data->tax_total }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @if ($data->available_qty > 0)
                                    <div
                                        class="w-full shadow-lg p-5 rounded-lg  bg-white xlg:w-full xmd:w-full 3xl:mb-0 xl:mb-0 xlg:mb-5 xxsm:mb-5 mt-5" >
                                        <p class="font-poppins font-semibold text-xl leading-6 text-black pb-3 pt-0">
                                            {{ __('Payment Methods') }}</p>

                                        <div
                                            class="flex md:space-x-5 md:flex-col md:space-y-0 sm:flex-col sm:space-x-0 sm:space-y-5 xxsm:flex-col xxsm:space-x-0 xxsm:space-y-5 mb-5 payments" style="background-color: #f9f9f9;">
                                            <?php $setting = App\Models\PaymentSetting::find(1); ?>
                                            @if ($data->type == 'free')
                                                @if(Auth::guard('appuser')->check())
                                                    <input type="hidden" name="email" value="{{ auth()->guard('appuser')->user()->email }}">
                                                    <input type="hidden" name="phone" value="{{ auth()->guard('appuser')->user()->phone }}">
                                                    <input type="hidden" name="name" value="{{ auth()->guard('appuser')->user()->name }}">
                                                    <div
                                                        class="border border-gray-light  p-5 rounded-lg text-gray-100 w-full font-normal font-poppins text-base leading-6 flex">
                                                        {{ __('FREE') }}
                                                        <input id="default-radio-1" required type="radio" value="FREE"
                                                            name="payment_type" 
                                                            class="ml-2 h-5 w-5 mr-2 border border-gray-light  hover:border-gray-light focus:outline-none">
                                                    </div>
                                                @else
                                                    <div class="border border-gray-light p-5 rounded-lg text-gray-100 w-full font-normal font-poppins text-base leading-6">
                                                        <div class="flex flex-wrap -mx-2">
                                                            <div class="w-full md:w-1/3 px-2 mb-4">
                                                                <label class="font-poppins font-normal text-sm text-gray-200 leading-8 block">
                                                                    {{ __('Full Name') }}
                                                                </label>
                                                                <input type="text" name="name" id="name_free" placeholder="Enter Full Name" required
                                                                    class="font-poppins font-medium text-base leading-7 text-gray w-full p-2 border rounded">
                                                            </div>
                                                            <div class="w-full md:w-1/3 px-2 mb-4">
                                                                <label class="font-poppins font-normal text-sm text-gray-200 leading-8 block">
                                                                    {{ __('Email') }}
                                                                </label>
                                                                <input type="email" name="email" id="email_free" placeholder="Enter Email Id" required
                                                                    class="font-poppins font-medium text-base leading-7 text-gray w-full p-2 border rounded">
                                                            </div>
                                                            <div class="w-full md:w-1/3 px-2 mb-4">
                                                                <label class="font-poppins font-normal text-sm text-gray-200 leading-8 block">
                                                                    {{ __('Contact') }}
                                                                </label>
                                                                <input type="number" name="phone" id="phone_free" placeholder="Enter Contact Number"
                                                                    class="font-poppins font-medium text-base leading-7 text-gray w-full p-2 border rounded">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="border border-gray-light p-5 rounded-lg text-gray-100 w-full font-normal font-poppins text-base leading-6 mt-4">
                                                        <div class="flex items-center">
                                                            {{ __('FREE') }}
                                                            <input id="default-radio-1" required type="radio" value="FREE" name="payment_type" class="ml-2 h-5 w-5 mr-2 border border-gray-light hover:border-gray-light focus:outline-none">

                                                        </div>
                                                    </div>
                                                
                                                    <script>
                                                        const nameInput = document.getElementById('name_free');
                                                        const emailInput = document.getElementById('email_free');
                                                        const phoneInput = document.getElementById('phone_free');
                                                        const defaultRadio = document.getElementById('default-radio-1');
                                                
                                                        function toggleDefaultRadio() {
                                                            if (nameInput.value.trim() !== '' &&
                                                                emailInput.value.trim() !== '' &&
                                                                phoneInput.value.trim() !== '') {
                                                                defaultRadio.disabled = false;
                                                            } else {
                                                                defaultRadio.disabled = true;
                                                            }
                                                        }
                                                
                                                        nameInput.addEventListener('input', toggleDefaultRadio);
                                                        emailInput.addEventListener('input', toggleDefaultRadio);
                                                        phoneInput.addEventListener('input', toggleDefaultRadio);
                                                        window.addEventListener('DOMContentLoaded', toggleDefaultRadio);
                                                    </script>
                                                @endif
                                            @else
                                                @if ($setting->paypal == 1)
                                                    <div
                                                        class="border border-gray-light  p-5 rounded-lg text-gray-100 w-full font-normal font-poppins text-base leading-6 flex align-middle">
                                                        <input id="Paypal" required type="radio" value="PAYPAL"
                                                            name="payment_type"
                                                            class="h-5 w-5 mr-2 border border-gray-light  hover:border-gray-light focus:outline-none">
                                                        <label for="Paypal"><img
                                                                src="{{ asset('images/payments/paypal.svg') }}"
                                                                alt="" class="object-contain"></label>
                                                    </div>
                                                @endif

                                                @if ($setting->razor == 1)
                                                    @if(Auth::guard('appuser')->check())
                                                        <input type="hidden" name="email" value="{{ auth()->guard('appuser')->user()->email }}">
                                                        <input type="hidden" name="phone" value="{{ auth()->guard('appuser')->user()->phone }}">
                                                        <input type="hidden" name="name" value="{{ auth()->guard('appuser')->user()->name }}">
                                                        <div
                                                            class="border border-gray-light p-5 rounded-lg text-gray-100 w-full font-normal font-poppins text-base leading-6 flex">
                                                            <input id="Razor" required type="radio" value="RAZOR"
                                                                name="payment_type" disabled
                                                                class="h-5 w-5 mr-2 border border-gray-light  hover:border-gray-light focus:outline-none">
                                                            <label for="Razor"><img
                                                                    src="{{ asset('images/payments/razorpay.svg') }}"
                                                                    alt="" class="object-contain"></label>
                                                        </div>
                                                    
                                                   @else
                                                        <div class="border border-gray-light p-5 rounded-lg text-gray-100 w-full font-normal font-poppins text-base leading-6">
                                                            <div class="flex flex-wrap -mx-2">
                                                                <div class="w-full md:w-1/3 px-2 mb-4">
                                                                    <label class="font-poppins font-normal text-sm text-gray-200 leading-8 block">
                                                                        {{ __('Full Name') }}
                                                                    </label>
                                                                    <input type="text" name="name" id="name" placeholder="Enter Full Name" required
                                                                        class="font-poppins font-medium text-base leading-7 text-gray w-full p-2 border rounded">
                                                                </div>
                                                                <div class="w-full md:w-1/3 px-2 mb-4">
                                                                    <label class="font-poppins font-normal text-sm text-gray-200 leading-8 block">
                                                                        {{ __('Email') }}
                                                                    </label>
                                                                    <input type="email" name="email" id="email" placeholder="Enter Email Id" required
                                                                        class="font-poppins font-medium text-base leading-7 text-gray w-full p-2 border rounded">
                                                                </div>
                                                                <div class="w-full md:w-1/3 px-2 mb-4">
                                                                    <label class="font-poppins font-normal text-sm text-gray-200 leading-8 block">
                                                                        {{ __('Contact') }}
                                                                    </label>
                                                                    <input type="number" name="phone" id="phone" placeholder="Enter Contact Number"
                                                                        class="font-poppins font-medium text-base leading-7 text-gray w-full p-2 border rounded">
                                                                </div>
                                                                <div class="w-full px-2 mb-4">
                                                                    <label class="flex items-center space-x-2">
                                                                        <input type="checkbox" id="claimGST" class="h-5 w-5 text-blue-600 border-gray-300 rounded">
                                                                        <span class="text-sm text-gray-200 font-poppins">Do you want to claim your GST?</span>
                                                                    </label>
                                                                    <!-- Hidden input to store GST number -->
                                                                    <input type="hidden" name="gst_number" id="gst_number_hidden">
                                                                    
                                                                    <!-- Display entered GST number -->
                                                                    <div id="gstNumberDisplay" class="hidden mt-2 text-sm text-green-400"></div>
                                                                    
                                                                    <!-- GST Modal -->
                                                                    <div id="gstModal" class="hidden mt-4 bg-gray-800 p-4 rounded-lg">
                                                                        <h2 class="text-lg font-semibold mb-2 text-black">Enter GST Number</h2>
                                                                        <input type="text" id="gst_number_input" placeholder="Enter GST Number (e.g., 22AAAAA0000A1Z5)"
                                                                            class="w-full border border-gray-300 rounded p-2 text-gray-800 font-poppins">
                                                                        <div class="flex  mt-3 space-x-2" >
                                                                            <button type="button" id="cancelGST"
                                                                                class="px-4 py-2 bg-gray-600 text-black rounded hover:bg-gray-700">Cancel</button>
                                                                            <button type="button" id="saveGST"
                                                                                class="px-4 py-2 bg-blue-600 text-black rounded hover:bg-blue-700">Save</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="border border-gray-light p-5 rounded-lg text-gray-100 w-full font-normal font-poppins text-base leading-6 mt-4" style="margin-inline: auto; margin-top:10px;">
                                                            <div class="flex items-center">
                                                                <input id="Razor" required type="radio" value="RAZOR" name="payment_type"
                                                                    class="h-5 w-5 mr-2 border border-gray-light hover:border-gray-light focus:outline-none" disabled>
                                                                <label for="Razor" class="flex items-center">
                                                                    <img src="{{ asset('images/payments/razorpay.svg') }}" alt="Razorpay" class="object-contain h-8">
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <script>
                                                            const nameInput = document.getElementById('name');
                                                            const emailInput = document.getElementById('email');
                                                            const phoneInput = document.getElementById('phone');
                                                            const razorRadio = document.getElementById('Razor');
                                                            const claimGSTCheckbox = document.getElementById('claimGST');
                                                            const gstModal = document.getElementById('gstModal');
                                                            const cancelGSTBtn = document.getElementById('cancelGST');
                                                            const saveGSTBtn = document.getElementById('saveGST');
                                                            const gstNumberInput = document.getElementById('gst_number_input');
                                                            const gstNumberHidden = document.getElementById('gst_number_hidden');
                                                            const gstNumberDisplay = document.getElementById('gstNumberDisplay');

                                                            // Enable/disable Razorpay radio based on form fields
                                                            function toggleRazorRadio() {
                                                                razorRadio.disabled = !(nameInput.value.trim() && emailInput.value.trim() && phoneInput.value.trim());
                                                            }

                                                            nameInput.addEventListener('input', toggleRazorRadio);
                                                            emailInput.addEventListener('input', toggleRazorRadio);
                                                            phoneInput.addEventListener('input', toggleRazorRadio);

                                                            // Handle GST checkbox click
                                                            claimGSTCheckbox.addEventListener('change', function() {
                                                                if (this.checked) {
                                                                    if (gstNumberHidden.value) {
                                                                        // GST number already exists, show it
                                                                        gstNumberDisplay.textContent = `GST Number: ${gstNumberHidden.value}`;
                                                                        gstNumberDisplay.classList.remove('hidden');
                                                                    } else {
                                                                        // Show modal to enter GST number
                                                                        gstModal.classList.remove('hidden');
                                                                    }
                                                                } else {
                                                                    // Clear GST number and hide display
                                                                    gstNumberHidden.value = '';
                                                                    gstNumberDisplay.classList.add('hidden');
                                                                    gstModal.classList.add('hidden');
                                                                }
                                                            });

                                                            // Save GST number
                                                            saveGSTBtn.addEventListener('click', function() {
                                                                const gstNumber = gstNumberInput.value.trim();
                                                                if (gstNumber && validateGSTNumber(gstNumber)) {
                                                                    gstNumberHidden.value = gstNumber;
                                                                    gstNumberDisplay.textContent = `GST Number: ${gstNumber}`;
                                                                    gstNumberDisplay.classList.remove('hidden');
                                                                    claimGSTCheckbox.checked = true;
                                                                    gstModal.classList.add('hidden');
                                                                    gstNumberInput.value = '';
                                                                } else {
                                                                    alert('Please enter a valid GST number (e.g., 22AAAAA0000A1Z5)');
                                                                }
                                                            });

                                                            // Cancel GST entry
                                                            cancelGSTBtn.addEventListener('click', function() {
                                                                if (!gstNumberHidden.value) {
                                                                    claimGSTCheckbox.checked = false;
                                                                }
                                                                gstModal.classList.add('hidden');
                                                                gstNumberInput.value = '';
                                                            });

                                                            // Basic GST number validation
                                                            function validateGSTNumber(gstNumber) {
                                                                const gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
                                                                return gstRegex.test(gstNumber);
                                                            }

                                                            // Initialize display if GST number already exists
                                                            if (gstNumberHidden.value) {
                                                                claimGSTCheckbox.checked = true;
                                                                gstNumberDisplay.textContent = `GST Number: ${gstNumberHidden.value}`;
                                                                gstNumberDisplay.classList.remove('hidden');
                                                            }
                                                        </script>
                                                    @endif
                                                    
                                                @endif

                                                @if ($setting->stripe == 1)
                                                    <div
                                                        class="border border-gray-light p-5 rounded-lg text-gray-100 w-full font-normal font-poppins text-base leading-6 flex">
                                                        <input id="Stripe" required type="radio" value="STRIPE"
                                                            name="payment_type"
                                                            class="h-5 w-5 mr-2 border border-gray-light  hover:border-gray-light focus:outline-none">
                                                        <label for="Stripe"><img
                                                                src="{{ url('images/payments/stripe.svg') }}"
                                                                alt="" class="object-contain"></label>
                                                    </div>
                                                @endif

                                                @if ($setting->flutterwave == 1)
                                                    <div
                                                        class="border border-gray-light p-5 rounded-lg text-gray-100 w-full font-normal font-poppins text-base leading-6 flex">
                                                        <input id="Flutterwave" required type="radio"
                                                            value="FLUTTERWAVE" name="payment_type"
                                                            class="h-5 w-5 mr-2 border border-gray-light  hover:border-gray-light focus:outline-none">
                                                        <label for="Flutterwave"><img
                                                                src="{{ url('images/payments/flutterwave.svg') }}"
                                                                alt="" class="object-contain"></label>
                                                    </div>
                                                @endif

                                                @if (
                                                    $setting->cod == 1 ||
                                                        ($setting->flutterwave == 0 && $setting->stripe == 0 && $setting->paypal == 0 && $setting->razor == 0))
                                                    <div
                                                        class="border border-gray-light p-5 rounded-lg text-gray-100 w-full font-normal font-poppins text-base leading-6 flex">
                                                        <input id="Cash" type="radio" value="LOCAL"
                                                            name="payment_type"
                                                            class="h-5 w-5 mr-2 border border-gray-light  hover:border-gray-light focus:outline-none">
                                                        <label for="Cash"><img
                                                                src="{{ url('images/payments/cash.svg') }}"
                                                                alt="" class="object-contain"></label>
                                                    </div>
                                                @endif
                                                @if ($setting->wallet == 1)
                                                    <div
                                                        class="border border-gray-light p-5 rounded-lg text-gray-100 w-full font-normal font-poppins text-base leading-6 flex">
                                                        <input id="wallet" type="radio" value="wallet"
                                                            name="payment_type"
                                                            class="h-5 w-5 mr-2 border border-gray-light  hover:border-gray-light focus:outline-none">
                                                        <label for="wallet"><img
                                                                src="{{ url('images/payments/wallet.svg') }}"
                                                                alt="" class="object-contain"></label>
                                                    </div>
                                                @endif

                                            @endif
                                        </div>
                                        <div class="paypal-button-section  mt-4 mx-auto">
                                            <div id="paypal-button-container" class="hidden">

                                            </div>
                                        </div>
                                        <!-- <div class="stripe-form-section hidden mt-4  mx-auto"> -->
                                        <div class="card stripeCard hidden" id="stripeform">
                                            <div class="bg-danger text-white hidden stripe_alert rounded-lg py-5 px-6 mb-3 text-base text-red-700 inline-flex items-center w-full"
                                                role="alert">
                                                <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                    data-icon="times-circle" class="w-4 h-4 mr-2 fill-current"
                                                    role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 512 512">
                                                    <path fill="currentColor"
                                                        d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z">
                                                    </path>
                                                </svg>
                                                <div class="stripeText"></div>
                                            </div>
                                            <div class="card-body">
                                                <form method="post"
                                                    class="require-validation customform xxxl:w-[680px] s:w-[225px] m:w-[300px] l:w-[400px] sm:w-[320px] md:w-[450px] lg:w-[300px] xl:w-[540px] xxl:w-[550px]"
                                                    data-cc-on-file="false" id="stripe-payment-form">
                                                    @csrf
                                                    <div>
                                                        <div class="mb-3">
                                                            <div class="form-group">
                                                                <label for="email"
                                                                    class="font-poppins font-medium text-black text-base tracking-wide">{{ __('Email') }}</label>
                                                                <input type="email" name="card_email"
                                                                    title="Enter Your Email" placeholder="Email"
                                                                    class="email form-control required border border-gray-light focus:outline-none rounded-lg p-3 w-full mt-3" />
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="form-group">
                                                                <label for="card-number"
                                                                    class="font-poppins font-medium text-black text-base tracking-wide">{{ __('Card Information') }}</label>
                                                                <div class="form-group">
                                                                    <div id="card-number"></div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div id="card-expiry"></div>
                                                                </div>
                                                                <input type="hidden"
                                                                    class="card-expiry-month required form-control"
                                                                    name="card-expiry-month" />
                                                                <input type="hidden"
                                                                    class="card-expiry-year required form-control"
                                                                    name="card-expiry-year" />
                                                                <div class="form-group">
                                                                    <div id="card-cvc"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mt-3">
                                                                <label
                                                                    class="font-poppins font-medium text-black text-base tracking-wide ">{{ __('Name on card') }}</label>
                                                                <input type="text"
                                                                    class="required form-control border border-gray-light focus:outline-none rounded-lg p-3 w-full mt-3"
                                                                    name="card_name" placeholder="Name"
                                                                    title="Name on Card" required />
                                                            </div>
                                                        </div>
                                                        <div class="form-group text-start">
                                                            <button type="submit"
                                                                class="bg-primary l:w-[250px] h-[47px] s:w-full px-5 p-2 rounded-md cursor-pointer font-poppins font-medium text-white text-lg mt-4 btn-submit">{{ __('Pay with stripe') }}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- </div> -->
                                        <div class="mt-3">
                                            <button type="submit" id="form_submit"
                                                class="font-poppins font-medium text-lg leading-6 text-white bg-primary w-full rounded-md py-3"
                                                <?php
                                        if(!isset($_REQUEST['payment_type'])&&$setting->cod == 0 && $setting->wallet ==0 ){ ?> disabled <?php
                                        } ?>>
                                                <div id="formtext">
                                                    <i class="fa pr-2 fa-check-square"></i>{{ __('Place Order') }}
                                                </div>
                                                <div id="formloader"
                                                    class="hidden mx-auto animate-spin rounded-full border-t-2 border-blue-500 border-solid h-7 w-7">
                                                </div>
                                            </button>

                                        </div>
                                    </div>
                                @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
  
@endsection

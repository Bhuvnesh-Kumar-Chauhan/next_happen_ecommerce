@extends('frontend.master', ['activePage' => 'event'])
@section('title', __('Event Details'))

@section('content')


<div class="bg-white shadow-lg rounded-md p-4 mt-10" id="tickets">

    <div class="flex justify-between">
        <p class="font-poopins font-semibold  text-3xl leading-9 text-black">{{ __('Tickets') }}</p>
    </div>
    <div
        class="grid xl:grid-cols-4 xlg:grid-cols-3 xxmd:grid-cols-2 sm:grid-cols-2 msm:grid-cols-1 xxsm:grid-cols-1 pt-5 gap-5">
        @if (count($data->paid_ticket) != 0)

            @foreach ($data->paid_ticket as $item)
                <div class="relative rounded-lg border border-gray-light p-5 ">
                    <div class="!h-auto mb-5" style="height: auto;margin-bottom:100px;">
                        <div class="flex justify-center">
                            <p
                                class="font-poppins font-medium text-sm leading-4 text-danger text-center rounded-full bg-danger-light w-16 py-1">
                                {{ __('Paid') }}</p>
                        </div>
                        <p class="font-poppins font-medium text-xl leading-7 text-primary text-center py-4">
                            {{ $item->name }}</p>
                        <div class="flex justify-center space-x-2">
                            <span
                                class="font-poppins font-medium text-2xl leading-8 text-center text-black pt-1">{{ __($currency) }}</span>
                            <p class="font-poppins font-medium text-5xl leading-10 text-black text-center">
                                {{ $item->price }}</p>
                        </div>
                        {{-- when tickets are available --}}
                        <div class="py-4">
                            @if ($item->available_qty < 0)
                                <p
                                    class="font-poppins font-normal text-lg leading-7 text-danger text-center rounded-full bg-danger-light py-2">
                                    {{ __('No Available tickets') }}</p>
                            @else
                                <p
                                    class="font-poppins font-normal text-lg leading-7 text-success text-center bg-success-light rounded-full py-2">
                                    {{ $item->available_qty }}&nbsp{{ __('Available tickets') }}</p>
                            @endif
                        </div>
                        <p class="font-poppins font-normal text-base leading-6 text-gray text-left">
                            <style>
                                .description-data {
                                    margin-left: -40px; /* Desktop & Tablet ke liye default  */
                                }
                                @media (max-width: 480px) {
                                    .description-data {
                                        margin-left: -40px; /* Sirf mobile screens ke liye */
                                    }
                                }
                            </style>
                            <div class="description-data">
                                {!! $item->description !!}
                            </div>
                        </p>
                        <p class="font-poppins font-normal text-base leading-6 text-gray text-left">
                            {{ __('Ticket Sale starts onwards') }}
                        </p>
                        <p class="font-poppins font-normal text-base leading-6 text-gray text-left">
                            @if (Carbon\Carbon::parse($item->start_time)->format('d M Y') === Carbon\Carbon::parse($item->end_time)->format('d M Y'))
                                {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }}
                            @else
                                {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }} {{__('till')}} {{ Carbon\Carbon::parse($item->end_time)->format('d M Y') }}
                            @endif
                        </p>

                    </div>

                    <div class="absolute bottom-5" style="width: 89%">
                        @if ($item->available_qty == 0)
                            <div class="mt-7  w-full border border-primary rounded-lg flex justify-center">
                                <a href="#"
                                    class="font-poppins font-medium text-base leading-6 text-primary  py-3">{{ __('Sold Out') }}</a>
                            </div>
                        @else
                            <a type="button"
                                href="{{ url('/checkout1/' . $item->id) }}"
                                class=" text-primary text-center font-poppins font-medium text-base leading-7 w-full  py-3 mt-7 border border-primary rounded-lg flex justify-center">{{ __('Book Now') }}
                                <i class="fa-solid fa-arrow-right w-3 h-3 mt-1.5 ml-2"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
        @if (count($data->free_ticket) != 0)
            @foreach ($data->free_ticket as $item)
                <div class="rounded-lg border border-gray-light p-5">
                    <div class="flex justify-center">
                        <p
                            class="font-poppins font-medium text-sm leading-4 text-primary text-center rounded-full bg-primary-light w-16 py-1">
                            {{ __('free') }}</p>
                    </div>
                    <p class="font-poppins font-medium text-xl leading-7 text-primary text-center py-4">
                        {{ $item->ticket_number }}</p>
                    <div class="flex justify-center space-x-2">
                        <span
                            class="font-poppins font-medium text-2xl leading-8 text-center text-black pt-1"></span>
                        <p class="font-poppins font-medium text-5xl leading-10 text-black text-center">
                            {{ __('Free') }}</p>
                    </div>
                    {{-- when tickets are available --}}
                    <div class="py-4">
                        @if ($item->available_qty == 0)
                            <p
                                class="font-poppins font-normal text-lg leading-7 text-danger text-center rounded-full bg-danger-light py-2">
                                {{ __('No Available tickets') }}</p>
                        @else
                            <p
                                class="font-poppins font-normal text-lg leading-7 text-success text-center bg-success-light rounded-full py-2">
                                {{ $item->available_qty . ' Available tickets' }}</p>
                        @endif
                    </div>
                    <div class="font-poppins font-normal text-base leading-6 text-gray text-left">
                        {!! $item->description !!}
                    </div>
                    <p class="font-poppins font-normal text-base leading-6 text-gray text-left">
                        {{ __('Ticket Date') }}
                    </p>
                    <p class="font-poppins font-normal text-base leading-6 text-gray text-left">
                        @if (Carbon\Carbon::parse($item->start_time)->format('d M Y') === Carbon\Carbon::parse($item->end_time)->format('d M Y'))
                            {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }}
                        @else
                            {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }} - {{ Carbon\Carbon::parse($item->end_time)->format('d M Y') }}
                        @endif
                    </p>
                    @if ($item->available_qty == 0)
                        <div class="mt-7  w-full border border-primary rounded-lg flex justify-center">
                            <a href="#"
                                class="font-poppins font-medium text-base leading-6 text-primary  py-3">{{ __('Sold Out') }}</a>
                        </div>
                    @else
                        <a type="button"
                                href="{{ url('/checkout1/' . $item->id) }}"
                                class=" text-primary text-center font-poppins font-medium text-base leading-7 w-full  py-3 mt-7 border border-primary rounded-lg flex justify-center">{{ __('Book Now') }}
                                <i class="fa-solid fa-arrow-right w-3 h-3 mt-1.5 ml-2"></i>
                            </a>
                    @endif
                </div>
            @endforeach
        @endif
        @if (count($data->free_ticket) == 0 && count($data->paid_ticket) == 0)
            <div class="mx-auro w-full">
                <div class="px-5">
                    <img src="{{ url('frontend/images/empty.png') }}">
                    <h6 class="font-poopins  font-light  text-3xl leading-9 text-black px-5">
                        {{ __('No Tickets found') }}!</h6>
                </div>
            </div>
        @endif
    </div>

</div>
@endsection



//latest
@extends('frontend.master', ['activePage' => 'event'])
@section('title', __('Event Details'))

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: relative;
        }
        
        /* Main Card */
        .booking-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            margin: 20px auto 80px;
            overflow: hidden;
            flex-grow: 1;
        }
        
        /* Header */
        .event-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        
        .event-header h1 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        /* Progress Steps */
        .progress-steps {
            display: flex;
            width: 100%;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }
        
        .step {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
            margin-right: 20px;
        }
        
        .step-number {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: #333;
            color: white;
            font-size: 12px;
        }
        
        .step-text {
            font-size: 14px;
            color: #333;
            font-weight: 500;
        }
        
        .step.inactive .step-number {
            background-color: #999;
        }
        
        .step.inactive .step-text {
            color: #999;
        }
        
        /* Event Info */
        .event-info {
            width: 100%;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }
        
        .event-info h2 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .event-date {
            font-size: 14px;
            color: #666;
        }
        
        /* Main Content */
        .content {
            padding: 20px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .section-subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 16px;
        }
        
        /* Ticket Card */
        .ticket-card {
            background: #f9f9f9;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 16px;
            cursor: pointer;
            transition: all 0.2s;
            border: 2px solid transparent;
        }
        
        .ticket-card.selected {
            border-color: #dc354b;
            background: #fff5f5;
        }
        
        .ticket-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .ticket-name {
            font-weight: 700;
            font-size: 16px;
            color: #525252;
        }
        
        .ticket-price {
            font-size: 16px;
            color: #dc354b;
            font-weight: 600;
        }
        
        /* Footer with Proceed Button - Aligned with card */
        .footer-container {
            display: flex;
            justify-content: center;
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(5px);
            padding: 12px 0;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            z-index: 100;
        }
        
        .footer-content {
            width: 100%;
            max-width: 500px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        
        .total-price {
            font-size: 18px;
            font-weight: 600;
            color: #dc354b;
        }
        
        .proceed-btn {
            background-color: #dc354b;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .proceed-btn:hover {
            background-color: #c82333;
        }
        
        .proceed-btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        
        .availability {
            font-size: 14px;
            margin-top: 8px;
        }
        
        .available {
            color: #28a745;
        }
        
        .sold-out {
            color: #dc3545;
        }
    </style>

    <!-- New Ticket Booking Card View -->
    <div class="booking-card" id="booking-card-view">
        <!-- Header -->
        <div class="event-header">
            <h1>{{ $data->title }}</h1>
        </div>
        
        <!-- Progress Steps -->
        <div class="progress-steps">
            <div class="step">
                <div class="step-number">1</div>
                <div class="step-text">Ticket</div>
            </div>
            <div class="step inactive">
                <div class="step-number">2</div>
                <div class="step-text">Review & Proceed to Pay</div>
            </div>
        </div>
        
        <!-- Event Info -->
        <div class="event-info">
            <h2>{{ $data->name }}</h2>
            <div class="event-date">
                {{ Carbon\Carbon::parse($data->start_date)->format('D d M') }} | 
                {{ Carbon\Carbon::parse($data->start_time)->format('h:i A') }}
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="content">
            <h2 class="section-title">Select Tickets</h2>
            <p class="section-subtitle">You can select only one ticket type</p>
            
            @if(count($data->paid_ticket) > 0 || count($data->free_ticket) > 0)
                @foreach($data->paid_ticket as $item)
                    <div class="ticket-card" data-ticket-id="{{ $item->id }}" data-price="{{ $item->price }}">
                        <div class="ticket-row">
                            <div class="ticket-name">{{ $item->name }}</div>
                            <div class="ticket-price">{{ __($currency) }}{{ $item->price }}</div>
                        </div>
                        
                        @if($item->available_qty > 0)
                            <div class="availability available">{{ $item->available_qty }} available</div>
                        @else
                            <div class="availability sold-out">Sold out</div>
                        @endif
                    </div>
                @endforeach
                
                @foreach($data->free_ticket as $item)
                    <div class="ticket-card" data-ticket-id="{{ $item->id }}" data-price="0">
                        <div class="ticket-row">
                            <div class="ticket-name">{{ $item->ticket_number }}</div>
                            <div class="ticket-price">Free</div>
                        </div>
                        
                        @if($item->available_qty > 0)
                            <div class="availability available">{{ $item->available_qty }} available</div>
                        @else
                            <div class="availability sold-out">Sold out</div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="text-center py-10">
                    <img src="{{ url('frontend/images/empty.png') }}" class="mx-auto mb-4" style="max-width: 200px;">
                    <h6 class="text-xl text-black">{{ __('No Tickets found') }}!</h6>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer with Proceed Button - Aligned with card -->
    <div class="footer-container">
        <div class="footer-content">
            <div class="total-price" id="footer-price">{{ __($currency) }}0</div>
            <button class="proceed-btn" id="proceed-btn" disabled>Proceed</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ticketCards = document.querySelectorAll('.ticket-card');
            const footerPrice = document.getElementById('footer-price');
            const proceedBtn = document.getElementById('proceed-btn');
            
            let selectedTicket = null;
            
            // Handle ticket selection
            ticketCards.forEach(card => {
                card.addEventListener('click', function() {
                    const isAvailable = !card.querySelector('.sold-out');
                    const ticketId = card.dataset.ticketId;
                    const price = card.dataset.price;
                    
                    if (!isAvailable) return;
                    
                    // Deselect previously selected ticket
                    if (selectedTicket) {
                        selectedTicket.classList.remove('selected');
                    }
                    
                    // Select new ticket
                    card.classList.add('selected');
                    selectedTicket = card;
                    
                    // Update footer
                    const priceText = price == 0 ? 'Free' : `{{ __($currency) }}${price}`;
                    footerPrice.textContent = priceText;
                    
                    // Enable proceed button
                    proceedBtn.disabled = false;
                });
            });
            
            // Proceed button handler
            proceedBtn.addEventListener('click', () => {
                if (selectedTicket) {
                    const ticketId = selectedTicket.dataset.ticketId;
                    window.location.href = `/checkout1/${ticketId}`;
                }
            });
        });
    </script>
@endsection
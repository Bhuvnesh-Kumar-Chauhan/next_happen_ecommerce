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
        
        /* View More Button Styles */
        .view-more-btn {
            color: #007bff;
            background: none;
            border: none;
            padding: 5px 0;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            margin-top: 8px;
        }
        
        .view-more-btn i {
            margin-left: 5px;
            transition: transform 0.3s;
        }
        
        .view-more-btn.expanded i {
            transform: rotate(180deg);
        }
        
        .ticket-description {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            font-size: 14px;
            color: #666;
            margin-top: 0;
        }
        
        .ticket-description.show {
            max-height: 500px;
            margin-top: 10px;
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
            {{-- <div class="event-date">
                {{ Carbon\Carbon::parse($data->start_date)->format('D d M') }} | 
                {{ Carbon\Carbon::parse($data->start_time)->format('h:i A') }}
            </div> --}}
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
                        
                        <button class="view-more-btn">
                            View More <i class="fas fa-chevron-down"></i>
                        </button>
                        
                        <div class="ticket-description">
                            {!! $item->description !!}
                        </div>
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
                        
                        <button class="view-more-btn">
                            View More <i class="fas fa-chevron-down"></i>
                        </button>
                        
                        <div class="ticket-description">
                            {!! $item->description !!}
                        </div>
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
                card.addEventListener('click', function(e) {
                    // Don't process click if it was on the view more button
                    if (e.target.closest('.view-more-btn')) return;
                    
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
            
            // Handle view more buttons
            document.querySelectorAll('.view-more-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation(); // Prevent triggering the card click
                    const description = this.nextElementSibling;
                    this.classList.toggle('expanded');
                    description.classList.toggle('show');
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
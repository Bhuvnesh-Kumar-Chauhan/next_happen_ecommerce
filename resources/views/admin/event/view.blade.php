@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Event Detail '),
            'headerData' => __('Event') ,
            'url' => 'events' ,
        ])

      <div class="section-body">
         <div class="row event-single">
             <div class="col-lg-8">
                 <div class="card">
                     <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <!--<div class="event-img w-100" style="background: url({{url('images/upload/'.$event->image)}})">-->
                                <!--</div>-->
                                @php
                                    
                                    $firstMedia = null;
                                
                                    if (is_array($event->image)) {
                                        $firstMedia = $event->image[0] ?? null;
                                    } elseif (is_string($event->image)) {
                                        if (Str::startsWith($event->image, '[')) {
                                            $decoded = json_decode($event->image, true);
                                            $firstMedia = is_array($decoded) ? $decoded[0] ?? null : null;
                                        } else {
                                            $firstMedia = $event->image;
                                        }
                                    }
                                
                                    $isImage = Str::endsWith($firstMedia, ['.jpg', '.jpeg', '.png', '.gif', '.webp'], true);
                                    $isVideo = Str::endsWith($firstMedia, ['.mp4', '.mov', '.avi'], true);
                                
                                    $mediaPath = $firstMedia
                                        ? ($isImage ? 'images/upload/' . basename($firstMedia)
                                        : ($isVideo ? 'videos/upload/' . basename($firstMedia)
                                        : null))
                                        : null;
                                @endphp
                                
                                @if ($mediaPath)
                                    @if ($isImage)
                                        <div class="event-img w-100" style="background: url('{{ asset($mediaPath) }}'); background-size: cover; background-position: center;" >
                                        </div>
                                    @elseif ($isVideo)
                                        <div class="event-img w-100">
                                            <video autoplay muted loop playsinline style="width: 100%; height: auto;">
                                                <source src="{{ asset($mediaPath) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    @endif
                                @endif

                            </div>
                            <div class="col-12 event-description">
                                <h2 class="mt-3">{{$event->name}} <button type="button" class="btn btn-primary "><a class="text-white" href="{{url($event->id.'/'.preg_replace('/\s+/', '-', $event->name).'/tickets')}}">{{__('Manage Tickets')}}</a></button></h2>
                                <p> {!!$event->description!!}  </p>
                            </div>
                        </div>
                        <div class="row ml-0 mr-0 mt-4">
                            <div class="col-lg-3">
                                <div class="card single-card-light">
                                    <div class="row">
                                        <div class="col-3 text-center">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div class="col-9">
                                            <p class="mb-0">{{__('People allowed')}}</p>
                                            <span>{{$event->people}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card single-card-light">
                                    <div class="row">
                                        <div class="col-3 text-center">
                                            <i class="far fa-calendar-alt"></i>
                                        </div>
                                        <div class="col-9">
                                            <p class="mb-0">{{__('Date')}}</p>
                                            <span>{{Carbon\Carbon::parse($event->start_time)->format('l').','}}</span>
                                            <span>{{$event->start_time->format('d F Y')}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="card single-card-light">
                                    <div class="row">
                                        <div class="col-2 text-center">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="col-9">
                                            <p class="mb-0">{{__('Location')}}</p>
                                            @if($event->type=="offline")
                                            <span> {{$event->address}} </span>
                                            @else
                                            <span> {{__('Online Event')}} </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
                <h2 class="section-title"> {{__('Recent Sales')}}</h2>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="">
                                <thead>
                                    <tr>
                                        <th>{{__('Order Id')}}</th>
                                        <th>{{__('Customer Name')}}</th>
                                        <th>{{__('Ticket Name')}}</th>
                                        <th>{{__('Date')}}</th>
                                        <th>{{__('Sold Ticket')}}</th>
                                        <th>{{__('Payment')}}</th>
                                        <th>{{__('Payment Gateway')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($event->sales as $item)
                                        <tr>
                                            <td>{{$item->order_id}}</td>
                                            <td>{{isset($item->customer->first_name)?$item->customer->first_name: '---'}}</td>
                                            <th>{{$item->ticket->name}}</th>
                                            <th>{{$item->created_at->format('Y-m-d')}}</th>
                                            <th>{{$item->quantity}}</th>
                                            <th>{{$currency.$item->payment}}</th>
                                            <th>{{$item->payment_type}}</th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
             </div>
             <div class="col-lg-4">
                 @if(count($event->ticket)>0)
                    @foreach ($event->ticket as $item)
                        <div class="card card-hero">
                            <div class="card-header">
                                <p class="text-right">{{__('Sales end on')}}</p>
                                <p class="text-right">{{$item->start_time->format('Y-m-d').','.$item->end_time->format('h:i a')}}</p>
                                <div class="card-icon">
                                    <i class="fas fa-ticket-alt"></i>
                                </div>
                                <div class="card-description">{{$item->name}} | <span>{{$currency.$item->price}}</span></div>
                                <h4>{{$item->used_ticket.'/'.$item->quantity}} </h4>
                            </div>
                        </div>
                    @endforeach
                @else

                <div class="card card-hero">
                    <div class="card-header">

                    <div class="card-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div class="card-description">{{__('No tickets')}}</div>
                    <a href="{{url($event->id.'/ticket/create')}}"><button type="button" class="btn btn-ticket" ><i class="fas fa-plus"></i> </button>  </a>
                    </div>
                </div>
                @endif

             </div>
         </div>
      </div>
    </section>
@endsection

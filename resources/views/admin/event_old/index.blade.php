@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Events'),
        ])
    <style>
       /* .dropdown-toggle {
            width: 30px;
            height: 30px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dropdown-item {
            font-size: 0.85rem;
            padding: 0.35rem 1rem;
        }

        .dropdown-item i {
            width: 18px;
            text-align: center;
        } */
        
      
    </style>
        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-4 mt-2">
                                <div class="col-lg-8">
                                    <h2 class="section-title mt-0"> {{ __('All Events') }}</h2>
                                </div>
                                <div class="col-lg-4 text-right">
                                    @can('event_create')
                                        <button class="btn btn-primary add-button"><a href="{{ url('event/create') }}"><i
                                                    class="fas fa-plus"></i> {{ __('Add New') }}</a></button>
                                    @endcan
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="report_table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>{{ __('Image') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Start Date') }}</th>
                                            <th>{{ __('Number of People') }}</th>
                                            <th>{{ __('Category') }}</th>
                                            <th>{{ __('SubCategory') }}</th>
                                            <th>{{ __('Label') }}</th>
                                            @if (Auth::user()->hasRole('admin'))
                                                <th>{{ __('Organization') }}</th>
                                            @endif
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Tickets Manage') }}</th>
                                            {{-- <th>{{ __('Term & Condition') }}</th>
                                            <th>{{ __('Disclaimer') }}</th> --}}
                                            <th>{{ __('Services Manage') }}</th>
                                            @if (Gate::check('event_edit') || Gate::check('event_delete'))
                                                <th>{{ __('Action') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($events as $item)
                                            <tr>
                                                <td></td>
                                                <!--<th> <img class="table-img"-->
                                                <!--        src="{{ url('images/upload/' . $item->image) }}">-->
                                                <!--</th>-->
                                                <th>
                                                    @php
                                                        $firstMedia = null;
                                                
                                                        if (is_array($item->image)) {
                                                            $firstMedia = $item->image[0] ?? null;
                                                        } elseif (is_string($item->image) && Str::startsWith($item->image, '[')) {
                                                            $decoded = json_decode($item->image, true);
                                                            $firstMedia = is_array($decoded) ? $decoded[0] ?? null : null;
                                                        } elseif (is_string($item->image)) {
                                                            $firstMedia = $item->image;
                                                        }
                                                
                                                        $isImage = Str::endsWith($firstMedia, ['.jpg', '.jpeg', '.png', '.gif', '.webp', '.JPG', '.JPEG', '.PNG', '.GIF', '.WEBP']);
                                                        $isVideo = Str::endsWith($firstMedia, ['.mp4', '.mov', '.avi']);
                                                
                                                        $mediaPath = $isImage ? 'images/upload/' . basename($firstMedia) : ($isVideo ? 'videos/upload/' . basename($firstMedia) : null);
                                                    @endphp
                                                
                                                    @if ($mediaPath)
                                                        @if ($isImage)
                                                            <img src="{{ asset($mediaPath) }}" alt="Image" class="table-img" width="60">
                                                        @elseif ($isVideo)
                                                            
                                                            <video autoplay muted playsinline loop
                                                                width="80"
                                                            >
                                                                <source src="{{ asset($mediaPath) }}" type="video/mp4">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        @endif
                                                    @endif
                                                </th>

                                                <td>
                                                    <h6 class="mb-0">{{ $item->name }}</h6>
                                                    <p class="mb-0">{{ $item->address }} </p>
                                                </td>
                                                <td>
                                                    <p class="mb-0">
                                                        {{ Carbon\Carbon::parse($item->start_time)->format('Y-m-d h:i a') . ', ' . $item->start_time->format('l') }}
                                                    </p>
                                                </td>
                                                <td>{{ $item->people }}</td>
                                                <td>{{ isset($item->category) ? $item->category->name : '---' }}</td>

                                                <td>{{ isset($item->subcategory) && $item->subcategory->name ? $item->subcategory->name : '---' }}</td>
                                                <td>{{ optional($item->label)->name ?? '---' }}</td>
                                                @if (Auth::user()->hasRole('admin'))
                                                    <td>{{ $item->organization->first_name . ' ' . $item->organization->last_name }}
                                                    </td>
                                                @endif
                                                <td>
                                                    <h5><span
                                                            class="badge {{ $item->status == '1' ? 'badge-success' : 'badge-warning' }}  m-1">{{ $item->status == '1' ? 'Publish' : 'Draft' }}</span>
                                                    </h5>
                                                </td>
                                                
                                                @if (Gate::check('ticket_access'))
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-primary dropdown-toggle" type="button" id="manageTicketDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                                {{ __('Manage Tickets') }}
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="manageTicketDropdown">
                                                                <li><a class="dropdown-item" href="{{ url($item->id . '/' . Str::slug($item->name) . '/tickets') }}">{{ __('Manage Tickets') }}</a></li>
                                                                <li><a class="dropdown-item" href="{{ url($item->id . '/' . Str::slug($item->name) . '/termsandconditions') }}">{{ __('Terms & Conditions') }}</a></li>
                                                                <li><a class="dropdown-item" href="{{ url($item->id . '/' . Str::slug($item->name) . '/disclaimer') }}">{{ __('Disclaimer') }}</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                 @endif
                                                <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-primary dropdown-toggle" type="button" id="manageServicesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                               {{ __('Manage Services') }}
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="manageServicesDropdown">
                                                                <li><a class="dropdown-item" href="{{ url($item->id . '/event-venues') }}">Event Venues</a></li>
                                                                <li><a class="dropdown-item" href="{{ url($item->id . '/event-talent') }}">Event Talent</a></li>
                                                                <li><a class="dropdown-item" href="{{ url($item->id . '/equipment-event') }}">Equipment Event</a></li>
                                                                <li><a class="dropdown-item" href="{{ url($item->id . '/services-event') }}">Services Event</a></li>
                                                            </ul>
                                                        </div>
                                                </td>
                                              
                                                @if (Gate::check('event_edit') || Gate::check('event_delete'))
                                                    <td class="text-center">
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-light rounded-circle" type="button" id="eventActions-{{ $item->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="eventActions-{{ $item->id }}">
                                                                <a class="dropdown-item" href="{{ url('/events_details', $item->id) }}">
                                                                    <i class="fas fa-eye mr-2 text-primary"></i> View Event
                                                                </a>
                                                                <a class="dropdown-item" href="{{ url('event-gallery/' . $item->id) }}">
                                                                    <i class="far fa-images mr-2 text-warning"></i> Event Gallery
                                                                </a>
                                                                
                                                                @can('event_edit')
                                                                    <a class="dropdown-item" href="{{ route('events.edit', $item->id) }}">
                                                                        <i class="fas fa-edit mr-2 text-info"></i> Edit Event
                                                                    </a>
                                                                @endcan
                                                                
                                                                @can('event_delete')
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item text-danger" href="#" onclick="deleteData('events','{{ $item->id }}'); return false;">
                                                                        <i class="fas fa-trash-alt mr-2"></i> Delete Event
                                                                    </a>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>    
@endsection

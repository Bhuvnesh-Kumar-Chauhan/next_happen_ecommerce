@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Events'),
        ])

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
                                            @if (Gate::check('event_edit') || Gate::check('event_delete'))
                                                <th>{{ __('Action') }}</th>
                                            @endif
                                            @if (Gate::check('ticket_access'))
                                                <th>{{ __('Tickets') }}</th>
                                                <th>{{ __('Term & Condition') }}</th>
                                                <th>{{ __('Disclaimer') }}</th>
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
                                                @if (Gate::check('event_edit') || Gate::check('event_delete'))
                                                    <td>
                                                        <a href="{{ url('/events_details', $item->id) }}" title="View Event"
                                                            class="btn-icon"><i class="fas fa-eye"></i></a>
                                                        <a href="{{ url('event-gallery/' . $item->id) }}"
                                                            title="Event Gallery" class="btn-icon"><i
                                                                class="far fa-images"></i></a>
                                                        @can('event_edit')
                                                            <a href="{{ route('events.edit', $item->id) }}" title="Edit Event"
                                                                class="btn-icon"><i class="fas fa-edit"></i></a>
                                                        @endcan
                                                        @can('event_delete')
                                                            <a href="#"
                                                                onclick="deleteData('events','{{ $item->id }}');"
                                                                title="Delete Event" class="btn-icon text-danger"><i
                                                                    class="fas fa-trash-alt text-danger"></i></a>
                                                        @endcan
                                                    </td>
                                                @endif
                                                @if (Gate::check('ticket_access'))
                                                    <td>
                                                        <a href="{{ url($item->id . '/' . Str::slug($item->name) . '/tickets') }}"
                                                            class=" btn btn-primary">{{ __('Manage Tickets') }}</a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url($item->id . '/' . Str::slug($item->name) . '/termsandconditions') }}"
                                                            class=" btn btn-primary">{{ __('Manage Terms & Conditions') }}</a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url($item->id . '/' . Str::slug($item->name) . '/disclaimer') }}"
                                                            class=" btn btn-primary">{{ __('Disclaimer') }}</a>
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
@endsection

@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => __('Book Ticket'),
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
                        <div class="col-lg-8"><h2 class="section-title mt-0"> {{__('View Events')}}</h2></div>

                    </div>
                  <div class="table-responsive">
                    <table class="table" id="report_table">
                        <thead>
                            <tr>
                                <th>{{ __('Id') }}</th>
                                <th>{{__('Image')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                         <tbody>
                            @foreach ($events as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <!--<th> <img style="height: 50px;width:50px" src="{{url('images/upload/'.$item->image)}}"> </th>-->
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
                                                <img src="{{ asset($mediaPath) }}" alt="Image" style="height: 50px;width:50px">
                                            @elseif ($isVideo)
                                                
                                                <video autoplay muted playsinline loop style="height: 50px;width:50px">
                                                    <source src="{{ asset($mediaPath) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @endif
                                        @endif
                                    </th>
                                    <td>{{$item->name}}</td>

                                    <td>
                                        <h5><span class="badge {{$item->status=="1"?'badge-success': 'badge-danger'}}  m-1">{{$item->status=="1"?'Active': 'Block'}}</span></h5>
                                    </td>
                                    <td>
                                        <a href="{{ url('/organizer'.'/'.$item->id.'/'. preg_replace('/\s+/', '_', $item->name)) }}" title="User Detail" class="btn-icon text-success"><i class="fas fa-eye"></i></a>
                                    </td>
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

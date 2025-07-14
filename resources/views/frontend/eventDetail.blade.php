@extends('frontend.master', ['activePage' => 'event'])
@section('title', __('Event Details'))
@php
    $gmapkey = \App\Models\Setting::find(1)->map_key;
@endphp
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

<style>
.owl-carousel .owl-nav button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0,0,0,0.5) !important;
    color: #fff !important;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.owl-carousel .owl-nav button.owl-prev {
    left: 10px;
}
.owl-carousel .owl-nav button.owl-next {
    right: 10px;
}
.owl-carousel .owl-nav button.disabled {
    opacity: 0;
}
.owl-carousel .item {
    padding: 0 5px;
}


@media (min-width: 1220px) {
    .xl\:h-20 {
        height: 100%;
        object-fit: fill;
    }
}
</style>


    {{-- content --}}
    <div class="pb-20 bg-scroll min-h-screen" style="background-image: url('images/events.png')">
        {{-- scroll --}}
        <div class="mr-4 flex justify-end z-30">
            <a type="button" href="{{ url('#') }}"
                class="scroll-up-button bg-primary rounded-full p-4 fixed z-20  2xl:mt-[49%] xl:mt-[59%] xlg:mt-[68%] lg:mt-[75%] xxmd:mt-[83%] md:mt-[90%]
                xmd:mt-[90%] sm:mt-[117%] msm:mt-[125%] xsm:mt-[160%]">
                <img src="{{ asset('images/downarrow.png') }}" alt="" class="w-3 h-3 z-20">
            </a>
        </div>
        <div
            class="mt-5 3xl:mx-52 2xl:mx-28 1xl:mx-28 xl:mx-36 xlg:mx-32 lg:mx-36 xxmd:mx-24 xmd:mx-32 md:mx-28 sm:mx-20 msm:mx-16 xsm:mx-10 xxsm:mx-5 z-10 relative">
            <div class="flex sm:space-x-6 msm:space-x-0 xxsm:space-x-0 xxmd:flex-row xmd:flex-col xxsm:flex-col">
                <div class="xxmd:w-2/3 xmd:w-full xxsm:w-full">
                    <!--<div>-->
                    <!--    @if (Auth::guard('appuser')->user())-->
                    <!--        <div-->
                    <!--            class="shadow-2xl rounded-lg w-10 h-10 text-center absolute bg-white top-8 xxmd:right-[38%] xmd:right-6 md:right-6 sm:right-6 xxsm:right-6">-->
                    <!--            @if (Str::contains($appUser->favorite, $data->id))-->
                    <!--                <a href="javascript:void(0);" class="like"-->
                    <!--                    onclick="addFavorite('{{ $data->id }}','{{ 'event' }}')"><img-->
                    <!--                        src="{{ url('images/heart-fill.svg') }}" alt=""-->
                    <!--                        class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg"></a>-->
                    <!--            @else-->
                    <!--                <a href="javascript:void(0);" class="like"-->
                    <!--                    onclick="addFavorite('{{ $data->id }}','{{ 'event' }}')"><img-->
                    <!--                        src="{{ url('images/heart.svg') }}" alt=""-->
                    <!--                        class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg"></a>-->
                    <!--            @endif-->
                    <!--        </div>-->
                    <!--    @endif-->
                    <!--    <img src="{{ url('images/upload/' . $data->image) }}" class="w-full h-96 object-cover"-->
                    <!--        id="eventimage" alt="not found">-->
                    <!--</div>-->
                   


                    <div class="owl-carousel owl-theme">
                        @php
                            $mediaItems = [];
                    
                            if (is_array($data->image)) {
                                $mediaItems = $data->image;
                            } elseif (is_string($data->image) && Str::startsWith($data->image, '[')) {
                                $mediaItems = json_decode($data->image, true) ?? [];
                            } elseif (is_string($data->image)) {
                                $mediaItems[] = $data->image;
                            }
                        @endphp
                    
                        @foreach ($mediaItems as $index => $media)
                            @php
                                $isImage = Str::endsWith($media, ['.jpg', '.jpeg', '.png', '.gif', '.webp', '.JPG', '.JPEG', '.PNG', '.GIF', '.WEBP']);
                                $isVideo = Str::endsWith($media, ['.mp4', '.mov', '.avi']);
                                $mediaPath = $isImage ? 'images/upload/' . basename($media) : ($isVideo ? 'videos/upload/' . basename($media) : '');
                            @endphp
                    
                            <div class="item">
                                <div class="relative h-96">
                                    @if ($index === 0 && Auth::guard('appuser')->user())
                                        <div class="shadow-2xl rounded-lg w-10 h-10 text-center absolute bg-white top-4 right-4 z-10">
                                            @if (Str::contains($appUser->favorite, $data->id))
                                                <a href="javascript:void(0);" class="like" onclick="addFavorite('{{ $data->id }}','{{ 'event' }}')">
                                                    <img src="{{ url('images/heart-fill.svg') }}" alt="" class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg" >
                                                </a>
                                            @else
                                                <a href="javascript:void(0);" class="like" onclick="addFavorite('{{ $data->id }}','{{ 'event' }}')">
                                                    <img src="{{ url('images/heart.svg') }}" alt="" class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg">
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    @php
                                        $url = !empty($data->urls) ? $data->urls : '#';
                                    @endphp
                                    
                                    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer">
                                        @if ($isImage)
                                            <img src="{{ asset($mediaPath) }}" alt="Event Image" class="w-full  object-cover rounded-lg" style=" object-fit: fill;height: 100%;">
                                        @elseif ($isVideo)
                                            <video controls class="w-full  object-cover rounded-lg">
                                                <source src="{{ asset($mediaPath) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                    </a>

                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
                    <script>
                    $(document).ready(function(){
                        $(".owl-carousel").owlCarousel({
                            items: 1, // Yeh ensure karega ki ek baar me sirf ek item dikhe
                            loop: true,
                            margin: 10,
                            nav: true,
                            dots: false,
                            autoplay: true,
                            autoplayTimeout: 3000,
                            autoplayHoverPause: true,
                            navText: [
                                '<i class="fa fa-chevron-left"></i>',
                                '<i class="fa fa-chevron-right"></i>'
                            ],
                            responsive: {
                                768: {
                                    items: 1
                                },
                                1024: {
                                    items: 1
                                }
                            }
                        });
                    });
                    </script>


                    <div class="mt-8 pb-5 bg-white shadow-lg rounded-md">
                        <div
                            class="flex justify-between p-4 lg:flex-wrap sm:flex-wrap msm:flex-wrap xxsm:flex-wrap xlg:flex-nowrap">
                            <div class="">
                                <p class="font-poppins font-semibold text-2xl leading-8 text-black pb-3">
                                    {{ $data->name }}</p>
                                @if ($data->rate > 1)
                                    <div class="flex space-x-2 pt-3 ">
                                        @for ($i = 1; $i <= $data->rate; $i++)
                                            <img src="{{ asset('images/star-fill.png') }}" alt="">
                                        @endfor
                                        @for ($i = 5; $i > $data->rate; $i--)
                                            <img src="{{ asset('images/star.png') }}" alt="">
                                        @endfor
                                    </div>
                                @endif
                            </div>
                            <!--<a-->
                            <!--    href="{{ route('organizationDetails', ['id' => $data->organization->id]) }}">-->
                            <!--    <div class="flex msm:flex-wrap xxsm:flex-wrap">-->
                            <!--        <div class="">-->
                            <!--            <img src="{{ url('images/upload/' . $data->organization->image) }}"-->
                            <!--                class="w-10 h-10 bg-cover object-cover" alt="">-->
                            <!--        </div>-->
                            <!--        <div class="ml-3">-->
                            <!--            <p class="font-poppins font-normal text-xs leading-4 text-gray-100">-->
                            <!--                {{ __('Organized by') }}</p>-->
                            <!--            <p class="font-poppins font-normal text-base leading-6 text-gray">-->
                            <!--                {{  $data->organization->organization_name }}</p>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--</a>-->
                        </div>
                        <div class="px-4">
                            <div class="pt-4 flex space-x-6 md:flex-nowrap sm:flex-wrap xxsm:flex-wrap">
                                <img src="{{ asset('images/calender-icon.png') }}" alt=""
                                    class="bg-success-light rounded-md p-2 w-10">
                                <!--<div class="flex space-x-2 ">-->
                                <!--    <p class="font-poppins font-bold text-4xl leading-10 text-black">-->
                                <!--        {{ Carbon\Carbon::parse($data->start_time)->format('d') }}-->
                                <!--    </p>-->
                                <!--    <p class="font-poppins font-semibold text-2xl leading-8 text-gray-200 pt-2">-->
                                <!--        {{ Carbon\Carbon::parse($data->start_time)->format('M y') }}</p>-->
                                <!--</div>-->
                                <!--<div class="flex space-x-2">-->
                                <!--    <p class="font-poppins font-bold text-4xl leading-10 text-black">-->
                                <!--        {{ Carbon\Carbon::parse($data->end_time)->format('d') }}-->
                                <!--    </p>-->
                                <!--    <p class="font-poppins font-semibold text-2xl leading-8 text-gray-200 pt-2">-->
                                <!--        {{ Carbon\Carbon::parse($data->end_time)->format('M y') }}</p>-->
                                <!--</div>-->
                                
                                @if (Carbon\Carbon::parse($data->start_time)->format('d M Y') === Carbon\Carbon::parse($data->end_time)->format('d M Y'))
                                    <div class="flex space-x-2">
                                        <p class="font-poppins font-bold text-4xl leading-10 text-black">
                                            {{ Carbon\Carbon::parse($data->start_time)->format('d') }}
                                        </p>
                                        <p class="font-poppins font-semibold text-2xl leading-8 text-gray-200 pt-2">
                                            {{ Carbon\Carbon::parse($data->start_time)->format('M y') }}
                                        </p>
                                    </div>
                                @else
                                    <div class="flex space-x-2">
                                        <p class="font-poppins font-bold text-4xl leading-10 text-black">
                                            {{ Carbon\Carbon::parse($data->start_time)->format('d') }}
                                        </p>
                                        <p class="font-poppins font-semibold text-2xl leading-8 text-gray-200 pt-2">
                                            {{ Carbon\Carbon::parse($data->start_time)->format('M y') }}
                                        </p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <p class="font-poppins font-bold text-4xl leading-10 text-black">
                                            {{ Carbon\Carbon::parse($data->end_time)->format('d') }}
                                        </p>
                                        <p class="font-poppins font-semibold text-2xl leading-8 text-gray-200 pt-2">
                                            {{ Carbon\Carbon::parse($data->end_time)->format('M y') }}
                                        </p>
                                    </div>
                                @endif

                            </div>
                            <div class="pt-4 flex space-x-6 md:flex-nowrap sm:flex-wrap xxsm:flex-wrap">
                                <img src="{{ asset('images/location-icon.png') }}" alt=""
                                    class="p-2 w-auto h-10 rounded-md bg-blue-light">
                                <div class="">
                                    <p class="font-poppins font-normal text-lg leading-7 text-gray">
                                        @if ($data->type == 'online')
                                            {{ __('Online Event') }}
                                        @else
                                            {{ $data->address }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="pt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-center gap-4 sm:gap-6">
                                    <img src="{{ asset('images/user-icon.png') }}" alt="" class="p-2 rounded-md bg-warning-light w-12 h-12">
                                    <p class="font-poppins font-normal text-lg leading-7 text-gray">
                                        {{ $data->people }}
                                    </p>
                                </div>
                                <a href="{{ url('ticket/' . $data->id . '/' . Str::slug($data->name)) }}" 
                                   class="px-6 py-2 bg-primary text-white rounded hover:bg-primary-dark transition whitespace-nowrap">
                                    Buy Ticket
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-10 bg-white shadow-lg rounded-md">
                        <div class="p-4">
                            <p class="font-poppins font-semibold text-2xl leading-8 text-black">{{ __('About Event') }}</p>
                            
                            <div class="font-poppins font-normal text-lg leading-7 text-gray pt-5 relative">
                                <div id="shortDescription" class="line-clamp-5">
                                    {!! $data->description !!}
                                </div>
                                <div id="fullDescription" class="hidden">
                                    {!! $data->description !!}
                                </div>
                                
                                @if(str_word_count(strip_tags($data->description)) > 30) <!-- Adjust word count as needed -->
                                    <button onclick="toggleDescription()" id="readMoreBtn" 
                                            class="text-primary font-medium mt-2 focus:outline-none">
                                        Read More
                                    </button>
                                @endif
                            </div>
                            
                            @foreach ($tags as $item)
                                <a href="{{ url('/user/tag/' . $item) }}"
                                   class="mt-5 px-3 py-1 text-success bg-success-light rounded-full font-poppins font-normal text-base leading-6">
                                    {{ $item }}
                                </a>
                            @endforeach
                        </div>
                        
                        <style>
                            .line-clamp-5 {
                                display: -webkit-box;
                                -webkit-line-clamp: 5;
                                -webkit-box-orient: vertical;
                                overflow: hidden;
                                text-overflow: ellipsis;
                            }
                        </style>
                        
                        <script>
                            function toggleDescription() {
                                const shortDesc = document.getElementById('shortDescription');
                                const fullDesc = document.getElementById('fullDescription');
                                const btn = document.getElementById('readMoreBtn');
                                
                                if (shortDesc.classList.contains('hidden')) {
                                    shortDesc.classList.remove('hidden');
                                    fullDesc.classList.add('hidden');
                                    btn.textContent = 'Read More';
                                } else {
                                    shortDesc.classList.add('hidden');
                                    fullDesc.classList.remove('hidden');
                                    btn.textContent = 'Read Less';
                                }
                            }
                        </script>
                    </div>
                </div>
                <!--<div class="xxmd:w-1/3 xmd:w-full xxsm:w-full">-->
                <!--    <div class="p-4 bg-white shadow-lg rounded-md">-->
                <!--        <p class="font-poppins font-semibold text-2xl leading-8 text-black pb-3">{{ __('Image Gallery') }}-->
                <!--        </p>-->
                <!--        <div-->
                <!--            class="grid lg:grid-cols-2 gap-y-5 xxmd:grid-cols-1 xmd:grid-cols-2 sm:grid-cols-2 msm:grid-cols-2 xxsm:grid-cols-1">-->

                <!--            <div id="eventimage" class=" hover:cursor-pointer"-->
                <!--                onclick="imagegallery('{{ $data->image }}')">-->

                <!--                <img src="{{ url('images/upload/' . $data->image) }}"-->
                <!--                    class="1xl:w-40 1xl:h-24 xlg:h-16 xl:h-20 lg:w-[90%] lg:h-10 xxmd:w-full xxmd:h-32 xmd:w-[90%] msm:w-[90%] xxsm:w-full rounded-md object-cover bg-cover"-->
                <!--                    alt="">-->
                <!--            </div>-->
                <!--            @foreach ($images as $item)-->
                <!--                @if (strlen($item) > 0)-->
                <!--                    <div id="eventimage1" class=" hover:cursor-pointer"-->
                <!--                        onclick="imagegallery('{{ $item }}')"><img-->
                <!--                            src="{{ url('images/upload/' . $item) }}"-->
                <!--                            class="1xl:w-40 1xl:h-24 xlg:h-16 xl:h-20 lg:w-[90%] lg:h-10 xxmd:w-full xxmd:h-32 xmd:w-[90%] msm:w-[90%] xxsm:w-full rounded-md object-cover bg-cover"-->
                <!--                            alt="{{ 'Event Image' }}">-->
                <!--                    </div>-->
                <!--                @endif-->
                <!--            @endforeach-->
                            
                <!--        </div>-->
                <!--    </div>-->
                <!--    @if ($data->type == 'offline')-->
                <!--        <div class="p-4 bg-white shadow-lg rounded-md xlg:mt-10 lg:mt-20">-->
                <!--            <p class="font-poppins font-semibold text-2xl leading-8 text-black pb-3">{{ __('Location') }}-->
                <!--            </p>-->
                <!--            <div id="map" style="width:100%;height:400px;">-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    @endif-->
                <!--</div>-->
                <div class="xxmd:w-1/3 xmd:w-full xxsm:w-full">
                    <div class="p-4 bg-white shadow-lg rounded-md">
                        <p class="font-poppins font-semibold text-2xl leading-8 text-black pb-3">{{ __('Image Gallery') }}</p>
                
                        <div class="grid lg:grid-cols-2 gap-y-5 xxmd:grid-cols-1 xmd:grid-cols-2 sm:grid-cols-2 msm:grid-cols-2 xxsm:grid-cols-1">
                
                            @php
                                $mediaItems = [];
                
                                if (is_array($data->image)) {
                                    $mediaItems = $data->image;
                                } elseif (is_string($data->image) && Str::startsWith($data->image, '[')) {
                                    $mediaItems = json_decode($data->image, true) ?? [];
                                } elseif (is_string($data->image)) {
                                    $mediaItems[] = $data->image;
                                }
                            @endphp
                
                            @foreach ($mediaItems as $media)
                                @php
                                    $isImage = Str::endsWith($media, ['.jpg', '.jpeg', '.png', '.gif', '.webp','.JPG', '.JPEG', '.PNG', '.GIF', '.WEBP']);
                                    $isVideo = Str::endsWith($media, ['.mp4', '.mov', '.avi']);
                                    $mediaPath = $isImage ? 'images/upload/' . basename($media) : ($isVideo ? 'videos/upload/' . basename($media) : '');
                                @endphp
                
                                <div id="eventimage" class="hover:cursor-pointer" onclick="imagegallery('{{ asset($mediaPath) }}')">
                                    @if ($isImage)
                                        <img src="{{ asset($mediaPath) }}"
                                            class="1xl:w-40 1xl:h-24 xlg:h-16 xl:h-20 lg:w-[90%] lg:h-10 xxmd:w-full xxmd:h-32 xmd:w-[90%] msm:w-[90%] xxsm:w-full rounded-md object-cover bg-cover"
                                            alt="Event Image">
                                    @elseif ($isVideo)
                                        <video controls
                                            class="1xl:w-40 1xl:h-24 xlg:h-16 xl:h-20 lg:w-[90%] lg:h-10 xxmd:w-full xxmd:h-32 xmd:w-[90%] msm:w-[90%] xxsm:w-full rounded-md object-cover bg-cover">
                                            <source src="{{ asset($mediaPath) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                </div>
                            @endforeach
                
                            @foreach ($images as $item)
                                @if (strlen($item) > 0)
                                    @php
                                        $isImage = Str::endsWith($item, ['.jpg', '.jpeg', '.png', '.gif', '.webp','.JPG', '.JPEG', '.PNG', '.GIF', '.WEBP']);
                                        $isVideo = Str::endsWith($item, ['.mp4', '.mov', '.avi']);
                                        $mediaPath = $isImage ? 'images/upload/' . basename($item) : ($isVideo ? 'video/upload/' . basename($item) : '');
                                    @endphp
                
                                    <div id="eventimage1" class="hover:cursor-pointer" onclick="imagegallery('{{ asset($mediaPath) }}')">
                                        @if ($isImage)
                                            <img src="{{ asset($mediaPath) }}"
                                                class="1xl:w-40 1xl:h-24 xlg:h-16 xl:h-20 lg:w-[90%] lg:h-10 xxmd:w-full xxmd:h-32 xmd:w-[90%] msm:w-[90%] xxsm:w-full rounded-md object-cover bg-cover"
                                                alt="Event Image">
                                        @elseif ($isVideo)
                                            <video autoplay muted playsinline loop
                                                class="1xl:w-40 1xl:h-24 xlg:h-16 xl:h-20 lg:w-[90%] lg:h-10 xxmd:w-full xxmd:h-32 xmd:w-[90%] msm:w-[90%] xxsm:w-full rounded-md object-cover bg-cover"
                                            >
                                                <source src="{{ asset($mediaPath) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>

                                        @endif
                                    </div>
                                @endif
                            @endforeach
                
                        </div>
                    </div>
                
                    {{-- Location --}}
                    @if ($data->type == 'offline')
                        <div class="p-4 bg-white shadow-lg rounded-md xlg:mt-10 lg:mt-20">
                            <p class="font-poppins font-semibold text-2xl leading-8 text-black pb-3">{{ __('Location') }}</p>
                            <div id="map" style="width:100%;height:400px;"></div>
                        </div>
                    @endif
                    
                    {{-- Recommended Events --}}
                    <div class="p-4 bg-white shadow-lg rounded-md xlg:mt-10 lg:mt-10">
                        <p class="font-poppins font-semibold text-2xl leading-8 text-black pb-3">{{ __('Recommended Events') }}</p>
                    
                        @if($recommendedEvents->count())
                            <div class="owl-carousel owl-theme recommended-carousel">
                                @foreach($recommendedEvents as $event)
                                    <div class="item">
                                        <div class="border rounded-md overflow-hidden shadow-sm hover:shadow-lg transition bg-white">
                                            <a href="{{ url('event/' . $event->id . '/' . Str::slug($event->name)) }}">
                                                <div class="w-full h-40 overflow-hidden">
                                                    <img src="{{ $event->imagePath . $event->image }}" alt="{{ $event->name }}" class="w-full h-full object-cover object-center">
                                                </div>
                                                <div class="p-3">
                                                    <h4 class="text-base font-semibold text-black">{{ $event->name }}</h4>
                                                    <p class="text-sm text-gray-600 mt-1">{{ \Illuminate\Support\Str::limit(strip_tags($event->description), 80) }}</p>
                                                    <p class="text-xs text-gray-500 mt-2">{{ date('d M Y, h:i A', strtotime($event->start_time)) }}</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No recommended events found.</p>
                        @endif
                    </div>

                    <script>
                        $(document).ready(function(){
                            $(".recommended-carousel").owlCarousel({
                                items: 3,
                                loop: true,
                                margin: 20,
                                nav: true,
                                dots: false,
                                autoplay: true,
                                autoplayTimeout: 4000,
                                autoplayHoverPause: true,
                                navText: [
                                    '<i class="fa fa-chevron-left"></i>',
                                    '<i class="fa fa-chevron-right"></i>'
                                ],
                                responsive: {
                                    0: {
                                        items: 1
                                    },
                                    768: {
                                        items: 2
                                    },
                                    1024: {
                                        items: 3
                                    }
                                }
                            });
                        });
                    </script>


                </div>

            </div>
         
            {{-- review --}}
            <div class="bg-white shadow-lg rounded-md p-4 mt-10">
                <div class="flex">
                    <p class="font-poppins font-semibold text-2xl leading-7 text-black">{{ __('Reviews') }}</p>&nbsp;
                    <p class="font-poppins font-medium text-base leading-8 text-black">({{ count($data->review) }})</p>
                </div>
                @if (count($data->review) != 0)
                    @foreach ($data->review as $item)
                        <div>
                            <div class="flex justify-between mt-4 sm:flex-wrap xxsm:flex-wrap">
                                <div class="flex sm:flex-wrap xxsm:flex-wrap">
                                    <div class="">
                                        @php
                                            $user = \App\Models\Appuser::find($item->user_id);
                                        @endphp
                                        <img src="{{ asset('images/upload/' . $user->image) }}"
                                            class="w-10 h-10 bg-cover object-cover" alt="">
                                    </div>
                                    <div class="ml-3 ">
                                        <p class="font-poppins font-medium text-lg leading-6 text-black-100">
                                            {{ $user->name }}</p>

                                    </div>
                                </div>
                                <div class="flex">
                                    <p class="font-poppins font-medium text-base leading-4 text-gray-200 pt-1 mr-3">
                                        {{ __('Rating : ' . $item->rate) }}</p>
                                    <div class="flex space-x-1">
                                        @for ($i = 1; $i <= $item->rate; $i++)
                                            <img src="{{ asset('images/star-fill.png') }}"
                                                class="h-5 w-5 bg-cover object-cover" alt="">
                                        @endfor

                                    </div>
                                </div>
                            </div>
                            <div class="ml-12 mt-4">
                                <p class="font-poppins font-normal text-base leading-6 text-gray">
                                    {{ $item->message }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                @else
                @endif

            </div>
            {{-- Report Event --}}
            <!--<div class="bg-white shadow-lg rounded-md p-4 mt-10">-->
            <!--    <p class="font-poppins font-semibold text-2xl leading-8 text-black">{{ __('Report Event') }}</p>-->
            <!--    <form class="form-a" method="post" action="{{ url('report-event') }}">-->
            <!--        @csrf-->
            <!--        <div class="">-->
            <!--            <div class="grid md:grid-cols-2 sm:grid-cols-1 xxsm:grid-cols-1 mt-5 gap-3">-->
            <!--                <div class=" ">-->
            <!--                    <label for="name"-->
            <!--                        class="font-poppins font-normal text-lg leading-7 text-gray-100 pb-2">{{ __('Name') }}</label>-->
            <!--                    <input type="text" name="name"-->
            <!--                        class="focus:outline-none text-base leading-4 font-poppins font-normal text-gray-100 block p-3 rounded-md z-20-->
            <!--                border border-gray-light w-full"-->
            <!--                        placeholder="{{ __('Name *') }}">-->
            <!--                </div>-->
            <!--                <div class="">-->
            <!--                    <label for="name"-->
            <!--                        class="font-poppins font-normal text-lg leading-7 text-gray-100 pb-2">{{ __('Email address') }}</label>-->
            <!--                    <input type="email" required name="email"-->
            <!--                        class="focus:outline-none text-base leading-4 font-poppins font-normal text-gray-100 block p-3 rounded-md z-20-->
            <!--                border border-gray-light w-full"-->
            <!--                        placeholder="{{ __('Email *') }}">-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div class="grid md:grid-cols-2 sm:grid-cols-1 xxsm:grid-cols-1 mt-5 gap-3">-->
            <!--                <div class="w-full">-->
            <!--                    <label for="report_reason"-->
            <!--                        class="font-poppins font-normal text-lg leading-7 text-gray-100 pb-2">{{ __('Report Reason') }}</label>-->
            <!--                    <select id="report_reason" name="reason"-->
            <!--                        class="w-full focus:outline-none text-base leading-4 font-poppins font-normal text-gray-100 block p-3 rounded-md z-20-->
            <!--                border border-gray-light">-->
            <!--                        <option class="font-poppins font-normal text-base leading-4 text-gray-100" selected-->
            <!--                            disabled>-->
            <!--                            {{ __('Select Reason') }}</option>-->
            <!--                        <option class="font-poppins font-normal text-base leading-4 text-gray-100"-->
            <!--                            value="Canceled Event">-->
            <!--                            {{ __('Canceled Event') }}</option>-->
            <!--                        <option class="font-poppins font-normal text-base leading-4 text-gray-100"-->
            <!--                            value="Copyright or Trademark Infringement">-->
            <!--                            {{ __('Copyright or Trademark Infringement') }}</option>-->
            <!--                        <option class="font-poppins font-normal text-base leading-4 text-gray-100"-->
            <!--                            value="Fraudulent of Unauthorized Event">-->
            <!--                            {{ __('Fraudulent of Unauthorized Event') }}</option>-->
            <!--                        <option class="font-poppins font-normal text-base leading-4 text-gray-100"-->
            <!--                            value="Offensive or Illegal Event">-->
            <!--                            {{ __('Offensive or Illegal Event') }}</option>-->
            <!--                        <option class="font-poppins font-normal text-base leading-4 text-gray-100"-->
            <!--                            value="Spam">-->
            <!--                            {{ __('Spam') }}</option>-->
            <!--                        <option class="font-poppins font-normal text-base leading-4 text-gray-100"-->
            <!--                            value="Other">-->
            <!--                            {{ __('Other') }}</option>-->
            <!--                    </select>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div class="w-full mt-5">-->
            <!--                <textarea id="message" rows="4" required name="message"-->
            <!--                    class="block p-2.5 w-full focus:outline-none text-base leading-4 font-poppins font-normal text-gray-100-->
            <!--            border border-gray-light rounded-md"-->
            <!--                    placeholder="{{ __('Describe your message...') }}"></textarea>-->

            <!--            </div>-->
            <!--            <input type="hidden" name="event_id" id="" value="{{ $data->id }}">-->
            <!--            <div class="mt-5 flex justify-end">-->
            <!--                <button-->
            <!--                    class="bg-primary text-white text-right font-poppins font-medium text-lg leading-7 px-5 py-2 rounded-md">{{ __('Send Message') }}</button>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </form>-->
            <!--</div>-->
        </div>
    </div>
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: {{ $data->lat }},
                    lng: {{ $data->lang }}
                },
                zoom: 13
            });
            let marker = new google.maps.Marker({
                position: {
                    lat: {{ $data->lat }},
                    lng: {{ $data->lang }}
                },
                map: map
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ $gmapkey }}&callback=initMap"></script>

@endsection

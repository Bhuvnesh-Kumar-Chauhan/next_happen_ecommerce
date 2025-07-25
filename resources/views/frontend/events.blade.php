@extends('frontend.master', ['activePage' => 'event'])
@section('title', __('All Events'))
@section('content')


<style>
    .object-cover {
        object-fit: fill;
    }
</style>

    <div class="pb-20 bg-scroll min-h-screen" style="background-image: url('images/events.png')">

        {{-- scroll --}}

        <div
            class="mt-5 3xl:mx-52 2xl:mx-28 1xl:mx-28 xl:mx-36 xlg:mx-32 lg:mx-36 xxmd:mx-24 xmd:mx-32 md:mx-28 sm:mx-20 msm:mx-16 xsm:mx-10 xxsm:mx-5 z-10 relative">
            <div
                class="absolute bg-blue blur-3xl opacity-10 s:bg-opacity-10 3xl:w-[370px] 3xl:h-[370px] 2xl:w-[300px] 2xl:h-[300px] 1xl:w-[300px] xmd:w-[300px] xmd:h-[300px] sm:w-[200px] sm:h-[300px] xxsm:w-[300px] xxsm:h-[300px] rounded-full -mt-5 2xl:-ml-20 1xl:-ml-20 sm:ml-2 xxsm:-ml-7">
            </div>
            <!--<div class="flex justify-start pt-5 z-10">-->
            <!--    <p-->
            <!--        class="font-poppins font-semibold md:text-5xl xxsm:text-2xl xsm:text-2xl sm:text-2xl text-blue leading-10 ">-->
            <!--        {{ __('Events') }}</p>&nbsp;&nbsp;-->
            <!--    <p-->
            <!--        class="font-poppins font-medium md:text-2xl xxsm:text-xl xsm:text-xl sm:text-xl text-blue leading-10 pt-3">-->
            <!--        ( {{ $events->count() }} )</p>-->
            <!--</div>-->
            <div class="mb-4 pt-4">
                <ul class="flex flex-wrap -mb-px text-lg font-medium text-center events xmd:space-y-0 md:space-y-2 sm:space-y-2 xxsm:space-y-2"
                    id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2 ">
                        <button
                            class="inline-block p-4 px-6 py-3 rounded-md z-20 font-poppins shadow-md focus:outline-none relative"
                            id="all_events" data-tabs-target="#events" type="button" role="tab" aria-controls="events"
                            aria-selected="false">{{ __('All Events') }}( {{ $events->count() }} )</button>
                    </li>
                    <li class="mr-2">
                        <button
                            class="inline-block z-20 px-5 py-3 rounded-md font-poppins shadow-md focus:outline-none relative"
                            id="online_events" data-tabs-target="#online" type="button" role="tab"
                            aria-controls="online"
                            aria-selected="false">{{ __('Online Events') }}({{ $onlinecount }})</button>
                    </li>
                    <li class="mr-2">
                        <button
                            class="inline-block z-20 px-5 py-3 rounded-md font-poppins shadow-md focus:outline-none relative"
                            id="venue_events" data-tabs-target="#venue" type="button" role="tab" aria-controls="venue"
                            aria-selected="false">{{ __('Offline Events') }}({{ $offlinecount }})</button>
                    </li>
                    <li class="mr-2">
                        <button class="inline-block z-20 px-5 py-3 rounded-md font-poppins shadow-md focus:outline-none relative"
                            id="previous_events" data-tabs-target="#previous" type="button" role="tab" aria-controls="previous"
                            aria-selected="false">{{ __('Previous Events') }} ({{ count($previousEvents ?? []) }})</button>
                    </li>
                    <li class="mr-2">
                        <button class="inline-block z-20 px-5 py-3 rounded-md font-poppins shadow-md focus:outline-none relative"
                            id="upcoming_events" data-tabs-target="#upcoming" type="button" role="tab" aria-controls="upcoming"
                            aria-selected="false">{{ __('Upcoming Events') }} ({{ count($upcomingEvents ?? []) }})</button>
                    </li>
                </ul>
            </div>
            
            <?php
            $previousEvents = $previousEvents ?? [];
            $upcomingEvents = $upcomingEvents ?? [];

            ?>
            @if (count($events) == 0)
                <div class="font-poppins font-medium text-lg leading-4 text-black mt-10  capitalize">
                    {{ __('There are no events added yet') }}
                </div>
            @endif
            <div id="myTabContent">
                <div class="hidden" id="events" role="tabpanel" aria-labelledby="all_events">
                    {{-- Upcoming Events --}}
                    <h2 class="font-poppins font-semibold text-2xl text-blue mt-10">{{ __('Upcoming Events') }}</h2>
                    <div
                        class="grid gap-x-7 1xl:grid-cols-4 xl:grid-cols-4 xlg:grid-cols-4 xmd:grid-cols-2 xxmd:gap-y-7 xmd:gap-y-7 xxsm:gap-y-7 sm:grid-cols-1 sm:gap-y-7 msm:grid-cols-1 xxsm:grid-cols-1 justify-between pt-10 z-30 relative">
                        <!--@foreach ($upcomingEvents as $item)-->
                        <!--    <div-->
                        <!--        class="shadow-2xl p-5 rounded-lg bg-white hover:scale-110 transition-all duration-500 cursor-pointer">-->
                        <!--        <a href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}">-->
                        <!--            <img src="{{ url('images/upload/' . $item->image) }}" alt=""-->
                        <!--                class="h-40 rounded-lg w-full object-cover bg-cover ">-->
                        <!--            <p class="font-popping font-semibold text-xl leading-8 pt-2">{{ $item->name }}</p>-->
                        <!--            <p class="font-poppins font-normal text-base leading-6 text-gray pt-1">-->
                        <!--                @if (Carbon\Carbon::parse($item->start_time)->format('d M Y') === Carbon\Carbon::parse($item->end_time)->format('d M Y'))-->
                        <!--                    {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }}-->
                        <!--                @else-->
                        <!--                    {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }} {{__('till')}} {{ Carbon\Carbon::parse($item->end_time)->format('d M Y') }}-->
                        <!--                @endif-->
                        <!--            </p>-->
                        <!--        </a>-->
                        <!--        <div class="flex justify-between mt-7">-->
                        <!--            @if (Auth::guard('appuser')->user())-->
                        <!--                @if (Str::contains($user->favorite, $item->id))-->
                        <!--                    <a href="javascript:void(0);" class="like"-->
                        <!--                        onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')"><img-->
                        <!--                            src="{{ url('images/heart-fill.svg') }}" alt=""-->
                        <!--                            class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg"></a>-->
                        <!--                @else-->
                        <!--                    <a href="javascript:void(0);" class="like"-->
                        <!--                        onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')"><img-->
                        <!--                            src="{{ url('images/heart.svg') }}" alt=""-->
                        <!--                            class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg"></a>-->
                        <!--                @endif-->
                        <!--            @endif-->
                        <!--            <a type="button" id="EventDetails{{ $item->id }}"-->
                        <!--                href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}"-->
                        <!--                class="text-primary text-center font-poppins font-medium text-base leading-7 flex">{{ __('View Details') }}-->
                        <!--                <i class="fa-solid fa-arrow-right w-3 h-3 mt-1.5 ml-2"></i>-->
                        <!--            </a>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--@endforeach-->
                        @foreach ($upcomingEvents as $item)
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
                        
                                $mediaPath = $isImage ? 'images/upload/' . basename($firstMedia)
                                           : ($isVideo ? 'videos/upload/' . basename($firstMedia) : null);
                            @endphp
                        
                            <div class="shadow-2xl p-5 rounded-lg bg-white hover:scale-110 transition-all duration-500 cursor-pointer">
                                <a href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}">
                                    @if ($mediaPath)
                                        @if ($isImage)
                                            <img src="{{ asset($mediaPath) }}" alt="{{ $item->name }}"
                                                class="h-40 rounded-lg w-full object-cover bg-cover">
                                        @elseif ($isVideo)
                                            
                                            <video autoplay muted playsinline loop
                                                class="h-40 rounded-lg w-full object-cover bg-cover"
                                            >
                                                <source src="{{ asset($mediaPath) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                    @endif
                        
                                    <p class="font-popping font-semibold text-xl leading-8 pt-2">{{ $item->name }}</p>
                                    <p class="font-poppins font-normal text-base leading-6 text-gray pt-1">
                                        @php
                                            $start = Carbon\Carbon::parse($item->start_time)->format('d M Y');
                                            $end = Carbon\Carbon::parse($item->end_time)->format('d M Y');
                                        @endphp
                                        {{ $start === $end ? $start : "$start till $end" }}
                                    </p>
                                </a>
                        
                                <div class="flex justify-between mt-7">
                                    @if (Auth::guard('appuser')->user())
                                        @php
                                            $isFav = Str::contains($user->favorite, $item->id);
                                        @endphp
                                        <a href="javascript:void(0);" class="like" onclick="addFavorite('{{ $item->id }}','event')">
                                            <img src="{{ url('images/' . ($isFav ? 'heart-fill.svg' : 'heart.svg')) }}" alt="Favorite"
                                                class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg">
                                        </a>
                                    @endif
                        
                                    <a href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}"
                                        class="text-primary text-center font-poppins font-medium text-base leading-7 flex">
                                        {{ __('View Details') }}
                                        <i class="fa-solid fa-arrow-right w-3 h-3 mt-1.5 ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach


                    </div>

                    {{-- Previous Events --}}
                    <h2 class="font-poppins font-semibold text-2xl text-blue mt-10">{{ __('Previous Events') }}</h2>
                    <div
                        class="grid gap-x-7 1xl:grid-cols-4 xl:grid-cols-4 xlg:grid-cols-4 xmd:grid-cols-2 xxmd:gap-y-7 xmd:gap-y-7 xxsm:gap-y-7 sm:grid-cols-1 sm:gap-y-7 msm:grid-cols-1 xxsm:grid-cols-1 justify-between pt-10 z-30 relative">
                        <!--@foreach ($previousEvents as $item)-->
                        <!--    <div-->
                        <!--        class="shadow-2xl p-5 rounded-lg bg-white hover:scale-110 transition-all duration-500 cursor-pointer">-->
                        <!--        <a href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}">-->
                        <!--            <img src="{{ url('images/upload/' . $item->image) }}" alt=""-->
                        <!--                class="h-40 rounded-lg w-full object-cover bg-cover ">-->
                        <!--            <p class="font-popping font-semibold text-xl leading-8 pt-2">{{ $item->name }}</p>-->
                        <!--            <p class="font-poppins font-normal text-base leading-6 text-gray pt-1">-->
                        <!--                @if (Carbon\Carbon::parse($item->start_time)->format('d M Y') === Carbon\Carbon::parse($item->end_time)->format('d M Y'))-->
                        <!--                    {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }}-->
                        <!--                @else-->
                        <!--                    {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }} {{__('till')}} {{ Carbon\Carbon::parse($item->end_time)->format('d M Y') }}-->
                        <!--                @endif-->
                        <!--            </p>-->
                        <!--        </a>-->
                        <!--        <div class="flex justify-between mt-7">-->
                        <!--            @if (Auth::guard('appuser')->user())-->
                        <!--                @if (Str::contains($user->favorite, $item->id))-->
                        <!--                    <a href="javascript:void(0);" class="like"-->
                        <!--                        onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')"><img-->
                        <!--                            src="{{ url('images/heart-fill.svg') }}" alt=""-->
                        <!--                            class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg"></a>-->
                        <!--                @else-->
                        <!--                    <a href="javascript:void(0);" class="like"-->
                        <!--                        onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')"><img-->
                        <!--                            src="{{ url('images/heart.svg') }}" alt=""-->
                        <!--                            class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg"></a>-->
                        <!--                @endif-->
                        <!--            @endif-->
                        <!--            <a type="button" id="EventDetails{{ $item->id }}"-->
                        <!--                href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}"-->
                        <!--                class="text-primary text-center font-poppins font-medium text-base leading-7 flex">{{ __('View Details') }}-->
                        <!--                <i class="fa-solid fa-arrow-right w-3 h-3 mt-1.5 ml-2"></i>-->
                        <!--            </a>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--@endforeach-->
                       @foreach ($previousEvents as $item)
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
                        
                            <div class="shadow-2xl p-5 rounded-lg bg-white hover:scale-110 transition-all duration-500 cursor-pointer">
                                <a href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}">
                                    @if ($mediaPath)
                                        @if ($isImage)
                                            <img src="{{ asset($mediaPath) }}" alt=""
                                                class="h-40 rounded-lg w-full object-cover bg-cover ">
                                        @elseif ($isVideo)
                                            <video autoplay muted playsinline loop
                                                class="h-40 rounded-lg w-full object-cover bg-cover"
                                            >
                                                <source src="{{ asset($mediaPath) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                    @endif
                        
                                    <p class="font-popping font-semibold text-xl leading-8 pt-2">{{ $item->name }}</p>
                                    <p class="font-poppins font-normal text-base leading-6 text-gray pt-1">
                                        @if (Carbon\Carbon::parse($item->start_time)->format('d M Y') === Carbon\Carbon::parse($item->end_time)->format('d M Y'))
                                            {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }}
                                        @else
                                            {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }} {{ __('till') }} {{ Carbon\Carbon::parse($item->end_time)->format('d M Y') }}
                                        @endif
                                    </p>
                                </a>
                        
                                <div class="flex justify-between mt-7">
                                    @if (Auth::guard('appuser')->user())
                                        @if (Str::contains($user->favorite, $item->id))
                                            <a href="javascript:void(0);" class="like"
                                                onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')">
                                                <img src="{{ url('images/heart-fill.svg') }}" alt=""
                                                    class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg">
                                            </a>
                                        @else
                                            <a href="javascript:void(0);" class="like"
                                                onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')">
                                                <img src="{{ url('images/heart.svg') }}" alt=""
                                                    class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg">
                                            </a>
                                        @endif
                                    @endif
                        
                                    <a type="button" id="EventDetails{{ $item->id }}"
                                        href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}"
                                        class="text-primary text-center font-poppins font-medium text-base leading-7 flex">
                                        {{ __('View Details') }}
                                        <i class="fa-solid fa-arrow-right w-3 h-3 mt-1.5 ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
                <div class="hidden" id="online" role="tabpanel" aria-labelledby="online_events">
                    <div
                        class="grid gap-x-7 1xl:grid-cols-4 xl:grid-cols-4 xlg:grid-cols-4 xmd:grid-cols-2 xxmd:gap-y-7 xmd:gap-y-7 xxsm:gap-y-7 sm:grid-cols-1 sm:gap-y-7 msm:grid-cols-1 xxsm:grid-cols-1 justify-between pt-10 z-30 relative">
                        <!--@foreach ($events as $item)-->
                        <!--    @if ($item->type == 'online')-->
                        <!--        <div class="shadow-2xl p-5 rounded-lg bg-white hover:scale-110 transition-all duration-500">-->
                        <!--            <a href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}">-->

                        <!--                <img src="{{ url('images/upload/' . $item->image) }}" alt=""-->
                        <!--                    class="h-40 rounded-lg w-full object-cover bg-cover ">-->
                        <!--                <p class="font-popping font-semibold text-xl leading-8 pt-2">-->
                        <!--                    {{ $item->name }}</p>-->
                        <!--                <p class="font-poppins font-normal text-base leading-6 text-gray pt-1">-->
                        <!--                    @if (Carbon\Carbon::parse($item->start_time)->format('d M Y') === Carbon\Carbon::parse($item->end_time)->format('d M Y'))-->
                        <!--                        {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }}-->
                        <!--                    @else-->
                        <!--                        {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }} {{__('till')}} {{ Carbon\Carbon::parse($item->end_time)->format('d M Y') }}-->
                        <!--                    @endif-->
                        <!--                </p>-->
                        <!--            </a>-->
                        <!--            <div class="flex justify-between mt-7">-->
                        <!--                @if (Auth::guard('appuser')->user())-->
                        <!--                    @if (Str::contains($user->favorite, $item->id))-->
                        <!--                        <a href="javascript:void(0);" class="like"-->
                        <!--                            onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')"><img-->
                        <!--                                src="{{ url('images/heart-fill.svg') }}" alt=""-->
                        <!--                                class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg"></a>-->
                        <!--                    @else-->
                        <!--                        <a href="javascript:void(0);" class="like"-->
                        <!--                            onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')"><img-->
                        <!--                                src="{{ url('images/heart.svg') }}" alt=""-->
                        <!--                                class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg"></a>-->
                        <!--                    @endif-->
                        <!--                @endif-->
                        <!--                <a type="button"-->
                        <!--                    href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}"-->
                        <!--                    class=" text-primary text-center font-poppins font-medium text-base leading-7 flex">{{ __('View Details') }}-->
                        <!--                    <i class="fa-solid fa-arrow-right w-3 h-3 mt-1.5 ml-2"></i>-->
                        <!--                </a>-->
                        <!--            </div>-->
                        <!--        </div>-->
                        <!--    @endif-->

                        <!--@endforeach-->
                        @foreach ($events as $item)
                            @if ($item->type == 'online')
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
                        
                                <div class="shadow-2xl p-5 rounded-lg bg-white hover:scale-110 transition-all duration-500">
                                    <a href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}">
                        
                                        @if ($mediaPath)
                                            @if ($isImage)
                                                <img src="{{ asset($mediaPath) }}" alt=""
                                                    class="h-40 rounded-lg w-full object-cover bg-cover ">
                                            @elseif ($isVideo)
                                                <video autoplay muted playsinline loop
                                                    class="h-40 rounded-lg w-full object-cover bg-cover"
                                                >
                                                    <source src="{{ asset($mediaPath) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @endif
                                        @endif
                        
                                        <p class="font-popping font-semibold text-xl leading-8 pt-2">{{ $item->name }}</p>
                                        <p class="font-poppins font-normal text-base leading-6 text-gray pt-1">
                                            @if (Carbon\Carbon::parse($item->start_time)->format('d M Y') === Carbon\Carbon::parse($item->end_time)->format('d M Y'))
                                                {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }}
                                            @else
                                                {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }} {{ __('till') }} {{ Carbon\Carbon::parse($item->end_time)->format('d M Y') }}
                                            @endif
                                        </p>
                                    </a>
                        
                                    <div class="flex justify-between mt-7">
                                        @if (Auth::guard('appuser')->user())
                                            @if (Str::contains($user->favorite, $item->id))
                                                <a href="javascript:void(0);" class="like"
                                                    onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')">
                                                    <img src="{{ url('images/heart-fill.svg') }}" alt=""
                                                        class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg">
                                                </a>
                                            @else
                                                <a href="javascript:void(0);" class="like"
                                                    onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')">
                                                    <img src="{{ url('images/heart.svg') }}" alt=""
                                                        class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg">
                                                </a>
                                            @endif
                                        @endif
                        
                                        <a type="button"
                                            href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}"
                                            class="text-primary text-center font-poppins font-medium text-base leading-7 flex">
                                            {{ __('View Details') }}
                                            <i class="fa-solid fa-arrow-right w-3 h-3 mt-1.5 ml-2"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach


                    </div>
                </div>
                <div class="hidden" id="venue" role="tabpanel" aria-labelledby="venue_events">
                    <div
                        class="grid gap-x-7 1xl:grid-cols-4 xl:grid-cols-4 xlg:grid-cols-4 xmd:grid-cols-2 xxmd:gap-y-7 xmd:gap-y-7 xxsm:gap-y-7 sm:grid-cols-1 sm:gap-y-7 msm:grid-cols-1 xxsm:grid-cols-1 justify-between pt-10 z-30 relative">
                        <!--@foreach ($events as $item)-->
                        <!--    @if ($item->type == 'offline')-->
                        <!--        <div-->
                        <!--            class="shadow-2xl p-5 rounded-lg bg-white hover:scale-110 transition-all duration-500">-->
                        <!--            <a href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}">-->
                        <!--                <img src="{{ url('images/upload/' . $item->image) }}" alt=""-->
                        <!--                    class="h-40 rounded-lg w-full object-cover bg-cover">-->
                        <!--                <p class="font-popping font-semibold text-xl leading-8 pt-2">-->
                        <!--                    {{ $item->name }}</p>-->
                        <!--                <p class="font-poppins font-normal text-base leading-6 text-gray pt-1">-->
                        <!--                    @if (Carbon\Carbon::parse($item->start_time)->format('d M Y') === Carbon\Carbon::parse($item->end_time)->format('d M Y'))-->
                        <!--                        {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }}-->
                        <!--                    @else-->
                        <!--                        {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }} {{__('till')}} {{ Carbon\Carbon::parse($item->end_time)->format('d M Y') }}-->
                        <!--                    @endif-->
                        <!--                </p>-->
                        <!--                <div class="flex justify-between mt-7">-->
                        <!--                    @if (Auth::guard('appuser')->user())-->
                        <!--                        @if (Str::contains($user->favorite, $item->id))-->
                        <!--                            <a href="javascript:void(0);" class="like"-->
                        <!--                                onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')"><img-->
                        <!--                                    src="{{ url('images/heart-fill.svg') }}" alt=""-->
                        <!--                                    class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg"></a>-->
                        <!--                        @else-->
                        <!--                            <a href="javascript:void(0);" class="like"-->
                        <!--                                onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')"><img-->
                        <!--                                    src="{{ url('images/heart.svg') }}" alt=""-->
                        <!--                                    class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg"></a>-->
                        <!--                        @endif-->
                        <!--                    @endif-->

                        <!--                    <a type="button"-->
                        <!--                        href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}"-->
                        <!--                        class=" text-primary text-center font-poppins font-medium text-base leading-7 flex">{{ __('View Details') }}-->
                        <!--                        <i class="fa-solid fa-arrow-right w-3 h-3 mt-1.5 ml-2"></i>-->
                        <!--                    </a>-->
                        <!--                </div>-->
                        <!--            </a>-->
                        <!--        </div>-->
                        <!--    @endif-->
                        <!--@endforeach-->
                       @foreach ($events as $item)
                            @if ($item->type == 'offline')
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
                        
                                <div class="shadow-2xl p-5 rounded-lg bg-white hover:scale-110 transition-all duration-500">
                                    <a href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}">
                                        @if ($mediaPath)
                                            @if ($isImage)
                                                <img src="{{ asset($mediaPath) }}" alt=""
                                                    class="h-40 rounded-lg w-full object-cover bg-cover">
                                            @elseif ($isVideo)
                                                <video autoplay muted playsinline loop
                                                    class="h-40 rounded-lg w-full object-cover bg-cover"
                                                >
                                                    <source src="{{ asset($mediaPath) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @endif
                                        @endif
                        
                                        <p class="font-popping font-semibold text-xl leading-8 pt-2">{{ $item->name }}</p>
                                        <p class="font-poppins font-normal text-base leading-6 text-gray pt-1">
                                            @if (Carbon\Carbon::parse($item->start_time)->format('d M Y') === Carbon\Carbon::parse($item->end_time)->format('d M Y'))
                                                {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }}
                                            @else
                                                {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }} {{ __('till') }} {{ Carbon\Carbon::parse($item->end_time)->format('d M Y') }}
                                            @endif
                                        </p>
                        
                                        <div class="flex justify-between mt-7">
                                            @if (Auth::guard('appuser')->user())
                                                @if (Str::contains($user->favorite, $item->id))
                                                    <a href="javascript:void(0);" class="like"
                                                        onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')">
                                                        <img src="{{ url('images/heart-fill.svg') }}" alt=""
                                                            class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg">
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0);" class="like"
                                                        onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')">
                                                        <img src="{{ url('images/heart.svg') }}" alt=""
                                                            class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg">
                                                    </a>
                                                @endif
                                            @endif
                        
                                            <a type="button"
                                                href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}"
                                                class="text-primary text-center font-poppins font-medium text-base leading-7 flex">
                                                {{ __('View Details') }}
                                                <i class="fa-solid fa-arrow-right w-3 h-3 mt-1.5 ml-2"></i>
                                            </a>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach


                    </div>
                </div>
                <div class="hidden" id="previous" role="tabpanel" aria-labelledby="previous_events">
                    <div class="grid gap-x-7 1xl:grid-cols-4 xl:grid-cols-4 xlg:grid-cols-4 xmd:grid-cols-2 xxmd:gap-y-7 xmd:gap-y-7 xxsm:gap-y-7 sm:grid-cols-1 sm:gap-y-7 msm:grid-cols-1 xxsm:grid-cols-1 justify-between pt-10 z-30 relative">
                        <!--@foreach ($previousEvents as $item)-->
                        <!--    <div class="shadow-2xl p-5 rounded-lg bg-white hover:scale-110 transition-all duration-500 cursor-pointer">-->
                        <!--        <a href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}">-->
                        <!--            <img src="{{ url('images/upload/' . $item->image) }}" alt=""-->
                        <!--                class="h-40 rounded-lg w-full object-cover bg-cover">-->
                        <!--            <p class="font-popping font-semibold text-xl leading-8 pt-2">{{ $item->name }}</p>-->
                        <!--            <p class="font-poppins font-normal text-base leading-6 text-gray pt-1">-->
                        <!--                @if (Carbon\Carbon::parse($item->start_time)->format('d M Y') === Carbon\Carbon::parse($item->end_time)->format('d M Y'))-->
                        <!--                    {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }}-->
                        <!--                @else-->
                        <!--                    {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }} {{__('till')}} {{ Carbon\Carbon::parse($item->end_time)->format('d M Y') }}-->
                        <!--                @endif-->
                        <!--            </p>-->
                        <!--        </a>-->
                        <!--        <div class="flex justify-between mt-7">-->
                        <!--            @if (Auth::guard('appuser')->user())-->
                        <!--                @if (Str::contains($user->favorite, $item->id))-->
                        <!--                    <a href="javascript:void(0);" class="like"-->
                        <!--                        onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')"><img-->
                        <!--                            src="{{ url('images/heart-fill.svg') }}" alt=""-->
                        <!--                            class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg"></a>-->
                        <!--                @else-->
                        <!--                    <a href="javascript:void(0);" class="like"-->
                        <!--                        onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')"><img-->
                        <!--                            src="{{ url('images/heart.svg') }}" alt=""-->
                        <!--                            class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg"></a>-->
                        <!--                @endif-->
                        <!--            @endif-->
                        <!--            <a type="button" href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}"-->
                        <!--                class="text-primary text-center font-poppins font-medium text-base leading-7 flex">{{ __('View Details') }}-->
                        <!--                <i class="fa-solid fa-arrow-right w-3 h-3 mt-1.5 ml-2"></i>-->
                        <!--            </a>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--@endforeach-->
                        
                        @foreach ($previousEvents as $item)
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
                        
                            <div class="shadow-2xl p-5 rounded-lg bg-white hover:scale-110 transition-all duration-500 cursor-pointer">
                                <a href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}">
                                    @if ($mediaPath)
                                        @if ($isImage)
                                            <img src="{{ asset($mediaPath) }}" alt=""
                                                class="h-40 rounded-lg w-full object-cover bg-cover">
                                        @elseif ($isVideo)
                                            <video autoplay muted playsinline loop
                                                class="h-40 rounded-lg w-full object-cover bg-cover"
                                            >
                                                <source src="{{ asset($mediaPath) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                    @endif
                        
                                    <p class="font-popping font-semibold text-xl leading-8 pt-2">{{ $item->name }}</p>
                                    <p class="font-poppins font-normal text-base leading-6 text-gray pt-1">
                                        @if (Carbon\Carbon::parse($item->start_time)->format('d M Y') === Carbon\Carbon::parse($item->end_time)->format('d M Y'))
                                            {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }}
                                        @else
                                            {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }} {{ __('till') }} {{ Carbon\Carbon::parse($item->end_time)->format('d M Y') }}
                                        @endif
                                    </p>
                                </a>
                                <div class="flex justify-between mt-7">
                                    @if (Auth::guard('appuser')->user())
                                        @if (Str::contains($user->favorite, $item->id))
                                            <a href="javascript:void(0);" class="like"
                                                onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')">
                                                <img src="{{ url('images/heart-fill.svg') }}" alt=""
                                                    class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg">
                                            </a>
                                        @else
                                            <a href="javascript:void(0);" class="like"
                                                onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')">
                                                <img src="{{ url('images/heart.svg') }}" alt=""
                                                    class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg">
                                            </a>
                                        @endif
                                    @endif
                                    <a type="button" href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}"
                                        class="text-primary text-center font-poppins font-medium text-base leading-7 flex">
                                        {{ __('View Details') }}
                                        <i class="fa-solid fa-arrow-right w-3 h-3 mt-1.5 ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
                <div class="hidden" id="upcoming" role="tabpanel" aria-labelledby="upcoming_events">
                    <div class="grid gap-x-7 1xl:grid-cols-4 xl:grid-cols-4 xlg:grid-cols-4 xmd:grid-cols-2 xxmd:gap-y-7 xmd:gap-y-7 xxsm:gap-y-7 sm:grid-cols-1 sm:gap-y-7 msm:grid-cols-1 xxsm:grid-cols-1 justify-between pt-10 z-30 relative">
                        <!--@foreach ($upcomingEvents as $item)-->
                        <!--    <div class="shadow-2xl p-5 rounded-lg bg-white hover:scale-110 transition-all duration-500 cursor-pointer">-->
                        <!--        <a href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}">-->
                        <!--            <img src="{{ url('images/upload/' . $item->image) }}" alt=""-->
                        <!--                class="h-40 rounded-lg w-full object-cover bg-cover">-->
                        <!--            <p class="font-popping font-semibold text-xl leading-8 pt-2">{{ $item->name }}</p>-->
                        <!--            <p class="font-poppins font-normal text-base leading-6 text-gray pt-1">-->
                        <!--                @if (Carbon\Carbon::parse($item->start_time)->format('d M Y') === Carbon\Carbon::parse($item->end_time)->format('d M Y'))-->
                        <!--                    {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }}-->
                        <!--                @else-->
                        <!--                    {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }} {{__('till')}} {{ Carbon\Carbon::parse($item->end_time)->format('d M Y') }}-->
                        <!--                @endif-->
                        <!--            </p>-->
                        <!--        </a>-->
                        <!--        <div class="flex justify-between mt-7">-->
                        <!--            @if (Auth::guard('appuser')->user())-->
                        <!--                @if (Str::contains($user->favorite, $item->id))-->
                        <!--                    <a href="javascript:void(0);" class="like"-->
                        <!--                        onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')"><img-->
                        <!--                            src="{{ url('images/heart-fill.svg') }}" alt=""-->
                        <!--                            class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg"></a>-->
                        <!--                @else-->
                        <!--                    <a href="javascript:void(0);" class="like"-->
                        <!--                        onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')"><img-->
                        <!--                            src="{{ url('images/heart.svg') }}" alt=""-->
                        <!--                            class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg"></a>-->
                        <!--                @endif-->
                        <!--            @endif-->
                        <!--            <a type="button" href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}"-->
                        <!--                class="text-primary text-center font-poppins font-medium text-base leading-7 flex">{{ __('View Details') }}-->
                        <!--                <i class="fa-solid fa-arrow-right w-3 h-3 mt-1.5 ml-2"></i>-->
                        <!--            </a>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--@endforeach-->
                        @foreach ($upcomingEvents as $item)
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
                        
                            <div class="shadow-2xl p-5 rounded-lg bg-white hover:scale-110 transition-all duration-500 cursor-pointer">
                                <a href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}">
                                    @if ($mediaPath)
                                        @if ($isImage)
                                            <img src="{{ asset($mediaPath) }}" alt=""
                                                class="h-40 rounded-lg w-full object-cover bg-cover">
                                        @elseif ($isVideo)
                                            <video autoplay muted playsinline loop
                                                class="h-40 rounded-lg w-full object-cover bg-cover"
                                            >
                                                <source src="{{ asset($mediaPath) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                    @endif
                        
                                    <p class="font-popping font-semibold text-xl leading-8 pt-2">{{ $item->name }}</p>
                                    <p class="font-poppins font-normal text-base leading-6 text-gray pt-1">
                                        @if (Carbon\Carbon::parse($item->start_time)->format('d M Y') === Carbon\Carbon::parse($item->end_time)->format('d M Y'))
                                            {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }}
                                        @else
                                            {{ Carbon\Carbon::parse($item->start_time)->format('d M Y') }} {{ __('till') }} {{ Carbon\Carbon::parse($item->end_time)->format('d M Y') }}
                                        @endif
                                    </p>
                                </a>
                                <div class="flex justify-between mt-7">
                                    @if (Auth::guard('appuser')->user())
                                        @if (Str::contains($user->favorite, $item->id))
                                            <a href="javascript:void(0);" class="like"
                                                onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')">
                                                <img src="{{ url('images/heart-fill.svg') }}" alt=""
                                                    class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg">
                                            </a>
                                        @else
                                            <a href="javascript:void(0);" class="like"
                                                onclick="addFavorite('{{ $item->id }}','{{ 'event' }}')">
                                                <img src="{{ url('images/heart.svg') }}" alt=""
                                                    class="object-cover bg-cover fillLike bg-white-light p-2 rounded-lg">
                                            </a>
                                        @endif
                                    @endif
                                    <a type="button" href="{{ url('/event/' . $item->id . '/' . Str::slug($item->name)) }}"
                                        class="text-primary text-center font-poppins font-medium text-base leading-7 flex">
                                        {{ __('View Details') }}
                                        <i class="fa-solid fa-arrow-right w-3 h-3 mt-1.5 ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
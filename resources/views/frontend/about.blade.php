@extends('frontend.master', ['activePage' => null])
@section('title', __('About-'))
@section('content')
<div class="bg-scroll min-h-screen" style="background-image: url('{{ asset('images/events.png') }}')">

    {{-- Scroll Button --}}
    <div class="mr-4 flex justify-end z-30">
        <a href="#" class="scroll-up-button bg-primary rounded-full p-4 fixed z-20 2xl:mt-[49%] xl:mt-[59%] xlg:mt-[68%] lg:mt-[75%] xxmd:mt-[83%] md:mt-[90%] xmd:mt-[90%] sm:mt-[117%] msm:mt-[125%] xsm:mt-[160%]">
            <img src="{{ asset('images/downarrow.png') }}" alt="Scroll Down" class="w-3 h-3 z-20">
        </a>
    </div>

    {{-- About Content --}}
    <div class="mt-5 3xl:mx-52 2xl:mx-28 1xl:mx-28 xl:mx-36 xlg:mx-32 lg:mx-36 xxmd:mx-24 xmd:mx-32 md:mx-28 sm:mx-20 msm:mx-16 xsm:mx-10 xxsm:mx-5 z-10 relative">
        <div class="space-y-10 mt-10 mb-5">
            <p class="font-semibold font-poppins text-5xl leading-10 text-black mt-10">{{ __('Our Story') }}</p>
        </div>

        <div class="font-normal font-poppins text-xl leading-7 text-black-100 space-y-6">
            <p>
                Welcome to <b>Next Happen</b> — India’s most dynamic and versatile event-tech platform, designed to transform how people discover, attend, and organize events of every kind. From grand corporate summits and educational seminars to live concerts, movies, weddings, and private get-togethers — if it’s happening, it’s happening on Next Happen.
            </p>
            <br>
            <p>
                We are more than just a ticketing portal. We are a comprehensive digital ecosystem built to empower event organizers, streamline attendee experiences, and provide venue and service partners with meaningful exposure. Our platform is a bridge that connects ambition with audience, vision with execution, and ideas with real-world impact.
            </p>
            <br>

            <h3 class="font-semibold ">Our Mission</h3>
            <p>
                Our mission at <b>Next Happen</b> is simple yet powerful — <b>to make every event possible, discoverable, and extraordinary.</b> Whether you're hosting or attending, the process is seamless, secure, and memorable. We aim to democratize the event industry by offering tools and technology that help everyone — from first-time planners to seasoned professionals — thrive in the events space.
            </p>
            <br>

            <h3 class="font-semibold ">What We Do</h3>
            <ul style="list-style-type: disc; padding-left: 20px;">
                <li><b>Smart Event Listings</b><br>We enable organizers to list any type of event and reach their audience using tailored discoverability tools.</li>
                <li><b>Seamless Ticketing Experience</b><br>Manage your entire ticketing process with real-time tracking, confirmations, digital QR codes, and fraud protection.</li>
                <li><b>Venue, Hotel & Restaurant Booking</b><br>Book venues, hotels, and restaurants directly via our curated inventory.</li>
                <li><b>Event Planning & Execution Tools</b><br>Access marketing, attendee management, RSVP handling, analytics, and logistics tools.</li>
                <li><b>Diverse Event Categories</b><br>We support everything from leadership summits and music fests to weddings and brand launches.</li>
            </ul>
            
            <br>

            <h3 class="font-semibold ">Why Choose Us</h3>
            <ul style="list-style-type: disc; padding-left: 20px;">
                <li><b>All-In-One Convenience:</b> Ticketing, planning, booking, promotions, analytics — all in one place.</li>
                <li><b>Tech-Powered & User-First:</b> Built with cutting-edge technology for a world-class experience.</li>
                <li><b>Trustworthy & Transparent:</b> Verified listings and secure transactions to protect users and hosts.</li>
                <li><b>Tailored Support:</b> Dedicated team to help with tech, strategy, and success.</li>
                <li><b>Highly Scalable:</b> Suitable for events of all sizes — from 20 to 50,000+ attendees.</li>
            </ul>
            <br>

            <h3 class="font-semibold ">Who We Serve</h3>
            <ul style="list-style-type: disc; padding-left: 20px;">
                <li><b>Event Organizers:</b> Creators, agencies, corporations, and communities who want to host impactful events.</li>
                <li><b>Attendees & Explorers:</b> Curious minds and fun-lovers looking for unique experiences.</li>
                <li><b>Venue Partners & Service Providers:</b> Hotels, decorators, photographers, etc., seeking exposure and bookings.</li>
                <li><b>Brands & Sponsors:</b> Companies wanting impactful audience engagement.</li>
            </ul>
            <br>

            <h3 class="font-semibold ">Our Vision</h3>
            <p>
                We envision a world where discovering, booking, and managing events is seamless, exciting, and human. At <b>Next Happen</b>, we aim to be the heartbeat of the event ecosystem — empowering creativity, connecting cultures, and building communities through experiences. Our long-term goal is to be India’s leading event-tech brand, enabling events in both metro cities and emerging towns.
            </p>

            <br>
            <p><b>The Next Happen Difference</b></p>
            <ul style="list-style-type: disc; padding-left: 20px;">
                <li><b>Multi-Category, Multi-City Coverage</b></li>
                <li><b>Verified Listings & Genuine Reviews</b></li>
                <li><b>Real-Time Analytics & Event Performance Tracking</b></li>
                <li><b>Custom Marketing Campaigns & Outreach Support</b></li>
                <li><b>Robust Refund, Cancellation, and Dispute Resolution Policies</b></li>
            </ul>

            <br>
            <h3 class="font-semibold ">Join the Movement</h3>
            <p>
                Whether you're a startup launching your first pitch event, an NGO organizing a fundraiser, or someone seeking a weekend plan — <b>Next Happen is for you.</b><br>
                We are the future of event discovery, interaction, and celebration. Go ahead — list your event, book your seat, or just browse what's happening around you. Because life’s most memorable experiences aren't in the past — <b>they’re what’s Next Happen.</b>
            </p><br>
        </div>
    </div>
</div>
@endsection

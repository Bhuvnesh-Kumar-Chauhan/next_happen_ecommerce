@extends('frontend.master', ['activePage' => 'home'])
@section('title', __('Landing'))
@section('content')

<style>
    /* Hero Section Styles */
    .hero-section {
        position: relative;
        width: 100%;
        height: 100vh;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    
    .hero-video {
        position: absolute;
        top: 
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
    }
    
    .hero-video-embed {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        width: 100%;
        max-width: 1200px;
        color: white;
        padding: 20px;
        font-family: "Barlow", Sans-serif;
        gap: 30px;
    }
    
    /* Left Content */
    .left-content {
        flex: 1;
        min-width: 300px;
        max-width: 50%;
        text-align: left;
    }
    
    .left-content h2 {
        font-size: 35px;
        font-weight: 600;
        line-height: 42px;
        margin-bottom: 15px;
    }
    
    .stats {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .stat-item {
        font-size: 20px;
        font-weight: 500;
    }
    
    /* Form Section */
    .form-section {
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        max-width: 400px;
        width: 100%;
        text-align: center;
    }
    
    /* Form Inputs */
    .form-section h3 {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 15px;
        color: #333;
    }
    
    .form-section h4 {
        font-size: 16px;
        font-weight: 400;
        margin-bottom: 15px;
        color: #555;
    }
    
    .form-section input,
    .form-section textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        color:black;
    }
    
    .form-section button {
        background-color: #65469b;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        width: 100%;
    }
    
    .form-section button:hover {
        background-color: #523380;
    }
    
    
    .arrow-image-container{
        margin-left:250px;
    }
    
    
    /* 📱 RESPONSIVE FIXES */
    @media (max-width: 1024px) {
        .hero-content {
            flex-direction: column;
            text-align: center;
        }
    
        .left-content {
            max-width: 100%;
            text-align: center;
        }
    
        .stats {
            justify-content: center;
        }
    
        .form-section {
            max-width: 90%;
        }
    }
    
    @media (max-width: 600px) {
        .left-content h2 {
            font-size: 28px;
            line-height: 34px;
        }
    
        .stat-item {
            font-size: 18px;
        }
    
        .form-section {
            max-width: 100%;
        }
    }

</style>

<style>
    /* Client Section Styles */
    .client-section {
        padding: 75px 0;
        background-color: #f9f9f9;
        text-align: center;
    }

    .client-section h2 {
        font-size: 32px;
        font-weight: 600;
        margin-bottom: 40px;
        color: #333;
        font-family: "Barlow", Sans-serif;
    }

    .client-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 30px;
        padding: 0 5%;
    }

    .client-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .client-logo img {
        max-width: 100%;
        height: auto;
    }

    .client-logo:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
</style>

<style>
.event-management {
    text-align: center;
    padding: 70px 20px;
    background: #fdf9f5;
    position: relative;
    overflow: hidden;
}

.event-management h2 {
    font-size: 2.5rem;
    margin-bottom: 15px;
    font-weight: 700;
    color: #222;
    position: relative;
    display: inline-block;
}

.divider {
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #FF7F50, #FF6347);
    margin: 0 auto 30px;
    border-radius: 2px;
}

.event-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(240px, 1fr));
    gap: 25px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.event-card {
    background-size: cover;
    background-position: center;
    color: white;
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 16px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    cursor: pointer;
    font-size: 1.4rem;
    font-weight: 700;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    z-index: 1;
}

.event-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.3) 100%);
    border-radius: 16px;
    transition: all 0.4s ease;
    z-index: -1;
}

.event-card:hover {
    transform: scale(1.05) translateY(-5px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
}

.event-card:hover::before {
    background: linear-gradient(135deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 100%);
}

.quote-button {
    display: inline-block;
    margin-top: 40px;
    padding: 14px 32px;
    background: linear-gradient(90deg, #FF7F50, #FF6347);
    color: white;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    border-radius: 30px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 127, 80, 0.3);
    border: none;
    cursor: pointer;
}

.quote-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(255, 127, 80, 0.4);
    background: linear-gradient(90deg, #FF6347, #FF4500);
}

/* Make every 5th card larger */
/*.event-card:nth-child(5n) {*/
/*    grid-column: span 2;*/
/*    height: 250px;*/
/*}*/
/*.event-card:nth-child(6n) {*/
/*    grid-column: span 2;*/
/*    height: 250px;*/
/*}*/

@media (max-width: 768px) {
    .event-management {
        padding: 50px 15px;
    }
    
    .event-management h2 {
        font-size: 2rem;
    }
    
    .event-card {
        height: 160px;
        font-size: 1.2rem;
    }
    
    .event-card:nth-child(5n) {
        grid-column: span 1;
        height: 160px;
    }
}
</style>

<style>
.work-gallery {
    text-align: center;
    padding: 50px;
    background: #fff;
}
.work-gallery h2 {
    font-size: 28px;
    font-weight: bold;
    color: #111;
}
.divider {
    width: 50px;
    height: 5px;
    background: red;
    margin: 10px auto 30px;
}
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    max-width: 1000px;
    margin: auto;
}
.gallery-item {
    background-size: cover;
    background-position: center;
    height: 150px;
    border-radius: 8px;
    position: relative;
    overflow: hidden;
    filter: brightness(1.2);
}

/* Play Button (Only on Video Items) */
.gallery-item.video .play-button {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(255, 255, 255, 0.8);
    color: black;
    font-size: 24px;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

/* Hide Play Button on Normal Images */
.gallery-item:not(.video) .play-button {
    display: none;
}

.quote-button {
    margin-top: 20px;
    background: linear-gradient(to right, #65469b, #65469b);
    color: white;
    border: none;
    padding: 12px 24px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
}
.quote-button:hover {
    background: linear-gradient(to right, #65469b, #65469b);
}
</style>

<style>
    .about-us {
        display: flex;
        justify-content: center;
        align-items: center;
        background: #fff7f3;
        padding: 50px;
    }

    .about-container {
        display: flex;
        align-items: center;
        max-width: 1200px;
        flex-direction: column; /* Stack items vertically on smaller screens */
    }

    .about-images {
        position: relative;
        text-align: center; /* Center images on smaller screens */
    }

    .about-image {
        width: 100%; /* Full width on smaller screens */
        max-width: 300px; /* Limit maximum width */
        height: 200px;
        background-size: cover;
        background-position: center;
        border-radius: 10px;
        margin-bottom: 20px; /* Add spacing between images */
    }

    .about-image.bottom {
        position: static; /* Remove absolute positioning on smaller screens */
        margin-top: 20px; /* Add spacing between images */
    }

    .about-content {
        max-width: 100%; /* Full width on smaller screens */
        margin-left: 0; /* Remove left margin on smaller screens */
        text-align: center; /* Center text on smaller screens */
        padding: 0 20px; /* Add padding for better readability */
    }

    h2 {
        font-size: 24px;
        font-weight: bold;
    }

    .divider {
        width: 50px;
        height: 5px;
        background: red;
        margin: 10px auto; /* Center divider on smaller screens */
    }

    .quote-button {
        display: inline-block;
        padding: 10px 20px;
        background: linear-gradient(to right, #65469b, #65469b);
        color: white;
        font-weight: bold;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 10px;
    }

    /* Responsive Adjustments */
    @media (min-width: 768px) {
        .about-container {
            flex-direction: row; /* Side-by-side layout on larger screens */
        }

        .about-images {
            text-align: left; /* Align images to the left on larger screens */
        }

        .about-image {
            width: 300px; /* Fixed width on larger screens */
        }

        .about-image.bottom {
            position: absolute; /* Re-enable absolute positioning on larger screens */
            left: 50px;
            top: 100px;
        }

        .about-content {
            max-width: 500px; /* Limit content width on larger screens */
            margin-left: 150px; /* Add left margin on larger screens */
            text-align: left; /* Align text to the left on larger screens */
        }

        .divider {
            margin: 10px 0; /* Reset divider margin on larger screens */
        }
    }
</style>

<style>
.counter-section {
    position: relative;
    background: url('https://event-solutionservice.com/planner/wp-content/uploads/2024/12/counterbg.webp') no-repeat center center/cover;
    height: auto;
    padding: 50px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 87, 34, 0.7); /* Orange overlay */
}

.container {
    position: relative;
    z-index: 1;
    max-width: 1200px;
    width: 100%;
}

.counter-wrapper {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* 4 columns for large screens */
    gap: 20px;
}

.counter-box {
    background: white;
    padding: 50px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

/* RESPONSIVE FIXES */
@media (max-width: 992px) {
    .counter-wrapper {
        grid-template-columns: repeat(2, 1fr); /* 2 columns for tablets */
    }
}

@media (max-width: 600px) {
    .counter-wrapper {
        grid-template-columns: repeat(1, 1fr); /* 1 column for mobile screens */
    }
}

</style>

<style>
body {
    font-family: Arial, sans-serif;
}

.why-choose-us {
    text-align: center;
    padding: 50px 20px;
    background: #fdf6f2;
}

.section-title {
    font-size: 32px;
    font-weight: bold;
}

.divider {
    width: 50px;
    height: 5px;
    background: red;
    margin: 10px auto;
    border-radius: 5px;
}

.container {
    max-width: 1200px;
    margin: auto;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* 2 columns per row */
    gap: 20px;
    margin-top: 30px;
}

@media (max-width: 768px) {
    .features-grid {
        grid-template-columns: repeat(1, 1fr); /* 1 column per row on smaller screens */
    }
}

.feature-box {
    display: flex;
    align-items: center;
    background: white;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.feature-box:hover {
    transform: scale(1.05);
}

.feature-box img {
    width: 50px;
    height: 50px;
    margin-right: 15px;
}

.feature-text {
    text-align: left;
}

.feature-text h3 {
    margin: 0;
    font-size: 18px;
    color: #000;
}

.feature-text p {
    margin: 5px 0 0;
    font-size: 14px;
    color: #666;
}

</style>

<style>
    /* 🎯 Banner Section */
.banner {
    position: relative;
    width: 100%;
    height: 350px;
    background: url('https://event-solutionservice.com/planner/wp-content/uploads/2024/12/management_11.webp') no-repeat center center/cover;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: white;
}

/* 🔥 Dark Overlay */
.banner-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6); /* Dark effect */
}

/* 🎤 Banner Content */
.banner-content {
    position: relative;
    z-index: 1;
    max-width: 800px;
}

/* 🏆 Title */
.banner-title {
    font-size: 30px;
    font-weight: bold;
    margin-bottom: 10px;
}

/* 💡 Subtitle */
.banner-subtitle {
    font-size: 18px;
    margin-bottom: 20px;
}

/* ✨ Highlighted Text */
.highlight {
    color: #65469b;
    font-weight: bold;
}


/* 📌 Footer */
.site-footer {
    background: #111;
    color: white;
    text-align: center;
    padding: 10px;
    font-size: 14px;
}

.footer-text {
    margin: 0;
}

</style>

<section id="form-section">
    <div class="hero-section">
        <!-- Video Background -->
        <!--<div class="hero-video">-->
        <!--    <iframe class="hero-video-embed" frameborder="0" allowfullscreen="" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" src="https://www.youtube-nocookie.com/embed/6iPOnRScbE0?controls=0&rel=0&playsinline=1&cc_load_policy=0&enablejsapi=1&origin=https%3A%2F%2Fevent-solutionservice.com&widgetid=3&forigin=https%3A%2F%2Fevent-solutionservice.com%2Fplanner%2F%3Fgad_source%3D1%26gclid%3DEAIaIQobChMI9dWNzuaSjAMVt6NmAh33ZyUiEAAYASAAEgIZ1vD_BwE%23form&aoriginsup=1&vf=1&autoplay=1&mute=1" id="widget4" data-gtm-yt-inspected-8="true"></iframe>-->
        <!--</div>-->
        
        <div class="hero-video">
            <video class="hero-video-embed" autoplay muted loop playsinline>
                <source src="{{asset('videos/landing_video.mp4')}}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    
        <!-- Hero Content -->
        <div class="hero-content">
            <!-- Left Side: Content -->
            <div class="left-content">
                <h2>Best Corporate  Event Management company in Delhi - Ncr</h2>
                <p class="tagline">Where Every Event Becomes a Grand Experience </p>
                <div class="stats">
                    <div class="stat-item">
                        <p>100+</p>
                    </div>
                    
                    <div class="stat-item">
                        <p>Events Completed</p>
                    </div>
                </div>
                
                <div class="arrow-image-container">
        			<img decoding="async" width="150" height="50" src="https://event-solutionservice.com/planner/wp-content/uploads/2024/12/arrorpng-150.webp" class="attachment-full size-full wp-image-567" alt="">															
        		</div>
                
            </div>
            
    
            <!-- Right Side: Form -->
            <div class="form-section">
                <h3>GET IN TOUCH</h3>
                <h4>From annual parties to seminars, we handle it all</h4>
                <form action="{{ route('lead.submit') }}" method="POST">
                     @csrf
                    <input type="text" name="name" placeholder="Full Name" required>
                    <input type="email" name="email" placeholder="Business Email" required>
                    <input type="tel" name="phone"  placeholder="+91 Phone Number" required>
                    <select name="event_type" required style="
                        display: block;
                        width: 100%;
                        padding: 10px;
                        border: 1px solid #ddd;
                        border-radius: 4px;
                        font-size: 16px;
                        background-color: white;
                        color:#0f0e0e75;
                        margin: 10px 0;
                        -webkit-appearance: none;
                        -moz-appearance: none;
                        appearance: none;
                        background-repeat: no-repeat;
                        background-position: right 10px center;
                    ">
                        <option value=""selected>What type of event do you want?</option>
                        <option value="Business Event">Business Event</option>
                        <option value="Workshops">Workshops</option>
                        <option value="Business Meetings">Business Meetings</option>
                        <option value="Exhibitions">Exhibitions</option>
                        <option value="Award Shows">Award Shows</option>
                        <option value="Product Launch">Product Launch</option>
                        <option value="Others">Others</option>
                    </select>
                    <select name="requirement" required style="
                        display: block;
                        width: 100%;
                        padding: 10px;
                        border: 1px solid #ddd;
                        border-radius: 4px;
                        font-size: 16px;
                        background-color: white;
                        color:#0f0e0e75;
                        margin: 10px 0;
                        -webkit-appearance: none;
                        -moz-appearance: none;
                        appearance: none;
                        background-repeat: no-repeat;
                        background-position: right 10px center;
                    ">
                        <option value=""selected>Requirements </option>
                        <option value="sponsorships">Sponsorships</option>
                        <option value="audience">Audience</option>
                        <option value="business Meetings">Business Meetings</option>
                        <option value="venue">Venue</option>
                        <option value="fabrication">Fabrication</option>
                        <option value="influencer">Influencer</option>
                        <option value="celebrity">Celebrity</option>
                        <option value="speaker">Speaker</option>
                        <option value="others">Others</option>
                    </select>
                    <textarea name="description" placeholder="Your Description" rows="4" required></textarea>
                    
                    <button type="submit">GET A QUOTE</button>
                </form>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="client-section">
        <h2>WHO WE’VE WORKED WITH</h2>
        <div class="divider"></div>
        <div class="client-grid">
            <!-- Client Logos -->
            <div class="client-logo">
                <img src="{{ asset('images/work/(1).png') }}" alt="founderclubIndia">
            </div>
            <div class="client-logo">
                <img src="{{ asset('images/work/(2).png') }}" alt="foodaward">
            </div>
            <div class="client-logo">
                <img src="{{ asset('images/work/(3).png') }}" alt="bharatbusinessaward">
            </div>
            <div class="client-logo">
                <img src="{{ asset('images/work/(4).png') }}" alt="draxxfashion">
            </div>
            <div class="client-logo">
                <img src="{{ asset('images/work/(5).png') }}" alt="fashionindia">
            </div>
            <div class="client-logo">
                <img src="{{ asset('images/work/(6).png') }}" alt="ashwaveda">
            </div>
            <div class="client-logo">
                <img src="{{ asset('images/work/(7).jpg') }}" alt="taiiki">
            </div>
            
        </div>
        <br>
        <br>
        <!-- Anchor Link to Form Section -->
        <a href="#form-section" class="quote-button">GET A QUOTE</a>
    </div>
</section>
        


<section class="event-management">
    <h2>OUR EVENT MANAGEMENT SOLUTIONS</h2>
    <div class="divider"></div>
    <div class="event-grid">
        <div class="event-card" style="background-image: url('{{ asset('images/work/management(1).png') }}');">Award Shows</div>
        <div class="event-card" style="background-image: url('{{ asset('images/work/management(2).png') }}');">Corporate Parties</div>
        <div class="event-card" style="background-image: url('{{ asset('images/work/management(3).png') }}');">Product Launch</div>
        <div class="event-card" style="background-image: url('{{ asset('images/work/management(4).png') }}');">Corporate Event</div>
        <div class="event-card" style="background-image: url('{{ asset('images/work/management(5).png') }}');">Launch Parties</div>
        <div class="event-card" style="background-image: url('{{ asset('images/work/management(8).png') }}');">Sports Events</div>
    </div>
    <br><br>
    <a href="#form-section" class="quote-button">GET A QUOTE</a>
</section>

<section class="work-gallery">
            <h2> OUR WORK</h2>
            <div class="divider"></div>
            <div class="gallery-grid">
                <div class="gallery-item video">
                    <video autoplay loop muted playsinline style="width: 100%; height: 100%; object-fit: cover;">
                        <source src="{{ asset('images/work/Next Happen Website Video.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

                
                <div class="gallery-item video" >
                    <video autoplay loop muted playsinline style="width: 100%; height: 100%; object-fit: cover;">
                        <source src="{{ asset('images/work/work(2).mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="gallery-item video" >
                    <video autoplay loop muted playsinline style="width: 100%; height: 100%; object-fit: cover;">
                        <source src="{{ asset('images/work/Untitled design (10).mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="gallery-item video" >
                    <video autoplay loop muted playsinline style="width: 100%; height: 100%; object-fit: cover;">
                        <source src="{{ asset('images/work/work(3).mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="gallery-item" style="background-image: url('images/work/management(3).png');"></div>
                <div class="gallery-item video" >
                    <video autoplay loop muted playsinline style="width: 100%; height: 100%; object-fit: cover;">
                        <source src="{{ asset('images/work/work(5).mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="gallery-item video" >
                    <video autoplay loop muted playsinline style="width: 100%; height: 100%; object-fit: cover;">
                        <source src="{{ asset('images/work/work(6).mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="gallery-item video" >
                    <video autoplay loop muted playsinline style="width: 100%; height: 100%; object-fit: cover;">
                        <source src="{{ asset('images/work/work(7).mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <!--<div class="gallery-item" style="background-image: url('https://event-solutionservice.com/planner/wp-content/uploads/2024/12/about1.webp');"></div>-->
            </div>
            <br><br>
            <a href="#form-section" class="quote-button">GET A QUOTE</a>
        </section>

        <section class="about-us">
            <div class="about-container">
                <div class="about-images">
                    <div class="about-image top" style="background-image: url('https://event-solutionservice.com/planner/wp-content/uploads/2024/12/about1.webp');"></div>
                    
                </div>
                <div class="about-content">
                    <h2>ABOUT US</h2>
                    <div class="divider"></div>
                    <p>Next Happen is an  event management company,  a one-stop platform for all your event-related needs. From seamless event planning to flawless execution, we specialize in delivering extraordinary experiences within just 48 hours, handling over 2,000+ guests effortlessly.<br>
                    <br>Whether it's a corporate event, award show, business conference, networking event, or any special occasion, Next Happen is here to support you at every step – from concept to completion.<br>
                    <br>If you're looking for a team that brings innovation, precision, and perfection, Next Happen is the platform where your event dreams turn into reality.<br>"You Plan It, We Make It Happen!"</p><br>
                    <a href="#form-section" class="quote-button">GET A QUOTE</a>
                </div>
            </div>
        </section>

<section class="counter-section">
    <div class="overlay"></div>
    <div class="container">
        <div class="counter-wrapper">
            <div class="counter-box">
                <h2 class="counter">1,00+</h2>
                <p>Projects Delivered</p>
            </div>
            <div class="counter-box">
                <h2 class="counter">50+</h2>
                <p>Happy & Satisfied Clients</p>
            </div>
            <div class="counter-box">
                <h2 class="counter">30+</h2>
                <p>Team Members</p>
            </div>
            <div class="counter-box">
                <h2 class="counter">3+</h2>
                <p>Years of Excellence</p>
            </div>
        </div>
    </div>
</section>

<section class="why-choose-us">
    <h2 class="section-title">WHY CHOOSE US</h2>
    <div class="divider"></div>
    <div class="container">
        <div class="features-grid">
            <div class="feature-box">
                <img src="data:image/png;base64,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" alt="Reliable Service">
                <div class="feature-text">
                    <h3>Punctual & Reliable Service</h3>
                    <p>We ensure timely and dependable event management, meeting all deadlines with precision.</p>
                </div>
            </div>
            
            <div class="feature-box">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAF4AAABeCAMAAACdDFNcAAAAb1BMVEVMaXEAAAAAAAD/TgYAAAAEAQAAAAAAAACcMAAAAAAAAAD/TwP/UQD/TwT/TwT/TwL/TwUAAAAAAAAAAAAAAAD/TwP/UAMAAAAAAAD/TwMAAAD/TwMAAAD/TwT/TwRYGwGGKgFoIAH/UAQAAADNQANx0IVEAAAAInRSTlMAiA0mWDLhHQV1rtwP+O1THtM+8b6EoJv4Pk/KY2m38Yrbe0885wAAAAlwSFlzAAALEwAACxMBAJqcGAAABKlJREFUeNrtmNm2oygUhsEo4pAYxSkOqW53vf8zdgOiqOBw6pyLWiv/lTH6sWdIEProI7/pusb/MToDAGA/xe9AqPt2sBf4CNEQWJYxCClCfuB9H71hwALMAHKEcgCGAwas+QKIumHKSB44C3oNMMWlU9e1e91MMr7LAjpHpoYaE4C0E0n1uxSA4Brqq/EJODivQr5IOPErgAA5gTvdoG7g8Gera/SOW83DQrkX08sNQLh9OAS4Fn2fAVP++qn2dgiQiYs4KYokFpeZcc09YQBXXyvXosPxtHgMwzA8Cirx12JDCaTLxcb29GuxEn0Po96cn0N9qX19nsFZ2eiL01QyTsUwqRgz0jjn8Zkem2k1j88Z5iD0vM/4+xMhR3xxvjazZSmMeF6rhE+ZftDU8zrj5RucxnvLYTV+xKp7Sh1fqkfw+djXi4cb6QyG2rHhnSt4ROZSnCsnAEixt8yszK2H0yvBQaEyVCgFMjoBQChCLx3/EnUMlxq30Y3JlONNRQC4+e+Z/paBJ9WVsUDJvNE56dw1nmzQ50PRH0/ZyhcnpguQSqYT6lkbG/TWSnp7m1v5kio+Mn3Hd1OAdM6DGkY0Kdu2TOgYyQtVM4anElsJ35zSeaD4NaR082h6ceYIdXK7YljjVaLBfA3Gr7vL24mwKsMVdhejqgMgWQUMqwmKGVQZmZv8lkjdri83mi+Vegh5qfqkjI9VST1iG8HxzPKnlOQcG4qtC9Kc01X8nlM/WMx3qumosVKdi+IOchfRLAVC+aaTUermcwce4Z0U7NJGegBAyHbOHOExQN65JnUhaDukJxeU6zXyicY5wlNmqGstrbP5XRWGVafKSSX4AO/vNWBmmYpY4fMT+GAP71rwWZZl5OfwjtgVvhH/KqUK+iP4aN6tfgI/bSjJF/B+p08y6nrfi88XE9YVZ7NvxJPFkTqQB5EP/oP/2/AYY8z+HN9Y8IZ5H7+jlQq1W61+qQZy0cVuVd6loifKWC3EOkTb8XZLF6d0obtA5F3ANvi66ipY/BqNpfjW6Yzi42m6TaM1vtROCiu8flKg1iPSQmvzxcnK5+ccUq/xfFV5zkF99Hid4r+X+F7edTyPblPry1MaevGTfXsCHhf3Bb3VTiDGyuHHpFKVy5H6deh1j834uFDlGB2E/9Wu8/pGR/hEM6jYgz/LNXy43w7wt0Wm+F8JFtHJx8FmzgbvlctEjT/GDUqiLXwdzDX+19Ygc3He3oNJPdrB//Pb8EZrOOqagm56VsdbDFpbhBDtNz62r8Lk6Yxfd8eqyXeDHiUIxZEhTwpvMMhSDVsf74VYP5F/DJjw2+549PO/LVotG3x8q29f251F4LeJ4gbFcwxUJxqDjnZEILQalKyL0+QjRfv4f42JErbOtIjafNzXr987Bmn7RL8XdJsMBpV69uevH1YfrTKMpFWintZqPQq6rTuW6s3wpY8mWbtj6aBpKg7vwy14myizQckWfhh0hNCabu2OtZPHxch1OlG3+wkfd/H7BhVnfNzBH3RH/DjhoxV/bFB/JehL/BmD5Og5nABb/L08ZdDrQtA1/GmDkuR00EdFp7rjy7pdNuijj/7XfwOPPIEkj2j8AAAAAElFTkSuQmCC" alt="Exceptional Experiences">
                <div class="feature-text">
                    <h3>Exceptional Experiences</h3>
                    <p>Trust us to deliver outstanding events every time.</p>
                </div>
            </div>
            <div class="feature-box">
                <img src="data:image/png;base64,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" alt="Modern Management">
                <div class="feature-text">
                    <h3>Sophisticated & Modern Management</h3>
                    <p>Experience cutting-edge event management with our ultramodern approach.</p>
                </div>
            </div>
            <div class="feature-box">
                <img src="data:image/png;base64,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" alt="Quality">
                <div class="feature-text">
                    <h3>Commitment To Quality</h3>
                    <p>We are ready to bear penalties if we fail to meet the scheduled timeline.</p>
                </div>
            </div>
            
            <div class="feature-box">
                <img src="data:image/png;base64,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" alt="Personalized Service">
                <div class="feature-text">
                    <h3>Personalized Service</h3>
                    <p>Receive tailored event solutions that perfectly align with your unique vision and objectives.</p>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <!-- Anchor Link to Form Section -->
    <a href="#form-section" class="quote-button">GET A QUOTE</a>
</section>

<section class="banner">
    <div class="banner-overlay"></div>
    <div class="banner-content">
        <h2 class="banner-title">Ready to Elevate Your <span class="highlight">Next Event?</span></h2>
        <p class="banner-subtitle">Connect with Us and Let's Create Something <span class="highlight">Extraordinary!</span></p>
        <br>
        <br>
        <!-- Anchor Link to Form Section -->
        <a href="#form-section" class="quote-button">GET A QUOTE</a>
    </div>
</section>

<footer class="site-footer">
    <p class="footer-text">
        Copyright &copy; <span id="current-year">@php echo date('Y'); @endphp</span> <a href="https://nexthappen.com" target="_blank" class="footer-link">Nexthappen</a>
    </p>
</footer>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let counters = document.querySelectorAll(".counter");
    let speed = 200;

    counters.forEach(counter => {
        let target = +counter.innerText.replace(/\D/g, '');
        let count = 0;
        let increment = target / speed;

        let updateCounter = () => {
            count += increment;
            if (count < target) {
                counter.innerText = Math.ceil(count) + "+";
                requestAnimationFrame(updateCounter);
            } else {
                counter.innerText = target + "+";
            }
        };

        updateCounter();
    });
});
</script>


@endsection
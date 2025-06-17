@extends('frontend.master', ['activePage' => null])
@section('title', __('How We Help'))
@section('content')

<style>
    /* General Styles */
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background: #f4f4f9;
      color: #333;
      line-height: 1.6;
    }

    h1, h2, h3 {
      font-weight: 600;
      /*color: #0f0c29;*/
    }

    a {
      color: #000;
      text-decoration: none;
    }

    a:hover {
      text-decoration: none;
    }
    

    /* Hero Section */
    .hero {
      text-align: center;
      padding: 100px 20px;
      background-image: url('images/upload/67c1875f8923c.jpg'); 
      background-size: cover;
      background-position: center;
      color: #fff;
      position: relative;
    }

    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5); /* Overlay to make text readable */
    }

    .hero h1 {
      font-size: 3.5rem;
      margin-bottom: 20px;
      animation: fadeIn 2s ease-in-out;
      position: relative;
      z-index: 1;
    }

    .hero p {
      font-size: 1.2rem;
      max-width: 800px;
      margin: 0 auto;
      animation: fadeIn 3s ease-in-out;
      position: relative;
      z-index: 1;
    }

    /* Key Offerings Section */
    .offerings {
      padding: 60px 20px;
      background: #fff;
    }

    .offerings h2 {
      text-align: center;
      font-size: 2.5rem;
      margin-bottom: 40px;
    }

    .offerings-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .offering-card {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      text-align: center;
      transition: transform 0.3s ease;
    }

    .offering-card:hover {
      transform: translateY(-10px);
    }

    .offering-card h3 {
      font-size: 1.5rem;
      margin-bottom: 10px;
      color: #0f0c29;
    }

    .offering-card p {
      font-size: 1rem;
      color: #666;
    }
    
    
     .benefits {
      padding: 60px 20px;
      background: #fff;
    }

    .benefits h2 {
      text-align: center;
      font-size: 2.5rem;
      margin-bottom: 40px;
      color: #0f0c29;
    }

    .benefits-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .benefit-card {
      background: #fff;
      padding: 25px 20px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .benefit-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .benefit-card h3 {
      font-size: 1.4rem;
      color: #65469b;
      margin-bottom: 10px;
    }

    .benefit-card p {
      font-size: 1rem;
      color: #555;
    }

    /* Call-to-Action Section */
    .cta {
      text-align: center;
      padding: 60px 20px;
      background: linear-gradient(135deg, #0f0c29, #fff);
    }

    .cta h2 {
      font-size: 2.5rem;
      margin-bottom: 20px;
    }

    .cta a {
      background: #65469b;
      color: #fff;
      padding: 10px 20px;
      border-radius: 5px;
      font-size: 1.2rem;
      transition: background 0.3s ease;
    }

    .cta a:hover {
      background: #65469b;
    }

    /* Animations */
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
</style>

<!-- Hero Section -->
<section class="hero">
    <h1>We Help You Succeed</h1>
    <p>At Nexthappen, we empower innovators, businesses, and communities to achieve their goals through collaboration, resources, and cutting-edge solutions.</p>
</section>

<!-- Key Offerings Section -->
<section class="offerings">
    <h2>How We Help</h2>
    <div class="offerings-grid">
        <div class="offering-card">
            <h3><a href="/contact">Events</a></h3>
            <p><a href="/contact">Workshops, Business Meetups, Conferences, Exhibitions, Business Award Shows & more.</a></p>
        </div>
        <div class="offering-card">
            <h3><a href="/contact">Sponsorships</a></h3>
            <p><a href="/contact">Partner with us to gain global visibility and connect with industry leaders.</a></p>
        </div>
        <div class="offering-card">
            <h3><a href="/contact">Audience</a></h3>
            <p><a href="/contact">Reach a targeted and engaged audience of innovators and decision-makers.</a></p>
        </div>
        <div class="offering-card">
            <h3><a href="/contact">Venue</a></h3>
            <p><a href="/contact">We provide world-class venues for your events, ensuring a memorable experience.</a></p>
        </div>
        <div class="offering-card">
            <h3><a href="/contact">Fabrication</a></h3>
            <p><a href="/contact">Custom fabrication services to bring your creative visions to life.</a></p>
        </div>
        <div class="offering-card">
            <h3><a href="/contact">Influencers</a></h3>
            <p><a href="/contact">Connect with top influencers to amplify your brand.</a></p>
        </div>
        <div class="offering-card">
            <h3><a href="/contact">Celebrities</a></h3>
            <p><a href="/contact">Connect with top celebrities to amplify your brand.</a></p>
        </div>
        <div class="offering-card">
            <h3><a href="/contact">Others</a></h3>
            <p><a href="/contact">Tailored solutions for your unique needs.</a></p>
        </div>
    </div>
</section>


<!-- Event Services -->
<section class="benefits">
    <h2>Event Services</h2>
    <div class="benefits-grid">
        <div class="benefit-card">
            <h3>Venue Booking</h3>
        </div>
        <div class="benefit-card">
            <h3>Fabrication & Setup</h3>
        </div>
        <div class="benefit-card">
            <h3>Celebrity & Influencer Booking</h3>
        </div>
        <div class="benefit-card">
            <h3>Audience Management</h3>
        </div>
        <div class="benefit-card">
            <h3>Production Services</h3>
        </div>
        <div class="benefit-card">
            <h3>Sponsorship Management</h3>
        </div>
        <div class="benefit-card">
            <h3>Ticketing & Registration</h3>
        </div>
    </div>
</section>

<!-- Call-to-Action Section -->
<section class="cta">
    <h2>Ready to Take the Next Step?</h2>
    <a href="/contact">Get in Touch</a>
</section>

@endsection
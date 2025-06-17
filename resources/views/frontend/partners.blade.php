@extends('frontend.master', ['activePage' => null])
@section('title', __('Partners Nexthappen'))
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
    }

    a {
      color: #000;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    /* Hero Section */
    .hero {
      text-align: center;
      padding: 100px 20px;
      background-image: url('images/upload/67c165928466f.jpg');
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
      background: rgba(0, 0, 0, 0.5);
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

    /* Section Wrapper */
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
      grid-template-columns: repeat(3, minmax(250px, 1fr));
      gap: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }
    .benefits-grids {
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

    /* CTA Section */
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
      background: #53357e;
    }

    /* Additional Section Styling */
    .register-section {
      background-color: #f9f9ff;
    }

    /* Animations */
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
</style>

<!-- Hero Section -->
<section class="hero">
    <h1>Partner with Nexthappen</h1>
    <p>NextHappen invites event partners from all over India to collaborate and manage business events listed on our platform. Whether you're based in Delhi, Mumbai, Pune, Bengaluru, Hyderabad, or any other city — you can partner with us and start working on high-quality business events in your area.</p>
</section>

<section class="cta">
    <a href="/contact">Get in Touch</a>
</section>

<!-- Sponsorship Benefits Section -->
<section class="benefits">
    <h2>Why Partner with Nexthappen?</h2>
    <div class="benefits-grid">
        <div class="benefit-card">
            <h3>Access to Verified Events</h3>
            <p> Get listed on our platform and receive event opportunities directly in your city or region.</p>
        </div>
        <div class="benefit-card">
            <h3>Expand Your Reach</h3>
            <p>Work on premium corporate events, startup summits, conferences, exhibitions, and more—powered by NextHappen’s pan-India visibility.</p>
        </div>
        <div class="benefit-card">
            <h3>Complete Event Ecosystem</h3>
            <p>Collaborate with us on venue booking, fabrication, branding, artist management, celebrity/influencer booking, production, and sponsorships.</p>
        </div>
        <div class="benefit-card">
            <h3>B2B Support You Can Count On</h3>
            <p>Our backend team helps with client coordination, scope clarity, and tech integrations to simplify execution.</p>
        </div>
        <div class="benefit-card">
            <h3>Earn with Every Project</h3>
            <p>Transparent payouts, fair commission, and recurring collaboration across multiple cities and categories.</p>
        </div>
    </div>
</section>

<!-- Who Can Register Section -->
<section class="benefits">
    <h2>Who Can Register?</h2>
    <div class="benefits-grid">
        <div class="benefit-card">
            <h3>Event Management Companies</h3>
        </div>
        <div class="benefit-card">
            <h3>Production & Fabrication Agencies</h3>
        </div>
        <div class="benefit-card">
            <h3>Celebrity / Influencer Managers</h3>
        </div>
        <div class="benefit-card">
            <h3>AV & Technical Production Experts</h3>
        </div>
        <div class="benefit-card">
            <h3>Sponsorship Consultants</h3>
        </div>
        <div class="benefit-card">
            <h3>Local Event Planners</h3>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="benefits">
    <h2>How It Works</h2>
    <div class="benefits-grids">
        <div class="benefit-card">
            <h3>1. Fill the Registration Form</h3>
            <p>Share your portfolio, company profile, and service regions.</p>
        </div>
        <div class="benefit-card">
            <h3>2. Get Verified by Our Team</h3>
            <p>We evaluate your credentials and onboard you as an official city partner.</p>
        </div>
        <div class="benefit-card">
            <h3>3. Receive Event Requests</h3>
            <p>Start getting event assignments and collaborate with organizers from across India.</p>
        </div>
        <div class="benefit-card">
            <h3>4. Execute & Earn</h3>
            <p>Deliver excellence, build your profile, and grow your revenue with repeat opportunities.</p>
        </div>
    </div>
</section>


<!-- CTA Section -->
<section class="cta">
    <h2>Ready to Partner?</h2>
    <a href="/contact">Get in Touch</a>
</section>

@endsection

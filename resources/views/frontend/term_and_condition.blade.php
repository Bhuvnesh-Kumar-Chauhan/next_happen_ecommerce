@extends('frontend.master', ['activePage' => null])
@section('title', __('Term-and-condition'))
@section('content')
<div class=" bg-scroll min-h-screen" style="background-image: url('images/events.png')">
        {{-- scroll --}}
        <div class="mr-4 flex justify-end z-30">
            <a type="button" href="{{url('#')}}" class="scroll-up-button bg-primary rounded-full p-4 fixed z-20  2xl:mt-[49%] xl:mt-[59%] xlg:mt-[68%] lg:mt-[75%] xxmd:mt-[83%] md:mt-[90%]
                    xmd:mt-[90%] sm:mt-[117%] msm:mt-[125%] xsm:mt-[160%]">
                <img src="{{asset('images/downarrow.png')}}" alt="" class="w-3 h-3 z-20">
            </a>
        </div>

        <div
            class="mt-5 3xl:mx-52 2xl:mx-28 1xl:mx-28 xl:mx-36 xlg:mx-32 lg:mx-36 xxmd:mx-24 xmd:mx-32 md:mx-28 sm:mx-20 msm:mx-16 xsm:mx-10 xxsm:mx-5 z-10 relative">
            <div class="space-y-10 mt-10 mb-5">
                <p class="font-semibold font-poppins text-5xl leading-10 text-black mt-10">{{__('Term and condition')}}</p>
            </div>
            <p class="font-normal font-poppins text-xl leading-7 text-black-100">
                <section class="about-two">
                    <div class="container">
                    <div>
                    
                    <br>
                    <div>
                        Welcome to Next Happen. These Terms & Conditions (“Terms”) govern your use of our website,
                        mobile applications, and services offered through the Next Happen platform. By accessing or using
                        any part of our platform, you agree to comply with and be legally bound by these Terms. If you do
                        not agree with any part of these Terms, you must not use our services.
                        <br>
                        Next Happen is a comprehensive event discovery and management platform that allows users to
                        explore, book, plan, and list events across categories such as business, entertainment, sports,
                        education, and lifestyle. The platform also facilitates related services including hotel bookings,
                        restaurant reservations, and local travel assistance.
            
                    </div>
                    <br>
                    <div>
                        <h3 class="font-semibold">
                         1. Eligibility and Account Registration
                        </h3>
                      
                       <br>
                        To use our services, you must be at least 18 years of age and capable of entering into a legally
                        binding agreement. By registering with Next Happen, you represent and warrant that all information
                        provided by you is accurate, current, and complete. You agree to keep your account credentials
                        confidential and to notify us immediately in case of any unauthorized access or suspected breach.
                        You are solely responsible for all activities carried out under your account.
                       
                    </div>
                    <br>
                    <div>
                        <h3 class="font-semibold">
                         2. Use of the Platform
                        </h3>
                       
            
                        <br>
                        You may use Next Happen’s services solely for lawful purposes. You agree not to misuse the
                        platform in any way that could harm, disable, overburden, or impair its functionality or interfere
                        with the usage of other users. This includes but is not limited to:<br>
                        <ul style="list-style-type: disc; padding-left: 20px;">
                            <li>Uploading false, misleading, or fraudulent content or listings.</li>
                            <li>Transmitting any malware, spyware, or other harmful code.</li>
                            <li>Using automated systems (such as bots) to access the platform without authorization.</li>
                            <li>Attempting to gain unauthorized access to our systems, data, or other users’ accounts.</li>
                        </ul>
                        <br>
                        We reserve the right to suspend or terminate your access if we believe you are violating these
                        Terms.
                            

                        
                    </div>
                    <br>
                        <div>
                            <h3 class="font-semibold">
                         3. Event Listings and Organizer Responsibilities
                        </h3>
                       
            
                        <br>
                     
                    If you are an event organizer, you agree that the information you provide in your event listing is
                    accurate, complete, and not misleading. You are solely responsible for the delivery, organization,
                    and conduct of your events, including securing permissions, managing attendees, handling refunds
                    (if applicable), and fulfilling any promises made in your listings.<br>
                    Next Happen acts only as a technology platform and does not assume any responsibility or liability
                    for the actual execution of events. In cases of event cancellations, postponements, or discrepancies,
                    the organizer is fully liable to address attendee concerns, refund policies, and legal obligations.<br>
                    We reserve the right to remove any event listings that violate our policies, contain inappropriate
                    content, or mislead users in any way.<br>
                    </div>
                    
                      <br>
                        <div>
                            <h3 class="font-semibold">
                         4. Bookings and Payments
                        </h3>
                      
                        <br>
                        For attendees booking events on the platform, payment must be made through the secure payment
                        gateway integrated with Next Happen. All ticket prices are displayed in the local currency and
                        include applicable taxes unless stated otherwise.<br>
                        Once a booking is confirmed, users will receive a digital ticket and a confirmation email. It is your
                        responsibility to ensure the accuracy of booking details at the time of purchase. In case of a dispute
                        or issue with the event, you are encouraged to first contact the event organizer directly. If no
                        resolution is achieved, Next Happen may step in as a neutral facilitator but does not guarantee any
                        outcome.<br>
                        Refunds and cancellation policies vary based on the event organizer and will be clearly stated on the
                        event listing. Next Happen is not liable for any financial loss due to organizer-related cancellations or
                        changes.<br>
                      
                    </div>
                    
                     <br>
                        <div>
                            <h3 class="font-semibold">
                         5. Platform Fees and Commission
                        </h3>
                   
            
                        <br>
                     Next Happen may charge event organizers a commission or platform fee for using our services to list
                    and promote events or for facilitating bookings. These fees will be communicated in advance and are
                    subject to change. Continued use of the platform after such changes constitutes acceptance of the
                    updated fee structure.<br>
                    Organizers must ensure transparency in ticket pricing and agree not to collect off-platform payments
                    to avoid commission. Doing so will result in suspension or permanent removal from the platform.<br>
                    </div>
                    
                      <br>
                        <div>
                            <h3 class="font-semibold">
                         6. Intellectual Property
                        </h3>
                 
            
            
                        <br>
            All content on the Next Happen platform—including but not limited to logos, branding, images, text,
graphics, icons, and software—is the property of Next Happen or its licensors and is protected by
copyright and other intellectual property laws.<br>
You may not reproduce, modify, distribute, or republish any content from the platform without
express written permission from Next Happen. Any unauthorized use of our intellectual property will
be subject to legal action.
<br>
Organizers retain ownership of their event content but grant Next Happen a non-exclusive, royalty-
free license to display, promote, and distribute their content for the purpose of marketing and
bookings.    <br>   </div>
                    
                     <br>
                        <div>
                            <h3 class="font-semibold">
                         7. User-Generated Content
                        </h3>
                    
            
                        <br>
                        The platform may allow users and organizers to post content such as reviews, photos, event
                        descriptions, or comments. By submitting such content, you grant Next Happen the right to use,
                        modify, display, and distribute it on our platform and associated marketing channels.<br>
                        You agree not to post content that is offensive, defamatory, discriminatory, misleading, or infringes
                        on any third-party rights. We reserve the right to remove any content that violates these Terms or
                        applicable laws.
                        </div>
                        
                             <br>
                        <div>
                            <h3 class="font-semibold">
                         8. Limitation of Liability
                        </h3>
                 
            
            
                        <br>
            TheTo the maximum extent permitted by law, Next Happen shall not be liable for any direct, indirect,
            incidental, consequential, or punitive damages arising from:
            <ul style="list-style-type: disc; padding-left: 20px;">
                <li>Your use or inability to use the platform.</li>
                <li>Any error, delay, interruption, or security breach.</li>
                <li>Cancellations, disputes, or misconduct by event organizers or attendees.</li>
                <li>Loss of data, revenue, or business opportunities.</li>
            </ul>
            <br>
            We do not guarantee the accuracy, reliability, or quality of any content or service available on the
platform. All services are provided “as is” and “as available.”
            </div>
            
                <br>
                        <div>
                            <h3 class="font-semibold">
                                9. Indemnification
                            </h3>
                            <br>
                            You agree to indemnify, defend, and hold harmless Next Happen, its founders, employees, affiliates,
                            and partners from and against any claims, liabilities, damages, losses, and expenses arising out of or
                            related to:
                            <ul style="list-style-type: disc; padding-left: 20px;">
                                <li>Your use of the platform.</li>
                                <li>Your violation of these Terms.</li>
                                <li>Your interactions or disputes with third parties, including event organizers or attendees.</li>
                                <li>Any content you submit to the platform.</li>
                            </ul>
                        </div>

             <br>
                        <div>
                            <h3 class="font-semibold">
                         10. Changes to the Terms
                        </h3>
             
            
            
                        <br>
            Next Happen reserves the right to modify these Terms at any time without prior notice. Updated
versions will be posted on this page with a revised “Last Updated” date. Your continued use of the
platform constitutes your acceptance of any changes. We encourage you to review the Terms
periodically to stay informed.
            </div>
            
             <br>
                        <div>
                            <h3 class="font-semibold">
                         11. Termination
                        </h3>
            
            
            
                        <br>
            We may suspend or terminate your access to the platform, with or without notice, if we believe you
have violated these Terms, engaged in fraudulent activity, or caused harm to other users or the
platform. Upon termination, all rights granted to you under these Terms will cease immediately.
            </div>
            
             <br>
                        <div>
                            <h3 class="font-semibold">
                         12. Governing Law and Jurisdiction
                        </h3>
            
            
            
                        <br>
            These Terms are governed by the laws of [Insert Governing Jurisdiction – e.g., India], without regard
to its conflict of law provisions. Any disputes arising under or related to these Terms shall be subject
to the exclusive jurisdiction of the courts located in [Insert City or State].
            </div>
            
            <br>
                        <div>
                            <h3 class="font-semibold">
                         13. Contact Us
                        </h3>
            
            
                        <br>
            For questions, feedback, or concerns regarding these Terms & Conditions, please reach out to:<br>
<b>Email:</b> info@nexthappen.com<br>
<b>Phone:</b> +91-9009008969<br>
<b>Address:</b> Office no. 911, Iconic Tower, Corenthum, Sector 62, Noida, India. 201309
            </div>
            <br>
                        
            
              <br>
                       

                    </div>
                    </div>
                </section>
            </p>

        </div>
    </div>
@endsection

@extends('frontend.master', ['activePage' => null])
@section('title', __('Refund-and-cancellation-policy'))
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
                <p class="font-semibold font-poppins text-5xl leading-10 text-black mt-10">{{__('Refund and cancellation policy')}}</p>
            </div>
            <p class="font-normal font-poppins text-xl leading-7 text-black-100">
                <section class="about-two">
                    <div class="container">
                    <div>
                    
                    <br>
                    <div>
                       At Next Happen, we are committed to delivering a transparent and trustworthy experience for both
event organizers and attendees. This Refund & Cancellation Policy outlines the terms under which
refunds, cancellations, or rescheduling of events are managed on our platform. By using our
services, whether to list, promote, or book events, you agree to abide by the terms outlined in this
policy.
            
                    </div>
                    <br>
                    <div>
                        <h3 class="font-semibold">
                         1. General Overview
                        </h3>
                        
                       <br>
                        Next Happen serves as a technology platform connecting event organizers with potential attendees.
                        We facilitate the listing, promotion, ticketing, and management of events. However, Next Happen
                        does not directly organize or host events. As such, refunds and cancellations are governed primarily
                        by the policies of individual event organizers, which will be clearly mentioned on each event listing.<br>
                        Attendees are strongly encouraged to review the specific cancellation and refund conditions
                        outlined on the respective event page prior to making a purchase. In instances where such
                        conditions are not defined, the standard policies mentioned in this document shall apply.
            
                       
                    </div>
                    <br>
                    <div>
                       
                        <h3 class="font-semibold">
                         2. Cancellation by the Attendee
                        </h3>
            
            If you, as an attendee, decide to cancel your ticket booking, your eligibility for a refund will depend
            on the refund policy set by the event organizer and whether the request meets the conditions
            specified. In general:
                        <br>
                         <ul style="list-style-type: disc; padding-left: 20px;">
                            <li><b>Refund eligibility</b> typically requires a minimum notice period before the event date (e.g., 7
days or more).</li>
                             <li><b>Refunds may be partial or full</b>, depending on the organizer’s discretion, less applicable
convenience fees or transaction charges.</li>
                             <li>If no explicit refund window is provided by the organizer,<b>no refund will be issued</b> once a
ticket is purchased.</li>
                             <li>Refund requests received after the event date or time will <b>not be entertained</b> under any
circumstance.</li>
                            
                        </ul>
                        <br>
                        All cancellation requests must be submitted via the method prescribed on the platform, typically
through the "My Bookings" section or via direct communication with our support team.
                    </div>
                    <br>
                        <div>
                            <h3 class="font-semibold">
                             3. Cancellation by the Organizer
                            </h3>
                       
                        <br>
                     
                         In case an event is cancelled by the organizer due to unforeseen circumstances such as low
                        registrations, venue issues, legal restrictions, weather, or any other cause, attendees will be eligible
                        for<b> a full refund of the ticket price</b>. This excludes platform service fees unless otherwise mandated
                        by local laws.<br>
                        The organizer is responsible for initiating the refund, and Next Happen will facilitate the process
within 7–10 working days upon receiving formal confirmation from the organizer. If the organizer
fails to take action or defaults, Next Happen may act as a mediator but holds no legal liability for the
organizer’s non-performance.<br>
In the case of<b> rescheduled events, </b> attendees will have the option to either retain their ticket for the
new date or request a refund within a defined window after the announcement of the new
schedule.

                    </div>
                    
                      <br>
                        <div>
                            <h3 class="font-semibold">
                             4. No-Show Policy
                            </h3>
                       
                        <br>
                       Attendees who fail to attend the event without prior notice or cancellation are not eligible for a
refund. It is the attendee’s responsibility to arrive on time and comply with all entry procedures.
Refunds will<b> not be issued for late arrivals, incomplete attendance, or dissatisfaction with event
content or logistics,</b> unless the event is found to be fraudulent or materially different from the
description provided on the platform.
                      
                    </div>
                    
                     <br>
                        <div>
                            <h3 class="font-semibold">
                                5. Event Modifications
                            </h3>
                      
                        <br>
                      In rare cases, organizers may make modifications to event details, such as venue, speaker line-up,
timing, or format (e.g., switching from offline to virtual). If these changes are considered minor or
necessary, a refund will generally <b>not be issued.</b> However, in cases where the attendee believes the
changes are substantial and affect their decision to attend, they may raise a refund request for

review. The final decision will rest with the event organizer, with Next Happen playing a facilitative
role.
                    </div>
                    <br>
                        <div>
                            <h3 class="font-semibold">
                             6. Processing of Refunds
                            </h3>
                       
                        <br>
                       All approved refunds will be processed using the original method of payment. Once approved, the
amount will be credited to your account within <b> 7–14 business days,</b> depending on the bank or
payment provider. Refunds are  <b>exclusive of convenience fees, payment gateway charges, or any
third-party commissions,</b> unless otherwise agreed.<br>
If a refund is delayed or not received within the stipulated period, users may contact our support
team with the booking reference number, payment receipt, and event details for escalation and
tracking.
                      
                    </div>
                    
                    <br>
                    <div>
                       
                        <h3 class="font-semibold">
                         7. Non-Refundable Circumstances
                        </h3>
            
            The following scenarios are generally considered <b>non-refundable</b> unless stated otherwise on the
event page or mandated by law:
                        <br>
                         <ul style="list-style-type: disc; padding-left: 20px;">
                            <li>Last-minute cancellations within 24–48 hours of the event.</li>
                             <li>Digital/online event access once credentials or links have been shared.</li>
                             <li>Ticket upgrades, promotions, or special pricing deals.</li>
                             <li>Tickets purchased from unauthorized sources or third-party resellers.</li>
                             <li>Group discounts or bulk tickets unless entire group cancellation is approved.</li>
                            
                        </ul>
                        <br>
                       
                    </div>
                    <br>
                        <div>
                            <h3 class="font-semibold">
                             8. Organizer Default & Fraudulent Events
                            </h3>
                       
                        <br>
                       In the unfortunate event of a fraudulent listing or a defaulting organizer who fails to execute the
event entirely, Next Happen reserves the right to <b>blacklist the organizer, initiate investigation
proceedings,</b> and issue partial or full refunds to affected users subject to internal review.<br>
Next Happen will work with legal authorities and payment gateways to retrieve and return customer
funds where applicable, but makes no guarantees of recovery in cases involving criminal deception
or financial insolvency of the organizer.
                      
                    </div>
                    
                    <br>
                
                        <div>
                            <h3 class="font-semibold">
                             9. Dispute Resolution
                            </h3>
                       
                        <br>
                       If a dispute arises regarding eligibility for a refund, attendees may raise a formal complaint with
proof (such as ticket receipt, communication trail, or screenshots) via the help and support section.
Disputes will be addressed within 5–10 working days and may require coordination between the
platform, attendee, and organizer.<br>
The decision reached by Next Happen’s dispute resolution team will be final and binding unless
legally challenged in the appropriate jurisdiction.
                      
                    </div>
                    
                    <br>
                    <div>
                            <h3 class="font-semibold">
                             10. Amendments to the Policy
                            </h3>
                       
                        <br>
                       Next Happen reserves the right to amend or update this Refund & Cancellation Policy at any time
without prior notice. Any changes will be published on this page with a revised effective date. It is
your responsibility to review this policy periodically to stay informed of any changes. Continued use
of the platform constitutes acceptance of the updated policy.
                      
                    </div>
                    
                    <br>
                    <div>
                            <h3 class="font-semibold">
                             11. Contact Us
                            </h3>
                       
                        <br>
                       For all refund, cancellation, or support inquiries, please reach out to:<br>
<b>Support Email:</b> info@nexthappen.com<br>
<b>Customer Care:</b> +91-9009008969<br>
<b>Office Address:</b> Office no. 911, Iconic Tower, Corenthum, Sector 62, Noida, India. 201309<br>
<b>Hours of Operation:</b> Monday-Friday, 9:30AM-6:30PM
                      
                    </div>
                    
                    <br>
            
                    </div>
                    </div>
                </section>
            </p>

        </div>
    </div>
@endsection

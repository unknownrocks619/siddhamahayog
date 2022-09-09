 <!-- About Author Start -->
 <div class="sidebar-widget event-info">
     <h5 class="widget-title"> Information </h5>
     <ul class="sidebar-widget-list">
         @php
         $date_carbon = \Carbon\Carbon::parse($event->event_start_date);
         $event_end_date = \Carbon\Carbon::parse($event->event_end_date);
         @endphp
         <li><span>Date:</span> {{ $date_carbon->format("d M, Y") }}</li>
         <li><span>Time:</span> ({{ $date_carbon->format("H:i A") }} - {{ $event_end_date->format("H:i A") }})</li>
         <li><span>Event Category:</span> {{ $event->full_address }}</li>
         <li><span>Support Person:</span> {{ $event->event_contact_person }}</li>
         <li><span>Enquiry Number:</span> {{ $event->event_contact_phone }}</li>
         <li><span>Email:</span> support@siddhamahayog.org</li>
     </ul>
     @if ( ! auth()->check() )
     <a href="#" class="sigma_btn-custom d-block w-100 mt-4">
         Subscribe Now
     </a>
     @endif

 </div>
 <!-- About Author End -->
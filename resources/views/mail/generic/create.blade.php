@component('mail::message')
  {{-- Heading --}}
  <img style="margin:auto; margin-bottom:20px;" src="{{ asset('storage/images/letterheads/mrt-letter-header.jpg') }}" alt="">
  {{-- Body --}}
  <div style="color:black;">
    <p style="margin-bottom: 30px;">Hello {{ $data['recipient_name'] ?? '[FIRSTNAME] [LASTNAME]' }},</p>
    <p style="margin-bottom: 30px;">{!! nl2br($data['message'] ?? '[MESSAGE]') !!}</p>
  </div>
  {{-- Footer --}}
  <img style="margin:auto; margin-bottom: 20px;" src="{{ asset('storage/images/letterheads/mrt-letter-deb-banner.jpg') }}" alt="">
  <p style="text-align:center;">
    {{ $selected_system->getFormattedContactNumber() }}<br>
    {{ $selected_system->contact_email }}<br>
    ABN: {{ $selected_system->abn }}<br>
    <span style="color:hsl(24, 100%, 50%);">
      {{ $selected_system->website_url }}
    </span>
  </p>
  <p style="text-align:center; margin-bottom: 30px;">Click <a href="https://mossrooftreatment.com.au/login">Here</a> to Unsubscribe</p>
  <p style="color:#000000;">
    Kind regards,<br>
    <span style="color:hsl(24, 100%, 50%);">
      {{ $selected_system->contact_name }} {{ $selected_system->short_title }}
    </span>
  </p>
@endcomponent

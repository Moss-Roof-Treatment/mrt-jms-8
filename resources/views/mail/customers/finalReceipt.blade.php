@component('mail::message')
  {{-- Heading --}}
  <img style="margin:auto; margin-bottom:20px;" src="{{ asset('storage/images/letterheads/mrt-letter-header.jpg') }}" alt="">
  {{-- Body --}}
  <div style="color:black;">
    <p style="margin-bottom: 30px;">Hello {{ $data['recipient_name'] ?? '[FIRSTNAME] [LASTNAME]' }},</p>
    <p style="margin-bottom: 30px;">{!! nl2br($selected_email_template->text) !!}</p>
  </div>
  {{-- Button --}}
  <p style="margin-bottom: 30px; color:black;">If you have a spare minute, we would appreciate it if you could plese complete a satisfaction survey to help us improve our business. To complete the survey:</p>
  @component('mail::button', ['url' => 'https://' . $selected_system->website_url . '/login' ])
    Click Here
  @endcomponent
  <p style="margin-bottom: 30px; color:black;">To view your deposit receipt and job details:</p>
  @component('mail::button', ['url' => 'https://' . $selected_system->website_url . '/login' ])
    Click Here
  @endcomponent
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
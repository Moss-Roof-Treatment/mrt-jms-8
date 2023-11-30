@component('mail::message')

  {{-- Heading --}}
  <img style="margin:auto; margin-bottom:20px;" src="{{ asset('storage/images/letterheads/mrt-letter-header.jpg') }}" alt="">
  {{-- Body --}}
  <div style="color:black;">
    <p style="margin-bottom: 30px;">Hello {{ $data['recipient_name'] ?? '[FIRSTNAME] [LASTNAME]' }},</p>
    <p style="margin-bottom: 30px;">{!! nl2br($selected_email_template->text) !!}</p>
  </div>
  {{-- Character Responses --}}
  <table style="width: 100%; margin-bottom: 20px;">
    <tbody>
      <tr>
        <td style="width: 25%; text-align:center;">
          <a href="{{ 'https://mossrooftreatment.com.au/emails/quote-reminder-emails-r1/' . $data['selected_quote_id'] }}">
            <img src="{{ asset('storage/images/characters/thumbs-up-100x100.jpg') }}" style="width:70px;" alt="thumbs-up-100x100.jpg">
            <p style="text-align:center;">Yes, we would like to proceed.<br>What's the next step?</p>
          </a>
        </td>
        <td style="width: 25%; text-align:center;">
          <a href="{{ 'https://mossrooftreatment.com.au/emails/quote-reminder-emails-r2/' . $data['selected_quote_id'] }}">
            <img src="{{ asset('storage/images/characters/shrugs-sholders-alt-100x100.jpg') }}" style="width:70px;" alt="shrugs-sholders-alt-100x100.jpg">
            <p style="text-align:center;">I've got further questions<br>Can you contact me?</p>
          </a>
        </td>
        <td style="width: 25%; text-align:center;">
          <a href="{{ 'https://mossrooftreatment.com.au/emails/quote-reminder-emails-r3/' . $data['selected_quote_id'] }}">
            <img src="{{ asset('storage/images/characters/thumbs-up-alt-100x100.jpg') }}" style="width:70px;" alt="thumbs-up-alt-100x100.jpg">
            <p style="text-align:center;">Please keep us in mind<br>we will contact you soon.</p>
          </a>
        </td>
        <td style="width: 25%; text-align:center;">
          <a href="{{ 'https://mossrooftreatment.com.au/emails/quote-reminder-emails-r4/' . $data['selected_quote_id'] }}">
            <img src="{{ asset('storage/images/characters/thumbs-down-100x100.jpg') }}" style="width:70px;" alt="thumbs-down-100x100.jpg">
            <p style="text-align:center;">Do not want to proceed.</p>
          </a>
        </td>
      </tr>
    </tbody>
  </table>
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
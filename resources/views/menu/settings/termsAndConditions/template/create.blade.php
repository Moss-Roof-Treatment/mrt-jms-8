<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex">

  <title>Moss Roof Treatment - Terms and Contitions</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <style>

    .text-primary
    {
      color:#0712a6;
    }

    .text-secondary
    {
      color:#db5800;
    }

    th, td {
      border: 2px solid #0712a6;
    }

    td 
    {
      font-size: 12px;
    }

    th
    {
      font-size: 12px;
    }

    p
    {
      font-size: 12px;
    }

    hr
    {
      border: 1px solid #0712a6;
    }

    div.page
    {
      page-break-after: always;
      page-break-inside: avoid;
    }

    html{height: 0;}

  </style>

</head>
<body>

  <div>

    {{-- page 1 and 2 --}}
    <div class="page">

      {{-- letterhead --}}
      <img class="img-responsive" src="{{ public_path('storage/images/letterheads/mrt-letterhead.jpg') }}" alt="">
      {{-- letterhead --}}

      {{-- body --}}
      <table class="table table-bordered">
        <tbody>
          <tr class="text-center">
            <th colspan="4">
              <h4><b>Terms of Engagement</b></h4>
            </th>
          </tr>
          <tr class="active">
            <th colspan="4">Section 1 – Scope of Engagement</th>
          </tr>
          <tr>
            <td colspan="4">
              <p><b>MRT:</b> Moss Roof Treatment Pty Ltd</p>
              <p><b>Client:</b> [ Customer Name Goes Here ]</p>
              <p><b>Property:</b> [ Address Goes Here ]</p>
              <p><b>Commencement Date (subject to variation):</b> [ Approx Start Date Goes Here ]</p>
              <p><b>Quote Reference:</b> [ Quote Identifier Goes Here ]</p>
            </td>
          </tr>
          <tr>
            <th colspan="4">Services</th>
          </tr>
          <tr>
            <td colspan="4">The Client has instructed MRT to provide the following Services to the Client:</td>
          </tr>
          <tr>
            <td colspan="4">
              <ol>
                <li>[ Quote Task Goes Here ]</li>
                <li>[ Quote Task Goes Here ]</li>
                <li>[ Quote Task Goes Here ]</li>
              </ol>
            </td>
          </tr>
          <tr>
            <th colspan="4">Fees</th>
          </tr>
          <tr>
            <td colspan="4">[ Pricing Goes Here ]</td>
          </tr>
          <tr>
            <th>Acknowledgements</th>
          </tr>
          <tr>
            <td colspan="4">
              <ol>
                <li>The Client acknowledges having received and read and understood the following documents prior to engaging MRT to perform the Services:</li>
                <ol type="a">
                  <li>Moss Removal Treatment – Safety Data Sheet (Appendix 1); and</li>
                  <li>Manufacturer Statement (Appendix 2).</li>
                </ol>
                <li>By accepting performance of the Services by MRT, the Client is deemed to have accepted these Terms of Engagement.</li>
              </ol>
            </td>
          </tr>
          <tr class="active">
            <th colspan="4">Section 2 – Terms and Conditions</th>
          </tr>
          <tr>
            <td colspan="4">
              <ol>
                @foreach ($all_headings as $heading)
                  <li><b>{{ $heading->title }}</b></li>
                  <ul class="list-unstyled mb-3">
                    @foreach ($heading->terms_sub_headings as $sub_headings)
                      <li>{{ $sub_headings->title }}</li>
                      <ol type="a">
                        @foreach ($sub_headings->terms_items as $items)
                          <li>{{ $items->text }}</li>
                          <ol type="i">
                            @foreach ($items->terms_sub_items as $sub_items)
                              <li>{{ $sub_items->text }}</li>
                            @endforeach
                          </ol>
                        @endforeach
                      </ol>
                    @endforeach
                  </ul>
                @endforeach
              </ol>
            </td>
          </tr>
        </tbody>
      </table>

      {{-- footer --}}
      <img class="img-responsive my-3" src="{{ public_path('storage/images/letterheads/mrt-letter-footer.jpg') }}" alt="">
      {{-- footer --}}

    </div> {{-- page --}}
    {{-- page 1 and 2 --}}

    {{-- page 3 --}}
    <div class="page">

      <table class="table table-bordered">

        <tr class="active">
          <th colspan="4">Section 3 – Acknowledgement</th>
        </tr>
        <tr>
          <th colspan="4">The Client agrees to be bound by the Agreement.</th>
        </tr>
        <tr>
          <th colspan="2" width="50%">Signatory</th>
          <th colspan="2" width="50%">Witness</th>
        </tr>
        <tr>
          <td width="15%">Print Full Name</td>
          <td width="35%"></td>
          <td width="15%">Print Full Name</td>
          <td width="35%"></td>
        </tr>
        <tr>
          <td width="15%">Address</td>
          <td width="35%"></td>
          <td width="15%">Address</td>
          <td width="35%"></td>
        </tr>
        <tr>
          <td width="15%">Signature</td>
          <td width="35%"></td>
          <td width="15%">Signature</td>
          <td width="35%"></td>
        </tr>
        <tr>
          <td width="15%">Date</td>
          <td width="35%"></td>
          <td width="15%">Date</td>
          <td width="35%"></td>
        </tr>
        <tr>
          <th colspan="2" width="50%">Signatory</th>
          <th colspan="2" width="50%">Witness</th>
        </tr>
        <tr>
          <td width="15%">Print Full Name</td>
          <td width="35%"></td>
          <td width="15%">Print Full Name</td>
          <td width="35%"></td>
        </tr>
        <tr>
          <td width="15%">Address</td>
          <td width="35%"></td>
          <td width="15%">Address</td>
          <td width="35%"></td>
        </tr>
        <tr>
          <td width="15%">Signature</td>
          <td width="35%"></td>
          <td width="15%">Signature</td>
          <td width="35%"></td>
        </tr>
        <tr>
          <td width="15%">Date</td>
          <td width="35%"></td>
          <td width="15%">Date</td>
          <td width="35%"></td>
        </tr>
      </table>
      {{-- body --}}

      {{-- footer --}}
      <img class="img-responsive my-3" src="{{ public_path('storage/images/letterheads/mrt-letter-footer.jpg') }}" alt="">
      {{-- footer --}}

    </div> {{-- page --}}
    {{-- page 3 --}}

    {{-- page 4 --}}
    <div class="page">

      {{-- letterhead --}}
      <img class="img-responsive" src="{{ public_path('storage/images/letterheads/mrt-letterhead.jpg') }}" alt="">
      {{-- letterhead --}}

      <h2>Letter of Efficacy from Our Suppliers</h2>
      <h3 class="text-right">26/06/2020</h3>
      <h2><b>MRT (Moss Roof Treatment).</b></h2>
      <br>
      <p>MRT 4 x 5L and 15L Terracotta Treatment<br>
      MRT 4 x 5L and 15L Colourbond Treatment<br>
      <u>To whom it may concern, (Commercial in Confidence):</u></p>
      <br>
      <p>As the formulator and manufacturer (For MRT) of these hightly effective roof treatment products, we can confirm their specific formulation is to act as direct acting Moss, algae and slime killing treatments, then subsequently to act as a resifual deterrent.</p>
      <br>
      <p>The complete formulation of these mixtures are proprietary, but the active agent in the concentrate is a 10% active solution of Alkyl Dimethyl Ammonium Chloride, also known as 'Benzalkonium Chloride'.</p>
      <br>
      <p>This quaternary ammonium compound is very well recognised within the industry as a staple Germicide, antimicrobial. algicide and slimicide. Out supplier of this raw material refers:</p>
      <br>
      <p>"Benzalkonium Chloride is a typr of cationic surfactant (a non-oxidising low corrosiveity biocide). It can sufficiently withhold algae propafation and sludge reproduction. Benzalkonium Chloride has dispersing and penetrating properties, so can effectively penetrate and remove sludge, algae and moss."</p>
      <br>
      <p>Considerable quantities of Benzalkonium Chloride are used in sanitisers and disinfectants, our suppliers quote the use of this active at 4000ppm will meet the requirements for a hospital grade disinfectant (TGA option B (Dirty conditions)). Non oxidising quaternaries are less affected by organic dirt than oxidisers like Sodium hypochlorite (bleach).</p>
      <br>
      <p>The MRT product in user (15:1 dilution) carry more active Benzalkonium Chloride than is required for hospital grade disinfection which is why (in our formulations) they make for such effective roof cleaning products.</p>
      <br>
      <br>
      <br>
      <p><b>Graham Harfield BSc (hons) MRSC (UK)<br>
      Chief Chemist / Technical Manager.</b></p>

      {{-- footer --}}
      <img class="img-responsive my-3" src="{{ public_path('storage/images/letterheads/mrt-letter-footer.jpg') }}" alt="">
      {{-- footer --}}

    </div> {{-- page --}}
    {{-- page 4 --}}

  </div>

</body>
</html>
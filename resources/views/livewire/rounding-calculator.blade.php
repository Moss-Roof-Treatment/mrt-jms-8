<div>

  <div class="row">
    <div class="col-sm-4 offset-sm-4">

      {{-- calculator form --}}
      <div class="form-group row">
        <label for="amount" class="col-md-3 col-form-label text-md-right">Amount</label>
        <div class="col-md-8">
          <input type="text" class="form-control @error('amount') is-invalid @enderror mb-2" name="amount" id="amount" value="{{ old('amount') }}" wire:model="amount" placeholder="Please enter the amount">
          @error('amount')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div> {{-- col-md-8 --}}
      </div> {{-- form-group row --}}
      {{-- calculator form --}}

      {{-- results --}}
      @if ($data == null)
        <div class="card">
          <div class="card-body">
            <h5 class="text-center mb-0">Please enter the required amount</h5>
          </div> {{-- card-body --}}
        </div> {{-- card --}}
      @else
        <table class="table table-bordered table-fullwidth table-striped">
          <tbody>
            <tr>
              <th>Net Amount (excluding GST)</th>
              <td>{{ $data['net'] }}</td>
            </tr>
            <tr>
              <th>GST (10.0%)</th>
              <td>{{ $data['gst'] }}</td>
            </tr>
            <tr>
              <th>Gross Amount (including GST)</th>
              <td>{{ $data['gross'] }}</td>
            </tr>
          </tbody>
        </table>
      @endif
      {{-- results --}}

    </div> {{-- col-sm-6 --}}
  </div> {{-- row --}}

</div>

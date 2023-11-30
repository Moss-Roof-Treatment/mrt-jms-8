@if (session('status'))
<section class="bg-success text-white">
  <div class="container pt-3 pb-2">
    <ul>
      <li>{{ session('status') }}</li>
    </ul>
  </div>
</section>
@endif

@if (session('success'))
<section class="bg-success text-white">
  <div class="container pt-3 pb-2">
    <ul>
      <li>{{ session('success') }}</li>
    </ul>
  </div>
</section>
@endif

@if (session('warning'))
<section class="bg-warning text-dark">
  <div class="container pt-3 pb-2">
    <ul>
      <li>{{ session('warning') }}</li>
    </ul>
  </div>
</section>
@endif

@if (session('danger'))
<section class="bg-danger text-white">
  <div class="container pt-3 pb-2">
    <ul>
      <li>{{ session('danger') }}</li>
    </ul>
  </div>
</section>
@endif

@if (count($errors) > 0)
<section class="bg-danger text-white">
  <div class="container pt-3 pb-2">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
</section>
@endif
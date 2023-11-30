@extends('layouts.app')

@section('title', '- Frequently Asked Questions - Edit Selected Frequently Asked Question')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">FAQ SETTINGS</h3>
    <h5>View Selected Frequently Asked Question</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('faq-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>FAQ Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('faq-settings.edit', $selected_faq->id) }}">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
        </a>
      </div> {{-- col-sm-3 pb-3 --}} 
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>Frequently Asked Question Details</b></p>

    <table class="table table-bordered table-fullwidth table-striped bg-white">
      <tbody>
        <tr>
          <th>Question</th>
          <td>{{ $selected_faq->question }}</td>
        </tr>
        <tr>
          <th>Answer</th>
          <td>{{ $selected_faq->answer }}</td>
        </tr>
        <tr>
          <th>Visibility</th>
          <td>
            @if($selected_faq->is_visible == 1)
              <span class="badge badge-success py-2 px-2 ml-2">
                <i class="fas fa-eye mr-2" aria-hidden="true"></i>Visible
              </span>
            @else
              <span class="badge badge-danger py-2 px-2 ml-2">
                <i class="fas fa-eye-slash mr-2" aria-hidden="true"></i>Not Visible
              </span>
            @endif
          </td>
        </tr>
      </tbody>
    </table>

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

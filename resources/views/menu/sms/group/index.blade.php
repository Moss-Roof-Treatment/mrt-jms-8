@extends('layouts.app')

@section('title', '- SMS - Group SMS - View All Sent Group SMS')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">GROUP SMS</h3>
    <h5>View All Sent Group SMS</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('sms.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>SMS Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('group-sms.create') }}">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New SMS
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- sent sms table --}}
    <h5 class="text-primary my-3"><b>All Sent Group SMS</b></h5>
    @if (!$all_sms->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no group sms to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>User Group</th>
              <th>SMS Template</th>
              <th>Sent Date</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_sms as $sms)
              <tr>
                <td>{{ $sms->sms_recipient_group->title }}</td>
                <td>{{ $sms->sms_template->title }}</td>
                <td>{{ date('d/m/y - h:iA', strtotime($sms->created_at)) }}</td>
                <td class="text-center">
                  <a href="{{ route('group-sms.show', $sms->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                  {{-- trash modal --}}
                  {{-- modal button --}}
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmTrashModal{{$sms->id}}">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Trash
                  </button>
                  {{-- modal button --}}
                  {{-- modal --}}
                  <div class="modal fade" id="confirmTrashModal{{$sms->id}}" tabindex="-1" role="dialog" aria-labelledby="confirmTrashModal{{$sms->id}}Title" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="confirmTrashModal{{$sms->id}}Title">Confirm Trash</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p class="text-center">Are you sure that you would like to trash this item?</p>
                          <form action="{{ route('group-sms.destroy', $sms->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-block">
                              <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Confirm Trash
                            </button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  {{-- modal --}}
                  {{-- trash modal --}}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- sent sms table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection
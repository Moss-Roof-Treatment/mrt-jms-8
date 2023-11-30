@extends('layouts.app')

@section('title', 'Quotes - View Selected Quote')

@section('content')
<section>
  <div class="container-fluid py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUOTES</h3>
    <h5>View Selected Quote</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col mb-3">
        <a href="{{ route('quotes.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Quote Menu
        </a>
      </div> {{-- col mb-3 --}}
      <div class="col mb-3">
        <a href="{{ route('jobs.show', $selected_quote->job_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
        </a>
      </div> {{-- col mb-3 --}}
      <div class="col mb-3">
        <a href="{{ route('customers.show', $selected_quote->customer_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Customer
        </a>
      </div> {{-- col mb-3 --}}
      <div class="col mb-3">
        <a href="{{ route('quick-quote.show', $selected_quote->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Quick Quote
        </a>
      </div> {{-- col mb-3 --}}
      <div class="col mb-3">
        <form action="{{ route('quotes-finalise.update', $selected_quote->id) }}" method="POST">
          @method('PATCH')
          @csrf
          <button type="submit" class="btn btn-success btn-block">
            <i class="fas fa-check mr-2" aria-hidden="true"></i>Finalise Quote
          </button>
        </form>
      </div> {{-- col mb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    {{-- status dropdowns --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col mb-3">
        <p class="text-primary text-center"><b>Quote Status</b></p>
        <form action="{{ route('update-quote-status.update', $selected_quote->id) }}" method="POST">
          @method('PATCH')
          @csrf
          <div class="input-group mb-3">
            <select name="quote_status_id" class="custom-select @error('quote_status_id') is-invalid @enderror">
              @if ($selected_quote->quote_status_id != null)
                <option value="{{ $selected_quote->quote_status_id }}">{{ $selected_quote->quote_status->title }}</option>
              @endif
              <option disabled>Please select a job status</option>
              @foreach ($all_quote_statuses as $quote_status)
                <option value="{{ $quote_status->id }}" @if ($quote_status->id == $selected_quote->quote_status_id) hidden @endif>{{ $quote_status->title }}</option>
              @endforeach
            </select>
            <div class="input-group-append">
              <button class="btn btn-dark" type="submit" id="quote_status_id_button"><i class="fas fa-edit"></i></button>
            </div> {{-- form-control --}}
          </div> {{-- input-group mb-3 --}}
        </form>
      </div> {{-- col mb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- status dropdowns --}}

    {{-- content --}}
    <div class="row">
      <div class="col-sm-4">

        {{-- pricing table --}}
        <h5 class="text-primary my-3"><b>Quote Details</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped">
            <tbody>
              <tr>
                <th>Quote Identifier</th>
                <td>{{ $selected_quote->quote_identifier }}</td>
              </tr>
              <tr>
                <th>Job</th>
                <td>{{ $selected_quote->job_id }}</td>
              </tr>
              <tr>
                <th>Customer</th>
                <td>{{ $selected_quote->customer->getFullNameAttribute() }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        {{-- pricing table --}}

        {{-- tasks cards --}}
        <h5 class="text-primary my-3"><b>Quote Tasks</b></h5>
        @if (!$selected_quote->quote_tasks->count())
          <div class="card">
            <div class="card-body">
              <h5 class="text-center">There are no quote tasks to display</h5>
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @else
          @foreach ($selected_quote->quote_tasks as $quote_task)
            <div class="card my-3">
              <div class="card-body pb-0">

                <div class="row">
                  <div class="col-sm-2">

                    @if ($quote_task->task->image_path == null)
                      <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/task-256x256.jpg') }}" alt="">
                    @else
                      <img class="img-fluid" src="{{ asset($quote_task->task->image_path) }}" alt="">
                    @endif

                  </div> {{-- col-sm-2 --}}
                  <div class="col-sm-10">

                    <p>
                      <b>{{ $quote_task->task->title }}</b>
                      - {{ $quote_task->task->task_type->title }}
                      @if ($quote_task->task->is_quote_visible == 0)
                        <span class="badge badge-danger py-2 px-2 ml-2">
                          <i class="fas fa-eye-slash mr-2" aria-hidden="true"></i>Not Visible On Quote
                        </span>
                      @else
                        <span class="badge badge-success py-2 px-2 ml-2">
                          <i class="fas fa-eye mr-2" aria-hidden="true"></i>Visible On Quote
                        </span>
                      @endif
                    </p>
                  <form action="{{ route('quote-tasks.update', $quote_task->id ) }}" method="POST">
                    @method('PATCH')
                    @csrf

                    <div class="form-group row">
                      <div class="col">
                        <div class="input-group">
                          <input type="text" class="form-control" name="quantity" value="{{ $quote_task->total_quantity }}" aria-label="meters_squared" disabled>
                          <div class="input-group-append">
                            <span class="input-group-text">{{ $quote_task->task->dimension->sign }}</span>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text">X</span>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text">$</span>
                          </div>
                          <input type="text" class="form-control" name="individual_price" value="{{ number_format(($quote_task->individual_price / 100), 2, '.', ',') }}" aria-label="individual_price">
                          <div class="input-group-append">
                            <span class="input-group-text">=</span>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text">$</span>
                          </div>
                          <input type="text" class="form-control" name="total_price" value="{{ number_format(($quote_task->total_price / 100), 2, '.', ',') }}" aria-label="total_price" disabled>
                        </div>
                      </div> {{-- col --}}
                    </div> {{-- form-group row --}}

                    <div class="form-group row">
                      <div class="col">
                        <input type="text" class="form-control" name="description" value="{{ $quote_task->description }}" placeholder="Please enter any additional comments for this task">
                      </div> {{-- col --}}
                    </div> {{-- form-group row --}}

                    <div class="form-group row">
                      <div class="col">
                        <button type="submit" class="btn btn-primary">
                          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Update
                        </button>
                        </form>
                        </button>
                        {{-- delete modal --}}
                        {{-- modal button --}}
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirm-delete-task-{{ $quote_task->id }}">
                          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                        </button>
                        {{-- modal button --}}
                        {{-- modal --}}
                        <div class="modal fade" id="confirm-delete-task-{{ $quote_task->id }}" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-task-{{ $quote_task->id }}Title" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirm-delete-task-{{ $quote_task->id }}Title">Delete</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                      <p class="text-center">Are you sure that you would like to delete this task?</p>
                                      <form action="{{ route('quote-tasks.destroy', $quote_task->id ) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-block">
                                          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                                        </button>
                                      </form>
                                    </div> {{-- modal-body --}}
                                </div> {{-- modal-content --}}
                            </div> {{-- modal-dialog --}}
                        </div> {{-- modal fade --}}
                        {{-- modal --}}
                        {{-- delete modal --}}
                      </div> {{-- col --}}
                    </div> {{-- form-group row --}}

                  </div> {{-- col-sm-10 --}}
                </div> {{-- row --}}

              </div> {{-- card-body --}}
            </div> {{-- card --}}
          @endforeach
        @endif
        {{-- tasks cards --}}

        {{-- products table --}}
        <h5 class="text-primary my-3"><b>Quote Products</b></h5>
        @if (!$selected_quote->quote_products->count())
          <div class="card">
            <div class="card-body">
              <h5 class="text-center">There are no quote products to display</h5>
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @else
          @foreach ($selected_quote->quote_products as $quote_product)
            <div class="card my-3">
              <div class="card-body pb-0">
                <div class="row">
                  <div class="col-sm-2">
                    @if ($quote_product->product?->getFeaturedImage() == null)
                      <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/stock-256x256.jpg') }}" alt="">
                    @else
                      <img class="img-fluid shadow-sm" src="{{ asset($quote_product->product->getFeaturedImage()->image_path) }}" alt="">
                    @endif
                  </div> {{-- col-sm-2 --}}
                  <div class="col-sm-10">

                    <p><b>{{ $quote_product->product->name }}</b></p>
                    <form action="{{ route('quote-products.update', $quote_product->id ) }}" method="POST">
                      @method('PATCH')
                      @csrf

                    @if($quote_product->product_id != 6 ) 

                      <div class="form-group row">
                        <div class="col">
                          <div class="input-group">
                            <input type="text" class="form-control" name="quantity" value="{{ $quote_product->quantity }}" aria-label="meters_squared" disabled>
                            <div class="input-group-append">
                              <span class="input-group-text">Item</span>
                            </div>
                            <div class="input-group-append">
                              <span class="input-group-text">X</span>
                            </div>
                            <div class="input-group-append">
                              <span class="input-group-text">$</span>
                            </div>
                            <input type="text" class="form-control" name="price" value="{{ number_format(($quote_product->individual_price / 100), 2, '.', ',') }}" aria-label="price">
                            <div class="input-group-append">
                              <span class="input-group-text">=</span>
                            </div>
                            <div class="input-group-append">
                              <span class="input-group-text">$</span>
                            </div>
                            <input type="text" class="form-control" name="total_price" value="{{ number_format(($quote_product->total_price / 100), 2, '.', ',') }}" aria-label="total_price" disabled>
                          </div>
                        </div> {{-- col --}}
                      </div> {{-- form-group row --}}

                    @else

                    <p>{{ $quote_product->quantity }} Kms = ${{ number_format(($quote_product->total_price / 100), 2, '.', ',') }}</p>

                    @endif

                    <div class="form-group row">
                      <div class="col">
                        <input type="text" class="form-control" name="description" value="{{ $quote_product->description }}" placeholder="Please enter any additional comments for this product">
                      </div> {{-- col --}}
                    </div> {{-- form-group row --}}

                    <div class="form-group row">
                      <div class="col">
                        <button type="submit" class="btn btn-primary">
                          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Update
                        </button>
                        </form>
                        </button>
                      </div> {{-- col --}}
                    </div> {{-- form-group row --}}

                  </div> {{-- col-sm-10 --}}
                </div> {{-- row --}}
              </div> {{-- card-body --}}
            </div> {{-- card --}}
          @endforeach
        @endif
        {{-- products table --}}

        {{-- rates table --}}
        <h5 class="text-primary my-3"><b>Quote Rates</b></h5>
        @if (!$selected_quote->quote_rates->count()) 
          <div class="card">
            <div class="card-body">
              <h5 class="text-center">There are no quote rates to display</h5>
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @else
          @foreach ($selected_quote->quote_rates as $quote_rate)
            <div class="card my-3">
              <div class="card-body pb-0">
                <div class="row">
                  <div class="col-sm-2">
                    @if ($quote_rate->rate->image_path == null)
                      <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/tools-256x256.jpg') }}" alt="">
                    @else
                      <img class="img-fluid" src="{{ asset($quote_rate->rate->image_path) }}" alt="">
                    @endif
                  </div> {{-- col-sm-2 --}}
                  <div class="col-sm-10">

                    <p>
                      <b>{{ $quote_rate->rate->title }} -</b>
                      @if ($quote_rate->staff_id == null)
                        <span class="badge badge-warning py-2 px-2">
                          <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i> Pending
                        </span>
                      @else
                        {{ $quote_rate->staff->getFullNameTitleAttribute() }}
                      @endif
                    </p>
                    <form action="{{ route('quote-rates.update', $quote_rate->id ) }}" method="POST">
                      @method('PATCH')
                      @csrf

                    <div class="form-group row">
                      <div class="col">
                        <div class="input-group">
                          <input type="text" class="form-control" name="quantity" value="{{ $quote_rate->quantity }}" aria-label="quantity" disabled>
                          <div class="input-group-append">
                            <span class="input-group-text">Rate</span>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text">X</span>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text">$</span>
                          </div>
                          <input type="text" class="form-control" name="price" value="{{ number_format(($quote_rate->individual_price / 100), 2, '.', ',') }}" aria-label="price">
                          <div class="input-group-append">
                            <span class="input-group-text">=</span>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text">$</span>
                          </div>
                          <input type="text" class="form-control" name="total" value="{{ number_format(($quote_rate->total_price / 100), 2, '.', ',') }}" aria-label="total" disabled>
                        </div>
                      </div> {{-- col --}}
                    </div> {{-- form-group row --}}

                    <div class="form-group row">
                      <div class="col">
                        <input type="text" class="form-control" name="description" value="{{ $quote_rate->description }}" placeholder="Please enter any additional comments for this rate">
                      </div> {{-- col --}}
                    </div> {{-- form-group row --}}

                    <div class="form-group row">
                      <div class="col">
                        <button type="submit" class="btn btn-primary">
                          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Update
                        </button>
                        </form>
                        </button>
                        {{-- delete modal --}}
                        {{-- modal button --}}
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirm-delete-rate-{{ $quote_rate->id }}">
                          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                        </button>
                        {{-- modal button --}}
                        {{-- modal --}}
                        <div class="modal fade" id="confirm-delete-rate-{{ $quote_rate->id }}" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-rate-{{ $quote_rate->id }}Title" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="confirm-delete-rate-{{ $quote_rate->id }}Title">Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p class="text-center">Are you sure that you would like to delete this rate?</p>
                                <form action="{{ route('quote-rates.destroy', $quote_rate->id ) }}" method="POST">
                                  @method('DELETE')
                                  @csrf
                                  <button type="submit" class="btn btn-danger btn-block">
                                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                                  </button>
                                </form>
                              </div> {{-- modal-body --}}
                            </div> {{-- modal-content --}}
                          </div> {{-- modal-dialog --}}
                        </div> {{-- modal fade --}}
                        {{-- modal --}}
                        {{-- delete modal --}}
                      </div> {{-- col --}}
                    </div> {{-- form-group row --}}

                  </div> {{-- col-sm-9 --}}
                </div> {{-- row --}}
              </div> {{-- card-body --}}
            </div> {{-- card --}}
          @endforeach
        @endif
        {{-- rates table --}}

      </div> {{-- col --}}
      <div class="col-sm-4">

        {{-- pricing table --}}
        <h5 class="text-primary my-3"><b>Quote Totals</b></h5>

        <form action="{{ route('quotes.update', $selected_quote->id ) }}" method="POST">
          @method('PATCH')
          @csrf

          <div class="table-responsive">
            <table class="table table-bordered table-fullwidth table-striped">
              <tbody>
                <tr>
                  <th>Task Cost Total</th>
                  <td>{{ $selected_quote->getFormattedTotalTasksCost() }}</td>
                </tr>
                <tr>
                  <th>Tradesperson Rate Cost Total</th>
                  <td>{{ $selected_quote->getFormattedTotalRatesCost() }}</td>
                </tr>
                <tr>
                  <th>Product Cost Total</th>
                  <td>{{ $selected_quote->getFormattedTotalProductsCost() }}</td>
                </tr>
                <tr>
                  <th>Profit Margin</th>
                  <td>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="profit_margin"><i class="fas fa-dollar-sign"></i></span>
                      </div>
                      <input class="form-control" type="text" name="profit_margin" value="{{ number_format(($selected_quote->profit_margin / 100), 2, '.', ',') }}" placeholder="profit_margin" aria-label="profit_margin" aria-describedby="profit_margin">
                    </div>
                  </td>
                </tr>
                <tr>
                  <th>Discount</th>
                  <td>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="discount"><i class="fas fa-dollar-sign"></i></span>
                      </div>
                      <input class="form-control" type="text" name="discount" value="{{ number_format(($selected_quote->discount / 100), 2, '.', ',') }}" placeholder="discount" aria-label="discount" aria-describedby="discount">
                      <div class="input-group-append">
                        <a href="{{ route('rounding-calculator.index') }}" target="_blank" class="input-group-text bg-primary text-white" id="discount"><i class="fas fa-calculator"></i></a>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <th>Subtotal</th>
                  <td>{{ $selected_quote->getFormattedSubtotalWithoutGst() }}</td>
                </tr>
                <tr>
                  <th>GST</th>
                  <td>{{ $selected_quote->getFormattedSubtotalGst() }}</td>
                </tr>
                <tr>
                  <th>Quote Total</th>
                  <td>{{ $selected_quote->getFormattedQuoteTotal() }}</td>
                </tr>
              </tbody>
            </table>
          </div>

          <button class="btn btn-primary">
            <i class="fas fa-edit mr-2" aria-hidden="true"></i>Update
          </button>

        </form>
        {{-- pricing table --}}

      </div> {{-- col --}}

      <div class="col-sm-4">

        {{-- Job Images --}}
        <h5 class="text-primary my-3"><b>Job Images</b></h5>
        @if (!$image_type_collections->count())
          <div class="card">
            <div class="card-body text-center">
              <h5>There are no job images to display</h5>
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @else
          @foreach ($image_type_collections as $collections)
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="imageCollection{{$loop->index}}" onclick="toggle_visibility('{{ $collections->first()->job_image_type->title }}');" checked>
              <label class="custom-control-label" for="imageCollection{{$loop->index}}">
                <b>{{ $collections->first()->job_image_type->title }}</b></span> - {{ $collections->last()->staff->getFullNameAttribute() . ' - ' . date('d/m/y', strtotime($collections->last()->created_at)) }}
              </label>
            </div>
            <div class="" id="{{ $collections->first()->job_image_type->title }}">
              <div class="container">
                <div class="row row-cols-2">
                  @foreach ($collections as $image)
                    <div class="col py-3">
                      {{-- image modal --}}
                      {{-- modal button --}}
                      <a href="#" data-toggle="modal" data-target="#view-image-modal-{{$image->id}}">
                        @if ($image->image_path == null)
                          <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                        @else
                          <img class="img-fluid" src="{{ asset($image->image_path) }}" alt="job_image">
                        @endif
                      </a>
                      {{-- modal button --}}
                      {{-- modal --}}
                      <div class="modal fade" id="view-image-modal-{{$image->id}}" tabindex="-1" role="dialog" aria-labelledby="view-image-modal-{{$image->id}}Title" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="view-image-modal-{{$image->id}}Title">{{ $image->image_identifier }}</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body pt-0 pl-0 pr-0 pb-0 mt-0">
                              <a href="{{ route('job-images.show', $image->id) }}">
                                @if ($image->image_path == null)
                                  <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                                @else
                                  <img class="img-fluid" src="{{ asset($image->image_path) }}" alt="job_image">
                                @endif
                              </a>
                            </div> {{-- modal-body --}}
                            <div class="modal-footer">
                              <p>Click image to view details</p>
                            </div>
                          </div> {{-- modal-content --}}
                        </div> {{-- modal-dialog --}}
                      </div> {{-- modal fade --}}
                      {{-- modal --}}
                      {{-- image modal --}}
                    </div> {{-- col --}}
                  @endforeach
                </div> {{-- row row-cols-2 --}}
              </div> {{-- container --}}
            </div> {{-- visibility div --}}
          @endforeach
        @endif
        {{-- Job Images --}}

        </div> {{-- col-sm-4 --}}

    </div> {{-- row --}}
    {{-- content --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
  {{-- Toggle Visibility By Id Generic --}}
  <script type="text/javascript">
    function toggle_visibility(id) {
      var e = document.getElementById(id);
      if (e.style.display == 'none')
        e.style.display = 'block';
      else
        e.style.display = 'none';
    }
  </script>
  {{-- Toggle Visibility By Id Generic --}}
@endpush
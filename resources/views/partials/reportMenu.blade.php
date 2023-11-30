<div class="card">
  <div class="card-body">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><b>Customer Reports</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('reports/account-classes*') ? 'active text-secondary' : '' }}" href="{{ route('account-classes-report.index') }}">Customer Account Classes</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('reports/customer-referral*') ? 'active text-secondary' : '' }}" href="{{ route('customer-referral-report.index') }}">Customer Referrals</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><b>Sales Reports</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('reports/job-statistics*') ? 'active text-secondary' : '' }}" href="{{ route('suburb-report.index') }}">Most Popular Suburbs</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('reports/job-statistics*') ? 'active text-secondary' : '' }}" href="{{ route('job-statistics-report.index') }}">Job Statistics</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('reports/cash-payments-statistics*') ? 'active text-secondary' : '' }}" href="{{ route('cash-payments-report.index') }}">Payments Received</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('reports/quote-statistics*') ? 'active text-secondary' : '' }}" href="{{ route('quote-statistics-report.index') }}">Quote Statistics</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('reports/staff-sales-statistics*') ? 'active text-secondary' : '' }}" href="{{ route('staff-sales-statistics-report.index') }}">Salesperson Statistics</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('reports/written-off-report*') ? 'active text-secondary' : '' }}" href="{{ route('written-off-report.index') }}">Written Off Statistics</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><b>Survey Reports</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('reports/survey-individual*') ? 'active text-secondary' : '' }}" href="{{ route('survey-individual-report.index') }}">Individual Results</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('reports/survey-overall*') ? 'active text-secondary' : '' }}" href="{{ route('survey-overall-report.index') }}">Overall Results</a>
      </li>
    </ul>
  </div> {{-- card-body --}}
</div> {{-- card --}}
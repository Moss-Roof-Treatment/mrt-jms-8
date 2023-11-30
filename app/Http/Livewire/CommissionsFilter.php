<?php

namespace App\Http\Livewire;

use App\Models\BuildingStyle;
use App\Models\QuoteCommission;
use App\Models\QuoteStatus;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class CommissionsFilter extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // All The Required Variables.
    public $staff_member_id = '';
    public $quote_status_id = '';

    public $per_page = '10';
    public $order_asc = true;

    // Mount The Data.
    public function mount() {
        // Set the required variables.
        // All product categories.
        $this->all_quote_statuses = QuoteStatus::all('id', 'title');
        // All staff users.
        $this->all_staff_members = User::whereIn('account_role_id', [1,2,3,4]) // 1 = Super User, 2 = Staff, 3 = Tradesperson, 4 = Contractor.
            ->where('id', '!=', 1) // Not the first user in the database.
            ->get();
    }

    public function render()
    {
        // There are inputs that have been entered.
        $results = QuoteCommission::where(function ($q) {
            // Product Category ID.
            if ($this->staff_member_id != null) {
                $q->where('salesperson_id', $this->staff_member_id);
            }
            // Serial Number.
            if ($this->quote_status_id != null) {
                $q->whereHas('quote', fn ($q) => $q->where('quote_status_id', $this->quote_status_id));
            }
        })
        ->where('approval_date', null) // Where not approved.
        ->orderBy('id', $this->order_asc ? 'asc' : 'desc')
        ->paginate($this->per_page);
        // Return the view.
        return view('livewire.commissions-filter', [
            'results' => $results
        ]);
    }
}

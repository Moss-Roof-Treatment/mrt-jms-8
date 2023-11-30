<?php

namespace App\Http\Livewire;

use App\Models\Job;
use Livewire\Component;
use Livewire\WithPagination;

class MostPopularSuburb extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // All The Required Variables.
    public $per_page = 10;
    public $search = '';
    public $sort_direction = 'desc';

    public function render()
    {
        // All jobs that have quotes.
        $results = Job::has('quotes')
            ->where('tenant_suburb', 'LIKE', '%' . $this->search . '%')
            ->select('tenant_suburb')
            ->selectRaw('count(tenant_suburb) as qty')
            ->groupBy('tenant_suburb')
            ->orderBy('qty', $this->sort_direction)
            ->having('qty', '>', 1)
            ->paginate($this->per_page);
        // Return the view.
        return view('livewire.most-popular-suburb', [
            'results' => $results
        ]);
    }

    public function refresh()
    {
        // Reset all variables.
        $this->reset();
    }
}

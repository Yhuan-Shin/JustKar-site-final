<?php

namespace App\Livewire;
use App\Models\Sales;
use Livewire\Component;
use Livewire\WithPagination;

class LogsDisplay extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $filter = '';
    public function getFiltersProperty()
    {
        return [
            '' => 'All',
            'recent' => 'Recent',
            'lastweek' => 'Last Week',
            'lastmonth' => 'Last Month',
        ];
    }
    public function refresh()
    {
        $this->render();
        
    }
    public function render()
    {
        $sales = Sales::where('ref_no', 'LIKE', '%'.$this->search.'%')
            ->orWhere('product_name', 'LIKE', '%'.$this->search.'%')
            ->orWhere('product_type', 'LIKE', '%'.$this->search.'%')

            ->orWhere('quantity', 'LIKE', '%'.$this->search.'%')
            ->orWhereDate('created_at', '=', date('m-d-Y', strtotime(str_replace('-', '/', $this->search))))
            ->orWhere('cashier_name', 'LIKE', '%'.$this->search.'%');

        switch ($this->filter) {
            case 'recent':
                $sales->orderBy('created_at', 'desc');
                break;
            case 'lastweek':
                $sales->whereBetween(
                    'created_at',
                    [
                        now()->startOfWeek()->subWeek()->format('m-d-Y H:i:s'),
                        now()->endOfWeek()->format('m-d-Y H:i:s'),
                    ]
                );
                break;
            case 'lastmonth':
                $sales->whereBetween(
                    'created_at',
                    [
                        now()->startOfMonth()->subMonth()->format('m-d-Y H:i:s'),
                        now()->endOfMonth()->format('m-d-Y H:i:s'),
                    ]
                );
                break;

            default:
                # code...
                break;
        }
        $sales = $sales->paginate(10);

        if ($sales->count() == 0) {
            session()->flash('warning', 'No results found. Please enter a valid search term.');
        }  
     
        return view('livewire.logs-display' , ['sales' => $sales, ]);
    }

}

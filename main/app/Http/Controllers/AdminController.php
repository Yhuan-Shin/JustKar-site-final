<?php

namespace App\Http\Controllers;
use App\Models\Sales;
use App\Http\Controllers\Controller;
use App\Models\WhiteList;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    //

    public function index(Request $request)
    {
        $period = $request->input('period') ?? 'this_month';

        $data = $this->fetchData($period);
        
        return view('admin/admin-home', ['data' => $data, 'selectedPeriod' => $period]);
    }

    public function displayLogs(){
        $sales = Sales::all();
        return view('admin/admin-logs', ['sales' => $sales]);
    }
    public function fetchData($period)
    {
        $query = Sales::select(DB::raw('SUM(total_price) as total_price, product_name as name'));

        switch ($period) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'this_week':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth('created_at', Carbon::now()->month);
                break;
            case 'this_year':
                $query->whereYear('created_at', Carbon::now()->year);
                break;
        }

        $data = $query->groupBy('product_name')->get();

        // Convert the data to an array
        return $data->map(function ($row) {
            return [
                'name' => $row->name,
                'total_price' => $row->total_price,
            ];
        });
    }
}

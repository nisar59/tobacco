<?php

namespace App\Exports;

use App\Models\Cih;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SupplierLedger implements FromView
{

    private $req=null;


    function __construct($request)
    {
        $this->req = $request;
    }

    public function view(): View
    {
        $req=$this->req;

        $cihs=Cih::query();

        if ($req->report_date != null) {
            $string = explode('-', $req->report_date);
            $date1 = date('Y-m-d', strtotime($string[0]));
            $date2 = date('Y-m-d', strtotime($string[1]));

            $cihs->where('report_date', '>=', $date1);
            $cihs->where('report_date', '<=', $date2);
        }

      $cihs=$cihs->get();

        return view('reports::cih_export', [
            'cihs' => $cihs
        ]);
    }


}

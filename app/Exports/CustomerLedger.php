<?php

namespace App\Exports;

use App\Helpers\GeneralHelper;
use Illuminate\Contracts\View\View;


class CustomerLedger
{

    private $req=null;


    function __construct($request)
    {
        $this->req = $request;
    }

    public function view(): View
    {
        $req=$this->req;

        $purchases = GeneralHelper::getCustomerLedger($id,$date1=0,$date2=0);

        if (isset($_GET['sale_date']) && !empty($_GET['sale_date'])) {
            $string = explode('-', $_GET['sale_date']);
            $purchases = GeneralHelper::getCustomerLedger($id,date('Y-m-d', strtotime($string[0])),date('Y-m-d', strtotime($string[1])));
        }

        return view('reports::cih_export', [
            'cihs' => $cihs
        ]);
    }


}

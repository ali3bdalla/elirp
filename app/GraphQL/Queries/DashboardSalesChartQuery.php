<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\DB;

class DashboardSalesChartQuery
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
//        (created_at)
        $data=collect(DB::select("select
       
            id as date,
            status,
            sum(amount)
            from document_histories  where  status != 'draft' and type = 'INVOICE' and company_id= ".company_id().' group by 1,2'));
        $dates   =$data->pluck('date')->unique();
        $statues =$data->pluck('status')->unique();
        $datasets=[];
        foreach ($statues as $status) {
            $statusValues=$data->where('status', $status)->pluck('sum')->map(function ($value) {
                return round($value, 2);
            })->toArray();
            $datasets[]=['label'=>$status, 'data'=>$statusValues, 'fill'=>'true', 'borderColor'=>'#00D8FF', 'tension'=>'0.5', 'backgroundColor'=>'red', ];
        }
        return [
            'dates'    => $dates,
            'datasets' => $datasets
        ];
    }
}

<?php

namespace App\Exports;

use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StatusesExport implements FromQuery, WithHeadings, WithMapping, WithColumnWidths, WithColumnFormatting, WithEvents
{
    use Exportable;

    /**
    * constructor with Query Builder
    */
    public function __construct($request)
    {
    	$date_from = $request->date_from != null ? $request->date_from : date('Y-m-d');
        $date_to = $request->date_to != null ? $request->date_to : date('Y-m-d');
        $date_to = date('Y-m-d', strtotime($date_to . '+1 days'));
        $select_case = ['statuses.id', 'statuses.scenario', 'statuses.is_okay', 'statuses.updated_at', 'statuses.user_id', 'users.avatar','users.last_name','users.first_name', 'users.middle_name', 'users.contact', 'users.facebook', 'users.agency', 'users.occupation', 'users.address', 'countries.country', 'statuses.reason_id', 'reasons.reason'];

        $statuses = DB::table('statuses')->select($select_case)->leftJoin('users','users.id','=','statuses.user_id')->leftJoin('reasons', 'reasons.id', '=', 'statuses.reason_id')->join('countries', 'users.country_id', '=', 'countries.id')->whereBetween('statuses.updated_at', [$date_from, $date_to]);

        switch ($request->status) {
            case 'Hindi Mabuti':
                if ($request->search != null)
                {
                    $statuses = DB::table('statuses')->select($select_case)->leftJoin('users','users.id','=','statuses.user_id')->leftJoin('reasons', 'reasons.id', '=', 'statuses.reason_id')->join('countries', 'users.country_id', '=', 'countries.id')->where(['statuses.is_okay' => false])->where(function ($query) use ($request) {
                        $query->where(DB::raw("CONCAT(`users`.`first_name`, ' ', `users`.`last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere(DB::raw("CONCAT(`users`.`first_name`, ' ', `users`.`middle_name`, ' ', `users`.`last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere('statuses.scenario', 'LIKE', '%' . $request->search . '%')->orWhere('reasons.reason', 'LIKE', '%' . $request->search . '%');
                    })->whereBetween('statuses.updated_at', [$date_from, $date_to]);
                }
                else
                {
                    $statuses = DB::table('statuses')->select($select_case)->leftJoin('users','users.id','=','statuses.user_id')->leftJoin('reasons', 'reasons.id', '=', 'statuses.reason_id')->join('countries', 'users.country_id', '=', 'countries.id')->where(['statuses.is_okay' => false])->whereBetween('statuses.updated_at', [$date_from, $date_to]);
                }
                break;
            case 'Mabuti':
                if ($request->search != null)
                {
                    $statuses = DB::table('statuses')->select($select_case)->leftJoin('users','users.id','=','statuses.user_id')->leftJoin('reasons', 'reasons.id', '=', 'statuses.reason_id')->join('countries', 'users.country_id', '=', 'countries.id')->where(['statuses.is_okay' => true])->where(function ($query) use ($request) {
                        $query->where(DB::raw("CONCAT(`users`.`first_name`, ' ', `users`.`last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere(DB::raw("CONCAT(`users`.`first_name`, ' ', `users`.`middle_name`, ' ', `users`.`last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere('statuses.scenario', 'LIKE', '%' . $request->search . '%')->orWhere('reasons.reason', 'LIKE', '%' . $request->search . '%');
                    })->whereBetween('statuses.updated_at', [$date_from, $date_to]);
                }
                else
                {
                    $statuses = DB::table('statuses')->select($select_case)->leftJoin('users','users.id','=','statuses.user_id')->leftJoin('reasons', 'reasons.id', '=', 'statuses.reason_id')->join('countries', 'users.country_id', '=', 'countries.id')->where(['statuses.is_okay' => true])->whereBetween('statuses.updated_at', [$date_from, $date_to]);
                }
                break;
            default:
                if ($request->search != null)
                {
                    $statuses = DB::table('statuses')->select($select_case)->leftJoin('users','users.id','=','statuses.user_id')->leftJoin('reasons', 'reasons.id', '=', 'statuses.reason_id')->join('countries', 'users.country_id', '=', 'countries.id')->where(function ($query) use ($request) {
                        $query->where(DB::raw("CONCAT(`users`.`first_name`, ' ', `users`.`last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere(DB::raw("CONCAT(`users`.`first_name`, ' ', `users`.`middle_name`, ' ', `users`.`last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere('statuses.scenario', 'LIKE', '%' . $request->search . '%')->orWhere('reasons.reason', 'LIKE', '%' . $request->search . '%');
                    })->whereBetween('statuses.updated_at', [$date_from, $date_to]);
                }
                break;
        }

    	$this->queryCommand = $statuses->orderBy('id', 'ASC');
    	$this->queryCount = $this->queryCommand->count();
    	$this->request = $request;
    }

   /**
   	* Display Query
   	*/
   public function query()
   {
   		return $this->queryCommand;
   }

   /**
   	* Headers
   	*/
   public function headings(): array
	{
	    return [
	        'Name',
	        'Date',
	        'Status',
	        'Scenario',
	        'Contact',
	        'Facebook URL',
	        'Agency',
	        'Occupation',
	        'Address (Abroad)',
	        'Country'

	    ];
	}

	/**
	 * Data Mapping
	 */
	public function map($status): array
	{
		return [
            $status->first_name . ' ' . ($status->middle_name != null ? ($status->middle_name . ' ') : '') . $status->last_name,
            date('F j, Y', strtotime($status->updated_at)),
            $status->is_okay ? 'Good Condition' : $status->reason,
            $status->scenario,
            $status->contact,
            $status->facebook,
            $status->agency,
            $status->occupation,
            $status->address,
            $status->country
        ];
	}

	/**
     * Column Widths
     */
	public function columnWidths(): array
    {
        return [
            'A' => 12,
            'B' => 12,
            'C' => 18,
            'D' => 18,
            'E' => 9,
            'F' => 12,
            'G' => 8,
            'H' => 9,
            'I' => 14,
            'J' => 9
        ];
    }

    /**
     * Contact Format
     */
    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_TEXT
        ];
    }

	/**
     * Event Manipulation
     */
    public function registerEvents(): array
    {
        return [
        	BeforeSheet::class => function (BeforeSheet $event) {
				$event->sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			},
            AfterSheet::class => function(AfterSheet $event) {
            	$event->sheet->insertNewRowBefore(1, 3);
            	$event->sheet->getRowDimension(1)->setRowHeight(22);
		        $event->sheet->mergeCells('A1:J1');
		        $event->sheet->mergeCells('A2:J2');
		        $event->sheet->mergeCells('A3:J3');
		        $event->sheet->setCellValue('A1', 'OFW STATUSES REPORT');
		        $event->sheet->setCellValue('A2', date('F j, Y', strtotime($this->request->date_from)) . ' - ' . date('F j, Y', strtotime($this->request->date_to)));
		        $event->sheet->getStyle('A1:J4')->applyFromArray(['font' => ['bold' => true, 'align' => 'center'], 'alignment' => ['horizontal' => 'center']]);
		        $event->sheet->getStyle('A1')->applyFromArray(['font' => ['size' => 12]]);
				$event->sheet->getStyle('A1:J' . ($this->queryCount + 4))->applyFromArray(['alignment' => ['vertical' => 'center', 'wrapText' => true]]);
				$event->sheet->getStyle('A2:J' . ($this->queryCount + 4))->applyFromArray(['font' => ['size' => 8]]);
				$event->sheet->getStyle('A4:J' . ($this->queryCount + 4))->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => 'thin']]]);
        	}
        ];
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade;

class KumustaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('revalidate');
    }

    /**
     * Show the application kumusta kabayan.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $date_from = $request->date_from != null ? $request->date_from : date('Y-m-d');
        $date_to = $request->date_to != null ? $request->date_to : date('Y-m-d');
        $date_to = date('Y-m-d', strtotime($date_to . '+1 days'));
        $select_case = ['statuses.id', 'statuses.scenario', 'statuses.is_okay', 'statuses.updated_at', 'statuses.user_id', 'users.avatar','users.last_name','users.first_name', 'users.middle_name', 'users.contact', 'users.facebook', 'users.agency', 'users.occupation', 'users.address', 'countries.country', 'statuses.reason_id', 'reasons.reason'];

        switch ($request->status) {
            case 'Hindi Mabuti':
                if ($request->search != null)
                {
                    $statuses = DB::table('statuses')->select($select_case)->leftJoin('users','users.id','=','statuses.user_id')->leftJoin('reasons', 'reasons.id', '=', 'statuses.reason_id')->join('countries', 'users.country_id', '=', 'countries.id')->where(['statuses.is_okay' => false])->where(function ($query) use ($request) {
                        $query->where(DB::raw("CONCAT(`users`.`first_name`, ' ', `users`.`last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere(DB::raw("CONCAT(`users`.`first_name`, ' ', `users`.`middle_name`, ' ', `users`.`last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere('statuses.scenario', 'LIKE', '%' . $request->search . '%')->orWhere('reasons.reason', 'LIKE', '%' . $request->search . '%');
                    })->whereBetween('statuses.updated_at', [$date_from, $date_to])->paginate(10);
                }
                else
                {
                    $statuses = DB::table('statuses')->select($select_case)->leftJoin('users','users.id','=','statuses.user_id')->leftJoin('reasons', 'reasons.id', '=', 'statuses.reason_id')->join('countries', 'users.country_id', '=', 'countries.id')->where(['statuses.is_okay' => false])->whereBetween('statuses.updated_at', [$date_from, $date_to])->paginate(10);
                }
                break;
            case 'Mabuti':
                if ($request->search != null)
                {
                    $statuses = DB::table('statuses')->select($select_case)->leftJoin('users','users.id','=','statuses.user_id')->leftJoin('reasons', 'reasons.id', '=', 'statuses.reason_id')->join('countries', 'users.country_id', '=', 'countries.id')->where(['statuses.is_okay' => true])->where(function ($query) use ($request) {
                        $query->where(DB::raw("CONCAT(`users`.`first_name`, ' ', `users`.`last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere(DB::raw("CONCAT(`users`.`first_name`, ' ', `users`.`middle_name`, ' ', `users`.`last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere('statuses.scenario', 'LIKE', '%' . $request->search . '%')->orWhere('reasons.reason', 'LIKE', '%' . $request->search . '%');
                    })->whereBetween('statuses.updated_at', [$date_from, $date_to])->paginate(10);
                }
                else
                {
                    $statuses = DB::table('statuses')->select($select_case)->leftJoin('users','users.id','=','statuses.user_id')->leftJoin('reasons', 'reasons.id', '=', 'statuses.reason_id')->join('countries', 'users.country_id', '=', 'countries.id')->where(['statuses.is_okay' => true])->whereBetween('statuses.updated_at', [$date_from, $date_to])->paginate(10);
                }
                break;
            default:
                if ($request->search != null)
                {
                    $statuses = DB::table('statuses')->select($select_case)->leftJoin('users','users.id','=','statuses.user_id')->leftJoin('reasons', 'reasons.id', '=', 'statuses.reason_id')->join('countries', 'users.country_id', '=', 'countries.id')->where(function ($query) use ($request) {
                        $query->where(DB::raw("CONCAT(`users`.`first_name`, ' ', `users`.`last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere(DB::raw("CONCAT(`users`.`first_name`, ' ', `users`.`middle_name`, ' ', `users`.`last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere('statuses.scenario', 'LIKE', '%' . $request->search . '%')->orWhere('reasons.reason', 'LIKE', '%' . $request->search . '%');
                    })->whereBetween('statuses.updated_at', [$date_from, $date_to])->paginate(10);
                }
                else
                {
                    $statuses = DB::table('statuses')->select($select_case)->leftJoin('users','users.id','=','statuses.user_id')->leftJoin('reasons', 'reasons.id', '=', 'statuses.reason_id')->join('countries', 'users.country_id', '=', 'countries.id')->whereBetween('statuses.updated_at', [$date_from, $date_to])->paginate(10);
                }
                break;
        }

        $statuses->appends(request()->input())->links();

        return view('user.kumusta', compact('statuses', 'request'));
    }

    /**
     * Handle a generate report request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function statusesReport(Request $request)
    {
        $date_from = $request->date_from != null ? $request->date_from : date('Y-m-d');
        $date_to = $request->date_to != null ? $request->date_to : date('Y-m-d');
        $date_to = date('Y-m-d', strtotime($date_to . '+1 days'));
        $select_case = ['statuses.id', 'statuses.scenario', 'statuses.is_okay', 'statuses.updated_at', 'statuses.user_id', 'users.avatar','users.last_name','users.first_name', 'users.middle_name', 'users.contact', 'users.agency', 'users.occupation', 'users.address', 'countries.country', 'statuses.reason_id', 'reasons.reason'];

        switch ($request->status) {
            case 'Hindi Mabuti':
                if ($request->search != null)
                {
                    $statuses = DB::table('statuses')->select($select_case)->leftJoin('users','users.id','=','statuses.user_id')->leftJoin('reasons', 'reasons.id', '=', 'statuses.reason_id')->join('countries', 'users.country_id', '=', 'countries.id')->where(['statuses.is_okay' => false])->where(function ($query) use ($request) {
                        $query->where(DB::raw("CONCAT(`users`.`first_name`, ' ', `users`.`last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere(DB::raw("CONCAT(`users`.`first_name`, ' ', `users`.`middle_name`, ' ', `users`.`last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere('statuses.scenario', 'LIKE', '%' . $request->search . '%')->orWhere('reasons.reason', 'LIKE', '%' . $request->search . '%');
                    })->whereBetween('statuses.updated_at', [$date_from, $date_to])->get();
                }
                else
                {
                    $statuses = DB::table('statuses')->select($select_case)->leftJoin('users','users.id','=','statuses.user_id')->leftJoin('reasons', 'reasons.id', '=', 'statuses.reason_id')->join('countries', 'users.country_id', '=', 'countries.id')->where(['statuses.is_okay' => false])->whereBetween('statuses.updated_at', [$date_from, $date_to])->get();
                }
                break;
            case 'Mabuti':
                if ($request->search != null)
                {
                    $statuses = DB::table('statuses')->select($select_case)->leftJoin('users','users.id','=','statuses.user_id')->leftJoin('reasons', 'reasons.id', '=', 'statuses.reason_id')->join('countries', 'users.country_id', '=', 'countries.id')->where(['statuses.is_okay' => true])->where(function ($query) use ($request) {
                        $query->where(DB::raw("CONCAT(`users`.`first_name`, ' ', `users`.`last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere(DB::raw("CONCAT(`users`.`first_name`, ' ', `users`.`middle_name`, ' ', `users`.`last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere('statuses.scenario', 'LIKE', '%' . $request->search . '%')->orWhere('reasons.reason', 'LIKE', '%' . $request->search . '%');
                    })->whereBetween('statuses.updated_at', [$date_from, $date_to])->get();
                }
                else
                {
                    $statuses = DB::table('statuses')->select($select_case)->leftJoin('users','users.id','=','statuses.user_id')->leftJoin('reasons', 'reasons.id', '=', 'statuses.reason_id')->join('countries', 'users.country_id', '=', 'countries.id')->where(['statuses.is_okay' => true])->whereBetween('statuses.updated_at', [$date_from, $date_to])->get();
                }
                break;
            default:
                if ($request->search != null)
                {
                    $statuses = DB::table('statuses')->select($select_case)->leftJoin('users','users.id','=','statuses.user_id')->leftJoin('reasons', 'reasons.id', '=', 'statuses.reason_id')->join('countries', 'users.country_id', '=', 'countries.id')->where(function ($query) use ($request) {
                        $query->where(DB::raw("CONCAT(`users`.`first_name`, ' ', `users`.`last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere(DB::raw("CONCAT(`users`.`first_name`, ' ', `users`.`middle_name`, ' ', `users`.`last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere('statuses.scenario', 'LIKE', '%' . $request->search . '%')->orWhere('reasons.reason', 'LIKE', '%' . $request->search . '%');
                    })->whereBetween('statuses.updated_at', [$date_from, $date_to])->get();
                }
                else
                {
                    $statuses = DB::table('statuses')->select($select_case)->leftJoin('users','users.id','=','statuses.user_id')->leftJoin('reasons', 'reasons.id', '=', 'statuses.reason_id')->join('countries', 'users.country_id', '=', 'countries.id')->whereBetween('statuses.updated_at', [$date_from, $date_to])->get();
                }
                break;
        }

        $data = array('statuses' => $statuses, 'request' => $request);
        $pdf = Facade::loadView('reports.statuses', $data);

        return $pdf->download('OFW Statuses Report' . date('YmdHis') . '.pdf');
    }

    /**
     * Handle a status query request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function queryStatuses(Request $request)
    {
        

        return $statuses;
    }
}

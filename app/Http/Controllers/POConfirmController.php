<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class POConfirmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        Session::forget('token');
        $userid = Session::get('USERNAME');
        $passwd = Session::get('PASSWORD');
        $curl_getUserExist = curl_init();
        $curl_register = curl_init();
        $curl_login = curl_init();

        curl_setopt_array($curl_getUserExist, array(
            CURLOPT_URL => "https://svr01.kencana.org/service/api/getUserExist?email=".$userid."@".$userid.".com",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
            ),
        ));
        $response_getUserExist = curl_exec($curl_getUserExist);
        $err_getUserExist = curl_error($curl_getUserExist);
        curl_close($curl_getUserExist);

        if ($err_getUserExist) {
            return view('layouts.POConfirm')->with('error','UserExist#:' . $err_getUserExist);
        }
        else {
            $response_getUserExist = json_decode($response_getUserExist);
            $count = $response_getUserExist->message;

            if ($count < 1){

                $data = [
                    'name' => $userid,
                    'email' => $userid.'@'.$userid.'.com',
                    'password' => 'GeraltOfRivia1993',
                    'password_confirmation' => 'GeraltOfRivia1993',
                    'type' => 1,
                ];

                curl_setopt_array($curl_register, array(
                    CURLOPT_URL => "https://svr01.kencana.org/service/api/register",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30000,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($data),
                    CURLOPT_HTTPHEADER => array(
                        // Set here requred headers
                        "accept: */*",
                        "accept-language: en-US,en;q=0.8",
                        "content-type: application/json",
                    ),
                ));

                $response_register = curl_exec($curl_register);
                $err_register = curl_error($curl_register);

                curl_close($curl_register);

                if ($err_register) {
                    return view('layouts.POConfirm')->with('error','Register#:' . $err_register);
                } else {
                    $response_register = json_decode($response_register);

                    if (isset($response_register->token)){
                        Session::put('token', $response_register->token);
                        //return view('layouts.POConfirm')->with('success','API Authentication Success');
			return view('layouts.POConfirm');
                    }
                    else {
                        $errors = '';
                        foreach($response_register->errors as $a)
                        {

                            $a = str_replace(".", '\n', $a);
                            $errors .= $a;

                        }
                        return view('layouts.POConfirm')->with('error','RegisterAttempt#:' . $errors);
                    }
                }
            }
            else {

                $data = [
                    'email' => $userid.'@'.$userid.'.com',
                    'password' => 'GeraltOfRivia1993',
                ];

                curl_setopt_array($curl_login, array(
                    CURLOPT_URL => "https://svr01.kencana.org/service/api/login",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30000,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($data),
                    CURLOPT_HTTPHEADER => array(
                        // Set here requred headers
                        "accept: */*",
                        "accept-language: en-US,en;q=0.8",
                        "content-type: application/json",
                    ),
                ));

                $response_login= curl_exec($curl_login);
                $err_login = curl_error($curl_login);

                curl_close($curl_login);

                if ($err_login) {
                    return view('layouts.POConfirm')->with('error','Login#:' . $err_login);
                } else {
                    $response_login = json_decode($response_login);

                    if (isset($response_login->token)){
                        Session::put('token', $response_login->token);
                        //return view('layouts.POConfirm')->with('success','API Authentication Success');
			return view('layouts.POConfirm');
                    }
                    else {
                        return view('layouts.POConfirm')->with('error','LoginAttempt#:' . $response_login->message);
                    }

                }

            }
        }

    }

    public function getPOHdr (Request $request) {

        $token = Session::get('token');
        $dt_start = $request->dt_start;
        $dt_end = $request->dt_end;
        $flag = $request->flag;
        $po_id = $request->po_id;


        $allreq = '';

        if ($dt_start && !$dt_end) {

            $allreq .= '&dt_start='.$request->dt_start;

        }

        if (!$dt_start && $dt_end) {

            $allreq .= '&dt_end='.$request->dt_end;

        }

        if ($dt_start && $dt_end) {

            $allreq .= '&dt_start='.$request->dt_start;
            $allreq .= '&dt_end='.$request->dt_end;

        }

        if ($po_id) {

            $allreq .= '&po_id='.$po_id;

        }

        if ($flag) {

            $allreq .= '&flag='.$flag;

        }

        $url = "https://svr01.kencana.org/service/api/getPOHdr?1=1".$allreq;


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
                "Authorization: Bearer $token",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return view('layouts.POConfirm')->with('error','getPOHdr#:' . $err);
        }
        else {

            $response = json_decode($response);
            //dd($response);
            return \DataTables::of($response)
                ->editColumn('aprv_flag', function ($data) {
                    if ($data->aprv_flag == "Y") return '<span class="shadow-none badge badge-success"><i class="fa fa-check" aria-hidden="true"></i> Approved</span>';
                    if ($data->aprv_flag == "X") return '<span class="shadow-none badge badge-danger"><i class="fa fa-times" aria-hidden="true"></i> Rejected</span>';
                    return '<span class="shadow-none badge badge-warning"><i class="fa fa-clock-o" aria-hidden="true"></i> Open</span>';
                })
                ->addColumn('Detail', function($data) {

                    if ($data->aprv_flag == "Y")
                    return '
                        <a href="javascript:void(0)" data-id="'.$data->po_id.'" class="bs-tooltip viewDtl" data-placement="top" title="Detail" data-toggle="modal" data-target="#detailPO">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text text-primary"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </a>
                        ';

                    if ($data->aprv_flag == "X")
                    return '
                        <a href="javascript:void(0)" data-id="'.$data->po_id.'" class="bs-tooltip viewDtl" data-placement="top" title="Detail" data-toggle="modal" data-target="#detailPO">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text text-primary"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </a>
                        ';

                    return '
                        <a href="javascript:void(0)" data-id="'.$data->po_id.'" class="bs-tooltip viewDtl" data-placement="top" title="Detail" data-toggle="modal" data-target="#detailPO">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text text-primary"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </a>

                        <a href="javascript:void(0)" data-id="'.$data->po_id.'" class="bs-tooltip setApprove" data-placement="top" title="Approve">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </a>

                        <a href="javascript:void(0)" data-id="'.$data->po_id.'" class="bs-tooltip setReject" data-placement="top" title="Reject">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        </a>
                        ';
                    })
                ->rawColumns(['Detail','aprv_flag'])
                ->make(true);


                // <a href="javascript:void(0)" data-id="'.$data->po_id.'" class="bs-tooltip setUnApprove" data-placement="top" title="UnApprove">
                // <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-ccw text-warning"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                // </a>

        }

    }

    public function getPODtl (Request $request) {

        $token = Session::get('token');
        $id = $request->id;

        $url = "https://svr01.kencana.org/service/api/getPODtl?po_id=".$id;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
                "Authorization: Bearer $token",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return view('layouts.POConfirm')->with('error','getPODtl#:' . $err);
        }
        else {

            $response = json_decode($response);
            //dd($response);
            return \DataTables::of($response)
                ->make(true);

        }

    }

    public function setApprove (Request $request) {

        $token = Session::get('token');
        $userid = Session::get('USERNAME');
        $id = $request->id;

        $curl = curl_init();

        $data = [
            'userid' => $userid,
            'po_id' => $id,
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://svr01.kencana.org/service/api/setApprove",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
                "Authorization: Bearer $token",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return response()->json(['response' => 'Error:' . $err]);
        }
        else {

            $response = json_decode($response);
            $response = $response->message;
            return response()->json(['response' => $response]);

        }

    }

    public function setReject (Request $request) {

        $token = Session::get('token');
        $userid = Session::get('USERNAME');
        $id = $request->id;

        $curl = curl_init();

        $data = [
            'userid' => $userid,
            'po_id' => $id,
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://svr01.kencana.org/service/api/setReject",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
                "Authorization: Bearer $token",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return response()->json(['response' => 'Error:' . $err]);
        }
        else {

            $response = json_decode($response);
            $response = $response->message;
            return response()->json(['response' => $response]);

        }

    }

    public function setUnApprove (Request $request) {

        $token = Session::get('token');
        $userid = Session::get('USERNAME');
        $id = $request->id;

        $curl = curl_init();

        $data = [
            'userid' => $userid,
            'po_id' => $id,
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://svr01.kencana.org/service/api/setUnApprove",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
                "Authorization: Bearer $token",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return response()->json(['response' => 'Error:' . $err]);
        }
        else {

            $response = json_decode($response);
            $response = $response->message;
            return response()->json(['response' => $response]);

        }

    }
}

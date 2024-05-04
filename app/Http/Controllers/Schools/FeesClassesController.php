<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeesClass;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\FeesPaid;
class FeesClassesController extends Controller
{
    public function index()
    {
        // if (!Auth::user()->can('fees-type')) {
        //     $response = array(
        //         'message' => trans('no_permission_message')
        //     );
        //     return redirect(route('home'))->withErrors($response);
        // }

        $sections = ClassRoom::where('school_id',getSchool()->id)->get();

        return view('pages.schools.fees.fees_class',compact('sections'));
    }
    public function feesClassListIndex()
    {
        // if (!Auth::user()->can('fees-classes')) {
        //     $response = array(
        //         'message' => trans('no_permission_message')
        //     );
        //     return redirect(route('home'))->withErrors($response);
        // }
        // $classes = ClassSchool::orderByRaw('CONVERT(name, SIGNED) asc')->with('medium', 'sections','streams')->get();
        // $fees_type = FeesType::orderBy('id', 'ASC')->pluck('name', 'id');
        // $fees_type_data = FeesType::get();
        // $mediums = Mediums::orderBy('id', 'ASC')->get();

        return response(view('fees.fees_class'));
    }
    public function updateFeesClass(Request $request)
    {
        // return $request;
        // if (!Auth::user()->can('fees-classes')) {
        //     $response = array(
        //         'message' => trans('no_permission_message')
        //     );
        //     return redirect(route('home'))->withErrors($response);
        // }
        $validation_rules = array(
            'class_id' => 'required',
            'base_amount' => 'required|numeric',
        );
        $validator = Validator::make($request->all(), $validation_rules);

        // if ($validator->fails()) {
        //     $response = array(
        //         'error' => true,
        //         'message' => $validator->errors()->first()
        //     );
        //     return response()->json($response);
        // }
        try {
            // //Update Fees Type For Class first
            if ($request->fees_id != "NULL") {
                    $edit_fees_class = FeesClass::findOrFail($request->fees_id);
                    $edit_fees_class->class_section_id  =  $request->class_id;
                    $edit_fees_class->amount   = $request->base_amount;
                    $edit_fees_class->school_id         =  getSchool()->id;
                    $edit_fees_class->session_year_id =  getYearNow()->id;
                    $edit_fees_class->save();
            }

            //Add New Fees Type For Class
            if ($request->fees_id=="NULL") {

                $feesClass = FeesClass::create([
                    "class_section_id"  =>  $request->class_id,
                    "amount"            =>  $request->base_amount,
                    "school_id"         =>  getSchool()->id,
                    "session_year_id"   =>  getYearNow()->id,
                ]);
            }


            toastr()->success(trans('genirale.data_store_successfully'), 'Congrats');
            return  redirect()->back();
        } catch (\Throwable $e) {


            toastr()->error( trans('genirale.error_occurred'), 'Congrats');
            return  redirect()->back();
        }

    }

    public function feesClassList()
    {
        // if (!Auth::user()->can('fees-classes')) {
        //     $response = array(
        //         'message' => trans('no_permission_message')
        //     );
        //     return redirect(route('home'))->withErrors($response);
        // }
        $offset = 0;
        $limit = 10;
        $sort = 'id';

        if (isset($_GET['offset']))
            $offset = $_GET['offset'];
        if (isset($_GET['limit']))
            $limit = $_GET['limit'];

        if (isset($_GET['sort']))
            $sort = $_GET['sort'];


        $sql = ClassRoom::where('school_id',getSchool()->id)->with('fees_class');
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql->where('id', 'LIKE', "%$search%")
                ->orwhere('name', 'LIKE', "%$search%");
        }
        if (isset($_GET['medium_id']) && !empty($_GET['medium_id'])) {
            $sql = $sql->where('medium_id', $_GET['medium_id']);
        }
        $total = $sql->count();

        $sql->skip($offset)->take($limit);
        $res = $sql->get();
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        $no = 1;

        foreach ($res as $row) {

            $row = (object)$row;
            $operate = '<a href="" class="btn btn-xs btn-gradient-primary btn-rounded btn-icon edit-data" data-id=' . $row->id . ' title="'.trans('edit').'" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';

            $tempRow['no'] = $no++;
            $tempRow['class_id'] = $row->id;
            $tempRow['class_name'] =  $row->classe->name.' '. $row->name ;
            $tempRow['feesClass'] =  $row->fees_class->id ??'NULL' ;
            $tempRow['base_amount'] = $row->fees_class->amount.'  DZ'??'-';
            $tempRow['created_at'] = $row->created_at;
            $tempRow['updated_at'] = $row->updated_at;
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }


    //paid

    public function feesPaidListIndex()
    {
        // if (!Auth::user()->can('fees-paid')) {
        //     $response = array(
        //         'message' => trans('no_permission_message')
        //     );
        //     return redirect(route('home'))->withErrors($response);
        // }
        // $classes = ClassSchool::orderByRaw('CONVERT(name, SIGNED) asc')->with('medium', 'sections','streams')->get();
        // $session_year_all = SessionYear::select('id', 'name', 'default')->get();
        // $mediums = Mediums::orderBy('id', 'ASC')->get();
        return response(view('pages.schools.fees.fees_paid'));
    }

    public function feesPaidList()
    {
        // if (!Auth::user()->can('fees-paid')) {
        //     $response = array(
        //         'message' => trans('no_permission_message')
        //     );
        //     return redirect(route('home'))->withErrors($response);
        // }
        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'DESC';


        if (isset($_GET['offset']))
            $offset = $_GET['offset'];
        if (isset($_GET['limit']))
            $limit = $_GET['limit'];

        if (isset($_GET['sort']))
            $sort = $_GET['sort'];
        if (isset($_GET['order']))
        //     $order = $_GET['order'];


        //Fetching Students Data on Basis of Class Section ID with Realtion fees paid
        $sql = Student::with(['fees_paid','section']);
        // $session_year = getSettings('session_year');
        $session_year_id = getYearNow()->id;

        if (isset($_GET['session_year_id']) && !empty($_GET['session_year_id'])) {
            $sql->whereHas('fees_paid', function ($q) {
                $q->where('session_year_id', $_GET['session_year_id']);
            });
        }

        // if (isset($_GET['class_id']) && !empty($_GET['class_id'])) {
        //     $class_id = $_GET['class_id'];
        //     $class_section_id = ClassSection::where('class_id', $class_id)->pluck('id');
        //     $sql->whereIn('class_section_id', $class_section_id)
        //         ->with(['fees_paid' => function ($q) use ($session_year_id) {
        //             $q->with('class', 'session_year', 'payment_transaction')
        //                 ->where('session_year_id', $session_year_id);
        //         }]);
        // } else {
        //     $sql->has('fees_paid');
        // }

        // if (isset($_GET['mode']) && ($_GET['mode'] == 0 || $_GET['mode'] == 1 || $_GET['mode'] == 2)) {
        //     $sql->whereHas('fees_paid', function ($q) {
        //         $q->where('mode', $_GET['mode']);
        //     });
        // }

        // if (isset($_GET['search']) && !empty($_GET['search'])) {
        //     $search = $_GET['search'];
        //     $sql->where(function ($q) use ($search) {
        //         $q->where('id', 'LIKE', "%$search%")
        //             ->orWhereHas('user', function ($q) use ($search) {
        //                 $q->where('first_name', 'LIKE', "%$search%")
        //                     ->orWhere('last_name', 'LIKE', "%$search%");
        //             });
        //     });
        // }

        $total = $sql->count();
        $sql->orderBy($sort, $order)->skip($offset)->take($limit);
        $res = $sql->get();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        $no = 1;
        foreach ($res as $row) {
        //     $operate = "";
        //     $session_year = SessionYear::where('id',$session_year_id)->first();
        //     $due_date = $session_year->fee_due_date;

        //     $current_date = Carbon::now()->format('d-m-Y');
        //     $due_charges = 0;
        //     $base_amount_with_due_charges = 0;

        //     $payment_transaction = null;

        //     if($row->fees_paid){
        //         $payment_transaction = PaymentTransaction::where(['student_id' => $row->id , 'class_id' => $row->class_section->class_id , 'session_year_id' => $session_year_id])->latest()->first();
        //     }

        //     // Base Amount
        //     $base_amount = FeesClass::where(['class_id' => $row->class_section->class_id , 'choiceable' => 0])->selectRaw('SUM(amount) as base_amount')->first();
        //     $base_amount = $base_amount['base_amount'];

        //     // if due charges is applicable
        //     if (strtotime($current_date) > strtotime($due_date)) {
        //         $due_charges = $session_year->fee_due_charges;
        //         $charges = (($due_charges) * ($base_amount) / 100);
        //         $base_amount_with_due_charges = $base_amount + $charges;
        //     }

        //     // Get the fees data
        //     $compulsory_fees = FeesClass::where(['class_id' => $row->class_section->class_id , 'choiceable' => 0])->with('fees_type')->get();
        //     $choiceable_fees = FeesClass::where(['class_id' => $row->class_section->class_id , 'choiceable' => 1])->with('fees_type')->get();
        //     $installment_data = InstallmentFee::where('session_year_id',$session_year_id)->get();

        //     //Get Paid Fees

            $operate = "";
        //     // check that fees paid is not empty
        //     if(isset($row->fees_paid) && !empty($row->fees_paid)){
        //         // checks that fees paid's session year matches the current session year then allow to modify the fees payments or else show only clear and pdf option
        //         if($row->fees_paid->session_year_id == $session_year_id){
                    $operate = '<div class="dropdown"><button class="btn btn-xs btn-gradient-success btn-rounded btn-icon dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-dollar"></i></button><div class="dropdown-menu">';
                    // $operate .= '<a href="#"class="compulsory-data dropdown-item" data-id=' . $row->id . ' title="' . trans('compulsory') . ' ' . trans('fees') . '" data-toggle="modal" data-target="#compulsoryModal"><i class="fa fa-dollar text-success mr-2"></i>'.trans('compulsory').' '.trans('fees').'</a><div class="dropdown-divider"></div>';
                    $operate .= '<a href="#" class="optional-data dropdown-item" data-id=' . $row->id . ' title="' . trans('Paid')  .'" data-toggle="modal" data-target="#optionalModal"><i class="fa fa-dollar text-success mr-2"></i>'.trans('Paid').'</a>';
                    $operate .= '</div></div>&nbsp;&nbsp;';
                    $operate .= '<a href=  class="btn btn-xs btn-gradient-danger btn-rounded btn-icon delete-form" title="'.trans('clear').'" data-id=><i class="fa fa-remove"></i></a>&nbsp;&nbsp;';
                    $operate .= '<a href= class="btn btn-xs btn-gradient-info btn-rounded btn-icon generate-paid-fees-pdf" target="_blank" data-id= title="' . trans('generate_pdf') . ' ' . trans('fees') . '"><i class="fa fa-file-pdf-o"></i></a>&nbsp;&nbsp;';
        //         }else{
        //             $operate .= '<a href=' . route('fees.paid.clear.data', $row->fees_paid->id) . ' class="btn btn-xs btn-gradient-danger btn-rounded btn-icon delete-form" title="'.trans('clear').'" data-id=' . $row->fees_paid->id . '><i class="fa fa-remove"></i></a>&nbsp;&nbsp;';
        //             $operate .= '<a href=' . route('fees.paid.receipt.pdf', $row->fees_paid->id) . ' class="btn btn-xs btn-gradient-info btn-rounded btn-icon generate-paid-fees-pdf" target="_blank" data-id=' . $row->fees_paid->id . ' title="' . trans('generate_pdf') . ' ' . trans('fees') . '"><i class="fa fa-file-pdf-o"></i></a>&nbsp;&nbsp;';
        //         }
        //     }else{
        //         $operate = '<div class="dropdown"><button class="btn btn-xs btn-gradient-success btn-rounded btn-icon dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-dollar"></i></button><div class="dropdown-menu">';
        //         $operate .= '<a href="#"class="compulsory-data dropdown-item" data-id=' . $row->id . ' title="' . trans('compulsory') . ' ' . trans('fees') . '" data-toggle="modal" data-target="#compulsoryModal"><i class="fa fa-dollar text-success mr-2"></i>'.trans('compulsory').' '.trans('fees').'</a><div class="dropdown-divider"></div>';
        //         $operate .= '<a href="#" class="optional-data dropdown-item" data-id=' . $row->id . ' title="' . trans('optional') . ' ' . trans('fees') . '" data-toggle="modal" data-target="#optionalModal"><i class="fa fa-dollar text-success mr-2"></i>'.trans('optional').' '.trans('fees').'</a>';
        //         $operate .= '</div></div>&nbsp;&nbsp;';
        //     }

        //     $tempRow['id'] = null;
            $tempRow['student_id'] = $row->id;
            $tempRow['no'] = $no++;
            $tempRow['student_name'] = $row->first_name . ' ' . $row->last_name;
            $tempRow['class_id'] = $row->section->id;
            $tempRow['class_name'] = $row->section->name . ' ' . $row->section->classe->name;
            $tempRow['months']='';
            if($row->fees_paid){

                foreach ($row->fees_paid as $key => $fees) {

                     $tempRow['months'] .= getMonth($fees->month) . ' - ';

                }

            }




        //     if(isset($installment_data) && !empty($installment_data)) {
        //         $tempRow['installment_data'] = array();
        //         foreach ($installment_data as $data) {
        //             // Paid Installment Data
        //             $paid_installment = PaidInstallmentFee::where(['student_id' => $row->id, 'installment_fee_id' => $data->id])->first();

        //             if(strtotime($current_date) >= strtotime($data->due_date)){
        //                 $tempRow['installment_data'][] = array(
        //                     'id' => $data->id,
        //                     'name' => $data->name,
        //                     'due_date' => $data->due_date,
        //                     'due_charges' => $data->due_charges,
        //                     'due_charges_applicable' => 1,
        //                     'paid' => $paid_installment ? 1 : 0 ,
        //                     'paid_id' => $paid_installment ? $paid_installment->id : '',
        //                     'paid_on' => $paid_installment ? date('d-m-Y',strtotime($paid_installment->date)) : '',
        //                 );
        //             }else{
        //                 $tempRow['installment_data'][] = array(
        //                     'id' => $data->id,
        //                     'name' => $data->name,
        //                     'due_date' => $data->due_date,
        //                     'due_charges' => $data->due_charges,
        //                     'due_charges_applicable' => 0,
        //                     'paid' => $paid_installment ? 1 : 0 ,
        //                     'paid_id' => $paid_installment ? $paid_installment->id : '',
        //                     'paid_on' => $paid_installment ? $paid_installment->date : '',
        //                 );
        //             }
        //         }
        //     }
        //     if(isset($choiceable_fees) && !empty($choiceable_fees)) {
        //         $tempRow['choiceable_fees'] = array();
        //         $paid_choiceable_fees_query = FeesChoiceable::where(['class_id' => $row->class_section->class_id , 'student_id' => $row->id , 'session_year_id' => $session_year_id]);
        //         foreach ($choiceable_fees as $data) {
        //             //Clone the Query To Avoid Extra Addition of Where Fees Type ID
        //             $paid_choiceable_data = (clone $paid_choiceable_fees_query)->where('fees_type_id', $data->fees_type_id);
        //             if($paid_choiceable_data->count()){
        //                 $tempRow['choiceable_fees'][] = array(
        //                     'id' => $data->id,
        //                     'name' => $data->fees_type->name,
        //                     'class_id' => $data->class_id,
        //                     'fees_type_id' => $data->fees_type_id,
        //                     'choiceable' => $data->choiceable,
        //                     'amount' => $data->amount,
        //                     'is_paid' => 1,
        //                     'paid_id' => $paid_choiceable_data->first()->id,
        //                     'date' => $paid_choiceable_data->first()->date,
        //                 );
        //             }else{
        //                 $tempRow['choiceable_fees'][] = array(
        //                     'id' => $data->id,
        //                     'name' => $data->fees_type->name,
        //                     'class_id' => $data->class_id,
        //                     'fees_type_id' => $data->fees_type_id,
        //                     'choiceable' => $data->choiceable,
        //                     'amount' => $data->amount,
        //                     'is_paid' => 0,
        //                 );
        //             }
        //         }
        //     }
            // $tempRow['base_amount'] = $base_amount;
        //     $tempRow['base_amount_with_due_charges'] = $base_amount_with_due_charges;
        //     $tempRow['due_charges'] = array(
        //         'date' => date('d-m-Y',strtotime($due_date)),
        //         'charges' => $charges ?? null,
        //     );
            // $tempRow['session_year_name'] = $row->fees_paid->session_year->name ?? null;
            // $tempRow['mode'] = $payment_transaction->mode ?? null;
            // $tempRow['type_of_fee'] = $payment_transaction->type_of_fee ?? null;
            // $tempRow['cheque_no'] = $payment_transaction->cheque_no ?? null;
            $tempRow['created_at'] = $row->created_at;
            $tempRow['updated_at'] = $row->updated_at;
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }

    public function clearFeesPaidData($id)
    {
        // if (!Auth::user()->can('fees-paid')) {
        //     $response = array(
        //         'message' => trans('no_permission_message')
        //     );
        //     return redirect(route('home'))->withErrors($response);
        // }
        // try {
        //     $fees_paid_data = FeesPaid::find($id);

        //     // get the ids from fees paid to remove the fees choiced data
        //     $student_id = $fees_paid_data->student_id;
        //     $class_id = $fees_paid_data->class_id;
        //     $session_year_id = $fees_paid_data->session_year_id;

        //     $fees_paid_data->delete();

        //     FeesChoiceable::where(['student_id' => $student_id, 'class_id' => $class_id, 'session_year_id' => $session_year_id])->delete();
        //     PaidInstallmentFee::where(['student_id' => $student_id, 'class_id' => $class_id, 'session_year_id' => $session_year_id])->delete();
        //     PaymentTransaction::where(['student_id' => $student_id, 'class_id' => $class_id, 'session_year_id' => $session_year_id])->delete();

        //     $response = array(
        //         'error' => false,
        //         'message' => trans('data_delete_successfully')
        //     );
        // } catch (\Throwable $e) {
        //     $response = array(
        //         'error' => true,
        //         'message' => trans('error_occurred')
        //     );
        // }
        // return response()->json($response);
    }


    public function optionalFeesPaidStore(Request $request)
    {
        // return $request;
        // if (!Auth::user()->can('fees-paid')) {
        //     $response = array(
        //         'message' => trans('no_permission_message')
        //     );
        //     return redirect(route('home'))->withErrors($response);
        // }
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'mode' => 'required|in:0,1',
        ]);
        // if ($validator->fails()) {
        //     $response = array(
        //         'error' => true,
        //         'message' => $validator->errors()->first()
        //     );
        //     return response()->json($response);
        // }
        // try {
            $feesClass =FeesClass::where(['class_section_id'=>$request->class_id,
                    'session_year_id'=>1,'school_id'=>getSchool()->id])->first();
            $date = date('Y-m-d H:i:s', strtotime($request->date));
            $session_year = getYearNow();
            $session_year_id = getYearNow()->id;

            // Get the Father Id for Payment Transaction Table
            // $father_id = Students::where('id',$request->student_id)->pluck('father_id')->first();

            // Add Data in Payment Transaction Of Optional Payment Transaction
            // $payment_transaction_store = new PaymentTransaction();
            // $payment_transaction_store->student_id = $request->student_id;
            // $payment_transaction_store->class_id = $request->class_id;
            // $payment_transaction_store->parent_id = $father_id;
            // $payment_transaction_store->mode = $request->mode;
            // $payment_transaction_store->cheque_no = (isset($request->cheque_no) && !empty($request->cheque_no) && $request->mode == 1) ? $request->cheque_no : null;
            // $payment_transaction_store->type_of_fee = 2;
            // $payment_transaction_store->payment_status = 1;
            // $payment_transaction_store->total_amount = $request->total_amount;
            // $payment_transaction_store->session_year_id = $session_year_id;
            // $payment_transaction_store->save();


            // Add Data in Array of Optional Fees
            // $optional_fees_store = array();
            foreach($request->months as $month){

                $itExistOrNot =FeesPaid::where([
                    'student_id' => $request->student_id,
                    'fees_class_id' => $feesClass->id,
                    'month' => $month,
                    'amount' =>$feesClass->amount,
                    'session_year_id' => $session_year_id,
                    'is_fully_paid' => 1,
                    'school_id' => getSchool()->id,
                    'date' => $date,
                    'mode' => $request->mode,
                ])->count();
                if($itExistOrNot==0){

                    FeesPaid::create( [
                        'student_id' => $request->student_id,
                        'fees_class_id' => $feesClass->id,
                        'month' => $month,
                        'amount' => $feesClass->amount,
                        'session_year_id' => $session_year_id,
                        'is_fully_paid' => 1,
                        'school_id' => getSchool()->id,
                        'date' => $date,
                        'mode' => $request->mode,
                    ]);
                }

            }

            // Add Data in Fees Choiceable Of Optional Payment
            // FeesChoiceable::insert($optional_fees_store);

            // Add Data in Fees Paid Of Optional Payment Transaction
            // $update_fees_paid_query = FeesPaid::where(['student_id' => $request->student_id,'class_id' => $request->class_id,'session_year_id' => $session_year_id]);

            // $fees_paid = $update_fees_paid_query->firstOrNew();
            // $fees_paid->total_amount += $request->total_amount;
            // $fees_paid->date = $date;
            // if (!$fees_paid->exists) {
            //     $fees_paid->student_id = $request->student_id;
            //     $fees_paid->class_id = $request->class_id;
            //     $fees_paid->is_fully_paid = 0;
            //     $fees_paid->session_year_id = $session_year_id;
            // }
            // $fees_paid->save();

            $response = array(
                'error' => false,
                'message' => trans('data_store_successfully')
            );
        // } catch (\Throwable $e) {
        //     $response = array(
        //         'error' => true,
        //         'message' => trans('error_occurred')
        //     );
        // }
        return response()->json($response);
    }
}

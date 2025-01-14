<?php

namespace App\Http\Controllers\Schools;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeesClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\FeesPaid;
class FeesClassesController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('school-fees-class-index')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }

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
        if (!Auth::user()->can('school-fees-create')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        $validation_rules = array(
            'class_id' => 'required',
            'base_amount' => 'required|numeric',
        );
        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) {
            $response = array(
                'error' => true,
                'message' => $validator->errors()->first()
            );
            toastr()->error( trans('genirale.error_occurred'), 'Congrats');
            return  redirect()->back();
        }
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
        if (!Auth::user()->can('school-fees-class-index')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
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
            $tempRow['base_amount'] =isset($row->fees_class) ? $row->fees_class->amount  . ' ' . env('CURENCY') : '-';
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
        if (!Auth::user()->can('school-fees-paid-index')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        return response(view('pages.schools.fees.fees_paid'));
    }

    public function feesPaidList(Request $request)
    {
        if (!Auth::user()->can('school-fees-paid-index')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        // return $request;
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

        $sql = Student::where('school_id',getSchool()->id)->with(['fees_paid','section']);
        $session_year_id = getYearNow()->id;



        if( isset($_GET['class_id']) && !empty($_GET['class_id']) ){
            $sql->where('section_id', $_GET['class_id']);
        }


        $total = $sql->count();
        $sql->orderBy($sort, $order)->skip($offset)->take($limit);
        $res = $sql->get();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        $no = 1;
        foreach ($res as $row) {

            $operate = "";
                    $operate = '<div class="dropdown"><button class="btn btn-xs btn-gradient-success btn-rounded btn-icon dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-dollar"></i></button><div class="dropdown-menu">';
                    $operate .= '<a href="#" class="optional-data dropdown-item" data-id=' . $row->id . ' title="' . trans('Paid')  .'" data-toggle="modal" data-target="#optionalModal"><i class="fa fa-dollar text-success mr-2"></i>'.trans('Paid').'</a>';
                    $operate .= '</div></div>&nbsp;&nbsp;';
                    $operate .= '<a href="'.route('school.fees.class.paid.pdf', $row->id).'" class="btn btn-xs btn-gradient-info btn-rounded btn-icon generate-paid-fees-pdf" target="_blank" data-id= title="' . trans('generate_pdf') . ' ' . trans('fees') . '"><i class="fa fa-file-pdf-o"></i></a>&nbsp;&nbsp;';

            $tempRow['student_id'] = $row->id;
            $tempRow['no'] = $no++;
            $tempRow['student_name'] = $row->first_name . ' ' . $row->last_name;
            $tempRow['class_id'] = $row->section->id;
            $tempRow['class_name'] = $row->section->name . ' ' . $row->section->classe->name;
            $tempRow['fees_paid'] = $row->fees_paid()->pluck('month').' '.env('CURENCY');
            $tempRow['months']='';
            if($row->fees_paid){

                foreach($row->fees_paid as $key => $fees) {

                    if ($key % 3 === 0) {
                        if ($key > 0) {
                            $tempRow['months'] .= '</div>';
                        }
                        $tempRow['months'] .= '<div class="d-flex flex-wrap mb-2">';
                    }

                    $tempRow['months'] .= '<button class="btn btn-primary btn-sm" style="margin: 2px;">' . getMonth($fees->month) . '</button>';
                }

            }
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

    }


    public function optionalFeesPaidStore(Request $request)
    {
        if (!Auth::user()->can('school-fees-paid-create')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'mode' => 'required|in:0,1',
            'months' => 'required|array',
            'student_id' => 'required|integer',
            'class_id' => 'required|integer',
        ]);
        try {

            $feesClass =FeesClass::where(['class_section_id'=>$request->class_id,
                    'session_year_id'=>getYearNow()->id,'school_id'=>getSchool()->id])->first();
            $date = date('Y-m-d H:i:s', strtotime($request->date));
            $session_year = getYearNow();
            $sessionYearId = getYearNow()->id;
            $schoolId = getSchool()->id;

            if($request->months){
                $feesClass->fees_paid()->delete();
            }

            foreach($request->months as $month){


                    FeesPaid::create([
                        'student_id' => $request->student_id,
                        'fees_class_id' => $feesClass->id,
                        'month' => $month,
                        'amount' => $feesClass->amount,
                        'session_year_id' => $sessionYearId,
                        'is_fully_paid' => 1,
                        'school_id' => $schoolId,
                        'date' => $date,
                        'mode' => $request->mode,
                    ]);

            }

            toastr()->success(trans('genirale.data_store_successfully'), 'Congrats');
            return  redirect()->back();


            } catch (\Throwable $th) {

                toastr()->error( trans('genirale.error_occurred'), 'Error');
                return  redirect()->back();
            }
    }
    public function feesPaidGetReceip($id){


        try {
          $student = Student::find($id);
          $className=$student->section->classe->name.' '.$student->section->name;

        //   return   $student->fees_paid;
          $fees =  FeesPaid::where([
            'student_id'=> $student->id,
            'school_id'=> getSchool()->id,
            'session_year_id'=> getYearNow()->id,
          ])->get();
          if($fees->count()>0){
            $logo= url(Storage::url(getSchool()->setting->school_logo));
             $pdf = Pdf::loadView('pages.schools.fees.fees_receipt',compact('fees','student','className','logo'));
            return $pdf->stream('fees-receipt.pdf');

          }else{

            toastr()->success(trans('genirale.no_data_found'), 'Error');
            return redirect()->back();
          }

        }catch (Throwable $e) {
            return redirect()->back();
        }
    }

    public function feesPaidDelete($id){
        if (!Auth::user()->can('school-fees-paid-delete')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return response()->json($response);
        }

        try {

          $feesPaid = FeesPaid::find($id);
          $feesPaid->delete();


            $response = array(
                    'error' => false,
                    'message' => trans('genirale.data_store_successfully')
                );

            return response()->json($response);

        } catch (\Throwable $th) {

            $response = array(
                'error' => true,
                'message' => trans('genirale.error_occurred')
            );

            return response()->json($response);

        }
    }
}

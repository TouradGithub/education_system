<?php

namespace App\Http\Controllers;

use App\Models\SessionYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
class SessionYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->can('session-year-list')) {
            $response = array(
                'message' => trans('no_permission_message')
            );
            return redirect()->back();

        }
        return view('session_years.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('session-year-create')) {
            $response = array(
                'error' => true,
                'message' => trans('genirale.no_permission_message')
            );
            return response()->json($response);
        }
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
          ],[

        ]);

        try {
            $session_year = new SessionYear();
            $session_year->name = $request->name;
            $session_year->price = $request->price;
            $session_year->start_date = date('Y-m-d',strtotime($request->start_date));
            $session_year->end_date = date('Y-m-d',strtotime($request->end_date));
            $session_year->save();

            $response = array(
                'error' => false,
                'message' => trans('genirale.data_store_successfully')
            );
             return redirect()->back()->with('success',trans('genirale.data_store_successfully'));
        } catch (Throwable $e) {

             return redirect()->back()->with('success',trans('genirale.error_occurred'));

        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

        $sql = SessionYear::query(); // Start with a query builder
        if (isset($_GET['offset']))
        $offset = $_GET['offset'];
        if (isset($_GET['limit']))
        $limit = $_GET['limit'];

        if (isset($_GET['sort']))
        $sort = $_GET['sort'];
        if (isset($_GET['order']))
        $order = $_GET['order'];
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql->where(function ($query) use ($search) {
                $query->where('id', 'LIKE', "%$search%")
                      ->orWhere('name', 'LIKE', "%$search%")
                      ->orWhere('start_date', 'LIKE', "%$search%")
                      ->orWhere('end_date', 'LIKE', "%$search%")
                      ->orWhere('default', 'LIKE', "%$search%");
            });
        }

        $total = $sql->count();

        $sql->orderBy($sort, $order)->skip($offset)->take($limit);
        $res = $sql->get(); // Execute the query and get the results as a collection
        $no = 1;
        foreach ($res as $row) {
            $operate = '<a class="btn btn-xs btn-gradient-primary btn-rounded btn-icon editdata" data-id=' . $row->id . ' data-url=' . url('session-years') . ' title="Edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
            $operate .= '<a class="btn btn-xs btn-gradient-danger btn-rounded btn-icon deletedata" data-id=' . $row->id . ' data-url=' . url('session-years', $row->id) . ' title="Delete"><i class="fa fa-trash"></i></a>';

            $tempRow['id'] = $row->id;
            $tempRow['no'] = $no++;
            $tempRow['name'] = $row->name;
            $tempRow['price'] = $row->price.' DZ';
            $tempRow['default'] = $row->default;
            $tempRow['start_date'] = date('d-m-Y' ,strtotime($row->start_date));
            $tempRow['end_date'] = date('d-m-Y' ,strtotime($row->end_date));
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;

        return response()->json($bulkData);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SessionYear $sessionYear)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'active_session_year'=>'required|in:0,1',
          ],[
            'name.required' => 'The name field is required.',
            'price.required' => 'The price field is required.',
            'start_date.required' => 'The start date field is required.',
            'start_date.date' => 'The start date must be a valid date.',
            'end_date.required' => 'The end date field is required.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after_or_equal' => 'The end date must be a date after or equal to the start date.',
            'active_session_year.required' => 'The active session year field is required.',
            'active_session_year.in' => 'The active session year must be either active  or not active.',
        ]);
        try {

            $old_year = SessionYear::find($request->id);
            if(!$old_year){
                $response = array(
                    'error' => true,
                    'message' => trans('genirale.error_occurred')
                );
            }
            if($request->active_session_year=="1"){
                $settings_years = SessionYear::where('id','!=',$request->id)->get();

                foreach ($settings_years as $row) {
                    $row->default = 0;
                    $row->save();
                }

                $old_year->name = $request->name;
                $old_year->price = $request->price;
                $old_year->start_date = date('Y-m-d',strtotime($request->start_date));
                $old_year->end_date = date('Y-m-d',strtotime($request->end_date));
                $old_year->default = 1;
                $old_year->save();

            }else{
                $old_year->name = $request->name;
                $old_year->price = $request->price;
                $old_year->start_date = date('Y-m-d',strtotime($request->start_date));
                $old_year->end_date = date('Y-m-d',strtotime($request->end_date));
                $old_year->save();
            }
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {

        try {

       $year= SessionYear::find($id);
       if(!$year){
            $response = array(
                'error' => true,
                'message' => trans('genirale.error_occurred')
            );
            return response()->json($response);
        }
        if($year->default=="1"){
            $response = array(
                'error' => true,
                'message' => trans('This Year Is Active')
            );
            return response()->json($response);
        }
        $students = Student::where('academic_year',$year->id)->count();
        if($students){
            $response = array(
                'error' => true,
                'message' => trans('genirale.cannot_delete_beacuse_data_is_associated_with_other_data')
            );
            return response()->json($response);
        }

        $year->delete();
        $response = [
            'error' => false,
            'message' => trans('genirale.data_delete_successfully')
        ];

    } catch (Throwable $e) {
        $response = array(
            'error' => true,
            'message' => trans('genirale.error_occurred')
        );
    }
    return response()->json($response);

    }
}

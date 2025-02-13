<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Validator;
use App\Models\Exam;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trimester;
use Illuminate\Support\Facades\Auth;
class TrimesterController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('trimester-create')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect()->back();

        }
        return view('pages.trimester.index');
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
    public function store(Request  $request)
    {
        if (!Auth::user()->can('trimester-create')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return  response()->json($response);

        }

        $request->validate([
            'name' => 'required',
            'name_en' => 'required',
            'arrangement' => [
                'required',
                'integer',
                Rule::unique('trimesters')->where(function ($query) use ($request) {
                    return $query->where('arrangement', $request->arrangement);
                }),
            ],
        ]);


        try {

            $section = new Trimester();
            $section->arrangement = $request->arrangement;

            $section->name = ['fr' => $request->name_en, 'ar' => $request->name];

            $section->notes = $request->notes;
            $section->save();

          $response = [
              'error' => false,
              'message' => trans('data_store_successfully')
          ];
          }catch (\Exception $e){
              $response = [
                  'error' => true,
                  'message' =>  $e->getMessage()
              ];
          }
          return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(Trimester $section)
    {
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
        $order = $_GET['order'];

        $sql = Trimester::where('id', '!=', 0);
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql->where('id', 'LIKE', "%$search%")
            ->orwhere('name', 'LIKE', "%$search%");
        }
        $total = $sql->count();

        $res = $sql->orderBy($sort, $order)->skip($offset)->take($limit)->get();
        $res = $sql->get();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        $no = 1;
        foreach ($res as $row) {
            $operate = '';
            if (Auth::user()->can('trimester-edit')){
                $operate .= '<a class="btn btn-xs btn-gradient-primary btn-rounded btn-icon editdata" data-id=' . $row->id . ' title="Edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';

            }

            if (Auth::user()->can('trimester-delete')){
                $operate .= '<a class="btn btn-xs btn-gradient-danger btn-rounded btn-icon deletedata" data-id=' . $row->id . ' data-url=' . route('web.trimesters.destroy', $row->id) . ' title="Delete"><i class="fa fa-trash"></i></a>';

            }


            $tempRow['id'] = $row->id;
            $tempRow['arrangement'] = $row->arrangement;

           $tempRow['name'] = $row->getTranslation('name', 'ar');
           $tempRow['name_en'] = $row->getTranslation('name', 'fr');
           $tempRow['operate'] =$operate;
           $tempRow['notes'] = $row->notes;


            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (!Auth::user()->can('trimester-edit')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return response()->json($response);

        }
        try {
            $trimester =Trimester::find($request->id);

            if (!$trimester) {
                return response()->json([
                    'error' => true,
                    'message' => trans('genirale.no_data_found')
                ]);
            }

            $existingTrimester = Trimester::where('name', json_encode(['fr' => $request->name_en, 'ar' => $request->name]))
                                ->where('arrangement', $request->arrangement)
                                ->where('id', '!=', $trimester->id)
                                ->first();


            if ($existingTrimester) {
                return response()->json([
                'error' => true,
                'message' => trans('genirale.arrangement_already_exists')
                ]);
            }





            $trimester->arrangement = $request->arrangement;

            $trimester->name = ['fr' => $request->name_en, 'ar' => $request->name];

            $trimester->notes = $request->notes;
            $trimester->save();

            $response = [
                'error' => false,
                'message' => trans('genirale.data_update_successfully')
            ];
          }catch (\Exception $e){
              $response = [
                  'error' => true,
                  'message' =>  $e->getMessage()
              ];
          }
          return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!Auth::user()->can('trimester-delete')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return response()->json($response);

        }
        try {
            // return $id;
            $trimester= Trimester::find($id);
            if(!$trimester){
                $response = array(
                    'error' => false,
                    'message' => trans('genirale.no_data_found')
                );
                return response()->json($response);
            }

            // return  $trimester;
            $exams=  Exam::where('trimester_id',$trimester->id)->count();
            if($exams>0){
                return $exams;
                $response = array(
                    'error' => false,
                    'message' => trans('genirale.cannot_delete_beacuse_data_is_associated_with_other_data')
                );
                return response()->json($response);
            }
            Trimester::find($id)->delete();
            $response = array(
                'error' => false,
                'message' => trans('genirale.data_delete_successfully')
            );

        } catch (Throwable $e) {

            $response = array(
                'error' => true,
                'message' => trans('genirale.error_occurred')
            );

        }

        return response()->json($response);
    }

    public function getSections(int $id)
    {
        try {
           $class= Classes::find($id);
        //
        $response = $class->sections->map(function ($section) {
            return [
                'id' => $section->id,
                'name' => $section->getTranslation('name', app()->getLocale()), // Assuming 'arabic_name' is the attribute
            ];
        });
        } catch (Throwable $e) {

            $response = array(
                'error' => true,
                'message' => trans('error_occurred')
            );

        }

        return response()->json($response);
    }
}

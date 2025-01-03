<?php

namespace App\Http\Controllers\Schools;
// use App\Http\Requests\StoreGrades;
use Illuminate\Support\Facades\DB;
use App\Models\Section;
use App\Models\Classes;
use Illuminate\Support\Facades\Validator;
use App\Models\Grade;
use App\Models\ClassRoom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubjectTeacher;
class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->can('school-sections-index')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        return view('pages.schools.sections.index');
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
        if (!Auth::user()->can('school-sections-create')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return response()->json($response);
        }


        $validator = Validator::make($request->all(), [
            'name' => [
                'required',

            ],
            'name_en' => [
                'required',
            ],
            'class_id' => [
                'required',
                'integer',
            ],

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            // Combine all error messages into a single string
            $errorMessage = implode("\n", $errors);
            $response = [
                'error' => true,
                'message' => $errorMessage,
                'data' => $validator->errors()
            ];
            return response()->json($response);
        }
        try {
            $classRoomData = [
                [
                    'name' => json_encode(['fr' => $request->name_en, 'ar' => $request->name]),
                    'grade_id' => getSchool()->grade_id,
                    'class_id' => $request->class_id,
                    'school_id' => getSchool()->id,
                    'notes' => $request->notes,
                ]
            ];
            ClassRoom::insert($classRoomData);

            $response = [
                'error' => false,
                'message' => trans('genirale.data_store_successfully')
            ];
          }catch (\Exception $e){
              $response = [
                  'error' => true,
                  'message' =>  $e->getMessage()
              ];
              return $e->getMessage();
          }
          return response()->json($response);


    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
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

        $sql = ClassRoom::where('school_id',getSchool()->id);
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
            if (Auth::user()->can('school-sections-edit')){
                $operate .= '<a class="btn btn-xs btn-gradient-primary btn-rounded btn-icon editdata" data-id=' . $row->id . ' title="Edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';

            }

            if (Auth::user()->can('school-sections-delete')){
                $operate .= '<a class="btn btn-xs btn-gradient-danger btn-rounded btn-icon deletedata" data-id=' . $row->id . ' data-url=' . route('school.sections.destroy', $row->id) . ' title="Delete"><i class="fa fa-trash"></i></a>';

            }

           $tempRow['id'] = $row->id;
           $tempRow['name'] = $row->getTranslation('name', 'fr');
           $tempRow['name_ar'] = $row->getTranslation('name', 'ar');
           $tempRow['grade'] =$row->grade->name;
           $tempRow['class'] =$row->classe->name;
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

        try {
            if (!Auth::user()->can('school-sections-edit')) {
                $response = array(
                    'message' => trans('genirale.no_permission_message')
                );
                return response()->json($response);
            }
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'name_en' => 'required',
                'class_id' => 'required',
            ]);

            if ($validator->fails()) {
                $response = array(
                    'error' => true,
                    'message' => $validator->errors()->first()
                );
                return response()->json($response);
            }
            // return $request;
          // Prepare data for updating
        $classRoomData = [
            'name' => json_encode(['fr' => $request->name_en, 'ar' => $request->name]),
            'class_id' => $request->class_id,
            'notes' => $request->notes ?? '', // Ensure notes are not null
        ];

        // Use the query builder to update the ClassRoom
        $updated = DB::table('classrooms')
                    ->where('id', $request->edit_id)
                    ->update($classRoomData);


            $section->name = ['fr' => $request->name_en, 'ar' => $request->name];
            $section->grade_id = getSchool()->grade_id;
            $section->class_id = $request->class_id;
            $section->notes = $request->notes;
            $section->save();

            $response = [
                'error' => false,
                'message' => trans('genirale.data_store_successfully')
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
        if (!Auth::user()->can('school-sections-delete')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return response()->json($response);
        }
        try {

            $timetables = SubjectTeacher::where(['class_section_id'=>$id,'school_id'=>getSchool()->id])->count();
            if($timetables){
                $response = array(
                    'error' => true,
                    'message' => trans('genirale.cannot_delete_beacuse_data_is_associated_with_other_data')

                );
            }else{
                ClassRoom::find($id)->delete();
                $response = [
                    'error' => false,
                    'message' => trans('genirale.data_delete_successfully')
                ];
            }
        } catch (Throwable $e) {

            $response = array(
                'error' => true,
                'message' => trans('error_occurred')
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
                'message' => trans('genirale.error_occurred')
            );

        }

        return response()->json($response);
    }
}

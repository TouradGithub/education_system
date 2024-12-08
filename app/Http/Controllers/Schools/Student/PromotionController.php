<?php

namespace App\Http\Controllers\Schools\Student;
use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Student;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;
use App\Models\Trimester;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
define('MINIMUM_AVERAGE', 10);
class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->can('school-promotion-list')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        return view('pages.schools.promotions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->can('school-promotion-create')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        return view('pages.schools.promotions.create');
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {
         if (!Auth::user()->can('school-promotion-create')) {
             toastr()->error(trans('genirale.no_permission_message'), 'Error');
             return redirect()->back();
         }

         $validated = $request->validate([
             'from_section' => 'required|exists:classrooms,id',
             'to_section' => 'required|integer|exists:classrooms,id',
             'academic_year' => 'required|string',
             'academic_year_new' => 'required|string',
         ]);

         DB::beginTransaction();

         try {
             $fromSection = ClassRoom::findOrFail($validated['from_section']);
             $students = $fromSection->students;

             if ($students->isEmpty()) {
                 toastr()->error(trans('genirale.error_occurred'), 'Ooops');
                 return back();
             }

            foreach ($students as $student) {
                $isAdmin = $this->isAdmin($student);

                $student->update([
                    'section_id' => $isAdmin === "yes" ? $validated['to_section'] : $validated['from_section'],
                    'academic_year' => $validated['academic_year_new'],
                ]);

                Promotion::create([
                    'student_id' => $student->id,
                    'school_id' => getSchool()->id,
                    'from_section' => $validated['from_section'],
                    'to_section' => $isAdmin === "yes" ? $validated['to_section'] : $validated['from_section'],
                    'academic_year' => $validated['academic_year'],
                    'academic_year_new' => $validated['academic_year_new'],
                    'decision' => $isAdmin === "yes" ? "admin" : "ajouner",
                ]);
            }

            DB::commit();
            toastr()->success(trans('genirale.data_store_successfully'), 'Congrats');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error(trans('genirale.error_occurred') . ": " . $e->getMessage(), 'Error');
            return back();
        }
    }

     private function isAdmin(Student $student): string
     {
         $trimesters = Trimester::all();
         $totalScore = 0;

         foreach ($trimesters as $trimester) {
             $exams = Exam::where([
                 'student_id' => $student->id,
                 'school_id' => getSchool()->id,
                 'session_year' => getYearNow()->id,
                 'trimester_id' => $trimester->id,
             ])->get();

             if ($exams->isEmpty()) {
                 continue;
             }

             $totalScore += $this->calculateTrimesterAverage($exams);
         }

         $average = $totalScore / max($trimesters->count(), 1);
         return $average >= MINIMUM_AVERAGE ? "yes" : "not";
     }

     private function calculateTrimesterAverage($exams): float
     {
         if ($exams->isEmpty()) {
             return 0;
         }

         $totalWeightedScore = 0;
         $totalWeight = 0;

         foreach ($exams as $exam) {
             $totalWeightedScore += $exam->grade * $exam->subject->code;
             $totalWeight += $exam->subject->code;
         }

         return $totalWeight > 0 ? $totalWeightedScore / $totalWeight : 0;
     }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        if (!Auth::user()->can('school-promotion-list')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
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

        $sql = Promotion::where('school_id',getSchool()->id);
        if (isset($_GET['search']) && !empty($_GET['search'])) {

            $search = $_GET['search'];
            $sql->where('id', 'LIKE', "%$search%")
            ->orwhere('name', 'LIKE', "%$search%");
        }

        if (isset($_GET['session_year']) && !empty($_GET['session_year'])){

            $sql->where('academic_year', $_GET['session_year']);
        }
        if (isset($_GET['section_id']) && !empty($_GET['section_id'])){

            $sql->where('from_section', $_GET['section_id']);
        }

        if (empty($_GET['section_id'])){
            $limit=10;
        }

        $res = $sql->orderBy($sort, $order)->skip($offset)->take($limit)->get();
        $res = $sql->get();

        $bulkData = array();
        $rows = array();
        $tempRow = array();
        $no = 1;
        foreach ($res as $row) {
            $operate = '';
            $operate .= '<a class="btn btn-xs btn-gradient-info btn-rounded btn-icon" href='.route('school.student.show',$row->id). '><i class="fa fa-eye"></i></a>';
            $operate .= '</div></div>&nbsp;&nbsp;';


           $tempRow['id'] = $row->id;
           $tempRow['fullName'] =$row->student->first_name.' '.$row->student->last_name;

          $tempRow['operate'] =$operate;
           $tempRow['from_section_id'] =$row->fromSection->name??'';
           $tempRow['to_section_id'] =$row->toSection->name??'';
           $tempRow['academic_year'] =$row->fromSessionyear->name??'';
           $tempRow['academic_year_new'] =$row->toSessionyear->name??'';
           $tempRow['is_admin'] =$row->decision??'';
           $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        //
    }

    public function exportResultsPDF(Request $request)
    {

        $request->validate([
            's_section_id' => 'required',
            'session_year' => 'required',
        ]);

        $exams = Exam::with('subject')
            ->where([
                'section_id' => $request->s_section_id,
                'session_year' => $request->session_year,
                'school_id' => getSchool()->id,
            ])
            ->get();


        $students = ClassRoom::find($request->s_section_id);
        $student_promotions = $students->student_promotions()->where('academic_year', $request->session_year)
        ->get();
        $trimesters = Trimester::all();
        $trimester1 = Trimester::where('arrangement',1)->first();
        $trimester2 = Trimester::where('arrangement',2)->first();
        $trimester3 = Trimester::where('arrangement',3)->first();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetAuthor('Adross');
        $mpdf->SetTitle("Resultat");
        $mpdf->SetMargins(10, 10, 20, 20);
        $mpdf->SetAutoPageBreak(TRUE, 20);

        foreach ($student_promotions as $promotion) {
            $mpdf->AddPage('P', 'A4');
            $html = view('pages.schools.promotions.resultpdf', [
                'promotion' => $promotion,
                'exams' => $exams,
                'trimester1' => $trimester1,
                'trimester2' => $trimester2,
                'trimester3' => $trimester3,
            ])->render();
            $mpdf->writeHTML($html);
        }

        $mpdf->Output();
        ob_end_flush();

    }

    public function exportInscriptionPDF(Request $request)
    {

        $request->validate([
            's_section_id' => 'required',
            'session_year' => 'required',
        ]);


        $classRoom = ClassRoom::find($request->s_section_id);


        if (!$classRoom) {
            return redirect()->back()->withErrors(['s_section_id' => 'Classroom not found.']);
        }


        $student_promotions = $classRoom->student_promotions()
            ->where('academic_year', $request->session_year)
            ->get();


        if ($student_promotions->isEmpty()) {
            return redirect()->back()->withErrors(['promotion' => 'No promotions found for the selected academic year.']);
        }


        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetAuthor('Adross');
        $mpdf->SetTitle("Resultat");
        $mpdf->SetMargins(10, 10, 20, 20);
        $mpdf->SetAutoPageBreak(TRUE, 20);


        foreach ($student_promotions as $promotion) {
            $mpdf->AddPage('P', 'A4');
            $html = view('pages.schools.promotions.inscription', [
                'promotion' => $promotion,
            ])->render();
            $mpdf->writeHTML($html);
        }


        $mpdf->Output();
        ob_end_flush();
    }

}

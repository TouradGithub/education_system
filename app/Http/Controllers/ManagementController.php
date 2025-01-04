<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\Acadimy;
use App\Models\User;
use App\Models\AcademyManegment;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('acadimic-list') ) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect(route('home'))->withErrors($response);

        }
        $managements = Acadimy::orderBy('id')->paginate(5);
        return view('managements.index',compact('managements'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->can('acadimic-create') ) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect(route('home'))->withErrors($response);

        }
        return view('managements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('acadimic-create') ) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect(route('home'))->withErrors($response);

        }

        try {

            DB::beginTransaction();

            $acadimy = Acadimy::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);


            DB::commit();
            $response = array(
                'error' => false,
                'message' => trans('data_store_successfully')
            );

        }catch (Throwable $e) {
            DB::rollback();
            $response = array(
                'error' => true,
                'message' => trans('error_occurred'),
                'data' => $e
            );
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(Acadimy $management)
    {
        if (!Auth::user()->can('acadimic-show') ) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect(route('home'))->withErrors($response);

        }
        return " ";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Acadimy $id)
    {
        if (!Auth::user()->can('acadimic-edit') ) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect(route('home'))->withErrors($response);

        }
        $management = Acadimy::find($id)->first();
        return view('managements.edit',compact('management'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Acadimy $management)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Update the management record
            $management->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            DB::commit();
            $response = array(
                'error' => false,
                'message' => trans('data_updated_successfully')
            );

        } catch (Throwable $e) {
            DB::rollback();
            $response = array(
                'error' => true,
                'message' => trans('error_occurred'),
                'data' => $e->getMessage() // Include error message for debugging
            );
        }

        return redirect()->back()->with('success', trans('genirale.data_update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Acadimy $id)
    {
        $acadimy=  $id;
        if (!Auth::user()->can('acadimic-delete') ) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect(route('home'))->withErrors($response);

        }
        try {
            // Check if the academy has any associated schools
            if ($acadimy->schools()->exists()) {
                $response = [
                    'error' => true,
                    'message' => trans('genirale.cannot_delete_academy_with_schools')
                ];
                return redirect()->back()->with('error',  trans('genirale.cannot_delete_academy_with_schools'));
            }

            DB::beginTransaction();

            // Perform the delete operation
            $acadimy->delete();

            DB::commit();

            $response = [
                'error' => false,
                'message' => trans('genirale.academy_deleted_successfully')
            ];

            return redirect()->back()->with('success', trans('genirale.data_update_successfully'));
        } catch (Throwable $e) {
            DB::rollback();

            $response = [
                'error' => true,
                'message' => trans('genirale.error_occurred'),
                'data' => $e->getMessage() // Include error message for debugging
            ];
        }

        return redirect()->back()->withErrors($response);
    }
}

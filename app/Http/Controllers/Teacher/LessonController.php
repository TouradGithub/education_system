<?php

namespace App\Http\Controllers\Teacher;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassRoom;
use App\Models\Lesson;
use App\Models\File;
use Illuminate\Support\Facades\Validator;
class LessonController extends Controller
{
    public function create($section){
        $section = ClassRoom::find($section);
        return view('pages.teachers.lessons.index',compact('section'));

    }
    public function store(Request $request)
    {

        // return $request;
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required'],
                'description' => 'required',
                'section_id' => 'required|numeric',
                'subject_id' => 'required|numeric',

                'file' => 'nullable|array',
                'file.*.type' => 'nullable|in:file_upload,youtube_link,video_upload,other_link',
                'file.*.name' => 'required_with:file.*.type',
                'file.*.thumbnail' => 'required_if:file.*.type,youtube_link,video_upload,other_link',
                'file.*.file' => 'required_if:file.*.type,file_upload,video_upload',
            ],
            [
                'name.unique' => trans('lesson.lesson_alredy_exists')
            ]
        );

        if ($validator->fails()) {
            $response = array(
                'error' => true,
                'message' => $validator->errors()->first(),
            );
            return response()->json($response);
        }
        try {

            $lesson = new Lesson();
            $lesson->name = $request->name;
            $lesson->description = $request->description;
            $lesson->section_id = $request->section_id;
            $lesson->subject_id = $request->subject_id;
            $lesson->trimester_id = $request->trimester_id;
            $lesson->session_year = getYearNow()->id;
            $lesson->school_id = getSchool()->id;
            $lesson->save();


            foreach ($request->file as $key => $file) {
                if ($file['type']) {
                    $lesson_file = new File();
                    $lesson_file->file_name = $file['name'];
                    $lesson_file->modal()->associate($lesson);

                    if ($file['type'] == "file_upload") {
                        $lesson_file->type = 1;
                        $lesson_file->file_url = $file['file']->store('lessons', 'public');
                    } elseif ($file['type'] == "youtube_link") {
                        $lesson_file->type = 2;

                        $image = $file['thumbnail'];
                        // made file name with combination of current time
                        $file_name = time() . '-' . $image->getClientOriginalName();
                        //made file path to store in database
                        $file_path = 'lessons/' . $file_name;
                        //resized image
                        resizeImage($image);
                        //stored image to storage/public/lessons folder
                        $destinationPath = storage_path('app/public/lessons');
                        $image->move($destinationPath, $file_name);

                        $lesson_file->file_thumbnail = $file_path;
                        $lesson_file->file_url = $file['link'];
                    } elseif ($file['type'] == "video_upload") {
                        $lesson_file->type = 3;

                        $image = $file['thumbnail'];
                        // made file name with combination of current time
                        $file_name = time() . '-' . $image->getClientOriginalName();
                        //made file path to store in database
                        $file_path = 'lessons/' . $file_name;
                        //resized image
                        resizeImage($image);
                        //stored image to storage/public/lessons folder
                        $destinationPath = storage_path('app/public/lessons');
                        $image->move($destinationPath, $file_name);

                        $lesson_file->file_thumbnail = $file_path;

                        $lesson_file->file_url = $file['file']->store('lessons', 'public');
                    } elseif ($file['type'] == "other_link") {
                        $lesson_file->type = 4;

                        $image = $file['thumbnail'];
                        // made file name with combination of current time
                        $file_name = time() . '-' . $image->getClientOriginalName();
                        //made file path to store in database
                        $file_path = 'lessons/' . $file_name;
                        //resized image
                        resizeImage($image);
                        //stored image to storage/public/lessons folder
                        $destinationPath = storage_path('app/public/lessons');
                        $image->move($destinationPath, $file_name);

                        $lesson_file->file_thumbnail = $file_path;
                        $lesson_file->file_url = $file['link'];
                    }
                    $lesson_file->save();
                }
            }

            $response = array(
                'error' => false,
                'message' => trans('genirale.data_store_successfully')
            );
        } catch (Throwable $e) {
            $response = array(
                'error' => true,
                'message' => trans('genirale.error_occurred'),
                'exception' => $e
            );
        }
        return response()->json($response);
    }

    public function show()
    {
        // if (!Auth::user()->can('lesson-list')) {
        //     $response = array(
        //         'error' => true,
        //         'message' => trans('no_permission_message')
        //     );
        //     return response()->json($response);
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
            $order = $_GET['order'];

        // $sql = Lesson::lessonteachers()->with('subject', 'class_section', 'topic');
        $teacherId = auth('teacher')->user()->id;
        // $teacher->sectionTeachers
        $sql = Lesson::lessonteachers()->with('subject','section');

        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql->where('id', 'LIKE', "%$search%")
                ->orwhere('name', 'LIKE', "%$search%")
                ->orwhere('description', 'LIKE', "%$search%")
                ->orwhere('created_at', 'LIKE', "%" . date('Y-m-d H:i:s', strtotime($search)) . "%")
                ->orwhere('updated_at', 'LIKE', "%" . date('Y-m-d H:i:s', strtotime($search)) . "%")
                ->orWhereHas('class_section.section', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%");
                })
                ->orWhereHas('class_section.class', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%");
                })->orWhereHas('subject', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%");
                });
        }
        // return $_GET['filter_trimester_id'];
        if (isset($_GET['filter_subject_id']) && !empty($_GET['filter_subject_id'])){

            $sql->where('subject_id', $_GET['filter_subject_id']);
        }
        if (isset($_GET['filter_section_id']) && !empty($_GET['filter_section_id'])){

            $sql->where('section_id', $_GET['filter_section_id']);
        }
        if (isset($_GET['filter_trimester_id']) && !empty($_GET['filter_trimester_id'])){

            $sql->where('trimester_id', $_GET['filter_trimester_id']);
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

            $row = (object)$row;
            $operate = '<a href='.route('teacher.lesson.edit', $row->id).' class="btn btn-xs btn-gradient-primary btn-rounded btn-icon edit-data" data-id=' . $row->id . ' title="Edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
            $operate .= '<a href='.route('teacher.lesson.lesson-delete', $row->id).' class="btn btn-xs btn-gradient-danger btn-rounded btn-icon delete-form" data-id=' . $row->id . '><i class="fa fa-trash"></i></a>';

            $tempRow['id'] = $row->id;
            $tempRow['no'] = $no++;
            $tempRow['name'] = $row->name;
            $tempRow['description'] = $row->description;
            $tempRow['class_section_id'] = $row->class_section_id;
            $tempRow['class_section_name'] = $row->section->classe->name . ' ' . $row->section->name . ' - ' . $row->section->classe->name;
            $tempRow['trimester_id'] = $row->trimester_id;
            $tempRow['subject_id'] = $row->subject_id;
            $tempRow['class_section_id'] =$row->section->id;
            $tempRow['subject_name'] = $row->subject->name.' - '.$row->subject->type;
            $tempRow['subject_id'] = $row->subject->id;
            $tempRow['topic'] = $row->topic;
            $tempRow['file'] = $row->file;
            $tempRow['created_at'] = $row->created_at;
            $tempRow['updated_at'] = $row->updated_at;
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }
    public function destroy($id)
    {
        // if (!Auth::user()->can('lesson-delete')) {
        //     $response = array(
        //         'error' => true,
        //         'message' => trans('no_permission_message')
        //     );
        //     return response()->json($response);
        // }
        try {


                $lesson = Lesson::find($id);
                if ($lesson->file) {
                    foreach ($lesson->file as $file) {
                        if (Storage::disk('public')->exists($file->file_url)) {
                            Storage::disk('public')->delete($file->file_url);
                        }
                    }
                }
                $lesson->file()->delete();
                $lesson->delete();

                $response = array(
                    'error' => false,
                    'message' => trans('genirale.data_delete_successfully')
                );

            } catch (\Throwable $e) {
            $response = array(
                'error' => true,
                'message' => trans('genirale.error_occurred')
            );
        }
        return response()->json($response);
    }
    public function update(Request $request, $id)
    {
        // if (!Auth::user()->can('lesson-edit')) {
        //     $response = array(
        //         'error' => true,
        //         'message' => trans('no_permission_message')
        //     );
        //     return response()->json($response);
        // }
        $validator = Validator::make(
            $request->all(),
            [
                'edit_id' => 'required|numeric',
                'name' => ['required'],
                'description' => 'required',
                'section_id' => 'required|numeric',
                'subject_id' => 'required|numeric',

                'file' => 'nullable|array',
                'file.*.type' => 'nullable|in:file_upload,youtube_link,video_upload,other_link',
                'file.*.name' => 'required_with:file.*.type',
                'file.*.thumbnail' => 'required_if:file.*.type,youtube_link,video_upload,other_link',
                'file.*.file' => 'required_if:file.*.type,file_upload,video_upload',
            ],
            [
                'name.unique' => trans('lesson.lesson_alredy_exists')
            ]
        );
        if ($validator->fails()) {
            $response = array(
                'error' => true,
                'message' => $validator->errors()->first(),
            );
            return response()->json($response);
        }
        try {
            // return $request;
            $lesson = Lesson::find($request->edit_id);
            $lesson->name = $request->name;
            $lesson->description = $request->description;
            $lesson->section_id = $request->section_id;
            $lesson->subject_id = $request->subject_id;
            $lesson->trimester_id = $request->edit_trimester_id;
            $lesson->session_year = getYearNow()->id;
            $lesson->school_id = getSchool()->id;
            $lesson->save();

            // Update the Old Files
            foreach ($request->edit_file as $file) {
                if ($file['type']) {
                    $lesson_file = File::find($file['id']);
                    $lesson_file->file_name = $file['name'];

                    if ($file['type'] == "file_upload") {
                        $lesson_file->type = 1;
                        if (!empty($file['file'])) {
                            if (Storage::disk('public')->exists($lesson_file->getRawOriginal('file_url'))) {
                                Storage::disk('public')->delete($lesson_file->getRawOriginal('file_url'));
                            }
                            $lesson_file->file_url = $file['file']->store('lessons', 'public');
                        }
                    } elseif ($file['type'] == "youtube_link") {
                        $lesson_file->type = 2;
                        if (!empty($file['thumbnail'])) {
                            if (Storage::disk('public')->exists($lesson_file->getRawOriginal('file_thumbnail'))) {
                                Storage::disk('public')->delete($lesson_file->getRawOriginal('file_thumbnail'));
                            }

                            $image = $file['thumbnail'];
                            // made file name with combination of current time
                            $file_name = time() . '-' . $image->getClientOriginalName();
                            //made file path to store in database
                            $file_path = 'lessons/' . $file_name;
                            //resized image
                            resizeImage($image);
                            //stored image to storage/public/lessons folder
                            $destinationPath = storage_path('app/public/lessons');
                            $image->move($destinationPath, $file_name);

                            $lesson_file->file_thumbnail = $file_path;
                        }

                        $lesson_file->file_url = $file['link'];
                    } elseif ($file['type'] == "video_upload") {
                        $lesson_file->type = 3;
                        if (!empty($file['file'])) {
                            if (Storage::disk('public')->exists($lesson_file->getRawOriginal('file_url'))) {
                                Storage::disk('public')->delete($lesson_file->getRawOriginal('file_url'));
                            }
                            $lesson_file->file_url = $file['file']->store('lessons', 'public');
                        }

                        if (!empty($file['thumbnail'])) {
                            if (Storage::disk('public')->exists($lesson_file->getRawOriginal('file_thumbnail'))) {
                                Storage::disk('public')->delete($lesson_file->getRawOriginal('file_thumbnail'));
                            }

                            $image = $file['thumbnail'];
                            // made file name with combination of current time
                            $file_name = time() . '-' . $image->getClientOriginalName();
                            //made file path to store in database
                            $file_path = 'lessons/' . $file_name;
                            //resized image
                            resizeImage($image);
                            //stored image to storage/public/lessons folder
                            $destinationPath = storage_path('app/public/lessons');
                            $image->move($destinationPath, $file_name);

                            $lesson_file->file_thumbnail = $file_path;
                        }
                    } elseif ($file['type'] == "other_link") {
                        $lesson_file->type = 4;
                        if (!empty($file['thumbnail'])) {
                            if (Storage::disk('public')->exists($lesson_file->getRawOriginal('file_thumbnail'))) {
                                Storage::disk('public')->delete($lesson_file->getRawOriginal('file_thumbnail'));
                            }

                            $image = $file['thumbnail'];
                            // made file name with combination of current time
                            $file_name = time() . '-' . $image->getClientOriginalName();
                            //made file path to store in database
                            $file_path = 'lessons/' . $file_name;
                            //resized image
                            resizeImage($image);
                            //stored image to storage/public/lessons folder
                            $destinationPath = storage_path('app/public/lessons');
                            $image->move($destinationPath, $file_name);

                            $lesson_file->file_thumbnail = $file_path;
                        }
                        $lesson_file->file_url = $file['link'];
                    }

                    $lesson_file->save();
                }
            }

            //Add the new Files
            if ($request->file) {
                foreach ($request->file as $key => $file) {
                    if ($file['type']) {
                        $lesson_file = new File();
                        $lesson_file->file_name = $file['name'];
                        $lesson_file->modal()->associate($lesson);

                        if ($file['type'] == "file_upload") {
                            $lesson_file->type = 1;
                            $lesson_file->file_url = $file['file']->store('lessons', 'public');
                        } elseif ($file['type'] == "youtube_link") {
                            $lesson_file->type = 2;

                            $image = $file['thumbnail'];
                            // made file name with combination of current time
                            $file_name = time() . '-' . $image->getClientOriginalName();
                            //made file path to store in database
                            $file_path = 'lessons/' . $file_name;
                            //resized image
                            resizeImage($image);
                            //stored image to storage/public/lessons folder
                            $destinationPath = storage_path('app/public/lessons');
                            $image->move($destinationPath, $file_name);

                            $lesson_file->file_thumbnail = $file_path;
                            $lesson_file->file_url = $file['link'];
                        } elseif ($file['type'] == "video_upload") {
                            $lesson_file->type = 3;
                            $lesson_file->file_url = $file['file']->store('lessons', 'public');

                            $image = $file['thumbnail'];
                            // made file name with combination of current time
                            $file_name = time() . '-' . $image->getClientOriginalName();
                            //made file path to store in database
                            $file_path = 'lessons/' . $file_name;
                            //resized image
                            resizeImage($image);
                            //stored image to storage/public/lessons folder
                            $destinationPath = storage_path('app/public/lessons');
                            $image->move($destinationPath, $file_name);

                            $lesson_file->file_thumbnail = $file_path;
                        } elseif ($file['type'] == "other_link") {
                            $lesson_file->type = 4;

                            $image = $file['thumbnail'];
                            // made file name with combination of current time
                            $file_name = time() . '-' . $image->getClientOriginalName();
                            //made file path to store in database
                            $file_path = 'lessons/' . $file_name;
                            //resized image
                            resizeImage($image);
                            //stored image to storage/public/lessons folder
                            $destinationPath = storage_path('app/public/lessons');
                            $image->move($destinationPath, $file_name);

                            $lesson_file->file_thumbnail = $file_path;
                            $lesson_file->file_url = $file['link'];
                        }
                        $lesson_file->save();
                    }
                }
            }
            $response = array(
                'error' => false,
                'message' => trans('genirale.data_store_successfully')
            );
        } catch (Throwable $e) {
            $response = array(
                'error' => true,
                'message' => trans('genirale.error_occurred'),
                'exception' => $e
            );
        }
        return response()->json($response);
    }

    public function deleteFile($id)
    {
        try {
            $file = File::findOrFail($id);
            if (Storage::disk('public')->exists($file->file_url)) {
                Storage::disk('public')->delete($file->file_url);
            }
            $file->delete();
            $response = array(
                'error' => false,
                'message' => trans('genirale.data_delete_successfully')
            );
        } catch (\Throwable $e) {
            $response = array(
                'error' => true,
                'message' => trans('genirale.error_occurred')
            );
        }
        return response()->json($response);
    }
}

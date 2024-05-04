<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class lesson extends Model
{
    use HasFactory;
    protected $hidden = ["deleted_at", "updated_at"];

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function section() {
        return $this->belongsTo(ClassRoom::class)->with('classe');
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function ($lesson) { // before delete() method call this
            if ($lesson->file) {
                foreach ($lesson->file as $file) {
                    if (Storage::disk('public')->exists($file->file_url)) {
                        Storage::disk('public')->delete($file->file_url);
                    }
                }

                $lesson->file()->delete();
            }
            // if ($lesson->topic) {
            //     $lesson->topic()->delete();
            // }
        });
    }
    public function scopeLessonTeachers($query) {
        $teacherId = auth('teacher')->user()->id;
        // if ($user->hasRole('Teacher')) {
            // $teacher_id = $user->teacher()->select('id')->pluck('id')->first();
            $subject_teacher = SubjectTeacher::select('class_section_id', 'subject_id')->where('teacher_id', $teacherId)
            ->where('school_id', getSchool()->id)->get();
            if ($subject_teacher) {
                $subject_teacher = $subject_teacher->toArray();
                $class_section_id = array_column($subject_teacher, 'class_section_id');
                $subject_id = array_column($subject_teacher, 'subject_id');
                return $query->whereIn('section_id', $class_section_id)->whereIn('subject_id', $subject_id);
            }
            return $query;

        // }
        return $query;
    }

    public function topic() {
        return $this->hasMany(LessonTopic::class);
    }
    public function file() {
        return $this->morphMany(File::class, 'modal');
    }
}

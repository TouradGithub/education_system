<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesPaid extends Model
{
    use HasFactory;
    protected $table = 'fee_paids';
    protected $hidden = ["deleted_at", "created_at", "updated_at"];

    protected $fillable=[
        'fees_class_id',
        'is_fully_paid',
        'month' ,
        'date' ,
        'student_id',
        'mode',
        "amount"         ,
        "school_id"       ,
        "session_year_id" ,
    ];



    public function student(){
        return $this->belongsTo(Student::class ,'student_id');
    }

    public function fees_class() {
        return $this->belongsTo(FeesClass::class,'fees_class_id');
    }

    public function section() {
        return $this->belongsTo(ClassRoom::class);
    }

    public function sessionyear() {
        return $this->belongsTo(SessionYear::class,'session_year_id');
    }
}

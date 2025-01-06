<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeesClass extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'fees_classes';
    protected $hidden = ["deleted_at", "created_at", "updated_at"];

    protected $fillable=[
        "class_section_id" ,
        "amount"         ,
        "school_id"       ,
        "session_year_id" ,
    ];



    // public function fees_type(){
    //     return $this->belongsTo(FeesType::class ,'fees_type_id');
    // }

    // public function fees_paid() {
    //     return $this->hasMany(FeesPaid::class, 'fees_class_id');
    // }

    public function section() {
        return $this->belongsTo(ClassRoom::class, 'class_section_id');
    }
    public function fees_paid() {
        return $this->hasMany(FeesPaid::class, 'fees_class_id');
    }
}

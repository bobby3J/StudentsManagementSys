<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Student extends Model
{
    use HasFactory;
    // protected $with= ['course'];
    protected $fillable = ['student_id', 'firstname', 'lastname', 'email', 'gender', 'age', 'dob', 'image', 'course_id'];
    
    protected $with = ['course'];

    public function course(){
       return $this->belongsTo(Course::class);
    }

    public function getImageURL(){
        $image = $this->image ? $this->image : 'images/profile.jpg';
         return Storage::url($image);
    }

    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobImage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_id',
        'job_image_type_id',
        'staff_id',
        'colour_id',
        'title',
        'description',
        'image_identifier',
        'image_path',
        'is_pdf_image',
        'is_visible',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the job associated with the job image.
     */
    public function job() 
    {
        return $this->belongsTo('App\Models\Job');
    }

    /**
     * Get the image type associated with the job image.
     */
    public function job_image_type() 
    {
        return $this->belongsTo('App\Models\JobImageType');
    }

    /**
     * Get the staff member associated with the job image.
     */
    public function staff() 
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the image type associated with the job image.
     */
    public function colour() 
    {
        return $this->belongsTo('App\Models\Colour');
    }
}

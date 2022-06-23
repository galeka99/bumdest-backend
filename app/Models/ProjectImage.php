<?php

namespace App\Models;

use App\Http\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    use HasFactory;

    protected $fillable = ['image_path', 'project_id'];
    protected $hidden = ['image_path', 'project_id'];
    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return Helper::fileUrl($this->image_path);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
  protected $fillable = [
    "name",
    "slug",
    "tech_stack",
    "display_status",
    "image",
    "description",
  ];

  protected $casts = [
    "tech_stack" => "array",
    "display_status" => "boolean",
  ];

  /**
   * Auto-generate slug when creating a project.
   */
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($project) {
      $project->slug = Str::slug($project->name);
    });
  }
}

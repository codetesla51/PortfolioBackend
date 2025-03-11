<?php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
  /**
   * Display all Projects.
   */
  public function index()
  {
    $projects = Project::where("display_status", true)
      ->latest()
      ->paginate(8);

    return response()->json($projects);
  }
  public function adminIndex()
  {
    $projects = Project::latest()->get();
    return response()->json($projects);
  }
  /**
   * Store a new Project.
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      "name" => "required|string|max:255",
      "tech_stack" => "required|array",
      "display_status" => "boolean",
      "image" => "nullable|string",
      "description" => "nullable|string",
    ]);

    $validated["slug"] = $this->generateUniqueSlug($validated["name"]);

    $project = Project::create($validated);

    return response()->json(
      [
        "message" => "Project created successfully!",
        "project" => $project,
      ],
      201
    );
  }

  /**
   * Display a specific Project.
   */
  public function show($slug)
  {
    $project = Project::where("slug", $slug)->firstOrFail();
    return response()->json($project);
  }

  /**
   * Update a Project.
   */
  public function update(Request $request, $slug)
  {
    $project = Project::where("slug", $slug)->firstOrFail();

    $validated = $request->validate([
      "name" => "sometimes|string|max:255",
      "tech_stack" => "sometimes|array",
      "display_status" => "sometimes|boolean",
      "image" => "nullable|string",
      "description" => "nullable|string",
    ]);

    if (isset($validated["name"]) && $validated["name"] !== $project->name) {
      $validated["slug"] = $this->generateUniqueSlug($validated["name"]);
    }

    $project->update($validated);

    return response()->json([
      "message" => "Project updated successfully!",
      "project" => $project,
    ]);
  }

  /**
   * Delete a Project.
   */
  public function destroy($slug)
  {
    $project = Project::where("slug", $slug)->firstOrFail();
    $project->delete();
    return response()->json(["message" => "Project deleted successfully!"]);
  }

  /**
   * Generate a unique slug.
   */
  private function generateUniqueSlug($name)
  {
    $slug = Str::slug($name);
    $count = Project::where("slug", "LIKE", "$slug%")->count();

    return $count ? "{$slug}-" . ($count + 1) : $slug;
  }
}

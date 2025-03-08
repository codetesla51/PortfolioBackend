<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;

// API Routes for Projects
Route::get("/projects", [ProjectController::class, "index"]); // List all projects
Route::post("/projects", [ProjectController::class, "store"]); // Create a project
Route::get("/projects/{slug}", [ProjectController::class, "show"]); // Get project by slug
Route::put("/projects/{slug}", [ProjectController::class, "update"]); // Update project
Route::delete("/projects/{slug}", [ProjectController::class, "destroy"]); // Delete project
Route::prefix("contacts")->group(function () {
  Route::post("/", [ContactController::class, "store"]); // Create a new contact
  Route::get("/", [ContactController::class, "index"]); // Get all contacts
  Route::get("/{id}", [ContactController::class, "show"]); // Get a single contact
  Route::delete("/{id}", [ContactController::class, "destroy"]); // Delete a contact
});

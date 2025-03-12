<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminAuthMiddleware;

// Public routes for projects
Route::get("/projects", [ProjectController::class, "index"]);
Route::get("/projects/{slug}", [ProjectController::class, "show"]);
Route::get("/admin/projects", [ProjectController::class, "adminIndex"]);
Route::middleware([AdminAuthMiddleware::class])->group(function () {
  Route::post("/projects", [ProjectController::class, "store"]);
  Route::put("/projects/{slug}", [ProjectController::class, "update"]);
  Route::delete("/projects/{slug}", [ProjectController::class, "destroy"]);
  Route::patch('/projects/{slug}/toggle-display', [ProjectController::class, 'toggleDisplayStatus']);
});

Route::post("/contacts", [ContactController::class, "store"]); 
Route::middleware([AdminAuthMiddleware::class])->group(function () {
  Route::get("/contacts", [ContactController::class, "index"]);
  Route::get("/contacts/{id}", [ContactController::class, "show"]);
  Route::put("/contacts/{id}", [ContactController::class, "update"]); 
  Route::delete("/contacts/{id}", [ContactController::class, "destroy"]);
});

// Admin authentication routes
Route::post("/admin/login", [AdminController::class, "login"]);
Route::post("/admin/logout", [AdminController::class, "logout"])->middleware(
  AdminAuthMiddleware::class
);

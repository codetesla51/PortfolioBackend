<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create("projects", function (Blueprint $table) {
      $table->id();
      $table->string("name");
      $table->json("tech_stack");
      $table->string("slug")->unique();
      $table->boolean("display_status")->default(true);
      $table->string("image")->nullable();
      $table->longText("description")->nullable();
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists("projects");
  }
};

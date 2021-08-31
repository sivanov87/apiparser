<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp("parsed_at")->nullable();

            $table->foreignId("source_id");
            $table->text("author")->nullable();
            $table->text("title")->nullable();
            $table->text("description")->nullable();
            $table->text("content")->nullable();
            $table->text("url")->nullable();
            $table->string("url_hash")->nullable()->index();
            $table->text("url_to_image")->nullable();
            $table->timestamp("published_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->tinyInteger('n_rooms')->default(1);
            $table->tinyInteger('n_beds')->default(1);
            $table->tinyInteger('n_baths')->default(1);
            $table->smallInteger('square_meters');
            $table->decimal('lat', 10, 8);
            $table->decimal('lon', 11, 8);
            $table->string('address');
            $table->string('imgs')->nullable();
            $table->boolean('visible')->default(true);
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments');
    }
}

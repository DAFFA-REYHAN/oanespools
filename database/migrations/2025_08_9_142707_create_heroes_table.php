<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_hero_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeroTable extends Migration
{
    public function up()
    {
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah_proyek')->default(0); // Make sure this is an integer with default 0
            $table->integer('jumlah_pelanggan')->default(0); // Make sure this is an integer with default 0
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('heroes');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSchema extends Migration
{

    private function createShorterUrlTable() {

        Schema::create('shorter_url', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary("id");
            $table->string('url', 2000)->nullable(false);
            $table->string('short_url')->default("")->nullable(false);
            $table->integer("version")->default(1);
        });
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // shorter module
        $this->createShorterUrlTable();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}

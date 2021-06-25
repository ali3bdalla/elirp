<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('account_id')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('number')->nullable();
            $table->string('address')->nullable();
            $table->boolean('enabled')->default(true);
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}

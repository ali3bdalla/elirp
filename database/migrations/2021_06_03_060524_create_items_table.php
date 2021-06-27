<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('name')->nullable();
            $table->string('sku')->nullable();
            $table->text('description')->nullable();
            $table->longText('tags')->nullable();
            $table->string('model_number')->nullable();
            $table->string('model_name')->nullable();
            $table->string('brand')->nullable();
            $table->string('item_photo_path')->nullable();
            $table->double('sale_price', 15, 4)->nullable();
            $table->double('purchase_price', 15, 4)->nullable();
            $table->boolean('enabled')->default(true);
            $table->foreign('company_id')->references('id')->on('companies');
            $table->boolean('fixed_price')->default(false);
            $table->boolean('is_service')->default(false);
            $table->boolean('has_detail')->default(false);
            $table->index(['fixed_price', 'is_service', 'has_detail']);
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
        Schema::dropIfExists('items');
    }
}

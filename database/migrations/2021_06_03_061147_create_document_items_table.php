<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('item_id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('sku')->nullable();
            $table->double('quantity', 7, 2);
            $table->double('price', 15, 4);
            $table->float('tax', 15, 4)->default('0.0000');
            $table->string('discount_type')->nullable();
            $table->string('type')->nullable();
            $table->double('discount_rate', 15, 4)->default('0.0000');
            $table->double('total', 15, 4)->default(0);
            $table->double('subtotal', 15, 4)->default(0);
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('item_id')->references('id')->on('items');
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
        Schema::dropIfExists('document_items');
    }
}

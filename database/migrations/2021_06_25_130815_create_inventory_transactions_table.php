<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('inventory_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('document_item_id')->nullable();
            $table->unsignedBigInteger('document_id')->nullable();
            $table->double('quantity', 25, 2);
            $table->string('type')->nullable();
            $table->string('reference')->default(uniqid());
            $table->boolean('enabled')->default(true);
            $table->foreign('inventory_id')->references('id')->on('inventories');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('document_item_id')->references('id')->on('document_items');
            $table->foreign('document_id')->references('id')->on('documents');
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
        Schema::dropIfExists('inventory_transactions');
    }
}

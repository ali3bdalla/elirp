<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('tax_id');
            $table->unsignedBigInteger('document_id')->nullable();
            $table->unsignedBigInteger('document_item_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->double('amount', 100, 2)->default(0);
            $table->string('type')->nullable();
            $table->string('reference')->default(uniqid());
            $table->boolean('enabled')->default(true);

            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('document_item_id')->references('id')->on('document_items');
            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('tax_id')->references('id')->on('taxes');

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
        Schema::dropIfExists('tax_transactions');
    }
}

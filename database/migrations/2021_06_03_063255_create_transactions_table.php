<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->boolean('is_pending')->default(false);
            $table->boolean('enabled')->default(true);
            $table->double('amount', 100, 4);
            $table->string('currency_code', 20)->nullable();
            $table->double('currency_rate', 15, 8)->nullable();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('document_id')->nullable();
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->unsignedBigInteger('entry_id');
            $table->unsignedBigInteger('item_id')->nullable();
            $table->text('description')->nullable();
            $table->string('reference')->default(uniqid());
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('parent_id')->references('id')->on('transactions');
            $table->foreign('contact_id')->references('id')->on('contacts');
            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('entry_id')->references('id')->on('entries');
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
        Schema::dropIfExists('transactions');
    }
}

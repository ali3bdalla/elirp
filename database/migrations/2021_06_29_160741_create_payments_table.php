<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'payments',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('company_id');
                $table->unsignedBigInteger('payment_method_id');
                $table->unsignedBigInteger('contact_id');
                $table->unsignedBigInteger('document_id')->nullable();
                $table->double('amount', 100, 2)->default(0);
                $table->string('type')->nullable();
                $table->string('reference')->default(uniqid());
                $table->boolean('enabled')->default(true);
                $table->foreign('payment_method_id')->references('id')->on('payment_methods');
                $table->foreign('company_id')->references('id')->on('companies');
                $table->foreign('contact_id')->references('id')->on('contacts');
                $table->foreign('document_id')->references('id')->on('documents');
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}

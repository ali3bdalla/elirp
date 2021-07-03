<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('created_by_id');
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->float('amount', 100, 2)->nullable();
            $table->boolean('notify')->default(true);
            $table->boolean('notified')->default(false);
            $table->boolean('views')->default(false);
            $table->text('description')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('created_by_id')->references('id')->on('users');
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
        Schema::dropIfExists('document_histories');
    }
}

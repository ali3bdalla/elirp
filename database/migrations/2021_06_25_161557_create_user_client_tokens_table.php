<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    class CreateUserClientTokensTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('user_client_tokens', function(Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->boolean('is_active')->default(true);
                $table->string('driver')->nullable();
                $table->text('token')->nullable();
                $table->string('expires_in')->nullable();
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->string('client_id')->nullable();
                $table->string('avatar')->nullable();
                $table->string('nickname')->nullable();
                $table->text('refresh_token')->nullable();
                $table->foreign('user_id')->references('id')->on('users');
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
            Schema::dropIfExists('user_client_tokens');
        }
    }

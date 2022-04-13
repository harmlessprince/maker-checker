<?php

use App\Enums\ApprovalStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('approvable_id')->unsigned()->nullable();
            $table->string('approvable_type');
            $table->string('operation');
            $table->text('values');
            $table->text('changes')->nullable();
            $table->boolean('is_approved')->default(0);
            $table->string('status')->default(ApprovalStatus::PENDING);
            $table->foreignId('approved_by')->constrained('users', 'id');
            $table->timestamp('approved_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('approvals');
    }
}

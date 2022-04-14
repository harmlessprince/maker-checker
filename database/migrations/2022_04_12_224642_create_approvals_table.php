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
            $table->integer('created_by')->unsigned();
            $table->integer('approvable_id')->unsigned()->nullable();
            $table->string('approvable_type');
            $table->string('operation');
            $table->text('before')->nullable();
            $table->text('after')->nullable();
            $table->boolean('is_approved')->default(0);
            $table->string('status')->default(ApprovalStatus::PENDING);
            $table->foreignId('approved_by')->nullable()->constrained('users', 'id');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('declined_by')->nullable()->constrained('users', 'id');
            $table->timestamp('declined_at')->nullable();
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

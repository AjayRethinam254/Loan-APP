<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loan_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('loan_id')->constrained('loans')->onDelete('cascade');
            $table->foreignId('loan_application_id')->constrained('loan_applications')->onDelete('cascade');
            $table->date('due_date');
            $table->decimal('installment_amount', 15, 2)->nullable();
            $table->decimal('principal_amount', 15, 2)->nullable();
            $table->decimal('interest_amount', 15, 2)->nullable();
            $table->decimal('outstanding_amount', 15, 2)->nullable();
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            $table->foreignId('payment_id')->nullable()->constrained('payments')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_schedules');
    }
};

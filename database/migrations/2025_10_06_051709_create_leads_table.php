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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('lead_name');
            $table->string('lead_email')->nullable();
            $table->string('lead_phone');
            $table->string('alternate_phone')->nullable();
            $table->string('address')->nullable();
            $table->string('gender')->nullable();
            $table->decimal('monthly_income', 15, 2)->nullable();
            $table->integer('cibil_score')->nullable();
            $table->string('loan_type')->nullable(); 
            $table->decimal('loan_amount_required', 15, 2)->nullable();
            $table->string('loan_purpose')->nullable();
            $table->integer('loan_tenure_months')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('agents')->onDelete('set null'); 
            $table->enum('lead_source', ['website', 'referral', 'walk-in', 'phone', 'social_media', 'advertisement', 'other'])->default('website');
            $table->enum('lead_status', ['new', 'contacted', 'qualified', 'negotiation', 'converted', 'lost', 'follow_up'])->default('new');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->date('follow_up_date')->nullable();
            $table->text('notes')->nullable();
            $table->text('rejection_reason')->nullable(); 
            $table->foreignId('converted_to_client_id')->nullable()->constrained('clients')->onDelete('set null');
            $table->timestamp('converted_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};

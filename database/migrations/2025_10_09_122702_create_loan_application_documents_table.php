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
        Schema::create('loan_application_documents', function (Blueprint $table) {
            $table->id();       
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('loan_application_id')->constrained('loan_applications')->onDelete('cascade');
            $table->string('document_type');       
            $table->string('file_name');           
            $table->string('file_path');           
            $table->string('mime_type');          
            $table->integer('file_size')->nullable(); 
            $table->foreignId('uploaded_by')->constrained('agents')->onDelete('cascade'); 
            $table->foreignId('verified_by')->nullable()->constrained('agents')->onDelete('set null'); 
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('remarks')->nullable();  
            $table->timestamp('uploaded_at')->useCurrent(); 
            $table->timestamp('verified_at')->nullable();   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_application_documents');
    }
    
};

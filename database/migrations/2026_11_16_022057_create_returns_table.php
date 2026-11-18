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
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained('Loans')->cascadeOnDelete();
            $table->foreignId('received_by')->nullable()->constrained('Users')->nullOnDelete();

            $table->date('return_date');
            $table->enum('status', ['good', 'damaged', 'lost'])->default('good');
            $table->Integer('fine')->default(0);

            $table->index(['return_date','status']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};

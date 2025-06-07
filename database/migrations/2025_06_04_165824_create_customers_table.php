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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scan_id'); // Foreign key for Scan
            $table->string('customerId');
            $table->string('bsn');
            $table->string('firstName');
            $table->string('lastName');
            $table->date('dateOfBirth');
            $table->string('phoneNumber');
            $table->string('email');
            $table->string('tag')->nullable();
            $table->string('street');
            $table->string('postcode');
            $table->string('city');
            $table->json('products')->nullable();
            $table->string('ipAddress');
            $table->string('iban');
            $table->date('lastInvoiceDate')->nullable();
            $table->timestamp('lastLoginDateTime')->nullable();
            $table->boolean('is_fraud')->default(false);
            $table->string('fraud_reason')->nullable();
            $table->timestamps();

            $table->foreign('scan_id')->references('id')->on('scans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

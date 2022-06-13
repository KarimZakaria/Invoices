<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->string('product');
            $table->decimal('Amount_collection',8,2)->nullable();;
            $table->decimal('Amount_Commission',8,2);
            $table->decimal('discount');
            $table->string('rat_vat');
            $table->decimal('vat_value', 8, 2);
            $table->decimal('total', 8, 2);
            $table->string('status');
            $table->integer('status_value');
            $table->date('payment_date')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}

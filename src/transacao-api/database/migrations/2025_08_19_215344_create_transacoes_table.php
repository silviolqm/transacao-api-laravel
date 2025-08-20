<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->decimal('valor', 15, 2);
            $table->string('cpf');
            $table->string('documento_path')->nullable();
            $table->enum('status', ['Em processamento', 'Aprovada', 'Negada'])->default('Em processamento');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transacoes');
    }
};

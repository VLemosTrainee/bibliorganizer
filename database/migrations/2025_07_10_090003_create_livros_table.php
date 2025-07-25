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
    Schema::create('livros', function (Blueprint $table) {
        $table->id();
        $table->string('isbn')->unique();
        $table->text('nome');
        $table->foreignId('editora_id')->constrained('editoras')->onDelete('cascade');
        
        // ALTERAÇÃO AQUI: de text() para longText()
        $table->longText('bibliografia')->nullable(); 
        
        $table->string('imagem_capa')->nullable();
        $table->decimal('preco', 8, 2);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livros');
    }
};
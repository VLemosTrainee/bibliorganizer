<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        // Adiciona colunas às tabelas 'users' e 'livros'
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('cidadao');
            $table->boolean('is_active')->default(true);
            $table->unsignedTinyInteger('pontuacao')->default(5);
        });
        Schema::table('livros', function (Blueprint $table) {
            $table->unsignedInteger('stock_total')->default(1);
            $table->unsignedInteger('stock_disponivel')->default(1);
            $table->unsignedTinyInteger('estado_conservacao')->default(10);
        });

        // Cria a tabela 'requisicoes' JÁ COM TODAS AS COLUNAS
        Schema::create('requisicoes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_requisicao')->unique(); // Coluna adicionada aqui
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('livro_id')->constrained('livros');
            $table->unsignedTinyInteger('estado_no_emprestimo');
            $table->date('data_requisicao');
            $table->date('data_prevista_devolucao');
            $table->date('data_devolucao_efetiva')->nullable();
            $table->unsignedTinyInteger('estado_na_devolucao')->nullable();
            $table->string('status')->default('pendente');
            $table->text('notas_admin')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('requisicoes');
        Schema::table('users', function (Blueprint $table) { $table->dropColumn(['role', 'is_active', 'pontuacao']); });
        Schema::table('livros', function (Blueprint $table) { $table->dropColumn(['stock_total', 'stock_disponivel', 'estado_conservacao']); });
    }
};
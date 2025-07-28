<?php

namespace App\Mail;

use App\Models\Requisicao; // Importar a Requisicao
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequisicaoAprovada extends Mailable
{
    use Queueable, SerializesModels;

    // Propriedade pública para guardar a requisição
    public Requisicao $requisicao;

    /**
     * Cria uma nova instância da mensagem.
     */
    public function __construct(Requisicao $requisicao)
    {
        // Recebe a requisição e guarda-a na propriedade pública
        $this->requisicao = $requisicao;
    }

    /**
     * Define o "envelope" do email (assunto, de, para).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'A sua requisição de livro foi aprovada!',
        );
    }

    /**
     * Define o conteúdo do email (qual a view a usar).
     */
    public function content(): Content
    {
        // Diz ao Laravel para usar a view 'emails.requisicao-aprovada'
        return new Content(
            view: 'emails.requisicao-aprovada',
        );
    }
}
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requisição Aprovada</title>
    <style>
        /* Estilos básicos para garantir a renderização */
        body { margin: 0; padding: 0; background-color: #f4f4f7; font-family: Inter, sans-serif; }
        .email-container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .header { background-color: #cececeff; /* Cor 'primary' do DaisyUI */ color: #ffffff; padding: 20px; text-align: center; }
        .header img { max-height: 100px; }
        .content { font-size: 24px;padding: 30px; }
        .book-details { font-size: 24px;margin-top: 20px; padding: 20px; background-color: #f9f9fb; border-radius: 8px; display: flex; gap: 20px; align-items: center; }
        .book-cover { width: 200px; height: auto; border-radius: 4px; flex-shrink: 0; }
        .footer { padding: 20px; text-align: center; font-size: 14px; color: #888; }
        h2 { font-size: 24px; margin: 8; }
        p { line-height: 1.6; }
        strong { color: #3d4451; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
        <img src="https://i.imgur.com/LBbsz9A.png" style="height: 190px;" alt="Logo">
        </div>
        <div class="content" style="color: #3d4451;">
            <h3 style="font-size: 28px; font-weight: bold; margin-bottom: 15px;">Boas Notícias, {{ $requisicao->user->name }}!</h3>
            <p> A sua requisição para o livro abaixo foi <strong style="color: #016930ff;">APROVADA</strong>.</p>
            <p> Pode agora dirigir-se à biblioteca para o levantar. Não se esqueça de o tratar com carinho!</p>
            
            <div class="book-details">
                @if($requisicao->livro->imagem_capa)
                    <img src="{{ $message->embed(storage_path('app/public/' . $requisicao->livro->imagem_capa)) }}" alt="Capa do Livro" class="book-cover">
                @endif
                <div>
                    <p style="margin: 0 0 5px 10px;"> <strong>Livro:</strong> {{ $requisicao->livro->nome }}</p>
                    <p style="margin: 0 0 5px 10px;"> <strong>Nº da Requisição:</strong> {{ $requisicao->numero_requisicao }}</p>
                    <p style="margin: 0 0 5px 10px;"> <strong>Data Prevista de Devolução:</strong> {{ $requisicao->data_prevista_devolucao->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
        <div class="footer">
            <p>Obrigado por usar o BookOrganizer.</p>
        </div>
    </div>
</body>
</html>
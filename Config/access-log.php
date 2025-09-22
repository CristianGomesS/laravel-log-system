<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Habilitar ou Desabilitar o Log de Acesso
    |--------------------------------------------------------------------------
    |
    | Use esta opção para ligar ou desligar rapidamente o registro de logs
    | de acesso em toda a aplicação. É recomendado usar uma variável
    | de ambiente (.env) para controlar isso em diferentes ambientes.
    |
    */
    'enabled' => env('ACCESS_LOG_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Canal de Log Padrão
    |--------------------------------------------------------------------------
    |
    | Define para qual canal de log (definido em config/logging.php) as
    | informações de acesso serão enviadas. Por padrão, usamos o canal
    | 'accesslog' que criamos, mas o usuário pode mudar para 'stack',
    | 'single', etc.
    |
    */
    'channel' => env('ACCESS_LOG_CHANNEL', 'accesslog'),

    /*
    |--------------------------------------------------------------------------
    | Campos a Serem Omitidos do Log (Blacklist)
    |--------------------------------------------------------------------------
    |
    | Adicione aqui as chaves de qualquer campo do corpo da requisição
    | (request body) que você não quer que seja salvo no log.
    | Isso é crucial para a segurança e para não registrar dados
    | sensíveis como senhas e tokens.
    |
    */
    'except' => [
        'password',
        'password_confirmation',
        'token',
        'access_token',
        'refresh_token',
    ],

];
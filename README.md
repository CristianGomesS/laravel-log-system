# Pacote de Log de Acesso para Laravel
Um pacote simples e configurável para registrar logs de acesso (requests) em aplicações Laravel. Ele é projetado para ser flexível, permitindo que você decida exatamente o que e como registrar.


## Instalação
Você pode instalar o pacote via Composer. Este é o comando para importar a biblioteca para o seu projeto:

```bash
composer require carcara/system-log
```

## Configuração
O pacote utiliza o recurso de auto-discovery do Laravel, então você não precisa registrar o Service Provider manualmente. No entanto, são necessários dois passos de configuração:

1. Execute o comando vendor:publish para copiar o arquivo de configuração do pacote (access-log.php) para a pasta de config da sua aplicação. Isso permitirá que você customize as configurações.

```bash
php artisan vendor:publish --provider="Carcara\SystemLog\Providers\LoggingServiceProvider"
```

Neste arquivo, você poderá habilitar/desabilitar o log e definir quais campos de requisição devem ser ignorados.

2. Configurar o Canal de Log
Para separar os logs de acesso dos logs gerais da sua aplicação, adicione um novo "canal" de log no seu arquivo config/logging.php:

```php
// Em config/logging.php

'channels' => [
    // ... outros canais existentes

    'accesslog' => [
       'driver' => 'daily', // Cria um novo arquivo de log a cada dia
        'path' => storage_path('logs/accesslog/access.log'), // Caminho do arquivo
        'level' => 'info', // Nível mínimo para registrar
        'days' => 90,
        'replace_placeholders' => true,
    ],
],
```

### Como Usar
Após a configuração, basta aplicar o middleware access.log às rotas ou grupos de rotas que você deseja monitorar. É recomendado aplicá-lo sempre após os middlewares de autenticação.

#### Exemplo em um Grupo de Rotas:
```php
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'access.log'])->group(function () {
    
    Route::get('/meu-endpoint-protegido', function () {
        return response()->json(['message' => 'Este acesso foi logado!']);
    });

    // ... adicione outras rotas que devem ser logadas aqui
});
```


#### Exemplo em uma Rota Individual:
```php
use App\Http\Controllers\MeuController;

Route::post('/produtos', [MeuController::class, 'store'])->middleware('access.log');
```

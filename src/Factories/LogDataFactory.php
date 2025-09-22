<?php

namespace Carcara\SystemLog\Factories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogDataFactory
{
    /**
     * Cria e retorna um array estruturado com os dados do log.
     */
    public static function create(Request $request, Response $response, int $httpStatus, ?array $infoTrait): array
    {
        return [
            'user_id'      => Auth::id(),
            'path'         => $request->path(),
            'method'       => $request->method(),
            'ip'           => $request->ip(),
            'status'       => $httpStatus,
            'request_log'  => $request->except(config('access-log.except')),
            'response_log' => self::formatResponseContent($response),
            'before_log'   => $infoTrait['before_log'] ?? null,
            'after_log'    => $infoTrait['after_log'] ?? null,
            'change_log'   => $infoTrait['change_log'] ?? null,
            'user_http'    => $request->header('user-agent'),
            'dateTime'     => now()->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Formata o conteúdo da resposta de forma segura para o log.
     * Se o conteúdo for muito grande, retorna uma mensagem padronizada.
     * Caso contrário, tenta decodificar como JSON para uma melhor estrutura no log.
     */
    private static function formatResponseContent(Response $response): mixed
    {
        $content = $response->getContent();

        if (mb_strlen($content) > 1000) { // Limite de 1000 caracteres
            return ['message' => 'Response body is too large to be logged.'];
        }

        $jsonDecoded = json_decode($content, true);

        return $jsonDecoded ?? $content;
    }
}
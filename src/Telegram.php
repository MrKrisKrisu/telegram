<?php
declare(strict_types=1);

namespace K118;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use K118\Exception\InvalidTokenException;
use JsonException;
use stdClass;

abstract class Telegram {

    protected static ?string $token;
    private static string    $api_url = 'https://api.telegram.org/bot';

    public static function setToken(string $token): void {
        self::$token = $token;
    }

    /**
     * @throws InvalidTokenException
     * @throws JsonException
     */
    public static function sendMessage(
        string|int $chatId,
        string     $text,
        string     $parseMode = 'HTML',
        bool       $disableWebPagePreview = false,
        bool       $disableNotification = false,
        int        $replyToMessageId = null,
        bool       $allowSendingWithoutReply = false,
        string     $replyMarkup = null,
        string     $token = null,
    ): stdClass|bool {

        if($token === null && self::$token === null) {
            throw new InvalidTokenException('Token not set');
        }

        $token = $token ?? self::$token;

        try {
            $client   = new Client();
            $response = $client->post(self::$api_url . $token . '/sendMessage', [
                'form_params' => [
                    'chat_id'                     => $chatId,
                    'text'                        => $text,
                    'parse_mode'                  => $parseMode,
                    'disable_web_page_preview'    => $disableWebPagePreview,
                    'disable_notification'        => $disableNotification,
                    'reply_to_message_id'         => $replyToMessageId,
                    'allow_sending_without_reply' => $allowSendingWithoutReply,
                    'reply_markup'                => $replyMarkup,
                ]
            ]);

            return json_decode($response->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);
        } catch(GuzzleException) {
            return false;
        }
    }
}
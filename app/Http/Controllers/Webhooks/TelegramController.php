<?php
/**
 * Created by PhpStorm.
 * User: viktor
 * Date: 17.11.2020
 * Time: 20:14
 */

namespace App\Http\Controllers\Webhooks;


use App\Http\Controllers\Controller;
use App\Models\TelegramUser;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function webhook(Request $request)
    {
        file_put_contents('log.txt', 1 . PHP_EOL, FILE_APPEND);
    }

    public function massAds(Request $request)
    {

        $telegramUsers = TelegramUser::all();

        /** @var TelegramUser $telegramUser */
        foreach ($telegramUsers as $telegramUser)
        {
            $this->sendMessage($telegramUser->telegram_id, $request->text);
        }
    }

    private function sendMessage(int $telegramId, string $text)
    {

        $url = sprintf(config('messanger.telegram.host'), 'sendMessage');

        $payload = json_encode([
            "chat_id"   => $telegramId,
            "text"      => $text,
        ]);

        $ch = curl_init($url);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);

        curl_exec($ch);
        curl_close($ch);
    }
}
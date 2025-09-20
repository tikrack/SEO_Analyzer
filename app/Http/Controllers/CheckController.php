<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate(['url' => 'required']);

        $content = $this->fetchWithGuzzle($validated['url']);

        $prompt = <<<PROMPT
سلام این محتوای کامل یک صفحه از سایت است انرا کامل بخوان و تمامی مشکلات سئوی انرا به من بگو و به صورت کامل و خیلی کامل هم بگو و همجنین این رو بهم بگو که چه کار هایی انجام بدیم بهتر هست تا بتونیم سئو این سایتو ببریم بالا
$content
PROMPT;

        $result = $this->callAiApi([
            [
                'role' => 'system',
                'content' => $prompt
            ]
        ]);

        return redirect()->route("home")->with("data", $result->json()['choices'][0]['message']['content']);

    }

    private function callAiApi(array $messages)
    {
        return Http::withHeaders([
            'Authorization' => 'apikey 8a2406c2-4d8e-57df-b390-61f895fcb12f',
        ])->post(
            'https://arvancloudai.ir/gateway/models/GPT-4.1-Mini/mCx5LzHVh2uptdJvX462CPRaKFd_E1As1stv9lNkVlSVj7BJ9HXdM6uaJxGnxBq_5MqOzeMEtLzBFg817lzZIQy8h-jHSPX1GFzwyGg0PF4gxXM5bBjYZTJl0dJN4XtvFZVQaVi3wiacHJR-Yt94JAxFvlvSgyTRLRrpv86zU5FojCew4RqXCZ42ozAdrirnpYUkpJWieHKKLiHHnTdh9vklTcEUbzwZxG50UB1XifHHdgzbMYVOWPlUWG6G3g/v1/chat/completions',
            [
                'model' => 'DeepSeek-R1-qwen-7b-awq',
                'messages' => $messages,
                'max_tokens' => 2000,
                'temperature' => 0.5,
            ]
        );
    }

    private function fetchWithGuzzle(string $url): ?string
    {
        try {
            $response = Http::withOptions(['verify' => false, 'timeout' => 30,])->get($url);

            if (!$response->successful()) {
                return null;
            }

            return $response->body();

        } catch (Exception $e) {
            return null;
        }
    }
}

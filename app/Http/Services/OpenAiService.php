<?php
namespace App\Http\Services;

use OpenAI\Laravel\Facades\OpenAI;

class OpenAiService
{
    public function chat($request, $prompt)
    {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Your Mission is to provide completions in a ToDo List App'],
                ['role' => 'user', 'content' => $prompt . ':'. $request],
            ],
        ]);

        return $response->choices[0]->message->content ?? '';
    }

}
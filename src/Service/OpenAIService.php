<?php

namespace App\Service;

use Orhanerday\OpenAi\OpenAi;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class OpenAIService
{
    public function __construct(
        private ParameterBagInterface $parameterBag,
    ) {

    }
    public function getInputArticle(string $article): string
    {
        $open_ai_key = $this->parameterBag->get('OPENAI_API_KEY');
        $open_ai = new OpenAi($open_ai_key);
        $complete = $open_ai->completion([
            'model' => 'text-davinci-003',
            'prompt' => 'Tu es un journaliste français et tu dois me donner une réponse comme si tu écrivais un article sur ce sujet : ' . $article,
            'temperature' => 0.9,
            'max_tokens' => 3000,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ]);

        $json = json_decode($complete, true);

        if (isset($json['choices'][0]['text'])) {
            $json = $json['choices'][0]['text'];
            return $json;
        }
        $json = 'Une erreur est survenue lors du chargement de votre demande sur {{ form.titre }}';
            return $json;
    }
}


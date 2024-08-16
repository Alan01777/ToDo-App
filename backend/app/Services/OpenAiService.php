<?php

namespace App\Services;

use InvalidArgumentException;
use OpenAI\Laravel\Facades\OpenAI;
use App\Repositories\TagRepository;
use App\Repositories\CategoryRepository;

class OpenAiService
{
    protected TagRepository $tagRepository;
    protected CategoryRepository $categoryRepository;

    /**
     * Create a new OpenAiService instance.
     *
     * @param  TagRepository  $tagRepository
     * @param  CategoryRepository  $categoryRepository
     * @return void
     */
    public function __construct(TagRepository $tagRepository, CategoryRepository $categoryRepository)
    {
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Find tags by their IDs.
     *
     * @param array $tagIds
     * @return array
     */
    private function findTags(array $tagIds): array
    {
        return $this->tagRepository->findTagTitles($tagIds);
    }

    /**
     * Find categories by their IDs.
     *
     * @param array $categoryIds
     * @return array
     */
    private function findCategories(array $categoryIds): array
    {
        return $this->categoryRepository->findCategoriesTitles($categoryIds);
    }

    /**
     * Validate chat parameters.
     *
     * @param  mixed  $chatParameters
     * @return void
     * @throws InvalidArgumentException
     */
    private function validateChatParameters(mixed $chatParameters): void
    {
        if (!is_array($chatParameters)) {
            throw new InvalidArgumentException('Chat parameters must be an array.');
        }
    }

    /**
     * Convert chat parameters to an array if necessary.
     *
     * @param  mixed  $chatParameters
     * @return array
     */
    private function convertChatParameters(mixed $chatParameters): array
    {
        if (is_string($chatParameters)) {
            return json_decode($chatParameters, true);
        }

        return $chatParameters;
    }

    /**
     * Perform a chat with the OpenAI model.
     *
     * @param  mixed  $chatParameters
     * @param string $prompt
     * @return string
     */
    public function chat(mixed $chatParameters, string $prompt): string
    {
        $chatParameters = $this->convertChatParameters($chatParameters);
        $this->validateChatParameters($chatParameters);

        if (isset($chatParameters['tag_id']) && isset($chatParameters['category_id'])) {
            $tagTitles = $this->findTags($chatParameters['tag_id']);
            $categoryTitles = $this->findCategories($chatParameters['category_id']);

            $tagTitlesStr = implode(', ', $tagTitles);
            $categoryTitlesStr = implode(', ', $categoryTitles);
        }

        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Your Mission is to provide completions in a ToDo List App'],
                ['role' => 'user', 'content' => $prompt . ":\nTitle: " . $chatParameters['title'] . (isset($tagTitles, $categoryTitles) ? "\nTags: " . $tagTitlesStr . "\nCategories: " . $categoryTitlesStr : null)],
            ],
        ]);
        return $response->choices[0]->message->content ?? '';
    }
}

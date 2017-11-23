<?php
declare(strict_types = 1);
/**
 * /src/Command/ApiKey/ApiKeyHelper.php
 *
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
namespace App\Command\ApiKey;

use App\Entity\ApiKey as ApiKeyEntity;
use App\Resource\ApiKeyResource;
use App\Security\RolesService;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ApiKeyHelper
 *
 * @package App\Command\ApiKey
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
class ApiKeyHelper
{
    /**
     * @var ApiKeyResource
     */
    private $apiKeyResource;

    /**
     * @var RolesService
     */
    private $rolesService;

    /**
     * ApiKeyHelper constructor.
     *
     * @param ApiKeyResource $apiKeyResource
     * @param RolesService   $rolesService
     */
    public function __construct(ApiKeyResource $apiKeyResource, RolesService $rolesService)
    {
        $this->apiKeyResource = $apiKeyResource;
        $this->rolesService = $rolesService;
    }

    /**
     * Method to get API key entity. Also note that this may return a null in cases that user do not want to make any
     * changes to API keys.
     *
     * @param SymfonyStyle $io
     * @param string       $question
     *
     * @return ApiKeyEntity|null
     */
    public function getApiKey(SymfonyStyle $io, string $question): ?ApiKeyEntity
    {
        $apiKeyFound = false;

        while ($apiKeyFound === false) {
            $apiKeyEntity = $this->getApiKeyEntity($io, $question);

            if ($apiKeyEntity === null) {
                break;
            }

            $message = \sprintf(
                'Is this the correct API key \'[%s] [%s] %s\'?',
                $apiKeyEntity->getId(),
                $apiKeyEntity->getToken(),
                $apiKeyEntity->getDescription()
            );

            $apiKeyFound = $io->confirm($message, false);
        }

        return $apiKeyEntity ?? null;
    }

    /**
     * Helper method to get "normalized" message for API key. This is used on following cases:
     *  - User changes API key token
     *  - User creates new API key
     *  - User modifies API key
     *  - User removes API key
     *
     * @param string       $message
     * @param ApiKeyEntity $apiKey
     *
     * @return array
     */
    public function getApiKeyMessage(string $message, ApiKeyEntity $apiKey): array
    {
        return [
            $message,
            sprintf(
                "GUID:  %s\nToken: %s",
                $apiKey->getId(),
                $apiKey->getToken()
            )
        ];
    }

    /**
     * Method to list ApiKeys where user can select desired one.
     *
     * @param SymfonyStyle $io
     * @param string       $question
     *
     * @return ApiKeyEntity|null
     */
    private function getApiKeyEntity(SymfonyStyle $io, string $question): ?ApiKeyEntity
    {
        $choices = [];
        $iterator = $this->getApiKeyIterator($choices);

        \array_map($iterator, $this->apiKeyResource->find([], ['token' => 'ASC']));

        $choices['Exit'] = 'Exit command';

        return $this->apiKeyResource->findOne($io->choice($question, $choices));
    }

    /**
     * Method to return ApiKeyIterator closure. This will format ApiKey entities for choice list.
     *
     * @param array $choices
     *
     * @return \Closure
     */
    private function getApiKeyIterator(&$choices): \Closure
    {
        /**
         * Lambda function create api key choices
         *
         * @param ApiKeyEntity $apiKey
         */
        $iterator = function (ApiKeyEntity $apiKey) use (&$choices): void {
            $value = \sprintf(
                '[%s] %s - Roles: %s',
                $apiKey->getToken(),
                $apiKey->getDescription(),
                \implode(', ', $this->rolesService->getInheritedRoles($apiKey->getRoles()))
            );

            $choices[$apiKey->getId()] = $value;
        };

        return $iterator;
    }
}

<?php
declare(strict_types=1);
/**
 * /src/Resource/RequestLogResource.php
 *
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
namespace App\Resource;

use App\Entity\EntityInterface;
use App\Entity\RequestLog as Entity;
use App\Repository\RequestLogRepository as Repository;
use App\Rest\DTO\RestDtoInterface;
use App\Rest\RestRestResource;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/** @noinspection PhpHierarchyChecksInspection */
/** @noinspection PhpMissingParentCallCommonInspection */
/**
 * Class RequestLogResource
 *
 * @package App\Resource
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 *
 * @method Repository  getRepository(): Repository
 * @method Entity[]    find(array $criteria = null, array $orderBy = null, int $limit = null, int $offset = null, array $search = null): array
 * @method Entity|null findOne(string $id, bool $throwExceptionIfNotFound = null): ?EntityInterface
 * @method Entity|null findOneBy(array $criteria, array $orderBy = null, bool $throwExceptionIfNotFound = null): ?EntityInterface
 * @method Entity      create(RestDtoInterface $dto, bool $skipValidation = null): EntityInterface
 * @method Entity      update(string $id, RestDtoInterface $dto, bool $skipValidation = null): EntityInterface
 * @method Entity      delete(string $id): EntityInterface
 * @method Entity      save(EntityInterface $entity, bool $skipValidation = null): EntityInterface
 */
class RequestLogResource extends RestRestResource
{
    /**
     * RequestLogResource constructor.
     *
     * @param Repository         $repository
     * @param ValidatorInterface $validator
     */
    public function __construct(Repository $repository, ValidatorInterface $validator)
    {
        $this->setRepository($repository);
        $this->setValidator($validator);
    }
}
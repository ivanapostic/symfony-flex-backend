<?php
declare(strict_types=1);
/**
 * /tests/Integration/Entity/LogLoginFailureTest.php
 *
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
namespace App\Tests\Integration\Entity;

use App\Entity\LogLoginFailure;

/**
 * Class LogLoginFailureTest
 *
 * @package App\Tests\Integration\Entity
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
class LogLoginFailureTest extends EntityTestCase
{
    /**
     * @var string
     */
    protected $entityName = LogLoginFailure::class;
}
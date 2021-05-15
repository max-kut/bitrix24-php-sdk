<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Deal\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Deal\Service\Deal;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

/**
 * Class DealsTest
 *
 * @package Bitrix24\SDK\Tests\Integration\Services\CRM\Deals\Service
 */
class DealTest extends TestCase
{
    protected Deal $dealService;

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers Deal::add
     */
    public function testAdd(): void
    {
        self::assertGreaterThan(1, $this->dealService->add(['TITLE' => 'test deal'])->getId());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers Deal::delete
     */
    public function testDelete(): void
    {
        self::assertTrue($this->dealService->delete($this->dealService->add(['TITLE' => 'test deal'])->getId())->isSuccess());
    }

    /**
     * @covers Deal::fields
     * @throws BaseException
     * @throws TransportException
     */
    public function testFields(): void
    {
        self::assertIsArray($this->dealService->fields()->getFieldsDescription());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers Deal::get
     */
    public function testGet(): void
    {
        self::assertGreaterThan(
            1,
            $this->dealService->get($this->dealService->add(['TITLE' => 'test deal'])->getId())->deal()->ID
        );
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers Deal::list
     */
    public function testList(): void
    {
        $this->dealService->add(['TITLE' => 'test']);
        self::assertGreaterThanOrEqual(1, $this->dealService->list([], [], ['ID', 'TITLE', 'TYPE_ID'])->getDeals());
    }

    public function testUpdate(): void
    {
        $deal = $this->dealService->add(['TITLE' => 'test']);
        $newTitle = 'test2';

        self::assertTrue($this->dealService->update($deal->getId(), ['TITLE' => $newTitle], [])->isSuccess());
        self::assertEquals($newTitle, $this->dealService->get($deal->getId())->deal()->TITLE);
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\Contact\Service\Batch::list()
     * @throws BaseException
     * @throws TransportException
     */
    public function testBatchList(): void
    {
        $this->dealService->add(['TITLE' => 'test deal']);
        $cnt = 0;

        foreach ($this->dealService->batch->list([], ['>ID' => '1'], ['ID', 'NAME'], 1) as $item) {
            $cnt++;
        }
        self::assertGreaterThanOrEqual(1, $cnt);
    }

    /**
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\Batch::add()
     */
    public function testBatchAdd(): void
    {
        $deals = [];
        for ($i = 1; $i < 60; $i++) {
            $deals[] = ['TITLE' => 'TITLE-' . $i];
        }
        $cnt = 0;
        foreach ($this->dealService->batch->add($deals) as $item) {
            $cnt++;
        }

        self::assertEquals(count($deals), $cnt);
    }

    public function setUp(): void
    {
        $this->dealService = Fabric::getServiceBuilder()->getCRMScope()->deal();
    }
}
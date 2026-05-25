<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/OrderService.php';

class OrderServiceTest extends TestCase
{
    private $inventoryMock;
    private $notificationMock;
    private OrderService $orderService;

    protected function setUp(): void
    {
        $this->inventoryMock = $this->createMock(IInventoryRepository::class);
        $this->notificationMock = $this->createMock(INotificationService::class);
        
        $this->orderService = new OrderService($this->inventoryMock, $this->notificationMock);
    }

    public function test_placeOrder_ValidOrder_DecreasesStockAndSendsNotification(): void
    {
        $this->inventoryMock->method('getStock')->willReturn(10);
        
        $this->inventoryMock->expects($this->once())
            ->method('decreaseStock')
            ->with('prod-A', 2);

        $this->notificationMock->expects($this->once())
            ->method('sendConfirmation');

        $result = $this->orderService->placeOrder('user-123', 'prod-A', 2);

        $this->assertEquals('confirmed', $result['status']);
        $this->assertEquals(2, $result['quantity']);
    }

    public function test_placeOrder_InsufficientStock_ThrowsException(): void
    {
        $this->inventoryMock->method('getStock')->willReturn(1);

        $this->inventoryMock->expects($this->never())->method('decreaseStock');
        
        $this->expectException(InsufficientStockError::class);

        $this->orderService->placeOrder('user-123', 'prod-A', 5);
    }

    public function test_placeOrder_InvalidQuantity_ThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->orderService->placeOrder('user-123', 'prod-A', 0);
    }

    public function test_placeOrder_OnSuccess_NotificationServiceCalledOnce(): void
    {
        $this->inventoryMock->method('getStock')->willReturn(20);

        $this->notificationMock->expects($this->once())
            ->method('sendConfirmation');

        $this->orderService->placeOrder('user-123', 'prod-A', 1);
    }
}
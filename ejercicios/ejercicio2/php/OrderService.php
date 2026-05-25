<?php

interface IInventoryRepository {
    public function getStock(string $productId): int;
    public function decreaseStock(string $productId, int $quantity): void;
}

interface INotificationService {
    public function sendConfirmation(string $userId, string $orderId): void;
}

class InsufficientStockError extends \Exception {}

class OrderService 
{
    private IInventoryRepository $inventoryRepo;
    private INotificationService $notificationService;

    public function __construct(IInventoryRepository $inventoryRepo, INotificationService $notificationService) 
    {
        $this->inventoryRepo = $inventoryRepo;
        $this->notificationService = $notificationService;
    }

    public function placeOrder(string $userId, string $productId, int $quantity): array 
    {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException("La cantidad debe ser mayor a cero.");
        }

        $stock = $this->inventoryRepo->getStock($productId);

        if ($stock < $quantity) {
            throw new InsufficientStockError("No hay suficiente stock para el producto.");
        }

        $this->inventoryRepo->decreaseStock($productId, $quantity);
        
        $orderId = uniqid('ORD_');
        $this->notificationService->sendConfirmation($userId, $orderId);

        return [
            'orderId' => $orderId,
            'userId' => $userId,
            'productId' => $productId,
            'quantity' => $quantity,
            'status' => 'confirmed'
        ];
    }
}
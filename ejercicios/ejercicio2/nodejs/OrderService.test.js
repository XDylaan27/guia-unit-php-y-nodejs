const { OrderService, InsufficientStockError } = require('./OrderService');

describe('Pruebas de OrderService con Mocks en Node.js', () => {
  let mockInventoryRepo;
  let mockNotificationService;
  let orderService;

  beforeEach(() => {
    mockInventoryRepo = {
      getStock: jest.fn(),
      decreaseStock: jest.fn()
    };

    mockNotificationService = {
      sendConfirmation: jest.fn()
    };

    orderService = new OrderService(mockInventoryRepo, mockNotificationService);
  });

  it('placeOrder_ValidOrder_DecreasesStockAndSendsNotification', () => {
    mockInventoryRepo.getStock.mockReturnValue(10);

    const result = orderService.placeOrder('user-123', 'prod-A', 2);

    expect(result.status).toBe('confirmed');
    expect(result.quantity).toBe(2);
    expect(mockInventoryRepo.decreaseStock).toHaveBeenCalledWith('prod-A', 2);
    expect(mockNotificationService.sendConfirmation).toHaveBeenCalledWith('user-123', result.orderId);
  });

  it('placeOrder_InsufficientStock_ThrowsException', () => {
    mockInventoryRepo.getStock.mockReturnValue(1);

    expect(() => orderService.placeOrder('user-123', 'prod-A', 5)).toThrow(InsufficientStockError);
    
    expect(mockInventoryRepo.decreaseStock).not.toHaveBeenCalled();
  });

  it('placeOrder_InvalidQuantity_ThrowsException', () => {
    expect(() => orderService.placeOrder('user-123', 'prod-A', 0)).toThrow('La cantidad debe ser mayor a cero.');
  });

  it('placeOrder_OnSuccess_NotificationServiceCalledOnce', () => {
    mockInventoryRepo.getStock.mockReturnValue(20);

    orderService.placeOrder('user-123', 'prod-A', 1);

    expect(mockNotificationService.sendConfirmation).toHaveBeenCalledTimes(1);
  });
});
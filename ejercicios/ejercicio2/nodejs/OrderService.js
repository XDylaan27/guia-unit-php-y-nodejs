// Creamos una excepción personalizada para el stock
class InsufficientStockError extends Error {
  constructor(message) {
    super(message);
    this.name = "InsufficientStockError";
  }
}

class OrderService {
  // Inyección de dependencias a través del constructor
  constructor(inventoryRepository, notificationService) {
    this.inventoryRepo = inventoryRepository;
    this.notificationService = notificationService;
  }

  placeOrder(userId, productId, quantity) {
    if (quantity <= 0) {
      throw new Error("La cantidad debe ser mayor a cero.");
    }

    // Consultamos el stock al repositorio
    const stockAvailable = this.inventoryRepo.getStock(productId);
    
    if (stockAvailable < quantity) {
      throw new InsufficientStockError("No hay suficiente stock para el producto.");
    }

    // Reducimos el stock
    this.inventoryRepo.decreaseStock(productId, quantity);

    // Generamos un ID de orden simulado y notificamos
    const orderId = `ORD-${Date.now()}`;
    this.notificationService.sendConfirmation(userId, orderId);

    // Retornamos el objeto de la orden
    return {
      orderId,
      userId,
      productId,
      quantity,
      status: 'confirmed'
    };
  }
}

module.exports = { OrderService, InsufficientStockError };
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\OrderService;
use App\Repositories\OrderRepository;
use App\Notifications\OrderConfirmation;
use Illuminate\Support\Facades\Notification;
use Mockery;

class OrderServiceTest extends TestCase
{
    public function test_place_order_sends_notification(): void
    {
        // Fake de notificaciones — intercepta sin enviar emails reales
        Notification::fake();

        // Mock del repositorio
        $repoMock = Mockery::mock(OrderRepository::class);
        $repoMock->shouldReceive('create')->once()->andReturn(['id' => 42]);

        // Inyectar el mock en el contenedor de Laravel
        $this->app->instance(OrderRepository::class, $repoMock);

        $service = $this->app->make(OrderService::class);
        $service->placeOrder(userId: 1, items: [['sku' => 'ABC', 'qty' => 2]]);

        // Verificar que se envió la notificación al usuario 1
        Notification::assertSentTo(
            \App\Models\User::find(1),
            OrderConfirmation::class
        );
    }
}
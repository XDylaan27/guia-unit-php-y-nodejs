<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/StringHelper.php';

class StringHelperTest extends TestCase
{
    public function test_truncate_corta_el_texto_con_sufijo(): void
    {
        $resultado = StringHelper::truncate('Contenedor Docker Arachiz', 10);
        $this->assertEquals('Contenedor...', $resultado);
    }

    public function test_truncate_lanza_excepcion_con_limite_negativo(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        StringHelper::truncate('Un texto cualquiera', -5);
    }

    public function test_toslug_limpia_caracteres_y_espacios(): void
    {
        $resultado = StringHelper::toSlug('¡Hola Mundo! 2026');
        $this->assertEquals('hola-mundo-2026', $resultado);
    }

    public function test_toslug_maneja_texto_vacio(): void
    {
        $resultado = StringHelper::toSlug('   ');
        $this->assertEquals('', $resultado);
    }

    public function test_countwords_ignora_espacios_multiples(): void
    {
        $resultado = StringHelper::countWords('  Fondo   azul  y   amarillo neon  ');
        $this->assertEquals(5, $resultado);
    }

    public function test_countwords_devuelve_cero_con_cadena_vacia(): void
    {
        $resultado = StringHelper::countWords('      ');
        $this->assertEquals(0, $resultado);
    }
}
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DocentesTest extends TestCase
{
    /**
     * A basic feature test example.
     */

     /** @test */
    public function test_crear_docentes(): void
    {
        $data = [
            'numdocumento' => '343421',
            'nomcompleto' => 'Jhon cordoba',
            'vinculcion' => true,
        ];
        // Enviar POST al endpoint de store
        $response = $this->post(route('docentes.store'), $data);
        
        $response->dump();
        $response->assertRedirect(route('docentes.index'));
        $this->assertDatabaseHas('docentes', $data);

    }
}

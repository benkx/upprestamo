<?php

namespace Tests\Feature;

use App\Models\Ubicacion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UbicacionTest extends TestCase
{
    #use RefreshDatabase; // Reinicia la base de datos después de cada prueba

    // /** @test */
    public function puede_crear_una_ubicacion()
    {
        // Datos de prueba
        $data = [
            'codsalon' => 'A101',
            'dotacion' => 'Tiene Televison de 50 pulgadas',
            'estado' => 'Disponible',
        ];

        // Enviar POST al endpoint de store
        $response = $this->post(route('ubicacion.store'), $data);

        // Verificar redirección y éxito
        $response->assertRedirect(route('ubicacion.index'));
        $this->assertDatabaseHas('ubicacion', $data);
    }

    // /** @test */
    public function validacion_de_campos_obligatorios_al_crear()
    {
        $response = $this->post(route('ubicacion.store'), []);
        
        $response->assertSessionHasErrors(['codsalon', 'dotacion']);
    }


    // /** @test */
    public function puede_actualizar_una_ubicacion()
    {
        // Crear ubicación de prueba
        $ubicacion = Ubicacion::factory()->create();

        // Nuevos datos
        $updatedData = [
            'codsalon' => 'B202',
            'dotacion' => 'Proyector y Pantalla',
            'estado' => 'No Disponible',
        ];

        // Enviar PUT/PATCH al endpoint de update
        $response = $this->put(route('ubicacion.update', $ubicacion), $updatedData);

        // Verificar cambios en la base de datos
        $response->assertRedirect(route('ubicacion.index'));
        $this->assertDatabaseHas('ubicacion', $updatedData);
    }

    // /** @test */
    public function puede_eliminar_una_ubicacion()
    {
        $ubicacion = Ubicacion::factory()->make();

        $response = $this->delete(route('ubicacion.destroy', $ubicacion));

        $response->assertRedirect(route('ubicacion.index'));
        $this->assertDatabaseMissing('ubicacion', ['id' => $ubicacion->id]);
    }

    // /** @test */
    public function puede_ver_listado_de_ubicaciones()
    {
        // Crear 3 ubicaciones de prueba
        $ubicacion = Ubicacion::factory()->count(3)->create();

        $response = $this->get(route('ubicacion.index'));

        $response->assertStatus(200);
        $response->assertViewHas('ubicacion'); // Asumiendo que pasas $ubicaciones a la vista
    }

        // /** @test */
    public function puede_ver_detalle_de_una_ubicacion()
        {
            $ubicacion = Ubicacion::factory()->create();

            $response = $this->get(route('ubicacion.show', $ubicacion));

            $response->assertStatus(200);
            $response->assertSee($ubicacion->codsalon);
        }


}

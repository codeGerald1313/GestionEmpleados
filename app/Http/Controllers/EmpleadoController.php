<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmpleadoRequest;
use App\Http\Resources\EmpleadoCollection;
use App\Http\Resources\EmpleadoResource;
use App\Models\Empleado;
use App\Models\DatosLaborales;
use App\Models\Contrato;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmpleadoController extends Controller
{
    // Listar empleados con datos laborales y contratos
    public function index()
    {
        // Obtener los empleados con sus relaciones
        $empleados = Empleado::with('datosLaborales', 'contratos')
            ->orderBy('created_at', 'desc')
            ->get();

        // Retornar la colección con un mensaje de éxito
        return response()->json([
            'message' => 'Empleados listados con éxito.',
            'data' => new EmpleadoCollection($empleados)
        ], Response::HTTP_OK);
    }

    // Mostrar un empleado específico
    public function show($id)
    {
        // Busco el empleado por ID, cargando también sus datos laborales y contratos
        $empleado = Empleado::with('datosLaborales', 'contratos')->findOrFail($id);

        // Retornar los detalles del empleado con un mensaje de éxito que incluye el nombre completo concatenado
        return response()->json([
            'message' => 'Detalles del empleado ' . $empleado->nombres . ' ' . $empleado->apellidos . ' obtenidos con éxito.',
            'data' => new EmpleadoResource($empleado)
        ], Response::HTTP_OK);
    }

    // Muestra el formulario de creación
    public function create()
    {
        return view('empleados.create'); // Vista de creación de empleados
    }

    // Muestra el formulario de edición
    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleados.edit', compact('empleado')); // Vista de edición del empleado
    }

    public function saveOrUpdate(StoreEmpleadoRequest $request, $id = null)
    {
        // Si hay un ID, busca el empleado; de lo contrario, crea uno nuevo
        $empleado = $id ? Empleado::findOrFail($id) : new Empleado;

        // Validar los datos de entrada con StoreEmpleadoRequest
        $validated = $request->validated();

        // Si es una actualización, no se sobrescribre el DNI (ya que el DNI siempre será único)
        if ($id) {
            $empleado->update([
                'nombres' => $validated['nombres'],
                'apellidos' => $validated['apellidos'],
                'email' => $validated['email'],
                'fecha_nacimiento' => $validated['fecha_nacimiento'],
            ]);
        } else {
            // Si es una creación, incluye el DNI
            $empleado->fill([
                'nombres' => $validated['nombres'],
                'apellidos' => $validated['apellidos'],
                'dni' => $validated['dni'],
                'email' => $validated['email'],
                'fecha_nacimiento' => $validated['fecha_nacimiento'],
            ])->save();
        }

        // Actualizar o crear los datos laborales relacionados
        $datosLaborales = $empleado->datosLaborales ?: new DatosLaborales;
        $datosLaborales->fill([
            'area' => $validated['area'],
            'cargo' => $validated['cargo'],
            'local' => $validated['local'],
        ]);
        $empleado->datosLaborales()->save($datosLaborales);

        // Actualizar o crear el contrato relacionado
        $contrato = $empleado->contratos->first() ?: new Contrato;
        $contrato->fill([
            'fecha_inicio' => $validated['fecha_inicio'],
            'fecha_fin' => $validated['fecha_fin'],
            'tipo_contrato' => $validated['tipo_contrato'],
        ]);
        $empleado->contratos()->save($contrato);

        // Definir el mensaje en función de la operación
        $message = $id ? 'Empleado actualizado con éxito.' : 'Empleado creado con éxito.';

        // Retornar la respuesta JSON con un mensaje de éxito y datos actualizados
        return response()->json([
            'message' => $message,
            'data' => $empleado->load('datosLaborales', 'contratos')
        ], Response::HTTP_CREATED); 
    }

    // Eliminar un empleado
    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();
        return response()->json(['message' => 'Empleado eliminado correctamente'], Response::HTTP_OK);
    }

    // Dar de Baja a un empleado (cambiar estado baja = true)
    public function darDeBaja($id)
    {
        $empleado = Empleado::findOrFail($id);

        // Marcar como baja
        $empleado->baja = true; // Cambiar a true el campo baja para indicar que el empleado está inactivo
        $empleado->save(); // Guardar los cambios en el empleado

        return response()->json(['message' => 'Empleado dado de baja correctamente.'], Response::HTTP_OK);
    }

    // Reactivar empleado (cambiar estado baja = false)
    public function activar($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->baja = false; // Cambiar a false para activar al empleado
        $empleado->save();

        return response()->json(['message' => 'Empleado activado correctamente.'], Response::HTTP_OK);
    }

    // Filtrar por rangos de contratación
    public function filtrar(Request $request)
    {
        // Validar las fechas de entrada
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date'
        ]);

        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $typeFilter = $request->input('type_filter');

        $empleados = Empleado::whereHas('contratos', function ($query) use ($fechaInicio, $fechaFin, $typeFilter) {
            // Si el tipo de filtro es 'date_end_unideend', solo buscar por fecha de inicio con fecha_fin nula.
            if ($typeFilter === 'date_end_unideend') {
                $query->where('fecha_inicio', '>=', $fechaInicio) // Fecha de inicio debe ser igual o después del inicio del rango
                    ->where('fecha_inicio', '<=', $fechaFin) // Fecha de inicio debe ser antes o igual al fin del rango
                    ->whereNull('fecha_fin'); // Solo contratos indefinidos
            }
            // Si el tipo de filtro es 'date_end_in', buscar solo contratos con fecha de inicio y fecha de fin definidos.
            else if ($typeFilter === 'date_end_in') {
                $query->where('fecha_inicio', '>=', $fechaInicio) // Fecha de inicio debe estar dentro del rango
                    ->where('fecha_inicio', '<=', $fechaFin) // Fecha de inicio debe estar dentro del rango
                    ->where('fecha_fin', '>=', $fechaInicio) // Fecha de fin debe estar dentro del rango
                    ->where('fecha_fin', '<=', $fechaFin) // Fecha de fin debe estar dentro del rango
                    ->whereNotNull('fecha_fin'); // Excluir contratos indefinidos (fecha_fin nula)
            }
        })->with(['contratos', 'datosLaborales'])->get();

        // Retornar los empleados utilizando la colección EmpleadoCollection
        return new EmpleadoCollection($empleados);
    }
}

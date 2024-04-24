<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return 'Hello World';
// });

Route::resource('/', 'IndexController')->middleware('auth');
Route::resource('/empresas', 'EmpresaController')->middleware('auth');
Route::get('/landing', 'IndexController@landing')->middleware('auth');

//Rutas de administración
//Index
Route::get('/admin', 'AdminController@index')->name('admin.index')->middleware('auth', 'admin');
//Estadísticas de pasantías (TODO)
Route::resource('/admin/estadisticas', 'GraficasController')->middleware('auth', 'admin');
//Importar listado de alumnos autorizados para usar la plataforma
Route::resource('/admin/importarlista', 'ListadoController')->middleware('auth', 'admin');
//Asignar alumnos a los profesores correspondientes
//Tabla admin proyectos
Route::get('/admin/asignarProyectos', 'AdminController@asignarProyectosView')->name('admin.asignarProyectos')->middleware('auth', 'admin');
Route::get('/admin/asignarProyectos/{id}', 'AdminController@asignarProyectosManual')->middleware('auth', 'admin');
Route::get('/admin/asignarProyectos/{idProf}/{idProy}/{action}', 'AdminController@asignarProyectoQuick')->middleware('auth', 'admin');
// Ruta para inscribir nuevo proyecto
Route::post('/admin/listadoProyectos/inscribir', 'AdminController@inscribirProyecto')->name('admin.inscribirProyecto.post')->middleware('auth', 'admin');
// Ruta para adjuntar informe
Route::post('/admin/listadoProyectos/adjuntarInforme', 'AdminController@subirInforme')->name('admin.adjuntorInforme.post')->middleware('auth', 'admin');
// Ruta de exportacion de excel - tabla admin proyectos
Route::get('/admin/listadoProyectos/export', 'ProyectoController@asignarProyectosExcel')->name( 'tablaProyectos.export')->middleware('auth', 'admin');

// Rutas de Listado Inscripcion
// Ruta de Destroy Paso 2
Route::post('/admin/listadoInscripcion/{id}/edit/paso2D/', 'ListadoInscripcionController@destroyPaso2')->name('listadoInscripcion.destroyPaso2')->middleware('auth', 'admin');
// Ruta de Destroy Paso 3
Route::post('/admin/listadoInscripcion/{id}/edit/paso3D/', 'ListadoInscripcionController@destroyPaso3')->name('listadoInscripcion.destroyPaso3')->middleware('auth', 'admin');
// Ruta de Update Paso 2
Route::post('/admin/listadoInscripcion/{id}/edit/paso2E/', 'ListadoInscripcionController@updatePaso2')->name('listadoInscripcion.updatePaso2')->middleware('auth', 'admin');
//Ruta de Update Paso 3
Route::post('/admin/listadoInscripcion/{id}/edit/paso3E/', 'ListadoInscripcionController@updatePaso3')->name('listadoInscripcion.updatePaso3')->middleware('auth', 'admin');
// Ruta de editado de empresa unicamente
Route::get('/admin/listadoInscripcion/{id}', 'EmpresaController@edit')->middleware('auth', 'admin');
// Ruta de CRUD Listado Inscripcion
Route::resource('/admin/listadoInscripcion', 'ListadoInscripcionController')->middleware('auth', 'admin');
// Ruta de exportacion de excel
Route::get('/admin/tablaInscripciones', 'ListadoInscripcionController@export')->name( 'tablaInscripciones.export')->middleware('auth', 'admin');
// Ruta de validar al pariente
Route::get('/admin/listadoInscripcion/{id}/statusPaso2/{statusPaso2}', 'ListadoInscripcionController@validarPariente')->name('listadoInscripcion.validarPariente')->middleware('auth', 'admin');
// Ruta de validar proyecto
Route::get('/admin/listadoInscripcion/{id}/accion/{accion}', 'ListadoInscripcionController@validarProyecto')->name('listadoInscripcion.validarProyecto')->middleware('auth', 'admin');
// Ruta de validar todo
Route::get('/admin/listadoInscripcion/{nombresUsuario}/idPasantia/{idPasantia}', 'ListadoInscripcionController@validarTodo')->name('listadoInscripcion.validarTodo')->middleware('auth', 'admin');

// // Rutas Listado de Pasantias
// Route::get('/admin/listadoPasantia', 'ListadoPasantiaController@index')->middleware('auth', 'admin');
// // Ruta de exportacion de excel
// Route::get('/admin/tablaPasantias', 'ListadoPasantiaController@export')->name( 'tablaPasantias.export')->middleware('auth', 'admin');

Route::resource('/admin/listadoProyectos', 'ProyectoController')->middleware('auth', 'administrador');


// Ruta de Listado Defensas
Route::get('/admin/listadoDefensas/export', 'ListadoDefensasController@exportDefensas')->middleware('auth', 'admin');
Route::resource('/admin/listadoDefensas', 'ListadoDefensasController')->middleware('auth', 'admin');
Route::post('/admin/listadoDefensas/inscribir', 'ListadoDefensasController@inscribirDefensa')->name('listadoDefensas.crearDefensa')->middleware('auth', 'admin');
Route::post('/admin/listadoDefensas/editar', 'ListadoDefensasController@editarDefensa')->name('listadoDefensas.edit')->middleware('auth', 'admin');
Route::delete('/admin/listadoDefensas/eliminar/{id}', 'ListadoDefensasController@eliminarDefensa')->name('listadoDefensas.destroy')->middleware('auth', 'admin');
Route::get('/admin/comision', 'PortalDefensasController@comision')->middleware('auth');
Route::post('/admin/addComision', 'PortalDefensasController@addComision')->middleware('auth');
Route::post('/admin/defensas', 'PortalDefensasController@store')->name('defensas.store')->middleware('auth');
Route::delete('/admin/defensas','PortalDefensasController@adminDefensasDestroy')->name('adminDefensas.destroy')->middleware('auth');
Route::delete('/admin/defensas/{id}','PortalDefensasController@destroy')->name('defensas.destroy')->middleware('auth');
Route::get('/admin/defensas', 'PortalDefensasController@defensas')->name('defensas.index')->middleware('auth');
// 'esprofesor')
Route::post('/admin/rubrica', 'PortalDefensasController@rubrica')->name('admin.defensa.rubrica')->middleware('auth');


Route::resource('/perfil', 'PerfilController')->middleware('auth');

Route::get('/profesor', 'ProfesorController@index')->name('profesor.index')->middleware('auth', 'noAlumno');
Route::get('/profesor/proyecto/{id}', 'ProfesorController@verProyecto')->name('profesor.verProyecto')->middleware('auth', 'noAlumno');
Route::post('/profesor/proyecto/{id}/feedback', 'ProfesorController@feedbackProyecto')->middleware('auth', 'noAlumno');

//Rutas Admin Profesores
Route::get('/admin/listadoProfesores', 'ProfesorController@vistaAdminProfesores')->name('profesor.tablaProfesores')->middleware('auth', 'admin');
// Admin Profesor Añadir
Route::post('/admin/listadoProfesores/añadir', 'ProfesorController@addProfesores')->name('profesor.add')->middleware('auth', 'admin');
// Admin Profesor Editar
Route::post('/admin/listadoProfesores/editar', 'ProfesorController@editProfesores')->name('profesor.edit')->middleware('auth', 'admin');
// Admin Profesor Elmininar
Route::delete('/admin/listadoProfesores/eliminar/{id}', 'ProfesorController@deleteProfesor')->name('profesor.destroy')->middleware('auth', 'admin');
// Ruta de exportacion de excel
Route::get('/admin/listadoProfesores/export', 'ProfesorController@exportProfesores')->name('profesor.export')->middleware('auth', 'admin');

Route::get('/admin/loginAs', 'AdminController@loginAs')->middleware('auth', 'admin');
Route::post('/admin/doLoginAs', 'LoginController@doLoginAs')->name('admin.doLoginAs')->middleware('auth', 'admin');


Route::get('/download-ics/{id}', 'CalendarController@downloadICS');

Route::get('/login', function(){
	return view('login');
});

Route::post('/login', 'LoginController@authenticate')->name('login');
Route::get('logout', 'LoginController@logout')->name('logout');

Route::get('/inscripcion/0', 'PasantiaController@paso0View')->name('inscripcion.0.view')->middleware('auth');
Route::post('/inscripcion/0/post','PasantiaController@paso0Control')->name('inscripcion.0.post')->middleware('auth');
Route::get('/inscripcion/1', 'PasantiaController@paso1View')->name('inscripcion.1.view')->middleware('auth');
Route::post('/inscripcion/1/post','PasantiaController@paso1Control')->name('inscripcion.1.post')->middleware('auth');
Route::get('/inscripcion/2', 'PasantiaController@paso2View')->name('inscripcion.2.view')->middleware('auth');
Route::post('/inscripcion/2/post','PasantiaController@paso2Control')->name('inscripcion.2.post')->middleware('auth');
Route::get('/inscripcion/3', 'PasantiaController@paso3View')->name('inscripcion.3.view')->middleware('auth');
Route::post('/inscripcion/3/post','PasantiaController@paso3Control')->name('inscripcion.3.post')->middleware('auth');
Route::get('/inscripcion/4', 'PasantiaController@paso4View')->name('inscripcion.4.view')->middleware('auth');
Route::post('/inscripcion/4/post','PasantiaController@paso4Control')->name('inscripcion.4.post')->middleware('auth');
Route::get('/inscripcion/resumen', 'PasantiaController@resumenView')->name('inscripcion.resumen')->middleware('auth');
Route::get('/inscripcion/cambiarSupervisor', 'PasantiaController@cambiarSupervisor')->name('inscripcion.cambiarSupervisor')->middleware('auth');
Route::get('/inscripcion/certificado', 'PasantiaController@descargarCert')->name('inscripcion.certificado')->middleware('auth');
Route::get('/inscripcion/5', 'PasantiaController@paso5View')->name('inscripcion.5.view')->middleware('auth');
Route::post('/inscripcion/5/post','PasantiaController@paso5Control')->name('inscripcion.5.post')->middleware('auth');


Route::get('/confirmarTutor/{id}', 'PasantiaController@confirmarTutor')->name('confTutor');

Route::delete('/inscripcion/destroy/{id}','PasantiaController@destroy')->name('inscripcion.destroy')->middleware('auth', 'admin');

Route::post('evaluacion/{id}','EvalTutorController@save')->name('evalTutor.save');
Route::get('evaluacion/{id}', 'EvalTutorController@show')->name('evalTutor.show');
Route::get('evaluacion/enviar/{idAlumno}', 'EvalTutorController@enviar');
Route::post('evaluacion/enviar/enviarSeleccionados', 'EvalTutorController@enviarSeleccionados');
Route::get('evaluacion/listado/{idProyecto}', 'EvalTutorController@listado')->name('EvalTutor.listado')->middleware('auth', 'noAlumno');
Route::get('evaluacion/ver/{idEvaluacion}', 'EvalTutorController@ver')->middleware('auth', 'noAlumno');

@extends('layout')

@section('title', 'Graficos')

@section('contenido')

	@if(session()->get('success'))
		<div class="alert alert-success">
			{{ session()->get('success') }}
		</div><br />
		@endif
		<div class="row">
			<div class="col-md-12">
				<h1 id="estadisticas" class="text-center">Estadísticas administrativas actualizadas a la fecha: </h1>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div id="pasos"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div id="proyectosValidados"></div>
			</div>
			<div class="col-md-6">
				<div id="empresasEnConvenio"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div id="inscripcionesTerminadas"></div>
			</div>
			<div class="col-md-6">
				<div id="validacionSupervisor"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div id="proyectosInscritos"></div>
			</div>
			<div class="col-md-6">
				<div id=""></div>
			</div>
		</div>


<script>
//Fecha en forma SIF (self invoking function)
(function() {
	const hoy = new Date().getFullYear() + '-' + (new Date().getMonth()+1) + '-' + new Date().getDate();
	document.getElementById('estadisticas').innerHTML += hoy;
})();

//Funcion para obtener todo el html dinamico a mostrar cuando se clickea una barra de empresas
const detalleDatosEmpresas = (JSONdatosEmpresas) => {
	//Tabla HTML a desplegar
	let tablaHTMLEmpresas =
		'<table class="table table-striped">' +
		'<thead>' +
		'<tr>' +
		'<th scope="col">#</th>' +
		'<th scope="col">Nombre</th>' +
		'<th scope="col">URL</th>' +
		'</tr>' +
		'</thead>';
	const datosEmpresas = JSONdatosEmpresas;
	for (let i = 0; i < datosEmpresas.length; i++){
		let datosEmpresa = datosEmpresas[i];
		tablaHTMLEmpresas += '<tr>' +
			'<th scope="row">'+ (i + 1) +'</th>' +
			'<td>'+ datosEmpresa['nombre'] +'</td>' +
			'<td>'+ datosEmpresa['urlWeb'] +'</td>' +
			'</tr>';
	}
	tablaHTMLEmpresas += '<tbody>' +
		'</tbody>' +
		'</table>';
	return tablaHTMLEmpresas;
}

//Funcion para obtener todo el html dinamico a mostrar cuando se clickea una barra de alumnos
const detalleDatosAlumnos = (JSONdatosAlumnos) => {
	//Tabla HTML a desplegar
	let tablaHTMLAlumnos =
		'<table class="table table-striped">' +
		'<thead>' +
		'<tr>' +
		'<th scope="col">#</th>' +
		'<th scope="col">Nombre</th>' +
		'<th scope="col">Apellido</th>' +
		'<th scope="col">Email</th>' +
		'</tr>' +
		'</thead>';
	const datosAlumnos = JSONdatosAlumnos;
	for (let i = 0; i < datosAlumnos.length; i++){
		let datosAlumno = datosAlumnos[i];
		tablaHTMLAlumnos += '<tr>' +
			'<th scope="row">'+ (i + 1) +'</th>' +
			'<td>'+ datosAlumno['nombres'] +'</td>' +
			'<td>'+ datosAlumno['apellidoPaterno'] +'</td>' +
			'<td>'+ datosAlumno['email'] +'</td>' +
			'</tr>';
	}
	tablaHTMLAlumnos += '<tbody>' +
		'</tbody>' +
		'</table>';
	return tablaHTMLAlumnos;
}


//Grafico pasos de cada alumno
window.chart = new Highcharts.chart({
	chart: {
		//forma
		type: 'bar',
		//ubicacion
		renderTo: 'pasos',
		//tamaño
		height: (9 / 16 * 75) + '%'
	},
	title: {
		//texto titulo
		text: 'Porcentaje de postulantes en cada paso ',
		//estilos del titulo
		style: {
			fontSize: '22px'
		}
	},
	//Habilitar botones de descarga
	exporting: {
		enabled: true,
		csv: {
			dateFormat:'%A, %b %e, %Y'
		}
	},
	//Eliminar creditos del grafico
	credits: {
		enabled: false
	},
	//Todo sobre el eje X
	xAxis: {
		type: 'category',
		labels: {
			style: {
				fontSize: '1.25em',
				fontWeight: 'bold'
			}
		}
	},
	//Todo sobre el eje Y
	yAxis: {
		title: {
      text: 'Porcentaje de postulantes',
			style: {
				fontSize: '1.25em',
				fontWeight: 'bold'
			}
		},
		labels: {
			style: {
				fontSize: '1em'
			}
		}
	},
	//Columnas del grafico
	plotOptions: {
		series: {
			colorByPoint: true,
			cursor: 'pointer',
			dataLabels: {
				enabled: true,
				inside: true,
			},
			point: {
				events: {
					//Que hacer al clickear una barra
					click: function (e) {
						hs.htmlExpand(null, {
							pageOrigin: {
								x: e.pageX || e.clientX,
								y: e.pageY || e.clientY
							},
							//Mostrar contenido
							headingText: this.series.data[this.x].name,
							maincontentText: this.detalleDatos
						});
					}
				}
			}
		}
	},
	//Datos del grafico
	series: [{
		name: 'Postulantes',
		dataLabels: [{
			//Lo que se debe ver en el grafico
			align: 'right',
			format: '{y} '
		},{
			align: 'center',
			format: '{point.porcentajePostulantes:.2f} %'
		}],
		//Datos
		data: [{
			y: @json($estadisticasPasantias['pasantiasPaso1Count']),
			porcentajePostulantes: @json($estadisticasPasantias['pasantiasPaso1Count']) / @json($estadisticasPasantias['pasantiasTotal']) * 100,
			name: 'Requisitos académicos',
			detalleDatos: detalleDatosAlumnos(@json($estadisticasPasantias['alumnosPasantiaPaso1']))
		}, {
			y: @json($estadisticasPasantias['pasantiasPaso2Count']),
			porcentajePostulantes: @json($estadisticasPasantias['pasantiasPaso2Count']) / @json($estadisticasPasantias['pasantiasTotal']) * 100,
			name: 'Inscripción pasantía',
			detalleDatos: detalleDatosAlumnos(@json($estadisticasPasantias['alumnosPasantiaPaso2']))
		}, {
			y: @json($estadisticasPasantias['pasantiasPaso3Count']),
			porcentajePostulantes: @json($estadisticasPasantias['pasantiasPaso3Count']) / @json($estadisticasPasantias['pasantiasTotal']) * 100,
			name: 'Inscripción supervisor',
			detalleDatos: detalleDatosAlumnos(@json($estadisticasPasantias['alumnosPasantiaPaso3']))
		}, {
			y: @json($estadisticasPasantias['pasantiasPaso4Count']),
			porcentajePostulantes: @json($estadisticasPasantias['pasantiasPaso4Count']) / @json($estadisticasPasantias['pasantiasTotal']) * 100,
			name: 'Inscripción proyecto',
			detalleDatos: detalleDatosAlumnos(@json($estadisticasPasantias['alumnosPasantiaPaso4']))
		}],
		showInLegend: false
	}]
});

/*
chart_RenderTo -> id del elemento en donde se mostrara este grafico STRING
title_Text -> titulo del grafico STRING
series_Name -> nombre general de los datos STRING
data_Attributes1 -> [nombre, valorNumerico, valorPorcentaje, detalleDatos] STRING, INT, FLOAT, OBJECT
data_Attributes2 -> [nombre, valorNumerico, valorPorcentaje, detalleDatos] STRING, INT, FLOAT, OBJECT
	*****detalleDatos -> funcion que da HTML a mostrar cuando se clickea un elemento del grafico
*/
const pieChartConstructor = (chart_RenderTo, title_Text, series_Name, data_Attributes1, data_Attributes2) => {
	//Grafico de torta genérico
	window.chart = new Highcharts.chart({
		chart: {
			//tipo
			type: 'pie',
			//donde ubicar
			renderTo: chart_RenderTo,
			//tamaño
			height: (9 / 16 * 100) + '%',
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false
		},
		title: {
			//titulo
			text: title_Text,
			//estilos
			style: {
				fontSize: '22px'
			}
		},
		//lo que muestra al hover
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		//descarga habilitada
		exporting: {
			enabled: true,
			csv: {
				//fecha
				dateFormat:'%A, %b %e, %Y'
			}
		},
		//no usar creditos en el grafico
		credits: {
			enabled: false
		},
		//opciones del grafico
		plotOptions: {
			pie: {
				allowPointSelect: true,
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b>: {point.y} ({point.percentage:.1f}%)',
					style: {
						color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
						fontSize: '1em'
					}
				}
			},
			series: {
				cursor: 'pointer',
				point: {
					events: {
						click: function (e) {
							hs.htmlExpand(null, {
								pageOrigin: {
									x: e.pageX || e.clientX,
									y: e.pageY || e.clientY
								},
								//lo que se mostrara al clickear
								headingText: this.series.data[this.x].name,
								maincontentText:this.detalleDatos
							});
						}
					}
				}
			}
		},
		//todos los datos del grafico
		series: [{
			name: series_Name,
			colorByPoint: true,
			data: [{
				name: data_Attributes1[0],
				y: data_Attributes1[1],
				value: data_Attributes1[2],
				detalleDatos: data_Attributes1[3],
				sliced: true,
				selected: true
			}, {
				name: data_Attributes2[0],
				y: data_Attributes2[1],
				value: data_Attributes2[2],
				detalleDatos: data_Attributes2[3],
			}]
		}]
	});
}

//Pie chart de empresas
pieChartConstructor('empresasEnConvenio', 'Convenios de empresas', 'Empresas',
	//data_Attributes1
	['Empresas con convenio',
	@json($estadisticasEmpresas['empresasValidadasCount']),
	@json($estadisticasEmpresas['empresasPorcentajeValidadas']),
	detalleDatosEmpresas(@json($estadisticasEmpresas['empresasValidadas']))],
	//data_Attributes2
	['Empresas sin convenio',
	@json($estadisticasEmpresas['empresasNoValidadasCount']),
	@json($estadisticasEmpresas['empresasPorcentajeNoValidadas']),
	detalleDatosEmpresas(@json($estadisticasEmpresas['empresasNoValidadas']))]);

//Pie chart de proyectos validados vs no validados
pieChartConstructor('proyectosValidados', 'Estado de los proyectos', 'Proyectos',
	//data_Attributes1
	['Proyectos validados',
	@json($estadisticasProyectos['proyectosAprobadosCount']),
	@json($estadisticasProyectos['proyectosAprobadosPorcentaje']),
	detalleDatosAlumnos(@json($estadisticasProyectos['alumnosProyectosAprobados']))],
	//data_Attributes2
	['Proyectos no validados',
	@json($estadisticasProyectos['proyectosNoAprobadosCount']),
	@json($estadisticasProyectos['proyectosNoAprobadosPorcentaje']),
	detalleDatosAlumnos(@json($estadisticasProyectos['alumnosProyectosNoAprobados']))]);

//Pie chart de proyectos inscritos vs no inscritos
pieChartConstructor('proyectosInscritos', 'Inscripciones de proyectos', 'Inscripciones',
	//data_Attributes1
	['Proyectos inscritos',
	@json($estadisticasProyectos['proyectosInscritosCount']),
	@json($estadisticasProyectos['proyectosInscritosPorcentaje']),
	detalleDatosAlumnos(@json($estadisticasProyectos['alumnosProyectosInscritos']))],
	//data_Attributes2
	['Proyectos no inscritos',
	@json($estadisticasProyectos['proyectosNOInscritosCount']),
	@json($estadisticasProyectos['proyectosNoInscritosPorcentaje']),
	detalleDatosAlumnos(@json($estadisticasProyectos['alumnosProyectosNOInscritos']))]);

//Pie chart de inscripciones terminadas
pieChartConstructor('inscripcionesTerminadas', 'Estado de las pasantías', 'Pasantías',
	//data_Attributes1
	['Pasantías terminadas',
	@json($estadisticasInscripciones['inscripcionesTerminadasCount']),
	@json($estadisticasInscripciones['inscripcionesTerminadasPorcentaje']),
	detalleDatosAlumnos(@json($estadisticasInscripciones['alumnosInscripcionesTerminadas']))],
	//data_Attributes2
	['Pasantías no terminadas',
	@json($estadisticasInscripciones['inscripcionesNoTerminadasCount']),
	@json($estadisticasInscripciones['inscripcionesNoTerminadasPorcentaje']),
	detalleDatosAlumnos(@json($estadisticasInscripciones['alumnosInscripcionesNoTerminadas']))]);

//Pie chart de validaciones de supervisor
pieChartConstructor('validacionSupervisor', 'Pasantías validadas por supervisor', 'Pasantía',
	//data_Attributes1
	['Pasantías no validadas por supervisor',
	@json($estadisticasSupervisores['pasantiasNoValidadasSupervisorCount']),
	@json($estadisticasSupervisores['pasantiasNoValidadasSupervisorPorcentaje']),
	detalleDatosAlumnos(@json($estadisticasSupervisores['alumnosNoPasantiasValidadasSupervisor']))],
	//data_Attributes2
	['Pasantías validadas por supervisor',
	@json($estadisticasSupervisores['pasantiasValidadasSupervisorCount']),
	@json($estadisticasSupervisores['pasantiasValidadasSupervisorPorcentaje']),
	detalleDatosAlumnos(@json($estadisticasSupervisores['alumnosPasantiasValidadasSupervisor']))]);
	</script>
@endsection

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<style>
	h1{
		font-size: 20px;
		text-align: center;
		padding-top: 100px;
		padding-bottom: 10px;
	}
	body {
		width: 700px;
		margin-left: auto;
		margin-right: auto;
		font-family: Calibri, sans-serif;
		font-size: 14px;
	}
	.logo {
		float:right;
	}

	.firma {
		margin-left: auto;
		margin-right: auto;
		display: block;
	}
	</style>
 <title>Certificado de pasantía</title>
</head>
<body>
	<p>
		<img src="{{ asset('img/logouai.png') }}" class="logo">
	</p>
	<p>
		<h1>CERTIFICADO DE PASANTÍA</h1>
	</p>
	<p>
		<div style="text-align: right;">Santiago, {{$fecha}}</div>
	</p>
	<p>
		Certifico que:<br/><br/>
		Nombre: {{$nombre}}<br/>
		R.U.N: {{$rut}}<br/>
		Carrera: {{$carrera}}<br/>
	</p>
	<p style="text-align: justify;">
		Es alumno regular de la Facultad de Ingeniería de la Universidad Adolfo Ibáñez, y que ha cumplido los requisitos académicos para iniciar el proyecto Capstone o Cúlmine de su plan de estudios.<br/><br/>

		El proyecto Capstone es parte integral del currículum académico de la carrera, y tiene por objetivo que el alumno aplique e integre los conocimientos adquiridos durante sus estudios, identificando y enfrentando problemas reales, proponiendo y diseñando soluciones ingenieriles a éstos, para finalmente generar valor.<br/><br/>

		El proyecto Capstone puede desarrollarse en la Universidad o en alguna empresa bajo el formato de Pasantía, en este último caso deberá tener una duración mínima de 810 horas, las que deberán ser cumplidas el segundo semestre del año 2020.<br/><br/>

		Mientras el alumno se encuentre desarrollando su proyecto Capstone, será alumno regular de la Universidad Adolfo Ibáñez.<br/><br/>

		Asimismo, siendo la pasantía una actividad académica y teniendo el alumno la asignatura correspondiente a la pasantía debidamente inscrita, este se encontrará asegurado según el Artículo Nº3 de la Ley 16744 que Establece Normas Sobre Accidentes del Trabajo y Enfermedades Profesionales.<br/><br/>

		Se extiende el presente certificado a petición del interesado para ser presentado en la empresa {{$nombreEmpresa}}.<br/><br/>

	</p>
	<p style ="text-align: center; display: block; margin-top:-50px; height:100px;">
		<img src="{{ asset('img/firmajm.png') }}">
	</p>
	<p style="text-align: center;">
		<b>José Maldifassi Pohlhammer</b><br/>
		Secretario Académico<br/>
		Facultad de Ingeniería y Ciencias<br/>
		Universidad Adolfo Ibáñez<br/>
	</p>

	<p style="text-align: right; margin-top:45px;">
		SANTIAGO: Diagonal Las Torres 2700, Peñalolén. Teléfono: (56 2) 2331 1000<br/>
		Av. Presidente Errázuriz 3485 Las Condes. Teléfono: (56 2) 2331 1000<br/>
		VIÑA DEL MAR: Av. Padre Hurtado 750. Teléfono: (56 32) 250 3500<br/>
		MIAMI : 1200 Brickell Ave. Teléfono: (1 305) 416 6015<br/>
		<a href="http://uai.cl">WWW.UAI.CL</a>
</p>


</body>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Sistema de pasantías UAI</title>
	<!-- Styles -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
  <!-- Scripts -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<style>body,html {
  height: 100%;
}</style>

</head>
<body>
<nav class="navbar navbar-expand navbar-dark bg-dark">
		<!-- Logo SVG UAI -->
		<a class="navbar-brand mr-1" href="https://www.uai.cl">
			<img src="{{asset('media/images/').'/'.'logouai.svg'}}" alt="Universidad Adolfo Ibáñez">
		</a>
		<!-- Boton Collapse Sidebar -->
		<button class="btn btn-link text-white" type="button" data-toggle="collapse" data-target="#MenuSidebar" aria-expanded="true" aria-controls="MenuSidebar" href="#">
      <i class="fas fa-bars"></i>
		</button>
	</nav>
    <div class="container p-5">
        <div class="row justify-content-center">
            <h1>Evaluación enviada exitosamente.</h1>
            <h1>Muchas gracias por su participación</h1>
        </div>
    </div>
</body>
</html>
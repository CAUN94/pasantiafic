<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>@yield('title')</title>

	<!-- Highcharts -->
	<script src="http://code.highcharts.com/stock/highstock.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://www.highcharts.com/media/com_demo/js/highslide-full.min.js"></script>
	<script src="https://www.highcharts.com/media/com_demo/js/highslide.config.js" charset="utf-8"></script>

	<!-- CSS STYLES -->
	<link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- Font Awesome CSS -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<!-- Highcharts CSS -->
	<link rel="stylesheet" type="text/css" href="https://www.highcharts.com/media/com_demo/css/highslide.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

    <style>
        :root {
            --font-family-sans-serif: "Open Sans", sans-serif;
            --font-family-base: var(--font-family-sans-serif);
        }

        .fontt {
            font-family: var(--font-family-base);
        }


        /* Estilo de fondo */
        .ficuai-bg-primary {
            background-color: #00B8E2 !important;
        }

        .ficuai-bg-dark {
            background-color: #02ABD2 !important;
        }

        /* Texto principal */
        .ficuai-text-primary {
            color: #00B8E2 !important;
        }

        /* Botones */
        .ficuai-btn-primary {
            background-color: #00B8E2 !important;
            border-color: #00B8E2 !important;
            color: #fff !important;
        }

        .ficuai-btn-dark {
            background-color: #02ABD2 !important;
            border-color: #02ABD2 !important;
            color: #fff !important;
        }

        /* Enlaces y botones de enlace */
        .ficuai-link {
            color: #00B8E2 !important;
        }

        /* Alertas */
        .ficuai-alert-primary {
            background-color: #00B8E2 !important;
            border-color: #00B8E2 !important;
            color: #fff !important;
        }

        /* Tarjetas */
        .ficuai-card-primary {
            background-color: #00B8E2 !important;
            border-color: #00B8E2 !important;
        }

        /* Barra de navegación */
        .ficuai-navbar-primary {
            background-color: #00B8E2 !important;
        }

        .ficuai-border {
            border: 1px solid #00B8E2 !important;
        }
    </style>


	<!-- JS -->
	<!-- Font Awesome JS -->
	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
	<!-- jQuery JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<!-- Bootstrap JS -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!--Bootstrap Tables-->
	<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.css">
	<script src="https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.js"></script>

</head>

<body class="fontt">
    <nav class="navbar navbar-expand ficuai-bg-dark">
        <p></p>
    </nav>
	<nav class="navbar navbar-expand ficuai-navbar-primary ficuai-bg-primary">
		<!-- Logo SVG UAI -->
        <div class="container d-flex justify-content-between">
            <a class="navbar-brand mr-1" href="https://www.uai.cl">
                <img src="{{asset('media/images/').'/'.'logouai.svg'}}" alt="Universidad Adolfo Ibáñez">
            </a>

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link text-white" aria-current="page" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-white" href="#">Syllabus</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-white" href="#">Busca tu Pasantía</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-white" href="#">FAQ</a>
                </li>
            </ul>
        </div>
	</nav>

    @yield('contenido')

		<!-- Footer -->
	<div class="container-fluid">
		<div class="row flex-xl-nowrap">
			<div class="col-12 ficuai-bg-primary border-top ficuai-border">
				<div class="text-center">
          <hr>
          <!-- year with php -->
					<span class="text-light small">©{{date('Y')}} UNIVERSIDAD ADOLFO IBAÑEZ</span>
					<address style="text-align: center;">
						<span class="text-light small">SANTIAGO : DIAGONAL LAS TORRES 2640 PEÑALOLÉN / PRESIDENTE ERRÁZURIZ 3485 LAS CONDES.</span>
						<br>
						<span class="text-light small">VIÑA DEL MAR : AVDA. PADRE HURTADO 750, VIÑA DEL MAR.</span>
					</address>
          <hr>
				</div>
			</div>
		</div>
	</div>
		<!-- Fin Footer -->

</body>
</html>

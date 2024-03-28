<?php

namespace App\Repositories;

use App\User;
use App\Pasantia;
use App\Empresa;
use App\Proyecto;

class PasantiasRepository
{

  //Arreglo que contendra los datos de la pasantia
  private static $datosPasantias = [];

  //Traductor de pasos a texto
  public function traductorPasos($pasantia)
  {
    /*
    PASO 0
      statusPaso0Pasantia == 2 Reglamento aceptado
      statusPaso0Pasantia != 2 Reglamento aún no aceptado
    */
    if ($pasantia->statusPaso0 == 2) {
      $pasantia->statusPaso0 = 'Reglamento aceptado';
    } elseif ($pasantia->statusPaso0 != 2) {
      $pasantia->statusPaso0 = 'Reglamento aún no aceptado';
    }

    /*
    PASO 1
      statusPaso1Pasantia == 2 Cumple requerimientos académicos
			statusPaso1Pasantia != 2 No cumple todos los requerimientos académicos
    */
    if ($pasantia->statusPaso1 == 2) {
      $pasantia->statusPaso1 = 'Cumple requerimientos académicos';
    } elseif ($pasantia->statusPaso1 != 2) {
      $pasantia->statusPaso1 = 'No cumple todos los requerimientos académicos';
    }

    /*
    PASO 2
      statusPaso2Pasantia == 1 Datos incompletos
			statusPaso2Pasantia == 2 Completado y validado
			statusPaso2Pasantia == 3 Pendiente por pariente
      else No ha iniciado el paso 2
    */
    if ($pasantia->statusPaso2 == 1) {
      $pasantia->statusPaso2 = 'Datos incompletos';
    } elseif ($pasantia->statusPaso2 == 2) {
      $pasantia->statusPaso2 = 'Completado y validado';
    } elseif ($pasantia->statusPaso2 == 3) {
      $pasantia->statusPaso2 = 'Pendiente por pariente';
    } else {
      $pasantia->statusPaso2 = 'No ha iniciado el paso 2';
    }

    /*
    PASO 3
      statusPaso3Pasantia == 0 No realizado
			statusPaso3Pasantia == 1 Datos incompletos
			statusPaso3Pasantia == 2 Correo no enviado
			statusPaso3Pasantia == 3 Correo no confirmado
      statusPaso3Pasantia == 4 Correo confirmado
    */
    if ($pasantia->statusPaso3 == 0) {
      $pasantia->statusPaso3 = 'No realizado';
    } elseif ($pasantia->statusPaso3 == 1) {
      $pasantia->statusPaso3 = 'Datos incompletos';
    } elseif ($pasantia->statusPaso3 == 2) {
      $pasantia->statusPaso3 = 'Correo no enviado';
    } elseif ($pasantia->statusPaso3 == 3) {
      $pasantia->statusPaso3 = 'Correo no confirmado';
    } elseif ($pasantia->statusPaso3 == 4) {
      $pasantia->statusPaso3 = 'Correo confirmado';
    }

    /*
    PASO 4
      statusPaso4Pasantia == 0 No realizado
			statusPaso4Pasantia == 1 Datos incompletos
			statusPaso4Pasantia == 2 No validado
			statusPaso4Pasantia == 3 Rechazado
      statusPaso4Pasantia == 4 Validado
    */
    if ($pasantia->statusPaso4 == 0) {
      $pasantia->statusPaso4 = 'No realizado';
    } elseif ($pasantia->statusPaso4 == 1) {
      $pasantia->statusPaso4 = 'Datos incompletos';
    } elseif ($pasantia->statusPaso4 == 2) {
      $pasantia->statusPaso4 = 'No validado';
    } elseif ($pasantia->statusPaso4 == 3) {
      $pasantia->statusPaso4 = 'Objetado';
    } elseif ($pasantia->statusPaso4 == 4) {
      $pasantia->statusPaso4 = 'Aprobado';
    }

    /*
    STATUS GENERAL
      statusGeneralPasantia == 0 Pasantía sin validar
			statusGeneralPasantia == 1 Pasantia validada
    */
    if ($pasantia->statusGeneral == 0) {
      $pasantia->statusGeneral = 'Pasantía sin validar';
    } elseif ($pasantia->statusGeneral == 1) {
      $pasantia->statusGeneral = 'Pasantia validada';
    }

    return $pasantia;
  }

  //Construccion de proyecto si no existe para mantener uniformidad de arreglo
  public function checkProyecto($proyecto)
  {
    if ($proyecto == null) {
      $proyecto = (object) [
        'idProyecto' => null,
        'status' => 0,
        'nombre' => 'Sin Nombre',
      ];
    }
    return $proyecto;
  }

  //Construccion de empresa si no existe para mantener uniformidad de arreglo
  public function checkEmpresas($empresas)
  {
    if ($empresas == null) {
      $empresas = (object) [
        'idEmpresa' => null,
        'nombre' => 'No se ha seleccionado empresa',
        'rubro' => 'No se ha seleccionado empresa',
        'urlWeb' => '',
        'correoContacto' => 'No se ha seleccionado empresa',
        'status' => 'No se ha seleccionado empresa',
      ];
    }
    return $empresas;
  }
  //Datos asociados a la pasantia
  public function llenaDatosPasantias($pasantia, $proyecto, $empresas, $usuarios)
  {
    $pasantia = $this->traductorPasos($pasantia);
    $proyecto = $this->checkProyecto($proyecto);
    $empresas = $this->checkEmpresas($empresas);

    
    $pasantiaDatos = array(
      //Atributos Pasantia
      'idPasantia' => $pasantia->idPasantia,
      'fechaInicioPasantia' => $pasantia->fechaInicio,
      'nombreJefePasantia' => $pasantia->nombreJefe,
      'correoJefePasantia' => $pasantia->correoJefe,
      'lecReglamentoPasantia' => $pasantia->lecReglamento,
      'practicaOpPasantia' => $pasantia->practicaOp,
      'ciudadPasantia' => $pasantia->ciudad,
      'paisPasantia' => $pasantia->pais,
      'horasSemanalesPasantia' => $pasantia->horasSemanales,
      'parienteEmpresaPasantia' => $pasantia->parienteEmpresa,
      'rolParientePasantia' => $pasantia->rolPariente,
      'statusGeneralPasantia' => $pasantia->statusGeneral,
      'statusPaso0Pasantia' => $pasantia->statusPaso0,
      'statusPaso1Pasantia' => $pasantia->statusPaso1,
      'statusPaso2Pasantia' => $pasantia->statusPaso2,
      'statusPaso3Pasantia' => $pasantia->statusPaso3,
      'statusPaso4Pasantia' => $pasantia->statusPaso4,
      //Atributos Proyecto
      'idProyecto' => $proyecto->idProyecto,
      'statusProyecto' => $proyecto->status,
      'nombreProyecto' => $proyecto->nombre,

      'areaProyecto' => "",
      'disciplinaProyecto' => "",
      'problematicaProyecto' => "",
      'objetivoProyecto' => "",
      'medidasProyecto' => "",
      'metodologiaProyecto' => "",
      'planificacionProyecto' => "",

      //Atributos Empresa
      'idEmpresa' => $empresas->idEmpresa,
      'nombreEmpresa' => $empresas->nombre,
      'rubroEmpresa' => $empresas->rubro,
      'urlWebEmpresa' => $empresas->urlWeb,
      'correoContactoEmpresa' => $empresas->correoContacto,
      'statusEmpresa' => $empresas->status,
      //Atributos Usuarios
      'idUsuario' => $usuarios->idUsuario,
      'nombresUsuario' => $usuarios->nombres,
      'apellidoPaternoUsuario' => $usuarios->apellidoPaterno,
      'apellidoMaternoUsuario' => $usuarios->apellidoMaterno,
      'idCarreraUsuario' => $usuarios->idCarrera,
      'statusPregradoUsuario' => $usuarios->statusPregrado,
      'rutUsuario' => $usuarios->rut,
      'rutUsuarioFormat' => $usuarios->getRutWithoutDvAttribute(),
      'dvUsuario' => $usuarios->getDvAttribute(),
      'emailUsuario' => $usuarios->email,
      'tipoMallaUsuario' => $usuarios->tipoMalla,
    );
      //Atributos Proyecto
      if(!is_null($proyecto->idProyecto)){
        $pasantiaDatos['areaProyecto'] = $proyecto->area;
        $pasantiaDatos['disciplinaProyecto'] = $proyecto->disciplina;
        $pasantiaDatos['problematicaProyecto'] = $proyecto->problematica;
        $pasantiaDatos['objetivoProyecto'] = $proyecto->objetivo;
        $pasantiaDatos['medidasProyecto'] = $proyecto->medidas;
        $pasantiaDatos['metodologiaProyecto'] = $proyecto->objetivo;
        $pasantiaDatos['planificacionProyecto'] = $proyecto->objetivo;
      }
    
    return $pasantiaDatos;
  }

  //Saca una unica pasantia y todos sus datos asociados
  public static function getPasantia($id)
  {
    $pasantia = Pasantia::where('idPasantia', $id)->first();
    $proyecto = Proyecto::where('idPasantia', $id)->first();
    $empresas = Empresa::where('idEmpresa', $pasantia->idEmpresa)->first();
    $usuarios = User::where('idUsuario', $pasantia->idAlumno)->first();

    self::$datosPasantias = (new self)->llenaDatosPasantias($pasantia, $proyecto, $empresas, $usuarios);
    return self::$datosPasantias;
  }

  //Saca todas las pasantias y todos sus datos asociados
  public static function getAllPasantias()
  {
    // get all pasantias from last fechaInicio desc
    $pasantias = Pasantia::orderBy('fechaInicio', 'desc')->get();

    foreach ($pasantias as $pasantia) {
      //Sacar datos de cada pasantia
      $proyecto = Proyecto::where('idPasantia', $pasantia->idPasantia)->first();
      $empresas = Empresa::where('idEmpresa', $pasantia->idEmpresa)->first();
      $usuarios = User::where('idUsuario', $pasantia->idAlumno)->first();

      //nombre de valor -> atributoTabla
      //Cada $datos[i] contiene un arreglo con los datos de la pasantia i
      array_push(self::$datosPasantias, (new self)->llenaDatosPasantias($pasantia, $proyecto, $empresas, $usuarios));
    }
    return self::$datosPasantias;
  }

  public static function getAllFilterPasantias($start,$end,$paso = null,$status = null,$starti = null,$endi = null,$profesor = null,$company = null){
    $pasantias = Pasantia::whereBetween('fechaInicio', [$start, $end])->orderBy('fechaInicio', 'desc');
    // check if paso isset
    if($paso != null){
      if($paso == 0){
        // statusPaso0 must != 0 and the other status must be 0
        $pasantias = $pasantias->where('statusPaso0', '!=', 0)->where('statusPaso1', 0)->where('statusPaso2', 0)->where('statusPaso3', 0)->where('statusPaso4', 0);
      }elseif($paso == 1){
        // statusPaso0 must != 0 and statusPaso1 must != 0 the other status must be 0
        $pasantias = $pasantias->where('statusPaso0', '!=', 0)->where('statusPaso1', '!=', 0)->where('statusPaso2', 0)->where('statusPaso3', 0)->where('statusPaso4', 0);
      }elseif($paso == 2){
        // statusPaso0 must != 0 and statusPaso1 must != 0 and statusPaso2 must != 0 the other status must be 0
        $pasantias = $pasantias->where('statusPaso0', '!=', 0)->where('statusPaso1', '!=', 0)->where('statusPaso2', '!=', 0)->where('statusPaso3', 0)->where('statusPaso4', 0);
      }elseif($paso == 3){
        // statusPaso0 must != 0 and statusPaso1 must != 0 and statusPaso2 must != 0 and statusPaso3 must != 0 the other status must be 0
        $pasantias = $pasantias->where('statusPaso0', '!=', 0)->where('statusPaso1', '!=', 0)->where('statusPaso2', '!=', 0)->where('statusPaso3', '!=', 0)->where('statusPaso4', 0);
      }elseif($paso == 4){
        // statusPaso0 must != 0 and statusPaso1 must != 0 and statusPaso2 must != 0 and statusPaso3 must != 0 and statusPaso4 must != 0
        $pasantias = $pasantias->where('statusPaso0', '!=', 0)->where('statusPaso1', '!=', 0)->where('statusPaso2', '!=', 0)->where('statusPaso3', '!=', 0)->where('statusPaso4', '!=', 0);
      }
    }

    if($status != null){
      if($status == 0){
        // General Status = 0
        $pasantias = $pasantias->where('statusGeneral', 0);
      } elseif ($status == 1){
        // General Status = 1
        $pasantias = $pasantias->where('statusGeneral', 1);
      }
    }

    if($starti != null && $endi != null){
      $pasantias = $pasantias->whereBetween('created_at', [$starti, $endi]);
    }

    if($profesor != null){
      // get all pasantias where profesor is tutor
      $pasantias = $pasantias->where('idProfesor', $profesor);
    }

    if($company != null){
      // get all pasantias where empresa is company
      $pasantias = $pasantias->where('idEmpresa', $company);
    }

    // $pasantiias to sql query
    // $pasantias = $pasantias->toSql();

    // ddd($pasantias);

    $pasantias = $pasantias->get();

    foreach ($pasantias as $pasantia) {
      //Sacar datos de cada pasantia
      $proyecto = Proyecto::where('idPasantia', $pasantia->idPasantia)->first();
      $empresas = Empresa::where('idEmpresa', $pasantia->idEmpresa)->first();
      $usuarios = User::where('idUsuario', $pasantia->idAlumno)->first();

      //nombre de valor -> atributoTabla
      //Cada $datos[i] contiene un arreglo con los datos de la pasantia i
      array_push(self::$datosPasantias, (new self)->llenaDatosPasantias($pasantia, $proyecto, $empresas, $usuarios));
    }
    return self::$datosPasantias;
  }
}

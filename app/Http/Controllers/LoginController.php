<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\User;
use App\AuthUsers;

class LoginController extends Controller
{
	public function authenticate(Request $request){
		$email = $request->Email;
		$password = $request->Password;
		if ($email == "" || $password == ""){
			return redirect('/login')->with('danger', 'Por favor ingrese su correo y clave.');
		}
		$authentication = false;
		$apellidos = "";
		$nombres = "";
		$rut = "";
		$org = "";
		$sede = "";
		$status = "";
		$anoIngreso = "";
		$grupo = "";
		$tipoProfe = "";
		$rol = 0;
		$profesor = false;
		$ldapconn = ldap_connect("10.100.2.6") or die("Could not connect to LDAP server.");
		ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
		if (Str::endsWith($email, 'uai.cl')){
			//Es un nusario interno de la Universidad.
			if (Str::endsWith($email, 'alumnos.uai.cl')){
				//Es un alumno. Revisamos si está en la lista de autorizados.
				if (!AuthUsers::where('email', $email)->first()){
					return redirect('/login')->with('danger', 'Usted no está autorizado para utilizar este sistema');
				}
				$ldaptree = "OU=Live@Edu,DC=uai,DC=cl";
	  		$usefulinfo = array("ou", "sn", "givenname", "mail", "employeeid", "distinguishedname");
			}
			else {
				//Es un profesor o funcionario. No necesita estar en listado de autorización
				$ldaptree = "OU=UAI,DC=uai,DC=cl";
	  		$usefulinfo = array("ou", "sn", "givenname", "mail", "employeeid", "distinguishedname");
			}
			if ($ldapconn) {
				$ldapbind = @ldap_bind($ldapconn, $email, $password);

				if ($ldapbind) {
					$result = @ldap_search($ldapconn, $ldaptree, "(mail=".$email.")", $usefulinfo);
					$data = @ldap_get_entries($ldapconn, $result);
					$apellidos = $data[0]['sn'][0];
					if (Str::contains($apellidos, ' ')){ //Existen usuarios con un solo apellido registrado.
						$splitApellidos = explode(' ', $apellidos, 2);
						$apellidoPaterno = $splitApellidos[0];
						$apellidoMaterno = $splitApellidos[1];
					}
					else {
						$apellidoPaterno = $apellidos;
						$apellidoMaterno = "";
					}
					$nombres = $data[0]['givenname'][0];
					$email = $data[0]['mail'][0];
					if (array_key_exists('employeeid', $data[0])){
						$rut = $data[0]['employeeid'][0];
					}
					else {
						$rut = "SIN RUT";
					}
					$org = $data[0]['distinguishedname'][0];
					$org = str_replace("OU=","",$org);
					$org = str_replace("CN=","",$org);
					$org = str_replace("DC=","",$org);
					$org_arr = explode (",", $org);

					if (Str::contains($email,'alumnos.uai.cl')){
						$sede = $org_arr[1];
						$status = $org_arr[2];
						$anoIngreso = $org_arr[3];
						$grupo = $org_arr[4];
						$rol = 1;
					}
					else {
						$tipo = $org_arr[1];
						if (Str::contains($tipo, 'Funcionarios')){
							$rol = 4;
						}
						if (Str::contains($tipo, 'Profesores Hora')){
							$rol = 3;
						}
					}
					$located = User::where('email', $email) -> first();
					if ($located == ""){
						$user = User::create([
							'nombres' => Str::title($nombres),
							'apellidoPaterno' => Str::title($apellidoPaterno),
							'apellidoMaterno' => Str::title($apellidoMaterno),
							'rut' => $rut,
							'idCarrera'=> 0,
							'statusPregrado' => 0,
							'statusOmega' => 0,
							'statusWebcursos'=> 0,
							'rol' => $rol,
							'email' => $email,
							'password' => 'INTUAI'
						]);
						Auth::login($user);
						return redirect('/');
					}
					else {
						$userID = $located['idUsuario'];
						Auth::loginUsingId($userID);
						return redirect('/');
					}
				}
				else {
					return redirect('/login')->with('danger', 'Credenciales incorrectas.');
				}
			}
		}
		else {
			//Externo (Empresa)
		};
	}

	public function logout(){
		Auth::logout();
		return redirect('/login');
	}


//FOR DEBUG ONLY: LOG IN AS ANOTHER USER
	public function doLoginAs(Request $request){
		$email = $request->Email;
		if (!User::where('email', $email)->first()){
			return redirect('/admin/loginAs')->with('danger', 'Usuario ' . $email . ' no encontrado en el sistema.');
		}
		else {
			$located = User::where('email', $email) -> first();
			$userID = $located['idUsuario'];
			Auth::loginUsingId($userID);
			return redirect('/');
		}
		Auth::logout();

	}
}

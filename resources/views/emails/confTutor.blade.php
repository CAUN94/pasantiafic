<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
   <title></title>
 </head>
 <body style="margin: 0; padding: 0;">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td align="left" height="39px" bgcolor="#000000" style="padding: 10px 0px 10px 10px;">
        <a target="_blank" style="color: #ffffff;">
          <img src="https://i.imgur.com/kP2EHza.png" alt="LogoUAI" style="display: block;" />
        </a>
      </td>
    </tr>
    <tr>
      <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
        <table border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td style="color: #333333; font-family: Arial, sans-serif; font-size: 24px;">
              <b>Confirmación de estudiante en pasantía:</b>
            </td>
          </tr>
          <tr>
            <td style="padding: 20px 0 30px 0; color: #333333; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
              Estimado {{$pasantia->nombreJefe}},<br/><br/>
              Necesitamos verificar que {{$user->nombres}} {{$user->apellidoPaterno}} estará bajo su cargo en {{$empresa->nombre}} realizando una Pasantía.<br/>
              Por favor confirmar los siguientes datos:
            </td>
          </tr>
          <tr>
            <td>
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td width="260" valign="top">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td style="padding: 25px 0 0 0;">
                          <table style="color: #333333; font-family: Arial, sans-serif; font-size: 14px; line-height: 20px;" border="1" align="center">
                            <tr>
                              <td align="center">
                                Nombre:
                              </td>
                              <td align="center">
                                {{$user->nombres}} {{$user->apellidoPaterno}} {{$user->apellidoMaterno}}
                              </td>
                            </tr>
                            <tr>
                              <td align="center">
                                Rut:
                              </td>
                              <td align="center">
                                {{$user->rut}}
                              </td>
                            </tr>
                            <tr>
                              <td align="center">
                                Fecha de inicio:
                              </td>
                              <td align="center">
                                {{$pasantia->fechaInicio}}
                              </td>
                            </tr>
                            <tr>
                              <td align="center">
                                Horas a la semana:
                              </td>
                              <td align="center">
                                {{$pasantia->horasSemanales}}
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td width="260" valign="top">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
                      <tr>
                        <td style="padding: 25px 10px 25px 10px;">
                            <table align="center" width="75%">
                              <tr>
                                <td style="padding: 25px 0 0 0; color: #333333; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                  Información declarada por {{$user->nombres}} {{$user->apellidoPaterno}} al inscribir su pasantía, si los datos son correctos confirmar en el siguiente enlace:
                                </td>
                              </tr>
                              <tr>
                                <td style="font-size: 0; line-height: 0;" height="20">
                                    &nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td align="center" bgcolor="#AACB3C" style="color:#ffffff; padding: 23px 23px 23px 23px; font-family: Arial, sans-serif; font-size: 18px; line-height: 20px;">
                                  <a href="http://gestionfic.uai.cl/confirmarTutor/{{$pasantia->tokenCorreo}}" target="_blank">
                                    http://gestionfic.uai.cl/confirmarTutor/{{$pasantia->tokenCorreo}}
                                  </a>
                                </td>
                              </tr>
                            </table>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 25px 0 0 0; color: #333333; font-family: Arial, sans-serif; font-size: 14px; line-height: 20px;">
                          *Haga click en el enlace o copie el enlace en una nueva pestaña de su navegador.
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td bgcolor="#1D1E20" style="padding: 10px 3px 10px 30px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <td width="75%" style="color: #ffffff; font-family: Arial, sans-serif; font-size: 10px;">
              SANTIAGO: Diagonal Las Torres 2640, Peñalolén <br/>
              Presidente Errázuriz 3485 Las Condes – (56 2) 2331 1000 <br/>
              Contacto: pasantia.fic@uai.cl
            </td>
            <td height="39px">
              <table border="0" cellpadding="0" cellspacing="0" align="right">
                <tr>
                  <td>
                    <a target="_blank" style="color: #ffffff;">
                      <img src="https://i.imgur.com/PVTysZo.jpg" alt="FIC UAI" style="display: block;" border="0" />
                    </a>
                  </td>
                  <td style="font-size: 0; line-height: 0;" width="20">
                      &nbsp;
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  </body>
</html>

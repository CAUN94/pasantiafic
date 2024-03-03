
//FUNCION FECHA
function fecha(){
  const hoy = new Date();
	let fecha = hoy.getFullYear()+'-'+(hoy.getMonth()+1)+'-'+hoy.getDate();
  return fecha;
}
function appendFecha(elementID){
  document.getElementById(elementID).innerHTML += fecha();
}

/*
function grafico(tipo, objetivo, titulo, nombreEjeY, ){
   window.chart = new Highcharts.chart({
     chart: {
       type: tipo,
       renderTo: objetivo,
       height: (9/16 * 75) + '%'
     },

     title: {
       text: titulo,
       style: {
         fontSize: '2em'
       }
     },

     exporting: {
       enabled: true,
       csv: {
         dateFormat: '%A, %b %e, %Y'
       }
     },

     credits: {
       enabled: false
     },

     xAxis: {
       type: 'category',
       labels: {
         style:{
           fontSize: '1.25em',
           fontWeight: 'bold'
         }
       }
     },

     yAxis: {
       min: 0,
       max: 100,
       title: {
        text: nombreEjeY,
        style: {

        }
       }
     }
   });
 }
*/

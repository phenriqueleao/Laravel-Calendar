<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CalendarEvent;
use App\Http\Requests;

class CalendarController extends Controller
{
    public function index()
    {
        $data = array(); //declaramos un array principal que va contener los datos
        $id = CalendarEvent::all()->lists('id'); //listamos todos los id de los eventos
        $title = CalendarEvent::all()->lists('title'); //lo mismo para lugar y fecha
        $startData = CalendarEvent::all()->lists('startData');
        $endData = CalendarEvent::all()->lists('endData');
        $allDay = CalendarEvent::all()->lists('allDay');
        $background = CalendarEvent::all()->lists('color');
        $count = count($id); //contamos los ids obtenidos para saber el numero exacto de eventos
 
        //hacemos un ciclo para anidar los valores obtenidos a nuestro array principal $data
        for($i=0;$i<$count;$i++){
            $data[$i] = array(
                "title"=>$title[$i], //obligatoriamente "title", "start" y "url" son campos requeridos
                "start"=>$startData[$i], //por el plugin asi que asignamos a cada uno el valor correspondiente
                "end"=>$endData[$i],
                "allDay"=>$allDay[$i],
                "backgroundColor"=>$background[$i],
                "id"=>$id[$i]
                //"url"=>"cargaEventos".$id[$i]
                //en el campo "url" concatenamos el el URL con el id del evento para luego
                //en el evento onclick de JS hacer referencia a este y usar el método show
                //para mostrar los datos completos de un evento
            );
        }
 
        json_encode($data); //convertimos el array principal $data a un objeto Json 
        return $data; //para luego retornarlo y estar listo para consumirlo
    }

    public function create(){
        //Valores recebidos via ajax
        $title = $_POST['title'];
        $start = $_POST['start'];
        $back = $_POST['background'];
        
        //Inserindo evento no BD
        $event = new CalendarEvent;
        $event->startData=$start;
        //$event->endData=$end;
        $event->allDay=true;
        $event->color=$back;
        $event->title=$title;
        $event->save();
    }

    public function update(){
        //Valores recibidos via ajax
        $id = $_POST['id'];
        $title = $_POST['title'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $allDay = $_POST['allday'];
        $back = $_POST['background'];

        $event = CalendarEvent::find($id);
        if($end=='NULL'){
            $event->endData=NULL;
        }else{
            $event->endData=$end;
        }
        $event->startData=$start;
        $event->allDay=$allDay;
        $event->color=$back;
        $event->title=$title;
        //$event->fechaFin=$end;


        $event->save();
   }

   public function delete(){
        //Valor id recibidos via ajax
        $id = $_POST['id'];
        CalendarEvent::destroy($id);
   }
}

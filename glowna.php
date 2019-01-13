<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Interface</title>
    
    <meta name="author" content="Marcin">
    

<link href="css/style.css" rel="stylesheet">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href='css/fullcalendar.css' rel='stylesheet' />
<link href='css/fullcalendar.print.css' rel='stylesheet' media='print' />

<script src='jquery/jquery-1.10.2.js'></script>
<script src='jquery/jquery-ui.custom.min.js'></script>
<script src="js/bootstrap.min.js"></script>
<script src='js/fullcalendar.js'></script>
<script src="js/scripts.js"></script>


        <script>
function showHint(str) {
    if (str.length == 0) { 
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "sortuj.php?q=" + str, true);
        xmlhttp.send();
    }
}
</script>

<script>
function getVote(int) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("poll").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","sortuj.php?vote="+int,true);
  xmlhttp.send();
}
</script>

<script>
function getPracownikow(int) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("pracowTabela").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","workersSortuj.php?vote="+int,true);
  xmlhttp.send();
}
</script>



<script>

	$(document).ready(function() {
	    var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		/*  className colors
		
		className: default(transparent), important(red), chill(pink), success(green), info(blue)
		
		*/		
		
		  
		/* initialize the external events
		-----------------------------------------------------------------*/
	
		$('#external-events div.external-event').each(function() {
		
			// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
			// it doesn't need to have a start or end
			var eventObject = {
				title: $.trim($(this).text()) // use the element's text as the event title
			};
			
			// store the Event Object in the DOM element so we can get to it later
			$(this).data('eventObject', eventObject);
			
			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});
			
		});
	
	
		/* initialize the calendar
		-----------------------------------------------------------------*/
		
		var calendar =  $('#calendar').fullCalendar({
			header: {
				left: 'title',
				center: 'agendaDay,agendaWeek,month',
				right: 'prev,next today'
			},
			editable: true,
			firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
			selectable: true,
			defaultView: 'month',
			
			axisFormat: 'h:mm',
			columnFormat: {
                month: 'ddd',    // Mon
                week: 'ddd d', // Mon 7
                day: 'dddd M/d',  // Monday 9/7
                agendaDay: 'dddd d'
            },
            titleFormat: {
                month: 'MMMM yyyy', // September 2009
                week: "MMMM yyyy", // September 2009
                day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
            },
			allDaySlot: false,
			selectHelper: true,
			select: function(start, end, allDay) {
				var title = prompt('Event Title:');
				if (title) {
					calendar.fullCalendar('renderEvent',
						{
							title: title,
							start: start,
							end: end,
							allDay: allDay
						},
						true // make the event "stick"
					);
				}
				calendar.fullCalendar('unselect');
			},
			droppable: true, // this allows things to be dropped onto the calendar !!!
			drop: function(date, allDay) { // this function is called when something is dropped
			
				// retrieve the dropped element's stored Event Object
				var originalEventObject = $(this).data('eventObject');
				
				// we need to copy it, so that multiple events don't have a reference to the same object
				var copiedEventObject = $.extend({}, originalEventObject);
				
				// assign it the date that was reported
				copiedEventObject.start = date;
				copiedEventObject.allDay = allDay;
				
				// render the event on the calendar
				// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
				$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
				
				// is the "remove after drop" checkbox checked?
				if ($('#drop-remove').is(':checked')) {
					// if so, remove the element from the "Draggable Events" list
					$(this).remove();
				}
				
			},
			
			events: [
				{
					id: 999,
					title: 'Koncert U2',
					start: new Date(y, m, 1, 17, 00),
                                        end: new Date(y, m, 1, 21, 0),
					url: 'http://www.u2.com/index/home',
					className: 'important'
				},
				{
					id: 999,
					title: 'Pokaz tańca salsa',
					start: new Date(y, m, 1, 21, 00),
                                        end: new Date(y, m, 1, 21, 30),
					allDay: false,
                                        url: 'https://www.youtube.com/watch?v=O6kN-usZzew',
					className: 'info'
				},
				{
					id: 999,
					title: 'Świętokrzyska Gala Discio Polo',
					start: new Date(y, m, 3, 16, 00),
                                        end: new Date(y, m, 3, 18, 0),
					allDay: false,
                                        url: 'http://www.koncertomania.pl/koncert/545761/bilety-bad-boys-blue-mig-cliver-freaky-boys-b-qll-jagoda-piekni-i-mlodzi-camasutra-andre-long-junior-dbomb-kielce-29-04-2016.html',
					className: 'info'
				},
				{
					title: 'Pokaz tańca Pol-dance',
					start: new Date(y, m, 4, 14, 00),
                                        end: new Date(y, m, 4, 14,15),
					allDay: false,
                                        url: 'http://poledanceproject.pl/',
					className: 'important'
				},
				{
					title: 'Turniej bilarda CUP 2016',
					start: new Date(y, m, 5, 15, 00),
					end: new Date(y, m, 5, 19, 0),
					allDay: false,
                                        url: 'https://www.google.pl/search?q=bilard&tbm=isch&imgil=Mz_SIJOnYPYTTM%253A%253B7TRuHkc6EWTUdM%253Bhttp%25253A%25252F%25252Fbilard.bialystok.pl%25252Fgra-dla-wybranych%25252F&source=iu&pf=m&fir=Mz_SIJOnYPYTTM%253A%252C7TRuHkc6EWTUdM%252C_&usg=__3BSxc91_U77A7xlNfas8ccEprA4%3D&biw=1366&bih=657&ved=0ahUKEwjT8tfzvqfMAhXCE5oKHQDeB10QyjcIXg&ei=BdkcV5PcBcKn6ASAvJ_oBQ#imgrc=Mz_SIJOnYPYTTM%3A',
					className: 'important'
				},
				{
					title: 'Spotkanie z aktorem Melem Gibsonem',
					start: new Date(y, m, 6, 15, 0),
					end: new Date(y, m, 6, 16, 00),
					allDay: false,
                                        url: 'https://pl.wikipedia.org/wiki/Mel_Gibson',
                                        className: 'important'
				},
				{
					title: 'Spotkanie z miss polonia',
					start: new Date(y, m, 7, 16, 0),
					end: new Date(y, m, 7, 22, 00),
					url: 'http://www.misspolonia.com.pl/',
					className: 'success'
				}
			],			
		});
		
		
	});

</script>

</head>
<body>

<?php

	echo "<p><b>Witaj</b> ".$_SESSION['user'].'! <a style="color: black; float: right;" href="logout.php">Wyloguj się!</a> </p>';
?>

     <!-- menu navbar-->
        <div id="menu">
             <ul>
              <li id="gl"><a class="active" href="glowna.php">Strona glówna</a></li>
              <li id="kal"><a  href="fullcalendar.html">kalendarz</a></li>
              <li id="dod"><a href="dodaj.html">dodaj wydarzenie</a></li>
              <li id="usu"><a href="usun.html">usuń wydarzenie</a></li>
              <li id="zob"><a href="zobacz.html">zobacz wydarzenia</a></li>
              <li id="map"><a href="mapa.html">mapka galerii</a></li>
              <li id="wyn"><a href="wynajmij.html">wynajmij lokal</a></li>
              <li id="rap"><a href="raport.html">zysk z lokali</a></li>
              <li id="rap2"><a  href="raport2.html">raport</a></li>
			  <li id="uzytk" ><a href="sortuj.php">użytkownicy</a></li>
            </ul>
        </div>
        <!-- koniec diva menu navbar-->
		
		
		 <h1 style="text-align: center"> SYSTEM ZARZĄDZANIA GALERIĄ</h1>
		
		<div id="galeriapic" style="text-align: center">
        <img src="img/galeria.jpg" style="width:600px;height:400px;">
        </div>
        
       
        
        
<div id='wrap'>

<div id='calendar'></div>

<div style='clear:both'></div>
</div>

			<div>
					<h1 style="text-align: center;">Dodawanie wydarzenia</h1>
					<div id="dodawanie">
						<form>
							Podaj nazwę wydarzenia: <br/> <input type="text" style="width: 40%;" name="login" > <br/><br>
							   <input type="submit" onclick="alert('Dodano wydarzenie!!!')" value="Zatwierdź" />
						</form>        
					</div>

            </div>
        
            <div id="dodajwyd" style="text-align: center">
                <img src="img/dodajwyd.jpg" style="width:220px;height:194px;">
            </div>
			
			
			<div>
					<h1 style="text-align: center;">Usuwanie wydarzenia</h1>
						<div id="usuwanie">
							<form>
								Podaj nazwę wydarzenia: <br/> <input type="text" style="width: 40%;" name="login"> <br/><br>
								   <input type="submit" onclick="alert('Usunięto wydarzenie!!!')" value="Zatwierdź" />
							</form>        
						</div>
            
            
        </div>
		
		<div id="kosz" style="text-align: center">
                <img src="img/kosz.jpg" style="width:220px;height:194px;">
            </div>
			
			
			
			         <div class="tabelka">
              <div class="container-fluid">
                    <div class="row">
                            <div class="col-md-12">
                                    <table class="table">

                                        <thead>
                                                    <tr class="danger">
                                                            <th>
                                                                    #
                                                            </th>
                                                            <th>
                                                                    Nazwa wydarzenia
                                                            </th>
                                                            <th>
                                                                    Czas
                                                            </th>
                                                            <th>
                                                                    Dochód
                                                            </th>
                                                    </tr>
                                            </thead>
                                            <tbody>

                                                    <tr class="warning">
                                                            <td>
                                                                    1
                                                            </td>
                                                            <td>
                                                                    Koncert U2
                                                            </td>
                                                            <td>
                                                                    01/04/2016 17:00 - 21:00
                                                            </td>
                                                            <td>
                                                                    14000,00 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    2
                                                            </td>
                                                            <td>
                                                                    Pokaz tańca salsa
                                                            </td>
                                                            <td>
                                                                    01/04/2016 21:00 - 21:30
                                                            </td>
                                                            <td>
                                                                    3000,00 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    3
                                                            </td>
                                                            <td>
                                                                    Świętokrzyska Gala Discio Polo
                                                            </td>
                                                            <td>
                                                                    03/04/2016 16:00 - 18:00
                                                            </td>
                                                            <td>
                                                                    12000,00 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    4
                                                            </td>
                                                            <td>
                                                                    Pokaz tańca Pol-dance
                                                            </td>
                                                            <td>
                                                                    04/04/2016 14:00 - 14:15
                                                            </td>
                                                            <td>
                                                                    3500,00 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    5
                                                            </td>
                                                            <td>
                                                                    Turniej bilarda CUP 2016
                                                            </td>
                                                            <td>
                                                                    05/04/2016 15:00 - 19:00
                                                            </td>
                                                            <td>
                                                                    40000,00 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    6
                                                            </td>
                                                            <td>
                                                                    Spotkanie z aktorem Melem Gibsonem
                                                            </td>
                                                            <td>
                                                                    06/04/2016 15:00 - 16:00
                                                            </td>
                                                            <td>
                                                                    20000,00 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    7
                                                            </td>
                                                            <td>
                                                                    Spotkanie z miss polonia
                                                            </td>
                                                            <td>
                                                                    07/04/2016 16:00 - 22:00
                                                            </td>
                                                            <td>
                                                                    7000,00 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    8
                                                            </td>
                                                            <td>
                                                                    Pokaz drittingu na parkingu
                                                            </td>
                                                            <td>
                                                                    08/04/2016 11:00 - 12:00
                                                            </td>
                                                            <td>
                                                                    3000,00 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    9
                                                            </td>
                                                            <td>
                                                                    Turniej Pokera Klasycznego
                                                            </td>
                                                            <td>
                                                                    15/04/2016 18:00 - 22:00
                                                            </td>
                                                            <td>
                                                                    1500,00 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    10
                                                            </td>
                                                            <td>
                                                                    Prezentacja nowych gadżetów elektronicznych
                                                            </td>
                                                            <td>
                                                                    19/04/2016 12:00 - 18:00
                                                            </td>
                                                            <td>
                                                                    darmo
                                                            </td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    11
                                                            </td>
                                                            <td>
                                                                    Prezentacja zespołu piłkarskiej Petarda Warszawa FC
                                                            </td>
                                                            <td>
                                                                    29/04/2016 12:00 - 14:00
                                                            </td>
                                                            <td>
                                                                    8000,00 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    12
                                                            </td>
                                                            <td>
                                                                    Degustacja zdrowego jedzenia
                                                            </td>
                                                            <td>
                                                                    02/05/2016 10:00 - 22:00
                                                            </td>
                                                            <td>
                                                                    3500,00 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    13
                                                            </td>
                                                            <td>
                                                                    Turniej siatkówki plażowej Mieszka Chrobrego
                                                            </td>
                                                            <td>
                                                                    10/05/2016 10:00 - 18:00
                                                            </td>
                                                            <td>
                                                                    14000,00 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    14
                                                            </td>
                                                            <td>
                                                                    Koncert muzyki klasycznej 
                                                            </td>
                                                            <td>
                                                                    11/05/2016 11:00 - 15:00
                                                            </td>
                                                            <td>
                                                                    50000,00 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    15
                                                            </td>
                                                            <td>
                                                                    Promocja książki Andrzeja Pisarzowskiego "Kryminalny Świat"
                                                            </td>
                                                            <td>
                                                                    16/05/2016 11:00 - 17:00
                                                            </td>
                                                            <td>
                                                                    500,50 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    16
                                                            </td>
                                                            <td>
                                                                    Poczęstunek alkoholu
                                                            </td>
                                                            <td>
                                                                    22/05/2016 11:00 - 22:00
                                                            </td>
                                                            <td>
                                                                    4000,00 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    17
                                                            </td>
                                                            <td>
                                                                    Turniej bilarda 
                                                            </td>
                                                            <td>
                                                                    06/06/2016 11:00 - 13:00
                                                            </td>
                                                            <td>
                                                                    2550,00 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    18
                                                            </td>
                                                            <td>
                                                                    Koncet muzyki Disco-Polo na Wesoło
                                                            </td>
                                                            <td>
                                                                    11/06/2016 11:00 - 13:00
                                                            </td>
                                                            <td>
                                                                    7555,00 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    19
                                                            </td>
                                                            <td>
                                                                    Spotkanie z gwiazdami kina
                                                            </td>
                                                            <td>
                                                                    21/06/2016 15:00 - 15:30
                                                            </td>
                                                            <td>
                                                                    440000,00 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    20
                                                            </td>
                                                            <td>
                                                                    Koncet Cyganów
                                                            </td>
                                                            <td>
                                                                    30/06/2016 16:00 - 16:30
                                                            </td>
                                                            <td>
                                                                    50,00 zł
                                                            </td>
                                                    </tr>
                                                   

                                    </table>
                            </div>
                    </div>
            </div>
</div>

 <div class="szukajpole">
              <div class="container-fluid">
                    <div class="row">
                            <div class="col-md-12">

        <div class="szukajinput">
                <form>
                   <input type="text" style="width: 40%;" name="login" > <br/><br>
                       <input type="submit" onclick="alert('Szukam...')" value="Szukaj" />
                </form>        
            </div>
        
                                <div class="legenda">
                                        <h2>LEGENDA MAPY:</h2>
                                        
                                        <h5> Zielone pola: lokale do wynajęcia</h5>
                                        <h5>    Czarne pola: lokale wynajęte</h5>
                                        <h5>    Niebieskie pola: wyjścia oraz schody</h5>
                                        <h5>    Szare pola: alejki</h5>                                            
 
                                </div>
                                
                            </div>
                        </div>
                  </div>
                </div>
				
				
				 <div class="calamapagalerii">
              <div class="container-fluid">
                    <div class="row">
                            <div class="col-md-12">
            
            
                                <h3>POZIOM -1</h3>
        <div class="sklep1" onclick="alert('Wynajęty!!!')">
            <button type="button">1</button>
        </div>
        
        <div class="sklep2" onclick="alert('Wynajęty!!!')">
           <button type="button">2</button>
        </div>
        <div class="sklep3" onclick="alert('Wynajęty!!!')">
            <button type="button">3</button>
        </div>
        <div class="sklep4" onclick="alert('Wynajęty!!!')">
            <button type="button">4</button>
        </div>
        <div class="sklep5" onclick="alert('Wynajęty!!!')">
            <button type="button">5</button>
        </div>
        <div class="sklep6" onclick="alert('Wynajęty!!!')">
            <button type="button">6</button>
        </div>
        <div class="sklep7" onclick="alert('Wynajęty!!!')">
            <button type="button">7</button>
        </div>
                
        <div class="sklep8" onclick="alert('Wynajęty!!!')">
            <button type="button">8</button>
        </div>
            
        <div class="sklep9" onclick="alert('Wynajęty!!!')">
            <button type="button">9</button>
        </div>
            
        <div class="sklep10" onclick="alert('Wynajęty!!!')">
            <button type="button">10</button>
        </div>
                                
                                <div class="wyjście1">
                                    <p>WYJŚCIE</p>
                                </div>
                                
                                <div class="alejka">
                                    <p>ALEJKA</p>
                                </div>
                                
                                <div class="schody2">
                                    <p>Schody</p>
                                    
                                </div>
        
        
      
            <div class="sklep11" onclick="alert('Wynajęty!!!')">
            <button type="button">11</button>
        </div>
        
        <div class="sklep12" onclick="alert('Wynajęty!!!')">
           <button type="button" onclick="alert('Wynajęty!!!')">12</button>
        </div>
        <div class="sklep13">
            <button type="button" onclick="alert('Wynajęty!!!')">13</button>
        </div>
            
        <div class="sklep14">
            <button type="button" onclick="alert('Wynajęty!!!')">14</button>
        </div>
            
        <div class="sklep15">
            <button type="button" onclick="alert('Wynajęty!!!')">15</button>
        </div>
            
        <div class="sklep16">
          <button type="button" onclick="alert('Wynajęty!!!')">16</button>
        </div>
            
        <div class="sklep17">
            <button type="button" onclick="alert('Wynajęty!!!')">17</button>
        </div>
            
        <div class="sklep18">
            <button type="button" onclick="alert('Wynajęty!!!')">18</button>
        </div>
            
        <div class="sklep19">
            <button type="button" onclick="alert('Wynajęty!!!')">19</button>
        </div>
            
            <div class="sklep20">
           <button type="button" onclick="alert('Wynajęty!!!')">20</button>
            </div>
            
                                <h3>POZIOM 1</h3>
            
            

            <div class="sklep21" onclick="alert('Wynajęty!!!')">
            <button type="button">21</button>
        </div>
        
        <div class="sklep22">
           <button type="button" onclick="alert('Wynajęty!!!')">22</button>
        </div>
        <div class="sklep23">
            <button type="button" onclick="alert('Wynajęty!!!')">23</button>
        </div>
        <div class="sklep24" onclick="alert('Do wynajęcia!!!')">
            <button type="button" style=" background-color: green;">24</button>
        </div>
        <div class="sklep25" >
            <button type="button" style=" background-color: green;" onclick="alert('Do wynajęcia!!!')">25</button>
        </div>
        <div class="sklep26">
            <button type="button" style=" background-color: green;" onclick="alert('Do wynajęcia!!!')">26</button>
        </div>
        <div class="sklep27">
            <button type="button" style=" background-color: green;" onclick="alert('Do wynajęcia!!!')">27</button>
        </div>
                
        <div class="sklep28">
            <button type="button" style=" background-color: green;" onclick="alert('Do wynajęcia!!!')">28</button>
        </div>
            
        <div class="sklep29">
            <button type="button" style=" background-color: green;" onclick="alert('Do wynajęcia!!!')">29</button>
        </div>
            
            <div class="sklep30">
            <button type="button" style=" background-color: green;" onclick="alert('Do wynajęcia!!!')">30</button>
        </div>
            
        
                            <div class="wyjście2">
                                    <p>WYJŚCIE</p>
                                </div>
                                
                                <div class="alejka2">
                                    <p>ALEJKA</p>
                                </div>
                                
                                <div class="schody2">
                                    <p>Schody</p>
                                    
                                </div>
      
            <div class="sklep31">
            <button type="button" style=" background-color: green;" onclick="alert('Do wynajęcia!!!')">31</button>
        </div>
        
        <div class="sklep32">
           <button type="button" style=" background-color: green;" onclick="alert('Do wynajęcia!!!')">32</button>
        </div>
        <div class="sklep33">
            <button type="button" style=" background-color: green;" onclick="alert('Do wynajęcia!!!')">33</button>
        </div>
            
        <div class="sklep34">
            <button type="button" style=" background-color: green;" onclick="alert('Do wynajęcia!!!')">34</button>
        </div>
            
        <div class="sklep35">
            <button type="button" style=" background-color: green;" onclick="alert('Do wynajęcia!!!')">35</button>
        </div>
            
        <div class="sklep36">
          <button type="button" style=" background-color: green;" onclick="alert('Do wynajęcia!!!')">36</button>
        </div>
            
        <div class="sklep37">
            <button type="button" style=" background-color: green;" onclick="alert('Do wynajęcia!!!')">37</button>
        </div>
            
        <div class="sklep38">
            <button type="button" style=" background-color: green;" onclick="alert('Do wynajęcia!!!')">38</button>
        </div>
            
        <div class="sklep39">
            <button type="button" style=" background-color: green;" onclick="alert('Do wynajęcia!!!')">39</button>
        </div>
            
            <div class="sklep40">
           <button type="button" style=" background-color: green;" onclick="alert('Do wynajęcia!!!')">40</button>
        </div>
            
            </div>
                 </div>
                        </div>
                            </div>
							
							
							
							
							 <div class="tabelkamapa">
              <div class="container-fluid">
                    <div class="row">
                            <div class="col-md-12">
                                    <table class="table">

                                        <thead>
                                                    <tr class="danger">
                                                            <th style="text-align: center;">
                                                                    #
                                                            </th>
                                                            <th style="text-align: center;">
                                                                    Lokal
                                                            </th>
                                                           
                                                    </tr>
                                            </thead>
                                            <tbody>

                                                    <tr class="warning">
                                                            <td>
                                                                    1
                                                            </td>
                                                            <td>
                                                                    Kino Bambino
                                                            </td>
                                                            
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    2
                                                            </td>
                                                            <td>
                                                                    Restauracja jadełko
                                                            </td>
                                                            
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    3
                                                            </td>
                                                            <td>
                                                                    Sklep wędkarski "Spławik"
                                                            </td>
                                                            
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    4
                                                            </td>
                                                            <td>
                                                                    Sklep motoryzacyjny "Kółeczko"
                                                            </td>
                                                            
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    5
                                                            </td>
                                                            <td>
                                                                    Siłownia "Łapa"
                                                            </td>
                                                           
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    6
                                                            </td>
                                                            <td>
                                                                    Restauracja "Do pełna"
                                                            </td>
                                                            
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    7
                                                            </td>
                                                            <td>
                                                                    Sklep odzieżowy "Miara"
                                                            </td>
                                                            
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    8
                                                            </td>
                                                            <td>
                                                                    Sklep meblowy "Igła"
                                                            </td>
                                                            
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    9
                                                            </td>
                                                            <td>
                                                                    Basen "Rzeczka"
                                                            </td>
                                                            
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    10
                                                            </td>
                                                            <td>
                                                                    Restauracja "Mielony u Zochy"
                                                            </td>
                                                            
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    11
                                                            </td>
                                                            <td>
                                                                    Sklep z zabawkami "Laleczka"
                                                            </td>
                                                            
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    12
                                                            </td>
                                                            <td>
                                                                    Kawiarnia "Czarna"
                                                            </td>
                                                            
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    13
                                                            </td>
                                                            <td>
                                                                    Sklep z butami "Pięta"
                                                            </td>
                                                            
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    14
                                                            </td>
                                                            <td>
                                                                    Sklep z ubraniami "Skwarek"
                                                            </td>
                                                            
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    15
                                                            </td>
                                                            <td>
                                                                    Lodziarnia "u Lodziary"
                                                            </td>
                                                           
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    16
                                                            </td>
                                                            <td>
                                                                    Pub "Przybij gwoździa"
                                                            </td>
                                                            
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    17
                                                            </td>
                                                            <td>
                                                                    Kręgielnia "One Kręgyl"
                                                            </td>
                                                            
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    18
                                                            </td>
                                                            <td>
                                                                    Szatnia "Szatniareczka blondyneczka"
                                                            </td>
                                                            
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    19
                                                            </td>
                                                            <td>
                                                                    Sklep odzieżowt "Smike"
                                                            </td>
                                                           
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    20
                                                            </td>
                                                            <td>
                                                                    Sklep odzieżowy "U Cygana"
                                                            </td>
                                                            
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    21
                                                            </td>
                                                            <td>
                                                                    Sklep odzieżowy "U Mariana"
                                                            </td>
                                                            
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    22
                                                            </td>
                                                            <td>
                                                                    Sklep odzieżowy "Sztywny"
                                                            </td>
                                                            
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    23
                                                            </td>
                                                            <td>
                                                                    Sklep odzieżowy "Za łukiem"
                                                            </td>
                                                           
                                                    </tr>

                                    </table>
                            </div>
                    </div>
            </div>
</div>

<h1 style="text-align: center;">FORMULARZ NAJMU</h1>

       <div class="formularznajmu">
                <form >
                <br/> Numer lokalu: <br/><input type="text"><br>
                <br/> Imię osoby najmującej: <br/><input type="text"><br>
                <br/> Nazwisko osoby najmującej: <br/><input type="text"><br>
                <br/> Adres: <br/><input type="text"><br>
                <br/> Dla firmy: <br/><input type="text" ><br>
                <br/> e-mail firmy: <br/><input type="text"><br>
                <br/> Data wynajęcia: <br/><input type="text"><br>
                <br/> Na okres: <br/><input type="text"><br>
                <br/> Cena: <br/><input type="text"><br>
                <br/> Dodatkowe uwagi: <br/><input type="text"><br><br>      
                       <input type="submit" onclick="alert('Lokal został wynajęty!!!')" value="WYNAJMIJ!!!" />

                 </form>
                </div>   
				
				
				
				  <div class="tabelka">
              <div class="container-fluid">
                    <div class="row">
                            <div class="col-md-12">
                                    <table class="table">

                                        <thead>
                                                    <tr class="danger">
                                                            <th>
                                                                    #
                                                            </th>
                                                            <th>
                                                                    Lokal
                                                            </th>
                                                            <th>
                                                                    Miesięczny koszt wynajmu
                                                            </th>
                                                            <th>
                                                                    Płatność
                                                            </th>
                                                    </tr>
                                            </thead>
                                            <tbody>

                                                    <tr class="warning">
                                                            <td>
                                                                    1
                                                            </td>
                                                            <td>
                                                                    Kino Bambino
                                                            </td>
                                                            <td>
                                                                    3000,00 zł
                                                            </td>
                                                            <td>
                                                                    Przelew
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    2
                                                            </td>
                                                            <td>
                                                                    Restauracja jadełko
                                                            </td>
                                                            <td>
                                                                    1200,00 zł
                                                            </td>
                                                            <td>
                                                                    Gotówka
                                                            </td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    3
                                                            </td>
                                                            <td>
                                                                    Sklep wędkarski "Spławik"
                                                            </td>
                                                            <td>
                                                                    599,99 zł
                                                            </td>
                                                            <td>
                                                                    Przelew
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    4
                                                            </td>
                                                            <td>
                                                                    Sklep motoryzacyjny "Kółeczko"
                                                            </td>
                                                            <td>
                                                                    795,95 zł
                                                            </td>
                                                            <td>
                                                                    Przelew
                                                            </td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    5
                                                            </td>
                                                            <td>
                                                                    Siłownia "Łapa"
                                                            </td>
                                                            <td>
                                                                    3099,99 zł
                                                            </td>
                                                            <td>
                                                                    Przelew
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    6
                                                            </td>
                                                            <td>
                                                                    Restauracja "Do pełna"
                                                            </td>
                                                            <td>
                                                                    1150,00 zł
                                                            </td>
                                                            <td>
                                                                    Gotówka
                                                            </td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    7
                                                            </td>
                                                            <td>
                                                                    Sklep odzieżowy "Miara"
                                                            </td>
                                                            <td>
                                                                    599,99 zł
                                                            </td>
                                                            <td>
                                                                    Przelew
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    8
                                                            </td>
                                                            <td>
                                                                    Sklep meblowy "Igła"
                                                            </td>
                                                            <td>
                                                                    995,95 zł
                                                            </td>
                                                            <td>
                                                                    Przelew
                                                            </td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    9
                                                            </td>
                                                            <td>
                                                                    Basen "Rzeczka"
                                                            </td>
                                                            <td>
                                                                    3100,00 zł
                                                            </td>
                                                            <td>
                                                                    Przelew
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    10
                                                            </td>
                                                            <td>
                                                                    Restauracja "Mielony u Zochy"
                                                            </td>
                                                            <td>
                                                                    250,00 zł
                                                            </td>
                                                            <td>
                                                                    Gotówka
                                                            </td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    11
                                                            </td>
                                                            <td>
                                                                    Sklep z zabawkami "Laleczka"
                                                            </td>
                                                            <td>
                                                                    390,99 zł
                                                            </td>
                                                            <td>
                                                                    Przelew
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    12
                                                            </td>
                                                            <td>
                                                                    Kawiarnia "Czarna"
                                                            </td>
                                                            <td>
                                                                    795,95 zł
                                                            </td>
                                                            <td>
                                                                    Przelew
                                                            </td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    13
                                                            </td>
                                                            <td>
                                                                    Sklep z butami "Pięta"
                                                            </td>
                                                            <td>
                                                                    3150,00 zł
                                                            </td>
                                                            <td>
                                                                    Przelew
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    14
                                                            </td>
                                                            <td>
                                                                    Sklep z ubraniami "Skwarek"
                                                            </td>
                                                            <td>
                                                                    1200,00 zł
                                                            </td>
                                                            <td>
                                                                    Gotówka
                                                            </td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    15
                                                            </td>
                                                            <td>
                                                                    Lodziarnia "u Lodziary"
                                                            </td>
                                                            <td>
                                                                    899,99 zł
                                                            </td>
                                                            <td>
                                                                    Przelew
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    16
                                                            </td>
                                                            <td>
                                                                    Pub "Przybij gwoździa"
                                                            </td>
                                                            <td>
                                                                    4795,95 zł
                                                            </td>
                                                            <td>
                                                                    Przelew
                                                            </td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    17
                                                            </td>
                                                            <td>
                                                                    Kręgielnia "One Kręgyl"
                                                            </td>
                                                            <td>
                                                                    5000,00 zł
                                                            </td>
                                                            <td>
                                                                    Przelew
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    18
                                                            </td>
                                                            <td>
                                                                    Szatnia "Szatniareczka blondyneczka"
                                                            </td>
                                                            <td>
                                                                    200,00 zł
                                                            </td>
                                                            <td>
                                                                    Gotówka
                                                            </td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    19
                                                            </td>
                                                            <td>
                                                                    Sklep odzieżowt "Smike"
                                                            </td>
                                                            <td>
                                                                    599,99 zł
                                                            </td>
                                                            <td>
                                                                    Przelew
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    20
                                                            </td>
                                                            <td>
                                                                    Sklep odzieżowy "U Cygana"
                                                            </td>
                                                            <td>
                                                                    795,95 zł
                                                            </td>
                                                            <td>
                                                                    Przelew
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    21
                                                            </td>
                                                            <td>
                                                                    Sklep odzieżowy "U Mariana"
                                                            </td>
                                                            <td>
                                                                    195,95 zł
                                                            </td>
                                                            <td>
                                                                    Przelew
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    22
                                                            </td>
                                                            <td>
                                                                    Sklep odzieżowy "Sztywny"
                                                            </td>
                                                            <td>
                                                                    795,95 zł
                                                            </td>
                                                            <td>
                                                                    Przelew
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    23
                                                            </td>
                                                            <td>
                                                                    Sklep odzieżowy "Za łukiem"
                                                            </td>
                                                            <td>
                                                                    5,95 zł
                                                            </td>
                                                            <td>
                                                                    Przelew
                                                            </td>
                                                    </tr>

                                    </table>
                            </div>
                    </div>
            </div>
</div>

<h1 style="text-align: center">Raport zysków za maj 2016</h1>


	   
	       <div class="raporcikzyskow">
              <div class="container-fluid">
                    <div class="row">
                            <div class="col-md-12">
                                    <table class="table">

                                        <thead>
                                                    <tr class="danger">
                                                            <th>
                                                                    #
                                                            </th>
                                                            <th>
                                                                    Typ zysku
                                                            </th>
                                                            <th>
                                                                    Okres
                                                            </th>
                                                            <th>
                                                                    Suma zysku danego typu
                                                            </th>
                                                    </tr>
                                            </thead>
                                            <tbody>

                                                    <tr class="warning">
                                                            <td>
                                                                    1
                                                            </td>
                                                            <td>
                                                                    wynajem
                                                            </td>
                                                            <td>
                                                                    05/2016
                                                            </td>
                                                            <td>
                                                                    32626,64 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td>
                                                                    2
                                                            </td>
                                                            <td>
                                                                    wydarzenia
                                                            </td>
                                                            <td>
                                                                    05/2016
                                                            </td>
                                                            <td>
                                                                    72000,50 zł
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    
                                                            </td>
                                                            <td>
                                                                   
                                                            </td>
                                                            <td>
                                                                   
                                                            </td>
                                                            <td style="font-weight: 900;" class="thicker">
                                                                      Podsumowanie: 
                                                            </td>
                                                    </tr>
                                                    <tr class="active">
                                                            <td>
                                                                    
                                                            </td>
                                                            <td>
                                                                    
                                                            </td>
                                                            <td>
                                                                    
                                                            </td>
                                                            <td>
                                                                 104627,14 zł 
                                                            </td>
                                                    </tr>
                                                   
                                                   
                                    </table>
                            </div>
                    </div>
            </div>
</div>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" target="_blank">
  <input type="submit" value="pobierz dane">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    
	require_once "connect.php";
	 $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

 if($polaczenie->connect_errno!=0)
	{ 
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$sql="SELECT `user` FROM `uzytkownicy` order BY `user` ";
		$result = $polaczenie->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	echo "<table ><tr><th>Name</th></tr>";
	
    while($row = $result->fetch_assoc()) {
		
        echo  "<tr><td>".$row["user"]. "</td></tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}
	$polaczenie->close();
	}
    
}
?>

 <!-- nowa zakładka-->
Wyświetl użytkowników w nowej zakładce
<form action="sortuj.php" method="get" target="_blank">
<input type="submit" value="ok">
</form>
	
	
	
<form> 
Wyświetl użytkowników za pomocą inputa <input type="text" onkeyup="showHint(this.value)">
</form>
<p>Tabela: <span id="txtHint"></span></p>
	

	
	tooooooooooooo
	<div id="poll">

<form>
<br>Wybierz radio button aby wyświetlić użytkowników:
<input type="radio" name="vote" value="1" onclick="getVote(this.value)">
</form>
</div>
	
	
	
	<div id="pracowTabela">

<form>
<br>zobacz tabele pracowników:
<input type="radio" name="vote" value="1" onclick="getPracownikow(this.value)">
</form>
</div>
	
	<footer>
            <div class="row" >
                
					
					<hr>
                                        <center><p>Copyright &copy; Marcin Bamburski</p></center>
            </div>	
		</footer>	

        
</body>
</html>

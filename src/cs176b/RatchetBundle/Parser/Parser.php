<?php

namespace cs176b\RatchetBundle\Parser;


use Symfony\Component\Validator\Exception\InvalidArgumentException;

class Parser {

    private $currentStream = null;
    private $previousStream = null;
    private $previousElements = array(array());
    private $currentElements = array(array());

    public function parseStream($stream){
        if($stream == null){
            throw new InvalidArgumentException("Stream is empty");
        }

        $this->previousStream = $this->currentStream;
        $this->previousElements = $this->currentElements;

        $this->currentStream = $stream;
        $this->currentElements = $this->parseTuplesToArray($stream);

        return $this->currentElements;
    }

    public function hasNew(){
        return $this->currentStream !== $this->previousStream;
    }

    public function getElements(){
        return $this->currentElements;
    }

    public function getLatestElement(){
        return end($this->currentElements);
    }

    public function getNewElements(){
        $new = $this->currentElements;
        $i = 0;
        while($i < count($this->previousElements) && $this->currentElements[$i] == $this->previousElements[$i]){
            array_shift($new);
            $i++;
        }
        return $new;
    }

    private function parseTuplesToArray($stream){
        $arr = array();
        preg_match_all('/([\\"\\\'])(?:(?=(\\\\?))\\2.)*?\\1/', $stream, $arr);
        $arr = $arr[0];

        $arrayOfTuples = array();
        for($i = 0; $i < count($arr)-1; $i+=2){
            array_push($arrayOfTuples, array (
                $arr[$i],
                $arr[$i+1]
            ));
        }

        return $arrayOfTuples;
    }

    private function getExampleStream(){
        return '
            Array (fromList [Array (fromList [String "11:43",String "Das war das 1. Freie Training - weiter geht\'s um 14:00 Uhr mit der zweiten Einheit. Wir berichten wie gewohnt wieder live vom Kampf um die Tagesbestzeit. Bis dahin."]),Array (fromList [String "11:43",String "H\195\188lkenberg landet auf Platz 10, Adrian Sutil war im 1. Training nicht im Einsatz. Er musste seinen Sauber Testfahrer van der Garde \195\188berlassen."]),Array (fromList [String "11:38",String "Vettel beendet das erste Training als Sechster weit vor seinem Red-Bull-Teamkollegen Ricciardo, der allerdings mit technischen Problemen k\195\164mpfte und nur 16. wurde."]),Array (fromList [String "11:31",String "Der 1. Freie Training ist vorbei. Hamilton gewinnt den ersten Schlagabtausch im K\195\182niglichen Park von Monza vor Button, Rosberg und Alonso."]),Array (fromList [String "11:29",String "Die letzten 60 Sekunden ticken herunter."]),Array (fromList [String "11:29",String "Riesengl\195\188pck f\195\188r Perez: Der Heckfl\195\188gle an seinem Force India ist beim Anbremsen vor einer Kurve nicht zugeklappt. Der Mexikaner konnte sein Auto nur mit Gl\195\188ck retten."]),Array (fromList [String "11:27",String "Dahinter folgen Ferrari und Red Bull."]),Array (fromList [String "11:27",String "Die Erkenntnisse des 1. Trainings sind: Mercedes ist wie erwartet das Ma\195\159 der Dinge - und McLaren scheint am n\195\164chsten dran zu sein an den Silberpfeilen."]),Array (fromList [String "11:26",String "Alle Teams arbeiten jetzt an der Rennabstimmung."]),Array (fromList [String "11:25",String "Noch 5 Minuten d\195\188rfen die Fahrer Gas geben - ob sich noch etwas im Klassement verschiebt erscheint allerdings fraglich."]),Array (fromList [String "11:24",String "Auch Hamilton dreht in den letzten Minuten dieser Session weitere Testrunden - aber der Brite scheint wie sein Teamkollege Rosberg mit einem schweren Auto unterwegs zu sein."]),Array (fromList [String "11:22",String "Die letzten 10 Minuten laufen - sehen wir noch weitere Verbesserungen?"]),Array (fromList [String "11:19",String "Momentan gibt es noch keine Verbesserungen - weder bei Rosberg noch bei Vettel oder den anderen Top-Piloten, die auf der Strecke sind."]),Array (fromList [String "11:16",String "Kann Rosberg die Zeit von Hamilton knacken?"]),Array (fromList [String "11:15",String "Die letzte Viertelstunde l\195\164uft - Rosberg greift wieder ins Geschehen ein."]),Array (fromList [String "11:15",String "Button, R\195\164ikk\195\182nen und auch H\195\188lkenberg sammeln wieder Testkilometer."]),Array (fromList [String "11:13",String "Daf\195\188r kommt Vettel jetzt zur\195\188ck. Was geht noch beim Weltmeister?"]),Array (fromList [String "11:13",String "Hamilton biegt in die Boxengasse ab, auch Alonso kehrt an seine Garage zur\195\188ck."]),Array (fromList [String "11:12",String "Perez hat sich mit seinen ersten schnellen Runden auf Platz 15 einsortiert."]),Array (fromList [String "11:11",String "Wann kommt die Antwort von Rosberg? Der WM-Spitzenreiter steht in der Box."]),Array (fromList [String "11:10",String "Hamilton verbessert sich um weitere 0,360 Sekunden."]),Array (fromList [String "11:10",String "Und Hamilton legt weiter zu: Bestzeit im 2. Sektor."]),Array (fromList [String "11:08",String "Noch eine Sekunde ist Hamilton von seiner Vorjahresbestzeit im 1. Freien Training entfernt."]),Array (fromList [String "11:07",String "Und Hamilton r\195\188ckt die Verh\195\164ltnisse wieder zurecht, \195\188bernimmt erneut die Spitze."]),Array (fromList [String "11:07",String "Hamilton ist auch wieder unterwegs - Rosberg steht dagegen in der Garage."]),Array (fromList [String "11:06",String "Und auch der Umbau des zweiten Force India ist abgeschlossen, Perez f\195\164hrt aus der Box."]),Array (fromList [String "11:04",String "Dagegen haben es die Force-India-Mechaniker geschafft, das Auto von H\195\188lkenberg wieder fit z bekommen. \'Hulk\' ist wieder auf der Strecke."]),Array (fromList [String "11:03",String "F\195\188r Ricciardo scheint das Training vorbei zu sein. Der Australier steigt aus seinem Auto und zieht den Helm aus."]),Array (fromList [String "11:02",String "Die letzte halbe Stunde des 1. Freien Trainings l\195\164uft."]),Array (fromList [String "11:01",String "Derweil k\195\164mpft der zweite Red-Bull-Pilot, Ricciardo, mit Problemen an seinem Energier\195\188ckgewinnungssystem."]),Array (fromList [String "11:01",String "Vettel ist an die Box zur\195\188ckgekehrt - hat es inzwischen aber doch geschafft, sich an R\195\164ikk\195\182nen vorbei auf Platz 6 zu schieben."]),Array (fromList [String "10:59",String "Button \195\188bernimmt die Spitze."]),Array (fromList [String "10:59",String "Auch in Sektor 2 f\195\164hrt Button Bestzeit - das sollte f\195\188r eine neue Gesamtbestzeit reichen."]),Array (fromList [String "10:58",String "Doch jetzt ist Button sehr schnell unterwegs: Bestzeit in Sektor 1."]),Array (fromList [String "10:58",String "Vielleicht ist Robserg aber auch in den Verkehr gekommen - momentan sind sehr viele Autos auf der Strecke."]),Array (fromList [String "10:57",String "Es reicht nicht - die letzten beiden Sektoren waren zu langsam."]),Array (fromList [String "10:56",String "Rosberg f\195\164hrt pers\195\182nliche Bestzeit in Sektor 1 - reicht das, um an Hamilton vorbei zu kommen?"]),Array (fromList [String "10:55",String "Auch Vettel f\195\164hrt schon mit einem schweren Auto. Der Red-Bull-Pilot steckt auf Platz 7 fest - ist abe rimmerhin schneller als Teamkollege Ricciardo, der nur 15. ist."]),Array (fromList [String "10:52",String "Rosberg und Alonso haben ihre Garagen verlassen."]),Array (fromList [String "10:52",String "Jetzt doch eine kleine Steigerung von R\195\164ikk\195\182nen: Der Finne zieht im Klassement an seinem Teamkollegen Alonso vorbei und schiebt sich auf Platz 5."]),Array (fromList [String "10:51",String "Bei Ferrari scheint man also schon an der Rennsabstimmung zu arbeiten."]),Array (fromList [String "10:50",String "R\195\164ikk\195\182nen hat inzwischen mehrere Runden am St\195\188cl abgespult, ohne sich jedoch zu verbessern."]),Array (fromList [String "10:48",String "Jetzt kommen auch Vettel und Kvyat aus ihren Boxen - jetzt beginnt die Action wieder richtig."]),Array (fromList [String "10:47",String "Vergne und Bianchi erh\195\182hen die Anzahl der Fahrer auf der Strecke auf 5."]),Array (fromList [String "10:46",String "Halbzeit im 1. Training - noch bleiben rund 43 Minuten in der ersten Einheit."]),Array (fromList [String "10:45",String "Am Force India von H\195\188lkenberg gibt es offenbar ein gr\195\182\195\159eres Problem - die Mechaniker haben den Unterboden abgeschraubt."]),Array (fromList [String "10:44",String "Auch Merhi ist wieder auf der Piste."]),Array (fromList [String "10:44",String "Endlich passiert wieder was: Chilton und R\195\164ikk\195\182nen sind auf der Strecke."]),Array (fromList [String "10:43",String "Im vergangenen Jahr fuhr Hamilton in 1:25,5 die Bestzeit in der ersten Trainingseinheit - davon ist der momentan noch rund 1,5 Sekunden entfernt."]),Array (fromList [String "10:41",String "Es wird weiter gewartet. Viele Fahrer sitzen nicht einmal in ihren Autos."]),Array (fromList [String "10:38",String "Perez wird immer noch ohne Runde im Zeitentableau im Klassement aufgef\195\188hrt - denn eigentlich ist Testfahrer Jucadella f\195\188r Force India im Einsatz. Doch momentan wird das Auto f\195\188r Stammpilot Perez umgebaut, der nun in den verbleibenden rund 50 Minuten fahren soll."]),Array (fromList [String "10:34",String "Es hei\195\159t weiter warten - noch immer stehen alle Autos in den Boxen."]),Array (fromList [String "10:31",String "Deshalb ist die Strecke jetzt wieder g\195\164hnend leer."]),Array (fromList [String "10:30",String "Die erste halbe Stunde der ersten Trainingssitzung ist vorbei - alle Fahrer kehren zu ihren Boxen zur\195\188ck. Der zus\195\164tzliche Reifensatz f\195\188r die erste halbe Stunde muss jetzt zur\195\188ckgegeben werden."]),Array (fromList [String "10:29",String "Zum ersten Mal in dieser Einheit f\195\188hren beide Silberpfeile das Klassement an: Hamilton ist derzeit 0,007 Sekunden schneller als Rosberg."]),Array (fromList [String "10:27",String "Offenbar hat die Rennleitung ein Problem: Derzeit kann DRS \195\188berall auf der Strecke eingesetzt werden - das ist nicht im Sinne des Erfinders."]),Array (fromList [String "10:25",String "Magnussen h\195\164lt sich jedoch hartn\195\164ckig an der Spitze. K\195\182nnen die McLaren der Tempo der Silberpfeile tats\195\164chlich mitgehen?"]),Array (fromList [String "10:24",String "Die Antwort folgt sofort: Rosberg verbessert sich wieder auf Platz 2 - Teamkollege Hamilton ist 4."]),Array (fromList [String "10:24",String "Rosberg ist inzwischen etwas nach hinten durchgereicht worden - auch Alonso im Ferrari ist vorbei geschl\195\188pft."]),Array (fromList [String "10:23",String "Von der Red-Bull-Box erfahren wir, dass an beiden Autos das DRS nicht funktioniert."]),Array (fromList [String "10:22",String "Vettels Teamkollege Ricciardo hat bereits eine schnelle Runde absolviert - rangiert aber momentan nur auf Platz 11."]),Array (fromList [String "10:22",String "Vettel kommt auf die Strecke."]),Array (fromList [String "10:21",String "Mit seiner ersten schnellen Runden schiebt sich Rosberg auf Platz 3."]),Array (fromList [String "10:21",String "Massa schiebt sich im Williams hinter Mangunsse auf Platz 2 - dahinter folgen ihre Teamkollegen Button uns Bottas."]),Array (fromList [String "10:20",String "An der Spitze sortieren sich die Mercedes befeuerten Autos ein."]),Array (fromList [String "10:19",String "Weitere Fahrer folgen  - Magnussen im McLaren \195\188bernimmt die Spitze."]),Array (fromList [String "10:18",String "Und wir haben die ersten Rundenzeiten: Nach Chilton markiert Vergne im Toro Rosso die Bestzeit."]),Array (fromList [String "10:17",String "Jetzt wird es voller auf der Piste: 12 Fahrer sind inzwischen unterwegs - darunter auch die Deutschen Rosberg und H\195\188lkenberg."]),Array (fromList [String "10:16",String "Der deutsche Lotterer, der beim vergangenen Rennen in Spa den Caterham fahren durfte, hat auf einen weiteren Einsatz freiwillig verzichtet."]),Array (fromList [String "10:15",String "Merhi f\195\164hrt als Testfahrer die erste Einheit, am Nachmittag wird wider Kobayashi \195\188bernehmen."]),Array (fromList [String "10:14",String "Am Steuer der Caterham sitzen im 1. Training Stammpilot Chilton und Roberto Merhi."]),Array (fromList [String "10:13",String "Die beiden Caterham-Piloten kommen wieder auf die Strecke."]),Array (fromList [String "10:09",String "Alle Piloten sind an die Boxen zur\195\188ckgekehrt - auf der Strecke ist nichts los."]),Array (fromList [String "10:09",String "Die Sonne scheint in Monza, das Thermometer zeigt bereits 21 Grad. Der Asphalt hat sich  allerdings erst auf 25 Grad erhitzt."]),Array (fromList [String "10:06",String "Au\195\159er Force-India-Pilot Sergio Perez waren schon alle Piloten einmal auf der Strecke."]),Array (fromList [String "10:04",String "Die Fahrer absolvieren wie gewohnt zu Beginn des 1. Training ihre Installationsrunden, um die Funktionsf\195\164hkeit ihrer Autos zu \195\188berpr\195\188fen."]),Array (fromList [String "10:02",String "Auf dem Highspeedkurs von Monza sollten wieder die Silberpfeile den Ton angeben. Das 1. Freie Training wird einen ersten Aufschluss dar\195\188ber geben, wer an diesem Wochenende erster Mercedes-J\195\164ger ist."]),Array (fromList [String "10:01",String "Los geht\'s. Das 1. Freie Training hat begonnen - die Strecke ist frei gegeben."]),Array (fromList [String "10:00",String "Werden die beiden wieder aneinander geraten?"]),Array (fromList [String "09:59",String "Nat\195\188rlich schauen nach dem Crash zwischen Nico Rosberg und Lewis Hamilton in Monza wieder alle auf die Silberpfeil-Piloten."]),Array (fromList [String "\160",String "N\195\164chstes Kapitel im Krieg der Sterne? Das 1. Training in Italien startet um 10 Uhr. Nat\195\188rlich wie immer live bei uns im Ticker."])])
        ';
    }

}
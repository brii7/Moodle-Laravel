<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class XMLExportar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

    }

    public function fire(){

        //Inicialitzem variables per a la connexió
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $bdd = 'moodle';

        //connexió a bdd
        $link = mysql_connect($host,$user,$pass);
        mysql_select_db($bdd,$link);

        //Agafem totes les taules
        $query = 'SHOW TABLES FROM '.$bdd;
        $result = mysql_query($query,$link) or die('cannot show tables');
        if(mysql_num_rows($result))
        {
            // Preparem les variables per al document, tab serà una tabulació, br un espai, etc...
            $tab = "\t";
            $br = "\n";
            $xml = '<?xml version="1.0" encoding="UTF-8"?>'.$br;
            $xml.= '<database name="'.$bdd.'">'.$br;

            //Realitzem l'acció per a totes les taules amb un while
            while($table = mysql_fetch_row($result)) {

                //Preparem l'output d'una taula
                $xml.= $tab.'<table name="'.$table[0].'">'.$br;

                //Agafem les files
                $query3 = 'SELECT * FROM '.$table[0];
                $records = mysql_query($query3,$link) or die('cannot select from table: '.$table[0]);

                //Agafem els atributs de la taula
                $attributes = array('name','blob','maxlength','multiple_key','not_null','numeric','primary_key','table','type','default','unique_key','unsigned','zerofill');
                $xml.= $tab.$tab.'<columns>'.$br;
                $x = 0;
                while($x < mysql_num_fields($records))
                {
                    $meta = mysql_fetch_field($records,$x);
                    $xml.= $tab.$tab.$tab.'<column ';
                    foreach($attributes as $attribute)
                    {
                        $xml.= $attribute.'="'.$meta->$attribute.'" ';
                    }
                    $xml.= '/>'.$br;
                    $x++;
                }
                $xml.= $tab.$tab.'</columns>'.$br;

                //Adjuntem a <records> les dades de la taula
                $xml.= $tab.$tab.'<records>'.$br;
                while($record = mysql_fetch_assoc($records))
                {
                    $xml.= $tab.$tab.$tab.'<record>'.$br;
                    foreach($record as $key=>$value)
                    {
                        $xml.= $tab.$tab.$tab.$tab.'<'.$key.'>'.htmlspecialchars(stripslashes($value)).'</'.$key.'>'.$br;
                    }
                    $xml.= $tab.$tab.$tab.'</record>'.$br;
                }
                $xml.= $tab.$tab.'</records>'.$br;
                $xml.= $tab.'</table>'.$br;
            }
            $xml.= '</database>';

            //Guardem el fitxer
            $handle = fopen($bdd.'-backup-'.time().'.xml','w+');
            fwrite($handle,$xml);
            fclose($handle);
        }

    }
}

<?php

class App{
    private $db = NULL;
    private $user = NULL;
//En el constructor creamas las variables necesarias para identificar y conectar a nuestra base de datos
//Con un try catch en caso de no coincidir los datos
    function __construct() {
        $server = "localhost";
        $user = "sebas_db";
        $pass = "BEwqgaF1TW";
        $bd = "sebas_db";


        try {
            $this->db = new PDO("mysql:host=".$server."; dbname=".$bd , $user, $pass );
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage() );
        }

        if ( array_key_exists( 'AUTH', $_COOKIE ) ) {

            $user = json_decode( $_COOKIE[ 'AUTH' ] );
            if ( ! session_id() ) 
            {
                session_start();
            } 
            if( $user ) $this->user = $user;
        }
    }

//function run equivale al sistema de rutas de Laravel, nos regirige a todas las funciones, y estas a sus templates

    public function run(){
        $result = '';


        if ( isset( $_REQUEST ) && !empty( $_REQUEST ) ){
            switch ( $_REQUEST[ 'action' ] ) {

                case 'dashboard': return include( 'templates/dashboard.php' );  break;

                case 'show-customer':   $result = $this->showCustomer(); break;

                case 'search-customer': $result = $this->searchCustomer(); break;

                case 'edit-customer':   
                    $result = $this->editCustomer($_REQUEST['id']); 
                break;              

                case 'update-customer': $result = $this->updateCustomer(); break;
                
                case 'delete-customer': 
                    $result = $this->deleteCustomer($_REQUEST['id']); 
                break;              
                
                case 'show-employee':   
                    $result = $this->showEmployee();
                break;

                case 'search-employee': $result = self::searchEmployee(); break;

                case 'edit-employee': 
                    $result = $this->editEmployee($_REQUEST['id']); 
                break;

                case 'update-employee': $result = $this->updateEmployee(); break;

                case 'delete-employee': 
                    $result = $this->deleteEmployee($_REQUEST['id']);
                break;  

                case 'defaulter': $result = $this->defaulter(); break;

                case 'materials' : $result = $this->materials(); break;

                case 'fisioterapia' : return include( 'templates/info/fisio.php' );  break;

                case 'gimnasio' : return include( 'templates/info/gym.php' );  break;

                case 'piscina' : return include( 'templates/info/pisci.php' );  break;

                case 'salas' : return include( 'templates/info/salas.php' );  break;

                case 'insert-reserve': $result = $this->insertReserve($_POST["instalacion"], $_POST["datetime"], ); break;

                case 'calendario': $result = $this->calendario(); break;

                case 'get-bookings': 
                    $date = null;
                    $instalacion = null;        // se requiere fecha e instalación para hacerla consulta de reservas

                    if ( isset( $_REQUEST['day'] ) ) $date = $_REQUEST['day'];
                    if ( isset( $_REQUEST['instalacion'] ) ) $instalacion = $_REQUEST['instalacion'];
                    
                    $result = $this->getBookings($date, $instalacion ); 
                break;

                case 'login':                   //nos lleva a  fucnction login y antes solicita usuario y contraseña   
                                                //los guarda en una variable que luego transforma en una cookie para evitar entradas falsas                     
                    if ( $this->login($_REQUEST['user'], $_REQUEST['pass'] ) ){
                        $user =  $this->login( $_REQUEST['user'], $_REQUEST['pass'] );

                        if ( $user ) {
                            $result = self::get_template( 'dashboard' );


                            $this->user = $user;
                            $_SESSION["iduser"] = $user['iduser'];
                            setcookie( 'AUTH', json_encode( $user ), time() + 24 * 60 * 60 );

                        } else {                //si no coinciden envía un mensaje de error
                            $result = self::showLogin([
                                'alert' => [
                                    'type' => 'danger',
                                    'msg' => 'Usuario o contraseña incorrectos',
                                ]
                            ]);
                        }

                    } else {
                        $result = self::showLogin([
                            'alert' => [
                                'type' => 'danger',
                                'msg' => 'Usuario o contraseña incorrectos',
                            ]
                        ]);
                    }
                break;
         
                case 'log-off':                 //cerramos sesión eliminamos la cookie       
                    session_start();
                    session_unset();
                    session_destroy();
                    setcookie( time() - 1 );
                    $result = self::showLogin();
                break;

                default:
                    return include( 'templates/dashboard.php' );    
                break;
            }
                   
        } else {
            $result = self::showLogin();

        }

      echo (self::print( $result ));
    }

    public static function showLogin($msg = null){
        return self::get_template( 'login', 'form', $msg );
    }

//          get_template hace un return include para llevarnos al teml¡late necesario, usando login el nombre de ruta y permite incluir una variable
    public static function get_template( $slug, $nombre = "", $attrs = null ) {

        if ($nombre) {
            $slug = "{$slug}-{$nombre}.php";
        } else {
            $slug = "{$slug}.php";
        }

        $slug = rtrim( $slug, '.php' );
        $template = $slug . '.php';

        $file = 'templates/' . $template;

        if ( file_exists( $file ) ) {
        
            if ( $attrs ) extract( $attrs );

            include( $file );
        }

    }
//A partir de aquí sería como el controler de LARAVEL que recoge todas las funciones y métodos que se vayan creando
//showCustomer inicia con un if para confirmar que es empleado
//luego reconoce por dni, isset reconoce que hay variable no nula, lo que nos permite hacer una búsqueda de un usuario concreto
//En caso de no hacerla, es decir, si en $_REQUEST no hay campo 'dni' ejecuta el select y realiza un listado de todos los socios
//la variable $sql recoge la sentencia sql de la base de datos
// en $socios llamamos a la base de datos para que ejecute la consulta y con fetchAll devuelva todos los valores
//asociados a la base de datos (FETCH_ASSOC)   
//luego pasamos la variable al template socios para que la imprima  
//si no cumple el if mandamos un aviso de usuario no autorizado 
    public function showCustomer(){
        if ( $this->user->tipo === 'E' ) {

            $sql = "SELECT * FROM usuario WHERE tipo='S'";
            
            if ( isset( $_REQUEST['dni'] ) ) $sql .= " AND DNI LIKE '".$_REQUEST['dni']."'";

            $sql .=" ORDER by Nombre";
//            file_put_contents( 'test.log', $sql."\n", FILE_APPEND );
            $socios = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
   
            return self::get_template( 'socios/socios', null, [
                'socios' => $socios
            ]);

        }   else {
            echo"Usuario NO Autorizado";
                return self::get_template( 'dashboard' );
            }   
    }

//searchCustomer nos redirige al template pidesocio.php para solicitar el dni que vimos en showCustomer
    public function searchCustomer(){
        return self::get_template( 'socios/pidesocio' , null, []);
    }
        
//editCustomer selecciona el usuario por dni, por eso en la función run hace un $_REQUEST sobre idUser, si no, no lo podría ejecutar
//con el id identificado nos lleva al template editasocio.php, que ejecutará updateCustomer
    public function editCustomer($id){
        $sql = "SELECT * FROM usuario WHERE IdUser = {$id}";
        $socio = $this->db->query( $sql )->fetch( PDO::FETCH_ASSOC );
        return self::get_template( 'socios/editasocio', null, [
            'socio' => $socio       
        ]);
    }

//extract "extraemos" las variables del array creado para imprimirlas en la base de datos
//con print_R la imprimimos y la transformamos en variables que podemos modificar con las ssentencia sql
//luego las ejecutamos en la base de datos
    public function updateCustomer(){
        extract( $_REQUEST );
        print_r($_REQUEST);
        $socio = [
            'IdUser' => $id,
            'DNI' => $dni,          
            'Nombre' => $name,
            'Caso' => $case, 
            'Promo' => $promo,
            'Cuota' => $fee
        ];

        $sql = "UPDATE usuario SET IdUser=:IdUser, DNI=:DNI, Nombre=:Nombre, Caso=:Caso, Promo=:Promo, Cuota=:Cuota WHERE IdUser=:IdUser";
        
        if( $this->db->prepare( $sql )->execute( $socio ) === TRUE ) {
            return self::get_template( 'socios/editasocio', null, [
                'socio' => $socio,
                'alert' => [
                    'type' => 'success',
                    'msg' => 'Cliente actualizado con exito'
                ] 
            ]);
        } else {

            return 'error';
        }
    }

//Es mezcla de show customer y eidtcustomr
//Reconoce al usuario por el id, ejecuta la sentencia sql que registra la variabla $sql y con fetch devuelve el nuevo valor
    public function deleteCustomer($id){
        $sql = "DELETE  FROM usuario WHERE IdUser = {$id}";
        $socios = $this->db->query( $sql )->fetch( PDO::FETCH_ASSOC );
        return $this->showCustomer();
    }

//otro select con condición
    public function defaulter(){
        $sql = "SELECT * FROM pago WHERE deudor = '1'";
        $socios = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
            
            return self::get_template( 'socios/deudores', null, [
                'socios' => $socios
            ]);
    }


    public function showEmployee(){
        
        
        if ( $this->user->tipo === 'E' ) {
            
            $sql = "SELECT * FROM usuario WHERE tipo='E'";

            if ( isset( $_REQUEST['dni'] ) ) $sql .= " AND DNI LIKE '".$_REQUEST['dni']."'";
        
            $sql .=" ORDER by Nombre";
            
            $empleados = $this->db->query( $sql );
            return self::get_template( 'empleados/empleados', null, [
                'empleados' => $empleados
            ]);

        } else {
            echo"Usuario NO Autorizado";
                return self::get_template( 'dashboard' );
            }       
        
    }


    public function searchEmployee(){
        return self::get_template( 'empleados/pidempleado' , null, []);
    }

    public function editEmployee($id){
        $sql = "SELECT * FROM usuario WHERE IdUser = {$id} AND tipo = 'E';";
        $empleados = $this->db->query( $sql )->fetch( PDO::FETCH_ASSOC );
        return self::get_template( 'empleados/editaempleado', null, [
            'empleados' => $empleados       
        ]);
    }

    public function updateEmployee(){
        extract( $_REQUEST );
        $empleado = [
            'IdUser' => $id,
            'Nombre' => $name,
            'DNI' => $dni,
            'Sueldo' => $salary
        ];

        $sql = "UPDATE usuario SET IdUser=:IdUser, DNI=:DNI, Nombre=:Nombre, Sueldo=:Sueldo WHERE IdUser=:IdUser";
        
        if( $this->db->prepare( $sql )->execute( $empleado ) === TRUE ) {
            return self::get_template( 'empleados/editaempleado', null, [
                'empleados' => $empleado,
                'alert' => [
                    'type' => 'success',
                    'msg' => 'Empleado actualizado con exito'
                ] 
            ]);
        } else {
            return 'error';
        }
    }

    public function deleteEmployee($id){
        $sql = "DELETE FROM usuario WHERE IdUser = {$id}";
        $empleados = $this->db->query( $sql )->fetch( PDO::FETCH_ASSOC );
        return $this->showEmployee();
    }

//Es el primer ejemplo de INNER JOIN combinamos dos tablas para mostrar una sentencia conjunta
    public function materials(){
            
        if ( $this->user->tipo === 'E' ) {
            
            $sql= "SELECT instalaciones.Nombre_Instalacion, materiales.nomMaterial, materiales.unidades FROM materiales INNER JOIN instalaciones ON instalaciones.Id_Instalacion=materiales.Id_Instalacion ORDER BY materiales.nomMaterial";
            $materiales = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
            return self::get_template( 'empleados/materiales' , null, [
                'materiales' => $materiales
            ]);

        } else {
            echo"Usuario NO Autorizado";
                return self::get_template( 'dashboard' );
            }             
    }



    public function insertReserve( $instalacion, $start ){
        if ( $instalacion && $start && $this->user ){
            $sql = "INSERT INTO reservas SET Id_Instalacion=:instalacion, start=:start, IdUser=:iduser";
            $arrayinsert =
            [
                "instalacion" => $instalacion,
                "start" => $start,
                "iduser" => $_SESSION['iduser']
            ];
            $reservas = $this->db->prepare( $sql )->execute($arrayinsert);
//            file_put_contents( 'test.log', $sql."\n", FILE_APPEND );
            
            echo true;

        } else {

            echo false;
        }
    }

//calendario nos lleva al template del mimso nombre y da la referencia de las instalaciones guardadas en la base de datos, que parecen en un select

    public function calendario( ){
            $sql = "SELECT Id_Instalacion, Nombre_Instalacion FROM instalaciones";
            $instalaciones = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
            return self::get_template( 'reservas/calendario' , null, [
                'instalaciones' => $instalaciones
            ]);      
    }


//getBookings parte de la variable date e instalacion como null, para cubrirla después en la jquery
//crea la sentencia jquery que hace que se imprima en el calendario las reservas de la base de datos
//comprueba que hay dato reservas e instalación, para dejar las horas libres   
    public function getBookings( $date=null, $instalacion=null ) {    
        $sql = "SELECT reservas.Id_Reservas as 'id', instalaciones.Nombre_Instalacion as 'instalacion', usuario.Nombre as 'usuario', reservas.start as 'init' FROM reservas INNER JOIN usuario ON usuario.IdUser=reservas.IdUser inner JOIN instalaciones ON instalaciones.Id_Instalacion=reservas.Id_Instalacion ";
     
        if ( $date || $instalacion ) { 

            $temp = ''; 

            if ( $date ) $temp .= "WHERE date(reservas.start) = '{$date}' ";

            if ( $instalacion ) {
                if ( strlen( $temp ) === 0 ) { 
                    $temp .= ' WHERE ';
                } else {
                    $temp .= ' AND ';
                }

                $temp .= " instalaciones.Id_Instalacion = {$instalacion}";
            }

            $sql .= $temp;
        }
        


//        file_put_contents( 'test.log', $sql."\n", FILE_APPEND );
// Recogemos las cuatro isntalaciones y les damos un color que pasa por el jquery para recogerlas en calendario.php
//$bookingsList crea un array con los datos que va a necesitar fullcalendar     
 //y procedemos a codificarlos   
        $bookings = $this->db->query( $sql )->fetchAll( PDO::FETCH_ASSOC );
        $bookingsList = [];
        foreach( $bookings as $booking ){
            
            switch( $booking['instalacion'] ){
                case 'Fisio': 
                    $letter = '#000000';
                    $background = '#FFF000';
                    break;
                case 'Gym': 
                    $letter = '#000000';
                    $background = '#F3DAAE';
                    break;      
                case 'Pisci': 
                    $letter = '#000000';
                    $background = '#AEEEF3';
                    break;  
                case 'Sala': 
                    $letter = '#000000';
                    $background = '#E7CEF2';
                    break;                                                                                  
                default:
                    $letter = '#000000';
                    $background = '#FFFFFF';
                    
            }
       
            $bookingsList[] = [
                'id' => $booking['id'],
                'title' => 'Reservado',
                'className' => $booking['instalacion'],
                'start'=> $booking['init'],
                'end' => date( 'Y-m-d H:i', strtotime( '+1hour', strtotime( $booking['init'] ) ) ),
                'allDay' => false,
                'color' => $background,
                'textColor' => $letter,
                'horaEntrada' => date( 'H', strtotime( $booking['init'] ) )
            ];
        
        }
        return json_encode( $bookingsList );
    }

//login recoge los datos que corresponden a las variables usuario y contraseña
//No hago SELECT *, introduzco todos los campos menos contraseña
    public function login( $user, $pass) {
        $sql = "SELECT usuario.iduser, usuario.usuario, usuario.tipo, usuario.DNI, usuario.Nombre, usuario.Caso, usuario.Cuota, usuario.Promo, usuario.Sueldo FROM usuario WHERE usuario LIKE '{$user}' AND password LIKE '{$pass}';";
        $query = $this->db->query( $sql )->fetch( PDO::FETCH_ASSOC );        
        if ( is_array( $query ) && !empty( $query ) ) return $query;        
        return false;
    }


//ob_start(); da la salida al buffer interno para poder acumular la información antes de enviar al cliente
//borramos el buffer acumulado con ob_get_clean();
    public static function print($content) {
        ob_start();
        
        echo $content;

        return ob_get_clean();

    }
}
<?php
    //mysql connection
    require_once('models/mysqlconnection.php');
    //exception
    require_once('models/recordnotfoundexception.php');

    class Station {
        //attributes
        private $id;
        private $temperature;
        private $humidity;
        private $weatherData;
    

        //getters and setters
        public function getId(){return $this->id;}
        public function setId($value){$this->id = $value;}
        public function getTemperature(){return $this->temperature;}
        public function setTemperature($value){$this->temperature = $value;}
         public function getHumidity(){return $this->humidity;}
        public function setHumidity($value){$this->humidity = $value;}
         public function getWeatherData(){return $this->weatherData;}
        public function setWeatherData($value){$this->weatherData = $value;}


        //method
        public static function getData() {
            //arrays for the weather data
            $list = array();
            //get connection with data base
            $connection = MySqlConnection::getConnection();
            //query
            $query = 'select id, temperature, humidity, weatherData from sensordata where id=?';
            //command
            $command = $connection->prepare($query);
            //execute
            $command->execute();
            //bind
            $command->bind_result($id,$temperature,$humidity,$weatherData);
            //fetch data (get)
            while($command->fetch()){
                array_push($list,new Station($id,$temperature,$humidity,$weatherData));
            }
            //close command
            mysql_stmt_close($command);
            //close connection
            $connection->close();
            //return list
            return $list;
        }
        
        //JSON format
        public static function getAlltoJson(){
            $list = array();
            foreach($_self::getAll() as $item){
                array_push($list, json_decode($item->toJson()));
            }
            return $list;
        }
        //constructor
        function _construct(){
            if(func_num_args() == 0){
                //empty objects
                $this->id = '';
                $this->temperature = '';
                $this->humidity = '';
                $this->weatherData = '';
            }
            if(func_num_args() == 1){
                //conecction
                $connection = MySqlConnection::getConnection();
                //query
                $query = 'select id, temperature, humidity, weatherData from sensordata where id=?';
                //prepare command
                $command = $command->prepare($query);
                //bind parameters
                $command->bind_param('s',func_get_arg(0));
                 //execute
                 $command->execute();
                 //bind result
                 $command->bind_result($this->id, $this->temperature, $this->humidity,$this->weatherData);
                 //fetch data (get)
                 $found = $command->fetch();
                 //close command
                 mysql_stmt_close($command);
                 //close connection
                 $connection->close();
                 //throw exception if record not found 
                 if(!$found) throw new RecordNotFoundException(func_get_arg(0));
            }
            //object with data
            if(func_num_args() == 2){
                $this->id = func_get_arg(0);
                $this->temperature = func_get_arg(1); 
                $this->humidity = func_get_arg(2);
                $this->weatherData = func_get_arg(3);
            }
        }
        //represent the object in JSON format
        public function toJson(){
            return json_encode(array('id' => $this->id,
             'temperature' => $this->temperature,
             'humidity' => $this->humidity,
             'weatherData' => $this->weatherData));
        }
    }
?>
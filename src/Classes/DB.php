<?php
namespace App\Classes;
use mysqli;
class DB
{
    private $link = null;
    public $filter;
    static $inst = null;
    public static $counter = 0;
     
    public function log_db_errors( $error, $query )
    {
        if (substr($error, 0,15) != 'Duplicate entry') {
            $message = '<p>Error at '. date('Y-m-d H:i:s').':</p>';
            $message .= '<p>Query: '. htmlentities( $query ).'<br />';
            $message .= 'Error: ' . $error;
            $message .= '</p>';
            echo $message; 
            if( defined( 'SEND_ERRORS_TO' ) )
            {
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'To: Admin <'.SEND_ERRORS_TO.'>' . "\r\n";
                $headers .= 'From: Yoursite <system@'.$_SERVER['SERVER_NAME'].'.com>' . "\r\n";

                mail( SEND_ERRORS_TO, 'Database Error', $message, $headers );   
            }
            else
            {
                trigger_error( $message );
            }

            if( !defined( 'DISPLAY_DEBUG' ) || ( defined( 'DISPLAY_DEBUG' ) && DISPLAY_DEBUG ) )
            {
                echo $message;   
            }
        }
    }
    
    public function getIp(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
        else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else $ip = $_SERVER['REMOTE_ADDR'];
        return $ip;
    }
    public function logdata($tipo,$tabela,$usuarioID,$username,$sqlacao,$logdataID,$dadosAntigos=[],$mensagem=''){
        if ($mensagem == '') {
            switch ($tipo) {
                case '1':
                    $mensagem = 'Usuário ' . $username . ' entrou no sistema';
                    break;
                case '2':
                    $mensagem = 'Usuário ' . $username . ' cadastrou em "' . $tabela . '" #' . $logdataID;
                    break;
                case '3':
                    $mensagem = 'Usuário ' . $username . ' excluiu em "' . $tabela . '" #' . $logdataID;
                    break;
                case '4':
                    $mensagem = 'Usuário ' . $username . ' editou em "' . $tabela . '" #' . $logdataID;
                    break;
                case '5':
                    $mensagem = 'Usuário ' . $username . ' pesquisou em "' . $tabela . '" #' . $logdataID;
                    break;
                case '6':
                    $mensagem = 'Usuário ' . $username . ' saiu do sistema';
                    break;
                
                default:
                    $mensagem = '';
                    break;
            }
        }
        $newLog = array(
            'ipAcesso'      => $this->getIp(),
            'dataHora'      => date('Y-m-d H:i:s'),
            'usuarioID'     => $usuarioID,
            'acaoLogID'     => $tipo,
            'tabelaAcao'    => $tabela,
            'mensagem'      => $mensagem,
            'sqlAcao'       => json_encode( $this->escape($sqlacao) ),
            'dadosAntigos'  => json_encode( $dadosAntigos )
        );
        if( $this->insert('log',$newLog) )return true;
        return false;
    }
    public function __construct($db_host_,$db_user_, $db_pass_, $db_name_ )
    {
        mb_internal_encoding( 'UTF-8' );
        mb_regex_encoding( 'UTF-8' );
        mysqli_report( MYSQLI_REPORT_STRICT );
        try {
            $this->link = new mysqli( $db_host_, $db_user_, $db_pass_, $db_name_ );
            $this->link->set_charset( "utf8" );
        } catch ( Exception $e ) {
            die( 'Unable to connect to database' . $e );
        }
    }

    public function __destruct()
    {
        if( $this->link)
        {
            $this->disconnect();
        }
    }
 
     public function filter( $data )
     {
         if( !is_array( $data ) )
         {
             $data = $this->link->real_escape_string( $data );
             $data = trim( htmlentities( $data, ENT_QUOTES, 'UTF-8', false ) );
         }
         else
         {
             //Self call function to sanitize array data
             $data = array_map( array( $this, 'filter' ), $data );
         }
         return $data;
     }
     
      
     public function escape( $data )
     {
         if( !is_array( $data ) )
         {
             $data = $this->link->real_escape_string( $data );
         }
         else
         {
             //Self call function to sanitize array data
             $data = array_map( array( $this, 'escape' ), $data );
         }
         return $data;
     }
     
     public function clean( $data )
     {
         $data = stripslashes( $data );
         $data = html_entity_decode( $data, ENT_QUOTES, 'UTF-8' );
         $data = nl2br( $data );
         $data = urldecode( $data );
         return $data;
     }
     
    public function db_common( $value = '' )
    {
        if( is_array( $value ) )
        {
            foreach( $value as $v )
            {
                if( preg_match( '/AES_DECRYPT/i', $v ) || preg_match( '/AES_ENCRYPT/i', $v ) || preg_match( '/now()/i', $v ) )
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
        else
        {
            if( preg_match( '/AES_DECRYPT/i', $value ) || preg_match( '/AES_ENCRYPT/i', $value ) || preg_match( '/now()/i', $value ) )
            {
                return true;
            }
        }
    }
    
    
    /**
     * Perform queries
     * All following functions run through this function
     *
     * @access public
     * @param string
     * @return string
     * @return array
     * @return bool
     *
     */
    public function query( $query )
    {
        $full_query = $this->link->query( $query );
        if( $this->link->error )
        {
            $this->log_db_errors( $this->link->error, $query );
            return false; 
        }
        else
        {
            return true;
        }
    }
    
    
    /**
     * Determine if database table exists
     * Example usage:
     * if( !$database->table_exists( 'checkingfortable' ) )
     * {
     *      //Install your table or throw error
     * }
     *
     * @access public
     * @param string
     * @return bool
     *
     */
     public function table_exists( $name )
     {
         self::$counter++;
         $check = $this->link->query( "SELECT 1 FROM $name" );
         if($check !== false)
         {
             if( $check->num_rows > 0 )
             {
                 return true;
             }
             else
             {
                 return false;
             }
         }
         else
         {
             return false;
         }
     }
    
    
    /**
     * Count number of rows found matching a specific query
     *
     * Example usage:
     * $rows = $database->num_rows( "SELECT id FROM users WHERE user_id = 44" );
     *
     * @access public
     * @param string
     * @return int
     *
     */
    public function num_rows( $query )
    {
        self::$counter++;
        $num_rows = $this->link->query( $query );
        if( $this->link->error )
        {
            $this->log_db_errors( $this->link->error, $query );
            return $this->link->error;
        }
        else
        {
            return $num_rows->num_rows;
        }
    } 
    public function exists( $table = '', $check_val = '', $params = array() )
    {
        self::$counter++;
        if( empty($table) || empty($check_val) || empty($params) )
        {
            return false;
        }
        $check = array();
        foreach( $params as $field => $value )
        {
            if( !empty( $field ) && !empty( $value ) )
            {
                //Check for frequently used mysql commands and prevent encapsulation of them
                if( $this->db_common( $value ) )
                {
                    $check[] = "$field = $value";   
                }
                else
                {
                    $check[] = "$field = '$value'";   
                }
            }

        }
        $check = implode(' AND ', $check);

        $rs_check = "SELECT $check_val FROM ".$table." WHERE $check";
        $number = $this->num_rows( $rs_check );
        if( $number === 0 )
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    
    /**
     * Return specific row based on db query
     *
     * Example usage:
     * list( $name, $email ) = $database->get_row( "SELECT name, email FROM users WHERE user_id = 44" );
     *
     * @access public
     * @param string
     * @param bool $object (true returns results as objects)
     * @return array
     *
     */
    public function get_row( $query, $object = false )
    {
        self::$counter++;
        $row = $this->link->query( $query );
        if( $this->link->error )
        {
            $this->log_db_errors( $this->link->error, $query );
            return false;
        }
        else
        {
            $r = ( !$object ) ? $row->fetch_row() : $row->fetch_object();
            return $r;   
        }
    }
    
    
    /**
     * Perform query to retrieve array of associated results
     *
     * Example usage:
     * $users = $database->get_results( "SELECT name, email FROM users ORDER BY name ASC" );
     * foreach( $users as $user )
     * {
     *      echo $user['name'] . ': '. $user['email'] .'<br />';
     * }
     *
     * @access public
     * @param string
     * @param bool $object (true returns object)
     * @return array
     *
     */
    public function get_results( $query, $object = false )
    {
        self::$counter++;
        //Overwrite the $row var to null
        $row = null;
        
        $results = $this->link->query( $query );
        if( $this->link->error )
        {
            $this->log_db_errors( $this->link->error, $query );
            return false;
        }
        else
        {
            $row = array();
            while( $r = ( !$object ) ? $results->fetch_assoc() : $results->fetch_object() )
            {
                $row[] = $r;
            }
            return $row;   
        }
    }
    
    
    /**
     * Insert data into database table
     *
     * Example usage:
     * $user_data = array(
     *      'name' => 'Bennett', 
     *      'email' => 'email@address.com', 
     *      'active' => 1
     * );
     * $database->insert( 'users_table', $user_data );
     *
     * @access public
     * @param string table name
     * @param array table column => column value
     * @return bool
     *
     */
    public function insert( $table, $variables = array() )
    {
        self::$counter++;
        //Make sure the array isn't empty
        if( empty( $variables ) )
        {
            return false;
        }
        
        $sql = "INSERT INTO ". $table;
        $fields = array();
        $values = array();
        foreach( $variables as $field => $value )
        {
            $fields[] = $field;
            if ($value != 'null') $values[] = "'".$value."'";
            else $values[] = "null";
        }
        $fields = ' (' . implode(', ', $fields) . ')';
        $values = '('. implode(', ', $values) .')';
        
        $sql .= $fields .' VALUES '. $values;

        $query = $this->link->query( $sql );
        
        if( $this->link->error )
        {
            //return false; 
            $this->log_db_errors( $this->link->error, $sql );
            return false;
        }
        else
        {
            return true;
        }
    }
     
    public function insert_safe( $table, $variables = array() )
    {
        self::$counter++;
        //Make sure the array isn't empty
        if( empty( $variables ) )
        {
            return false;
        }
        
        $sql = "INSERT INTO ". $table;
        $fields = array();
        $values = array();
        foreach( $variables as $field => $value )
        {
            $fields[] = $this->filter( $field );
            //Check for frequently used mysql commands and prevent encapsulation of them
            $values[] = $value; 
        }
        $fields = ' (' . implode(', ', $fields) . ')';
        $values = '('. implode(', ', $values) .')';
        
        $sql .= $fields .' VALUES '. $values;
        $query = $this->link->query( $sql );
        
        if( $this->link->error )
        {
            $this->log_db_errors( $this->link->error, $sql );
            return false;
        }
        else
        {
            return true;
        }
    }
    
    
    /**
     * Insert multiple records in a single query into a database table
     *
     * Example usage:
     * $fields = array(
     *      'name', 
     *      'email', 
     *      'active'
     *  );
     *  $records = array(
     *     array(
     *          'Bennett', 'bennett@email.com', 1
     *      ), 
     *      array(
     *          'Lori', 'lori@email.com', 0
     *      ), 
     *      array(
     *          'Nick', 'nick@nick.com', 1, 'This will not be added'
     *      ), 
     *      array(
     *          'Meghan', 'meghan@email.com', 1
     *      )
     * );
     *  $database->insert_multi( 'users_table', $fields, $records );
     *
     * @access public
     * @param string table name
     * @param array table columns
     * @param nested array records
     * @return bool
     * @return int number of records inserted
     *
     */
    public function insert_multi( $table, $columns = array(), $records = array() )
    {
        self::$counter++;
        //Make sure the arrays aren't empty
        if( empty( $columns ) || empty( $records ) )
        {
            return false;
        }

        //Count the number of fields to ensure insertion statements do not exceed the same num
        $number_columns = count( $columns );

        //Start a counter for the rows
        $added = 0;

        //Start the query
        $sql = "INSERT INTO ". $table;

        $fields = array();
        //Loop through the columns for insertion preparation
        foreach( $columns as $field )
        {
            $fields[] = '`'.$field.'`';
        }
        $fields = ' (' . implode(', ', $fields) . ')';

        //Loop through the records to insert
        $values = array();
        foreach( $records as $record )
        {
            //Only add a record if the values match the number of columns
            if( count( $record ) == $number_columns )
            {
                $values[] = '(\''. implode( '\', \'', array_values( $record ) ) .'\')';
                $added++;
            }
        }
        $values = implode( ', ', $values );

        $sql .= $fields .' VALUES '. $values;

        $query = $this->link->query( $sql );

        if( $this->link->error )
        {
            $this->log_db_errors( $this->link->error, $sql );
            return false;
        }
        else
        {
            return $added;
        }
    }
    
    
    /**
     * Update data in database table
     *
     * Example usage:
     * $update = array( 'name' => 'Not bennett', 'email' => 'someotheremail@email.com' );
     * $update_where = array( 'user_id' => 44, 'name' => 'Bennett' );
     * $database->update( 'users_table', $update, $update_where, 1 );
     *
     * @access public
     * @param string table name
     * @param array values to update table column => column value
     * @param array where parameters table column => column value
     * @param int limit
     * @return bool
     *
     */
    public function update( $table, $variables = array(), $where = array(), $limit = '' )
    {
        self::$counter++;
        //Make sure the required data is passed before continuing
        //This does not include the $where variable as (though infrequently)
        //queries are designated to update entire tables
        if( empty( $variables ) )
        {
            return false;
        }
        $sql = "UPDATE ". $table ." SET ";
        foreach( $variables as $field => $value )
        {
            if ($value != 'null') {
                $updates[] = "`$field` = '$value'";
            }
            else $updates[] = "`$field` = NULL";
        }
        $sql .= implode(', ', $updates);
        if( !empty( $where ) )
        {
            foreach( $where as $field => $value )
            {
                $value = $value;
                if ($value != 'null') {
                    $clause[] = "$field = '$value'";
                }
                else $clause[] = "$field = NULL";
            }
            $sql .= ' WHERE '. implode(' AND ', $clause);   
        }
        
        if( !empty( $limit ) )
        {
            $sql .= ' LIMIT '. $limit;
        }

        $query = $this->link->query( $sql );

        if( $this->link->error )
        {
            $this->log_db_errors( $this->link->error, $sql );
            return false;
        }
        else
        {
            return true;
        }
    }
    
    
    /**
     * Delete data from table
     *
     * Example usage:
     * $where = array( 'user_id' => 44, 'email' => 'someotheremail@email.com' );
     * $database->delete( 'users_table', $where, 1 );
     *
     * @access public
     * @param string table name
     * @param array where parameters table column => column value
     * @param int max number of rows to remove.
     * @return bool
     *
     */
    public function delete( $table, $where = array(), $limit = '' )
    {
        self::$counter++;
        //Delete clauses require a where param, otherwise use "truncate"
        if( empty( $where ) )
        {
            return false;
        }
        
        $sql = "DELETE FROM ". $table;
        foreach( $where as $field => $value )
        {
            $value = $value;
            $clause[] = "$field = '$value'";
        }
        $sql .= " WHERE ". implode(' AND ', $clause);
        
        if( !empty( $limit ) )
        {
            $sql .= " LIMIT ". $limit;
        }
            
        $query = $this->link->query( $sql );

        if( $this->link->error )
        {
            //return false; //
            $this->log_db_errors( $this->link->error, $sql );
            return false;
        }
        else
        {
            return true;
        }
    }
     
    public function lastid()
    {
        self::$counter++;
        return $this->link->insert_id;
    }
     
    public function affected()
    {
        return $this->link->affected_rows;
    }
     
    public function num_fields( $query )
    {
        self::$counter++;
        $query = $this->link->query( $query );
        $fields = $query->field_count;
        return $fields;
    } 
    public function list_fields( $query )
    {
        self::$counter++;
        $query = $this->link->query( $query );
        $listed_fields = $query->fetch_fields();
        return $listed_fields;
    }
     
    public function truncate( $tables = array() )
    {
        if( !empty( $tables ) )
        {
            $truncated = 0;
            foreach( $tables as $table )
            {
                $truncate = "TRUNCATE TABLE `".trim($table)."`";
                $this->link->query( $truncate );
                if( !$this->link->error )
                {
                    $truncated++;
                    self::$counter++;
                }
            }
            return $truncated;
        }
    }
     
    public function display( $variable, $echo = true )
    {
        $out = '';
        if( !is_array( $variable ) )
        {
            $out .= $variable;
        }
        else
        {
            $out .= '<pre>';
            $out .= print_r( $variable, TRUE );
            $out .= '</pre>';
        }
        if( $echo === true )
        {
            echo $out;
        }
        else
        {
            return $out;
        }
    }
    
     
    public function total_queries()
    {
        return self::$counter;
    }
    
     
    static function getInstance()
    {
        if( self::$inst == null )
        {
            self::$inst = new DB();
        }
        return self::$inst;
    }
    
     
    public function disconnect()
    {
        $this->link->close();
    }


} //end class DB
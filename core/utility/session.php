<?php
/**
 * Session Helper Class
 *
 * A simple session wrapper class.
 *
 * Usage Example:
 * <?php
 * Session::w('foo', 'bar');
 * 
 * echo Session::r('foo');
 * ?>
 *
 * Copyright (c) 2013 Robert Dunham
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @remarks A simple session wrapper class.
 * @author contact@robdunham.info
 * @website http://www.robdunham.info
 * @version 1.0.1
 * @date 20130423
 * @copyright Copyright (c) 2013, Robert Dunham
 */
 
 
//include_once 'CustomException.php';
//if ( !class_exists('CustomException') ) {
 //   class CustomException extends Exception {}
//}
//class SessionHandlerException extends CustomException {}
//class SessionDisabledException extends SessionHandlerException {}
//class InvalidArgumentTypeException extends SessionHandlerException {}
//defined('CHECK_ACCESS') or die('Direct access is not allowed.');
class session
{
    /**
     * Writes a value to the current session data.
     * @param string $key String identifier.
     * @param mixed $value Single value or array of values to be written.
     * @return void
     */
    public static function write($key, $value)
    {
        if ( !is_string($key) )
            throw new InvalidArgumentTypeException('Session key must be string value');
        self::_init();
        $_SESSION[$key] = $value;
    }
    
    /**
     * Alias for Session::write.
     * @param string $key String identifier.
     * @param mixed $value Single value or array of values to be written.
     * @return void
     */
    public static function w($key, $value)
    {
        self::write($key, $value);
    }
    
    /**
     * Reads a specific value from the current session data.
     * @param string $key String identifier.
     * @param boolean $child Optional child identifier for accessing array elements.
     * @return mixed Returns a string value upon success.  Returns false upon failure.
     */
    public static function read($key, $child = false)
    {
        if ( !is_string($key) )
            throw new InvalidArgumentTypeException('Session key must be string value');
        //self::_init();
        if (isset($_SESSION[$key]))
        {
            if (false == $child)
            {
                return $_SESSION[$key];
            }
            else
            {
                if (isset($_SESSION[$key][$child]))
                {
                    return $_SESSION[$key][$child];
                }
            }
        }
        return false;
    }
    
    /**
     * Alias for Session::read.
     * @param string $key String identifier.
     * @param boolean $child Optional child identifier for accessing array elements.
     * @return mixed Returns a string value upon success.  Returns false upon failure.
     */
    public static function r($key, $child = false)
    {
        return self::read($key, $child);
    }
    
    /**
     * Echos current session data.
     * @return void
     */
    public static function dump()
    {
    	//commented line below because it was causing a headers output problem
        //self::_init();
        echo nl2br(print_r($_SESSION));
    }
    /**
     * Starts or resumes a session.
     * @return boolean Returns true upon success and false upon failure.
     */
    public static function start()
    {
        // this function is extraneous
        return self::_init();
    }
    
    /**
     * Returns current session cookie parameters or an empty array.
     * @return array Associative array of session cookie parameters.
     */
    public static function params()
    {
        $r = array();
        if ( '' !== session_id() )
        {
            $r = session_get_cookie_params();
        }
        return $r;
    }
    
   
    
    /**
     * Closes the current session and releases session file lock.
     * @return boolean Returns true upon success and false upon failure.
     */
    public static function commit()
    {
        if ( '' !== session_id() )
        {
        	
            return session_write_close();
        }
			
		return true;
    }
    
    /**
     * Removes session data and destroys the current session.
     * @return void
     */
    public static function destroy()
    {
        // TODO: remove reference to init() and instead check for valid session
        self::_init();
        $_SESSION = array();
        
        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
    }
    
    /**
     * Initializes a new session or resumes an existing session.
     * @return boolean Returns true upon success and false upon failure.
     */
    private static function _init()
    {
        if (session_status() == PHP_SESSION_DISABLED)
            throw new SessionDisabledException();
        
        if ( '' === session_id() )
        {
            return session_start();
        }
        // Helps prevent hijacking by resetting the session ID at every request.
        // Might cause unnecessary file I/O overhead?
        // TODO: create config variable to control regenerate ID behavior
        return session_regenerate_id(true);
		
		
		
    }
	
	public function isLoggedIn(){
		return $this->read('isLoggedIn');
	}
	
	public function SetConnection(PDO $connx){
		//if(is_a($connx,"PDO")){	$this->connx = $connx;}
	}
	
}
?>
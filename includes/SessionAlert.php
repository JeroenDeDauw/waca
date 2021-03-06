<?php
if (!defined("ACC")) {
    die();
} // Invalid entry point

class SessionAlert
{
    private $message;
    private $title;
    private $type;
    private $closable;
    private $block;
    
    public function __construct($message, $title, $type = "alert-info", $closable = true, $block = true)
    {
        $this->message = $message;
        $this->title = $title;
        $this->type = $type;
        $this->closable = $closable;
        $this->block = $block;
    }
    
    public function getAlertBox()
    {
        return BootstrapSkin::displayAlertBox($this->message, $this->type, $this->title, $this->block, $this->closable, true);
    }
    
    /**
     * Shows a quick one-liner message
     * @param SessionAlert $alert 
     */
    public static function quick($message, $type = "alert-info")
    {
        SessionAlert::append(new SessionAlert($message, "", $type, true, false));
    }
    
    public static function success($message)
    {
        SessionAlert::append(new SessionAlert($message, "", "alert-success", true, true));
    }
    
    public static function warning($message, $title = "Warning!")
    {
        SessionAlert::append(new SessionAlert($message, $title, "alert-warning", true, true));
    }
    
    public static function error($message, $title = "Error!")
    {
        SessionAlert::append(new SessionAlert($message, $title, "alert-error", true, true));
    }

    
    public static function append(SessionAlert $alert)
    {
        $data = array();
        if( isset($_SESSION['alerts']) )
        {
            $data = $_SESSION['alerts'];
        }
        
        $data[] = serialize( $alert );
        
        $_SESSION['alerts'] = $data;
    }
    
    public static function retrieve()
    {
        $block = array();
        if(isset($_SESSION['alerts'])) 
        {
            foreach($_SESSION['alerts'] as $a)
            {
                $block[] = unserialize($a);
            }
        }
        
        $_SESSION['alerts'] = array();
        
        return $block;
    }
}

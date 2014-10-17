<?hh // strict

namespace Mkjp\Rx;

use Mkjp\Rx\Scheduler\Scheduler;
use Mkjp\Rx\Scheduler\EventLoop;


final class Schedulers {
    private static ?Scheduler $default = null;
    
    /**
     * Gets the default scheduler instance
     */
    public static function getDefault(): Scheduler {
        if( self::$default === null ) self::$default = new EventLoop();
        return self::$default;
    }
    
    /**
     * Sets the global default scheduler instance
     */
    public static function setDefault(Scheduler $default): void {
        self::$default = $default;
    }
}

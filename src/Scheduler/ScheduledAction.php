<?hh // strict

namespace Mkjp\Rx\Scheduler;

use Mkjp\Rx\Cancelable\Cancelable;


class ScheduledAction implements Cancelable {
    private float $lastExecuted = 0.0;
    private bool $cancelled = false;
    
    
    public function __construct(private (function(): void) $action,
                                private float $interval, private int $times) {
        $this->lastExecuted = microtime(true);
    }
    
    public function cancel(): void {
        $this->cancelled = true;
    }
    
    /**
     * Executes the scheduled action
     */
    public function execute(): bool {
        // If we have been cancelled, we do nothing and we don't want to be rescheduled
        if( $this->cancelled ) return false;
        
        // If we have been executed enough times already, we don't do anything and
        // we don't want to be rescheduled
        // NOTE that if times < 0, that means run forever, so we specifically check
        //      for times = 0
        if( $this->times === 0 ) return false;
        
        // If the time since we were last executed is > our interval, execute the
        // action
        $time = microtime(true);
        if( $time - $this->lastExecuted >= $this->interval ) {
            call_user_func($this->action);
            $this->lastExecuted = $time;
            $this->times--;
        }
        
        // We want to be rescheduled as long as times is not 0
        // Remember, an initial times of < 0 means run forever
        return $this->times !== 0;
    }
    
    public function isCancelled(): bool {
        return $this->cancelled;
    }
}

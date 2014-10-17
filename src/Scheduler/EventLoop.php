<?hh // strict

namespace Mkjp\Rx\Scheduler;

use Mkjp\Rx\Cancelable\Cancelable;


/**
 * Scheduler class that uses an event loop to run actions
 */
class EventLoop implements Scheduler {
    private Vector<ScheduledAction> $actions = Vector {};
    
    public function schedule((function(): void) $action, float $interval, int $times): Cancelable {
        $scheduled = new ScheduledAction($action, $interval, $times);
        $this->actions[] = $scheduled;
        return $scheduled;
    }
    
    public async function run(): \Awaitable<void> {
        for( ;; ) {
            // Yield control, but ask to be resumed
            await \RescheduleWaitHandle::create(0, 0);
            
            // Execute each scheduled action
            // The return value tells us if it wants to be rescheduled
            $nextActions = Vector { };
            foreach( $this->actions as $action ) {
                if( $action->execute() ) $nextActions[] = $action;
            }
            $this->actions = $nextActions;
        }
    }
}

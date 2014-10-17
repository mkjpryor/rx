<?hh // strict

namespace Mkjp\Rx\Scheduler;

use Mkjp\Rx\Cancelable\Cancelable;


/**
 * Interface for an object that can schedule actions to be run in the future
 */
interface Scheduler {
    /**
     * Schedules an action to be run a number of times at the given interval
     * 
     * If times is negative, the action is run at the given interval forever
     * 
     * The returned cancelable can be used to stop the action running
     */
    public function schedule((function(): void) $action, float $interval, int $times): Cancelable;
    
    /**
     * Runs the scheduler
     * 
     * Returns an awaitable that can be awaited along with other awaitables
     */
    public function run(): \Awaitable<void>;
}

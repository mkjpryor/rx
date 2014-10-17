<?hh // strict

namespace Mkjp\Rx\Cancelable;


/**
 * Interface for an object that can be cancelled
 */
interface Cancelable {
    /**
     * Cancel the object
     */
    public function cancel(): void;
    
    /**
     * Indicates if the object has been cancelled yet
     */
    public function isCancelled(): bool;
}

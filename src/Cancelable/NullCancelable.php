<?hh // strict

namespace Mkjp\Rx\Cancelable;


/**
 * Cancelable that does nothing other than enter the cancelled state when cancelled
 */
class NullCancelable implements Cancelable {
    private bool $cancelled = false;
    
    public function cancel(): void {
        $this->cancelled = true;
    }
    
    public function isCancelled(): bool {
        return $this->cancelled;
    }
}

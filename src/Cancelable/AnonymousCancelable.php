<?hh // strict

namespace Mkjp\Rx\Cancelable;


/**
 * Cancelable whose cancellation logic is given using a callback
 */
class AnonymousCancelable implements Cancelable {
    private bool $cancelled = false;
    
    public function __construct(private (function(): void) $onCancelled) { }
    
    public function cancel(): void {
        if( $this->cancelled ) return;
        
        $this->cancelled = true;
        call_user_func($this->onCancelled);
    }
    
    public function isCancelled(): bool {
        return $this->cancelled;
    }
}

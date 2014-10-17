<?hh // strict

namespace Mkjp\Rx\Observable;
                             
use Mkjp\Rx\Cancelable\Cancelable;
use Mkjp\Rx\Observer\Observer;


/**
 * Observable implementation that takes an anonymous function as the implementation
 * of getAsyncIterator
 */
class AnonymousObservable<T> implements Observable<T> {
    use ObservableTrait<T>;
    
    /**
     * Create a new anonymous observable with the given getAsyncIterator implementation
     */
    public function __construct(private (function(Observer<T>): Cancelable) $onSubscribe) { }
        
    protected function onSubscribe(Observer<T> $observer): Cancelable {
        return call_user_func($this->onSubscribe, $observer);
    }
}

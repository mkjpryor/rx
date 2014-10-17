<?hh // strict

namespace Mkjp\Rx\Observable;

//use Mkjp\Option\Option;
use Mkjp\Rx\Cancelable\Cancelable;
use Mkjp\Rx\Observer\Observer;


/**
 * Interface for an object that produces values and emits them to subscribers
 */
interface Observable<T> {
    /**
     * Subscribes the given observer to this observable
     * 
     * The returned cancelable can be used to cancel the subscription
     */
    public function subscribe(Observer<T> $observer): Cancelable;
    
    /**
     * Subscribes the callbacks to this observable
     * 
     * The returned cancelable can be used to cancel the subscription
     */
    public function subscribeCallbacks(?(function(T): void) $onNext = null,
                                       ?(function(\Exception): void) $onError = null,
                                       ?(function(): void) $onCompleted = null): Cancelable;
    
                                       
    /*** Operators ***/
    
    /**
     * Returns a new observable whose elements are the elements of this observable
     * for which the predicate returns true
     */
    public function filter((function(T): bool) $p): Observable<T>;
    
    //public function flatMap<TTo>((function(T): Observable<TTo>) $f): Observable<TTo>;
    
    /**
     * Returns a new observable whose elements are the elements of this observable
     * with $f applied to them
     */
    public function map<TTo>((function(T): TTo) $f): Observable<TTo>;
}

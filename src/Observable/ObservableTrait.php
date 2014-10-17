<?hh // strict

namespace Mkjp\Rx\Observable;

use Mkjp\Rx\Cancelable\Cancelable;
use Mkjp\Rx\Observer\Observer;
use Mkjp\Rx\Observer\AnonymousObserver;


trait ObservableTrait<T> {
    require implements Observable<T>;
    
    
    /**
     * Implements the core subscription logic
     * 
     * It can assume that observers are already safe, etc.
     */
    abstract protected function onSubscribe(Observer<T> $observer): Cancelable;
    
    
    public function subscribe(Observer<T> $observer): Cancelable {
        return $this->onSubscribe($observer);
    }
    
    public function subscribeCallbacks(?(function(T): void) $onNext = null,
                                       ?(function(\Exception): void) $onError = null,
                                       ?(function(): void) $onCompleted = null): Cancelable {
        $onNext = $onNext ?: ($x) ==> { /* NOOP */};
        $onError = $onError ?: ($error) ==> { throw $error; };
        $onCompleted = $onCompleted ?: () ==> { /* NOOP */};
        
        return $this->subscribe(new AnonymousObserver($onNext, $onError, $onCompleted));
    }
    
    
    /*** Operators ***/
    
    public function filter((function(T): bool) $p): Observable<T> {
        return new AnonymousObservable(($observer) ==> $this->subscribeCallbacks(
            ($x) ==> { if( $p($x) ) $observer->onNext($x); },
            ($error) ==> $observer->onError($error),
            () ==> $observer->onCompleted()
        ));
    }
    
    public function map<TTo>((function(T): TTo) $f): Observable<TTo> {
        return new AnonymousObservable(($observer) ==> $this->subscribeCallbacks(
            ($x) ==> $observer->onNext($f($x)),
            ($error) ==> $observer->onError($error),
            () ==> $observer->onCompleted()
        ));
    }
}

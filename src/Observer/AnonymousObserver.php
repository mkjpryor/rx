<?hh // strict

namespace Mkjp\Rx\Observer;


/**
 * Observer that allows the implementations of onNext, onError and onCompleted to be
 * specified using callbacks
 */
final class AnonymousObserver<T> implements Observer<T> {
    /**
     * Create a new observer using the given implementations of onNext, onError and onCompleted
     */
    public function __construct(private (function(T): void) $onNext,
                                private (function(\Exception): void) $onError,
                                private (function(): void) $onCompleted) { }
                                
    public function onCompleted(): void {
        call_user_func($this->onCompleted);
    }
    
    public function onError(\Exception $error): void {
        call_user_func($this->onError, $error);
    }
    
    public function onNext(T $next): void {
        call_user_func($this->onNext, $next);
    }
}

<?hh // strict

namespace Mkjp\Rx\Observer;


/**
 * Interface for an object that can be subscribed to an observable
 * 
 * Observables should call onNext 0 or more times, followed by onError OR onComplete
 */
interface Observer<T> {
    /**
     * Called by subscribed observables when the observable has finished producing values
     */
    public function onCompleted(): void;
    
    /**
     * Called by subscribed observables when an error occurs
     */
    public function onError(\Exception $error): void;
    
    /**
     * Called by subscribed observables when a value is available for consumption
     */
    public function onNext(T $next): void;
}

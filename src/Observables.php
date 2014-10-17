<?hh // strict

namespace Mkjp\Rx;

use Mkjp\Rx\Cancelable\NullCancelable;
use Mkjp\Rx\Cancelable\AnonymousCancelable;
use Mkjp\Rx\Observable\Observable;
use Mkjp\Rx\Observable\AnonymousObservable;
use Mkjp\Rx\Scheduler\Scheduler;
use Mkjp\Rx\Util\Ref;


final class Observables {
    public static function fromTraversable<T>(\Traversable<T> $items): Observable<T> {
        return new AnonymousObservable(($observer) ==> {
            try {
                foreach( $items as $v ) $observer->onNext($v);
                $observer->onCompleted();
            }
            catch( \Exception $error ) {
                $observer->onError($error);
            }
            return new NullCancelable();
        });
    }
    
    public static function interval(float $interval,
                                    ?Scheduler $scheduler = null): Observable<int> {
        $scheduler = $scheduler ?: Schedulers::getDefault();    
                                    
        return new AnonymousObservable(($observer) ==> {
            $i = new Ref(0);
            return $scheduler->schedule(
                () ==> { $j = $i->get(); $observer->onNext($j); $i->update(++$j); },
                $interval, -1
            );
        });
    }
}

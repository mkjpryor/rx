<?hh // strict

namespace Mkjp\Rx\Util;


/**
 * Class that can wrap a type to allow it to be passed by reference
 * 
 * Meant predominantly for use with primitive types that are normally passed by value
 */
final class Ref<T> {
    public function __construct(private T $wrapped) { }
    
    public function get(): T {
        return $this->wrapped;
    }
    
    public function update(T $new): void {
        $this->wrapped = $new;
    }
}

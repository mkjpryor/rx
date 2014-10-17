<?hh // strict

namespace Mkjp\Rx\Deferred;


class Deferred<T> implements \Awaitable<T> {
    private bool $complete = false;
    private ?T $value = null;
    private ?\Exception $error = null;
    
    public async function getWaitHandle(): \WaitHandle<T> {
        while( !$this->complete ) {
            // Keep asking to be rescheduled until we have are completed one way
            // or the other
            await \RescheduleWaitHandle::create(0, 0);
        }
        
        if( $this->value !== null ) return $this->value;
        else throw $this->error;
    }
    
    public function resolve(T $value): void {
        if( $this->complete ) return;
        
        $this->complete = true;
        $this->value = $value;
    }
    
    public function reject(\Exception $error): void {
        if( $this->complete ) return;
        
        $this->complete = true;
        $this->error = $error;
    }
}

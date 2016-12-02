<?php

namespace Bizhub\Impersonate\Traits;

use Exception;
use Session;
use Auth;

trait CanImpersonate
{
	public function impersonate()
    {
        if ($this->isImpersonating()) {
            throw new Exception('You must stop impersonating before impersonating another user.');
        }
        if (!Auth::check()) {
            throw new Exception('You must be logged in before impersonating another user.');
        }
        Session::put('impersonator', Auth::id());
        Session::put('impersonate', $this->id);
    }

    public function stopImpersonating()
    {
        Session::forget('impersonate');
    }

    public function isImpersonating()
    {
        return Session::has('impersonate');
    }

    public function impersonator() {
        if ($this->isImpersonating()) {
            return self::find(Session::get('impersonator'));
        }
        return null;
    }
}
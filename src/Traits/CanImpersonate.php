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

        $this->resetSessionKey($this->id);
    }

    public function stopImpersonating()
    {
        if (Session::has('impersonator')) {
            $this->resetSessionKey(Session::get('impersonator'));
            Session::forget('impersonator');
        }
        Session::forget('impersonate');
    }

    public function isImpersonating()
    {
        return Session::has('impersonate');
    }

    public function impersonator()
    {
        if ($this->isImpersonating()) {
            return self::find(Session::get('impersonator'));
        }
        return null;
    }

    /**
     * Sets the login session value to a new ID for compatibility with Auth::id()
     *
     * @param $id
     */
    protected function resetSessionKey($id)
    {
        $session_key = Auth::getName();
        if ($session_key) {
            Session::put($session_key, $id);
        }
    }
}

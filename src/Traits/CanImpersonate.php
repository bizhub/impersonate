<?php

namespace Bizhub\Impersonate\Traits;

use Session;

trait CanImpersonate
{
	public function impersonate()
    {
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
}
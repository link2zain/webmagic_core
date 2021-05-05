<?php

namespace Webmagic\Core\Controllers;

trait AjaxRedirectTrait
{
    /**
     * Redirect for regular request and for AJAX request
     *
     * Especially  prepared for work with dashboard scripts which redirect
     * with JS after got a JSON request with key redirect
     *
     * @param string $to
     * @param int    $status
     * @param array  $headers
     * @param null   $secure
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function redirect(string $to, $status = 302, $headers = [], $secure = null)
    {
        if (request()->ajax()) {
            return response()->json(['redirect' => url($to, [], $secure), 'status' => $status]);
        }

        return redirect($to, $status, $headers, $secure);
    }
}

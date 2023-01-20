<?php

namespace App\Http\Middleware;

use App\Models\ChMessage;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //echo 'working..';
        //redirect('msgerror');
        $getUserCurrent = User::all();
        $OrignalMessageTable  = ChMessage::all();
        $UserInfo = $getUserCurrent->find(Auth::user()->id)->toArray();
        //var_dump($UserInfo);
        if (isset($UserInfo) && count($UserInfo) > 0) {
            $messageLimit = $UserInfo['message_limit'];
            $countTotalMessage = $OrignalMessageTable->
            where(
              'from_id',Auth::user()->id
                )
            ->toArray();
            //var_dump($countTotalMessage);
            //dd();
            if (isset($countTotalMessage) && count($countTotalMessage) > 0) {
               //echo $messageLimit;
                //echo '<br><br>';
                //count($countTotalMessage);
                //dd();
                if (count($countTotalMessage) >= $messageLimit) {
                   return redirect('msgerror');
                 }
             }
        }

        return $next($request);
    }
}

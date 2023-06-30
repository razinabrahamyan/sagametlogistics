<?php

namespace App\Observers;

use App\Classes\Notifications\Types\WhatsApp\NewQueryCreated;
use App\Classes\Pusher\Triggers\FrontTriggers;
use App\Models\Query;

class QueryObserver
{
    public function saved(Query $query)
    {

    }

    /**
     * Handle the Query "created" event.
     *
     * @param  \App\Models\Query  $query
     * @return void
     */
    public function created(Query $query)
    {
        //Отправка сообщений о новой заявке
        (new NewQueryCreated($query))->sendMessage();
        //Отправка оповещений через pusher на фронт
        FrontTriggers::newQueryNotify();
    }

    /**
     * Handle the Query "updated" event.
     *
     * @param  \App\Models\Query  $query
     * @return void
     */
    public function updated(Query $query)
    {
        //
    }

    /**
     * Handle the Query "deleted" event.
     *
     * @param  \App\Models\Query  $query
     * @return void
     */
    public function deleted(Query $query)
    {
        //
    }

    /**
     * Handle the Query "restored" event.
     *
     * @param  \App\Models\Query  $query
     * @return void
     */
    public function restored(Query $query)
    {
        //
    }

    /**
     * Handle the Query "force deleted" event.
     *
     * @param  \App\Models\Query  $query
     * @return void
     */
    public function forceDeleted(Query $query)
    {
        //
    }
}

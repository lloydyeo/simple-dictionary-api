<?php

namespace App\Observers;

use App\Models\Dictionary;
use App\Models\DictionarySnapshot;

class DictionaryObserver
{
    /**
     * Handle the Dictionary "created" event.
     *
     * @param  \App\Models\Dictionary  $dictionary
     * @return void
     */
    public function created(Dictionary $dictionary)
    {
        //
    }

    /**
     * Handle the Dictionary "updated" event.
     *
     * @param  \App\Models\Dictionary  $dictionary
     * @return void
     */
    public function updated(Dictionary $dictionary)
    {
        $dictionary_snapshot = new DictionarySnapshot();
        $dictionary_snapshot->dictionary_id = $dictionary->id;
        $dictionary_snapshot->key = $dictionary->key;
        $dictionary_snapshot->value = $dictionary->getOriginal('value');
        $dictionary_snapshot->timestamp = $dictionary->getOriginal('timestamp');
        $dictionary_snapshot->save();
    }

    /**
     * Handle the Dictionary "deleted" event.
     *
     * @param  \App\Models\Dictionary  $dictionary
     * @return void
     */
    public function deleted(Dictionary $dictionary)
    {
        //
    }

    /**
     * Handle the Dictionary "restored" event.
     *
     * @param  \App\Models\Dictionary  $dictionary
     * @return void
     */
    public function restored(Dictionary $dictionary)
    {
        //
    }

    /**
     * Handle the Dictionary "force deleted" event.
     *
     * @param  \App\Models\Dictionary  $dictionary
     * @return void
     */
    public function forceDeleted(Dictionary $dictionary)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\DictionarySnapshot;
use Illuminate\Http\Request;
use App\Models\Dictionary;

class DictionaryController extends Controller
{
    public function retrieveAll(Request $request) {
        $dictionaries = Dictionary::all();
        foreach ($dictionaries as $dictionary) {
            $dictionary->value = json_decode($dictionary->value);
        }
        return response()->json([
            'status' => true,
            'dictionaries' => $dictionaries
        ], 200);
    }

    public function retrieve(Request $request, $key) {

        $dictionary =  Dictionary::where('key', $key)->first();

        if (!$dictionary) {
            return response()->json([
                'status' => false,
                'error'  => 'No entry exists for this key.'
            ], 200);
        }

        $value = json_decode($dictionary->value);

        if ($request->filled('timestamp')) {
            $timestamp = (int)$request->input('timestamp');
            if ($dictionary->timestamp > $timestamp) {

                $dictionary_snapshot =
                    DictionarySnapshot::where('dictionary_id', $dictionary->id)
                        ->where('timestamp', '<=', $timestamp)
                        ->orderBy('timestamp', 'desc')
                        ->first();

                if ($dictionary_snapshot) {
                    $value = json_decode($dictionary_snapshot->value);
                } else {
                    return response()->json([
                        'status' => false,
                        'error'  => 'No entry exists for this key at this timestamp.'
                    ], 200);
                }
            }
        }

        if ($dictionary) {
            return response()->json([
                'status' => true,
                'value'  => $value
            ], 200);
        }

    }

    public function upsert(Request $request) {

        $operations = [];

        foreach ($request->all() as $key => $value) {

            $value = json_encode($value);

            $dictionary = Dictionary::updateOrCreate(
                ['key' => $key], ['value' => $value, 'timestamp' => time()]
            );

            if ($dictionary->wasRecentlyCreated) {
                $operations[] = [ 'key' => $key, 'result' => 'created' ];
            } else {
                if ($dictionary->wasChanged()) {
                    $value_changed = false;
                    foreach ($dictionary->getChanges() as $key => $dict_change) {
                        if ($key == 'value') {
                            $value_changed = true;
                        }
                    }
                    if ($value_changed) {
                        $operations[] = [ 'key' => $key, 'result' => 'updated', 'changes' => $dictionary->getChanges() ];
                    } else {
                        $operations[] = [ 'key' => $key, 'result' => 'unchanged' ];
                    }
                } else {
                    $operations[] = [ 'key' => $key, 'result' => 'unchanged' ];
                }
            }
        }

        return response()->json([
            'status' => true,
            'operations' => $operations
        ], 200);
    }
}

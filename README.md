## About

A simple REST key-value dictionary API built using the Laravel framework.

## Endpoints

This service exposes 3 endpoints:
- /api/dictionary via POST to insert/update key-values
- /api/dictionary/{key} via GET to retrieve value associated with {key}
- /api/dictionary/get_all_records via GET to retrieve all records currently stored in the dictionary

Data exchanged are mostly through JSON & all POST only takes in a valid formed JSON.

## Documentation
Detailed documentation of the endpoints can be accessed [here](https://documenter.getpostman.com/view/14545141/TW77hiuD).

## Example
A sample deployment of this is available at:<br/>
[https://dictionary.lloydyeo.com/api/dictionary](https://dictionary.lloydyeo.com/api/dictionary)

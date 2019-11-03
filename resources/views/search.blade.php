@extends('layouts.app')

@section('content')
    <algolia-search token="{{ config('scout.algolia.key') }}"
                    identification="{{ config('scout.algolia.id') }}"></algolia-search>
    <!-- send Application ID and Search-Only API Key to AlgoliaSearch.vue component -->
    <!-- API Keys from algolia site located in .env file and config/scout.php use them -->
    <!-- in config/scout.php in 'algolia' key use 'id' and 'key' indexes -->
@endsection

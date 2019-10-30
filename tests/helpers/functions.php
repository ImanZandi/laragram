<?php

function create($model, $override = [], $count = null) {
    return factory($model, $count)->create($override);
}

function make($model, $override = [], $count = null) {
    return factory($model, $count)->make($override);
}

function raw($model, $override = [], $count = null) {
    return factory($model, $count)->raw($override);
}

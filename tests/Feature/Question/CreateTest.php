<?php

test('/questions/createページが表示できる', function () {
    $this->get('/questions/create')
        ->assertOk();
});

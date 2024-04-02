<?php

test('/questions/createページが表示できる',function () {
    $response = $this->get('/questions/create');
    $response->assertOk();
});
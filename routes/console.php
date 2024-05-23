<?php

use App\Console\Commands\CleanUpTestUserBooks;
use Illuminate\Support\Facades\Schedule;

Schedule::command(CleanUpTestUserBooks::class)->daily();

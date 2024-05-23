<?php

use App\Console\Commands\ResetTestUserBooks;
use Illuminate\Support\Facades\Schedule;

Schedule::command(ResetTestUserBooks::class)->daily();

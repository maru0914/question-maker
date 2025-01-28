<?php

use App\Console\Commands\ResetTestUserBooksCommand;
use Illuminate\Support\Facades\Schedule;

Schedule::command(ResetTestUserBooksCommand::class)->daily();

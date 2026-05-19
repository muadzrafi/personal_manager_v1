<?php

namespace App\Policies;
 
use App\Models\FinancialRecord;
use App\Models\User;
 
class FinancialRecordPolicy
{
    public function view(User $user, FinancialRecord $record): bool
    {
        return $user->id === $record->user_id;
    }
 
    public function update(User $user, FinancialRecord $record): bool
    {
        return $user->id === $record->user_id;
    }
 
    public function delete(User $user, FinancialRecord $record): bool
    {
        return $user->id === $record->user_id;
    }
}
<?php

namespace App\Policies;
 
use App\Models\Task;
use App\Models\User;
 
class TaskPolicy
{
    /**
     * Semua action memerlukan ownership.
     * Global scope di model sudah handle sebagian besar kasus,
     * tapi policy ini adalah backup saat ID di-pass langsung ke route.
     */
 
    public function view(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }
 
    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }
 
    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }
}

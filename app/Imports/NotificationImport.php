<?php

namespace App\Imports;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NotificationImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Validation of required fields
        if (!isset($row['title'], $row['description'], $row['user_id'] , $row['scheduled_at'])) {
            return null;
        }

        $user = User::find($row['user_id']);

        if (!$user) {
            return null; // أو تقدر تعمل create user
        }

        return new Notification([
            'title' => $row['title'],
            'description' => $row['description'],
            'user_id' => $user->id,
            'scheduled_at'=> $row['scheduled_at'],
        ]);
    }
}

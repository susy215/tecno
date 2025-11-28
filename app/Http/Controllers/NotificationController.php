<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index(): Response
    {
        $notifications = Notification::paginate(2);
        return Inertia::render('AdminLayout', [
            'notifications' => $notifications,
        ]);
    }
}

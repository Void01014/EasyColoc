<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Request as RequestModel;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function view(Request $request)
    {
        $group_name = $request->group_name;
        $token = $request->token;
        $user = auth()->user();
        $invitation = RequestModel::where('token', $token)->first();

        $group = $invitation?->group;
        // var_dump($group);
        // dd('s');

        return view('invitation', compact('user', 'token', 'group_name'));
    }

    public function action(Request $request)
    {
        $token = $request->token;
        $action = $request->action;
        $invitation = RequestModel::where('token', $token)
            ->where('user_id', auth()->id())
            ->first();

        if (!$invitation) {
            abort(404, 'Invalid invitation or not for you.');
        }

        $group = $invitation->group;

        if ($action == 'accept') {
            $group->addUser('member');
            $invitation->delete();
        } else {
            $invitation->delete();
        }
        return redirect()->route('dashboard')->with('status', 'Invitation processed.');
    }
}

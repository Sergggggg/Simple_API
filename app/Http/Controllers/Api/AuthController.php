<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Traits\JsonResponseFormat;
use Illuminate\Support\Str;
use Dirape\Token\Token;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Position;

class AuthController
{
    use JsonResponseFormat;

    /**
     * Get access token.
     * @ array json format
     */

    public function getToken()
    {
        $token = new Token;

        $token->token = Str::random(200);

        $token->expires_at = Carbon::now()->addMinutes(40);


        return array('access_token' => $token->token,
            'success' => 'true',
        );
    }

    /**
     * Get user by id.
     * @ array json format
     */

    public function user($id)
    {
        $user = User::query()
            ->where('id', $id)
            ->first();

        return array('user' => $user,
            'success' => 'true',
        );
    }

    /**
     * Get users by pages
     * @ array json format
     */

    public function users(Request $request)
    {

        $page = $request->page;

        $count = $request->count;

        $totalUsers = User::count();

        $url = $request->url();

        $users = User::query()
            ->where('id', '>', $count * ($page - 1))
            ->limit($count)
            ->select('id', 'name', 'email', 'phone', 'photo', 'position_id')
            ->with(['positions' => function ($q) {
                return $q->select('id', 'position');
            }])
            ->get();

        $users->position = $users->map(function ($user) {

            if ($user->positions)
                $user->position = $user->positions->position;

            unset($user->positions);
        });

            return array(
                'user' => $users,
                'success' => 'true',
                'total_users' => $totalUsers,
                'count' => $count,
                'page' => $page,
                'links' => array(
                    'next_url' => ($totalUsers / $count > $page
                        ? $url . '?page=' . ($page + 1) . '&count=' . $count
                        : null),

                    'prev_url' => ($page > 1 ? $url . '?page=' . ($page - 1) .
                        '&count=' . $count : null),
                ),
            );
    }

    /**
     * Get free position.
     * @ array json format
     */

    public function positions()
    {

        $positions = Position::query()
            ->select('position')
            ->where('avaliable', true)
            ->get();

        return array('positions' => $positions,
            'success' => 'true',
        );

    }
}

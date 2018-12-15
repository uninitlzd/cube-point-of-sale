<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreMemberRequest;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $members = $this->user->shop->members;
        return MemberResource::collection($members);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMemberRequest $request
     * @return MemberResource
     */
    public function store(StoreMemberRequest $request)
    {
        $member = $this->user->shop
                    ->members()->save(new Member($request->all()));
        return new MemberResource($member);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return MemberResource
     */
    public function show(Member $member)
    {
        return new MemberResource($member);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Member $member
     * @return MemberResource
     */
    public function update(Request $request, Member $member)
    {
        return new MemberResource(tap($member)
                        ->update($request->all())
                        ->refresh());
    }

    /**
     * Deactivate Member.
     *
     * @param Member $member
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Member $member)
    {
        if ($member->trashed()) {
            return response()->json([
                'success'=> false,
                'message' => 'Member already Deactivated'
            ]);
        }

        $member->delete();

        return response()->json([
            'success'=> true,
            'message' => 'Member deactivated'
        ]);
    }

    public function restore(Member $member)
    {
        if (!$member->trashed()) {
            return response()->json([
                'success'=> false,
                'message' => 'Member already Active'
            ]);
        }

        $member->restore();

        return response()->json([
            'success'=> true,
            'message' => 'Member re-Activated'
        ]);
    }
}

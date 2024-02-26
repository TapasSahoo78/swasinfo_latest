<?php

namespace App\Services\User;

use App\Contracts\Users\InviteContract;

class InviteService
{
    protected $inviteRepository;

    /**
     * class InviteService constructor
     */
    public function __construct(InviteContract $inviteRepository)
    {
        $this->inviteRepository = $inviteRepository;
    }

    /**
     * Fetch List of Invites
     * @return mixed
     */
    public function fetchInvites($request) {
        return $this->inviteRepository->findBy($request);
    }

    /**
     * Find Invite
     * @return mixed
     */
    public function findInviteOrFail($request) {
        return $this->inviteRepository->findOneByOrFail($request);
    }

    /**
     * Save FAQ information
     * @param array $request
     * @return mixed
     */
    // public function createInvite($request) {
    //     return $this->inviteRepository->createInvite($request);
    // }

    /**
     * Save FAQ information
     * @param array $request
     * @return mixed
     */
    public function createAdmin($request) {
        return $this->inviteRepository->createInvite($request);
    }
}

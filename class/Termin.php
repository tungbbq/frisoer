<?php

class Termin
{
    private int $id;
    private object $user;
    private string $slot;
    private int $user_id;

    /**
     * @param int $id
     * @param object $user
     * @param string $slot
     * @param int $user_id
     */
    public function __construct(int $id, object $user, string $slot, int $user_id)
    {
        $this->id = $id;
        $this->user = $user;
        $this->slot = $slot;
        $this->user_id = $user_id;
    }

    /**
     * @param object $user
     */
    public function setUser(object $user): void
    {
        $this->user = $user;
    }

    /**
     * @param string $slot
     */
    public function setSlot(string $slot): void
    {
        $this->slot = $slot;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return object
     */
    public function getUser(): object
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getSlot(): string
    {
        return $this->slot;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

}
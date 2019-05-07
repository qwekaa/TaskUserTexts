<?php

class People implements IteratorAggregate
{
    private $Users;
    
    public function createUser($id, $name)
    {
        $user = new User($id, $name);
        $this->addUser($user);
        return $user;
    }
    
    public function addUser(User $user)
    {
        $this->Users[] = $user;
    }
    
    public function accept(Task $Visitor)
    {
        if (empty($this->Users)) {
            return;
        }
        foreach ($this->Users as $User) {
            $Visitor->process($User);
        }
    }
    
    public function countUsers()
    {
        return count($this->Users);
    }
    
    public function getIterator() {
        return new ArrayIterator($this->Users);
    }
}
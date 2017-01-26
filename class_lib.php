<?php

//this is the parent class of employee

class person {

    var $name;
    private $pinn_number;

    function __construct($persons_name) {
        $this->name = $persons_name;
    }

    function set_name($newName) {
        $this->name = $newName;
    }

    function get_name() {
        return$this->name;
    }

}

class employee extends person {

    function __construct($employee_name) {
        $this->set_name($employee_name);
    }

}

////if a method in the employee class has to do something different than what it does in person class 
//you overried the person classes version of the method by declaring the same method in employee
class person2 {

    var $name;

    function __construct($persons_name) 
    {
        $this->name = $persons_name;
    }

    protected function set_name($newName) 
    {
        if($this->name != "Jimmy Two Guns")
        {
            $this->name == strtoupper($newName);
        }
    }

    function get_name() {
        return$this->name;
    }

}
//extends the keyword that enables inheritance
class employee2 extends person {
    protected function set_name($newName)
    {
        if($newName == "Stefaun Sucks")
        {
            $this->name == $newName;
        }
        else if ($newName = "Jonny Fingers")
        {
            //:: allows you to specifically name the class where you want php to search for a method:
            person::set_name($newName);
        }
    }
            function __construct($employee_name) {
        $this->set_name($employee_name);
    }

}
//class Learners
//{
//    var $learner1;
//    function __construct($learning)
//    {
//        $this->learner1 = $learning;
//    }
//    function getLearner
//    {
//        return$this->learner1;
//    }
//}

?>
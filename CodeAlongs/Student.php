<?php
class Student{
    private $name;
    private $studentId;
    protected $address;//accessible in the sub classes
    CONST numCourses = 5;//cannot be overridden, no $!
    
    //final methods CANNOT be overridden in subclass
    final public function __get($x){
        return $this->$x;
    }
    public function __set($property, $value){
        $this->$property = $value;
    }
    //constructor
    public function __construct($name, $studentId) {
        $this->studentId = $studentId;
        $this->name = $name;
    }
    public function __destruct() {
        echo "OBJECT DESTROYED<BR>";
    }
    public static function PrintSchool(){
        echo "NBCC<BR>";
    }
    //public abstract function SomeMethod();//abstract method
}
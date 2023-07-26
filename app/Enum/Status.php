<?php

namespace App\Enum;

use ReflectionEnum;

enum Status: int
{
    case Pending     =   0;
    case Published   =   1;
    case Approver    =   2;
    case Storekeeper =   3;
    case Confirmed   =   4;

    /**
     * [Will return cases name list]
     *
     * @return [array]
     * 
     */
    public static function getCases(){
        return array_column(self::cases(), 'name');
    }

   /**
     * [return cases list with description]
     *
     * @return [array]
     * 
     */
    public static function get(){
        foreach(array_column(self::cases(), 'name') as $item){
            $arr[$item]=self::getFromName($item)->toDescription();
        }
        return $arr;
    }

     /**
     * [get case object by name]
     *
     * @return [type]
     * 
     */
    public static function getFromName($name){
        $reflection = new ReflectionEnum(self::class);
        return $reflection->getCase($name)->getValue();
    }

    /**
     * [Description for toString]
     *
     * @return [type]
     * 
     */
    public function toDescription(){
        return match($this){
            self::Pending=>"Pending to Publish",
            self::Published=>"Pending to approver approval",
            self::Approver=>"Pending to storekeeper approval",
            self::Storekeeper=>"Pending to user approval",
            self::Confirmed=>"Approved by all",
        };
    }

    public function toString(){
        return match($this){
            self::Pending=>"Pending",
            self::Published=>"Published",
            self::Approver=>"Approver",
            self::Storekeeper=>"Storekeeper",
            self::Confirmed=>"Confirmed",
        };
    }

    public function toComment(){
        return match($this){
            self::Pending=>"the request has been decliened",
            self::Published=>"the request has been published",
            self::Approver=>"the request has been approved",
            self::Storekeeper=>"the request has been approved",
            self::Confirmed=>"Products has been recieved by the requested user and the stock adjusted",
        };
    }

    public function toType(){
        return match($this){
            self::Pending=>"Declined",
            self::Published=>"Published",
            self::Approver=>"Approved",
            self::Storekeeper=>"Approved",
            self::Confirmed=>"Confirmed",
        };
    }


}

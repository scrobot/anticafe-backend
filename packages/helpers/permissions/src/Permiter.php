<?php
namespace Helpers\Permissions;

use Anticafe\Http\Models\User;

/**
 * Class Permiter
 * @package Pinerp\Permissions
 */
class Permiter
{

    /**
     * @param  array|string $permissions it can be simple string 'module.model.action' or array of perms, like [ 'module.model.action_one',  'module.model.action_two'], or with params for callback ['module.model.simple_action', ['module.model.complex_action', \Auth::user(), $workUser] ]
     * @param string $operator
     * @param bool|false $throw
     * @param User|null $user
     * @param string $callback
     *
     * @return bool
     * @throws \Exception
     */

    public static function checkPermission($permissions, $operator = 'and', $throw = false, $user = null, $callback = null)
    {

        if($user == null) {
            $user = auth()->user();
        }

        if($user->level == 0) {
            return true;
        }

        /*
         * если строка, приводим к массиву из одного элемента
         */
        $permissions = (array) $permissions;

        $allowed = collect();

        if(!is_null($user)) {
            foreach ($user->roles as $role) {
                foreach ($role->permissions as $perm) {
                    $allowed->push($perm->id);
                }

            }
        }

        switch ($operator) {
            case "and":
                $summary = true;
                break;

            case "or":
                $summary = false;
                break;

            default:
                throw new \Exception('Invalid permissions operator: ' . print_r($operator, true));
        }

//        dd($permissions);

        foreach ($permissions as $permission) {

            /*
             * если строка, приводим к массиву из одного элемента
             */
            $permission = (array) $permission;

            /*
             * для "сложных" правил проверки получаем доп. аргументы для проверочной функции ['perm_with_callback', $user, $other]
             */

            $permission = $permission[0];

            $match = $allowed->contains($permission);

            /*
             * если в конфиге указаны функции для доп. проверки правил, выполним их, передав параметры
             */

            $callbackMatch = true;

            if (!is_null($callback)) {

                //dd($callback);

                if(is_array($callback)) {
                    $call = $callback[0];
//                    dd($call);
                    $params = array_slice($callback, 1, count($callback));
                    $callbackMatch = app()->call($call, $params);
//                    dd($callbackMatch);
                } else {
                    $callbackMatch = app()->call($callback);
                }



            }

            $result = $match && $callbackMatch;

//            dd($operator, $result, $match, $callbackMatch);

            if ($operator == 'and' && !$result) {
                $summary = false;
            } elseif ($operator == 'or' && $result) {
                $summary = true;
            }

        }

        if (!$summary) {
            return self::throwType($throw);
        }

        return true;
    }

    protected static function throwException($trans)
    {
        throw new \Exception(trans($trans));
    }

    protected static function throwType($throw)
    {
        if ($throw) {
            self::throwException("Доступ запрещен");
        } else {
            return false;
        }
    }
}
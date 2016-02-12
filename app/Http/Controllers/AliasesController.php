<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 12.02.2016
 * Time: 18:10
 */

namespace Anticafe\Http\Controllers;


use Anticafe\Http\Models\Alias;

class AliasesController extends Controller
{

    private $title;

    /**
     * AnticafeController constructor.
     */
    public function __construct()
    {
        $this->title = Alias::getModelName();
    }

}
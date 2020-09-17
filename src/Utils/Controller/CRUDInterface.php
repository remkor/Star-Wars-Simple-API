<?php
// src/Utils/Controller/CRUDInterface.php

namespace App\Utils\Controller;

use Symfony\Component\HttpFoundation\Request;

interface CRUDInterface
{
    public function indexAction(Request $request);

    public function createAction(Request $request);

    public function readAction(Request $request);

    public function updateAction(Request $request);

    public function deleteAction(Request $request);
}

<?php
namespace App\Http\Controllers\Interfaces;

use Illuminate\Http\Request;

interface FeatureInterface
{
    public function create(Request $request);
    public function update(Request $request);
    public function list();
    public function delete(Request $request);
    public function get(Request $request);
}

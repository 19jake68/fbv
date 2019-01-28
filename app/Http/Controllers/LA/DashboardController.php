<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;


/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();

    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return Response
   */
  public function index()
  {
    if (!Auth::user()->isAdministrator()) {
      return redirect(config('laraadmin.adminRoute') . "/orders");
    }
    return view('la.dashboard');
  }
}
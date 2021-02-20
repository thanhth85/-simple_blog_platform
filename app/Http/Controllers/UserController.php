<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Posts;

use Illuminate\Http\Request;

class UserController extends Controller
{
   /*
	 * Display the posts of a particular user
	 * 
	 * @param int $id
	 * @return Response
	 */
  public function logout()
  {
    Auth::logout();
    return redirect('/');
  }

  /*
   * Display active posts of a particular user
   * 
   * @param int $id
   * @return view
   */
  public function user_posts($id)
  {
    //
    $user = User::find($id);
    if($user->role === 'admin')
      $posts = Posts::where('active',1)->orderBy('created_at','desc')->paginate(5);
    else
      $posts = Posts::where('author_id',$id)->where('active',1)->orderBy('created_at','desc')->paginate(5);

    $title = User::find($id)->name;
    return view('home')->with('posts', $posts)->with('title', $title);
  }
  /*
   * Display all of the posts of a particular user
   * 
   * @param Request $request
   * @return view
   */
  public function user_posts_all(Request $request)
  {
    if($request->filter === 'status'){
      $name = 'active';
    }else if ($request->filter === 'date'){
      $name = 'updated_at';
    }else {
      $name = 'created_at';
    }
    //
    $user = $request->user();

    if($user->role === 'admin')
      $posts = Posts::orderBy($name,'desc')->paginate(5);
    else 
      $posts = Posts::where('author_id',$user->id)->orderBy($name,'desc')->paginate(5);

    $title = $user->name;
    $selected_filter = '';
    $selected_filter = $request->filter;
    return view('filter')->with('posts', $posts)->with('title', $title)->with('selected_filter', $selected_filter);
  }
  /*
   * Display draft posts of a currently active user
   * 
   * @param Request $request
   * @return view
   */
  public function user_posts_draft(Request $request)
  {
    //
    $user = $request->user();
    if($user->role === 'admin')
      $posts = Posts::where('active',0)->orderBy('created_at','desc')->paginate(5);
    else 
      $posts = Posts::where('author_id',$user->id)->where('active',0)->orderBy('created_at','desc')->paginate(5);
      
    $title = $user->name;
    return view('home')->with('posts', $posts)->with('title', $title);
  }
  /**
   * profile for user
   */
  public function profile(Request $request, $id) 
  {
    $data['user'] = User::find($id);
    // dd($data['user']);
    if (!$data['user'])
      return redirect('/');
    if ($request -> user() && $data['user'] -> id == $request -> user() -> id) {
      $data['author'] = true;
    } else {
      $data['author'] = null;
    }
    if($data['user']->role === 'admin'){
      $data['posts_count'] = Posts::count();
      $data['posts_active_count'] = Posts::where('active', '1') -> count();
      $data['posts_draft_count'] = $data['posts_count'] - $data['posts_active_count'];
      $data['latest_posts'] = Posts::where('active', '1') -> take(5)->get();
    }else {
      $data['posts_count'] = $data['user'] -> posts -> count();
      $data['posts_active_count'] = $data['user'] -> posts -> where('active', '1') -> count();
      $data['posts_draft_count'] = $data['posts_count'] - $data['posts_active_count'];
      $data['latest_posts'] = $data['user'] -> posts -> where('active', '1') -> take(5);
    }
   
    return view('admin.profile', $data);
  }
}

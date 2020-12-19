<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only('create');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
        $archives = $this->getArchives();
        return view('post.index', compact('posts', 'archives'));
    }

    public function archive($year, $month)
    {
        $posts = Post::whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
        $archives = $this->getArchives();
        return view('post.index', compact('posts', 'archives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $archives = $this->getArchives();
        $method = 'POST';
        $action = route('posts.store');
        return view('post.create', compact('archives', 'method', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:150',
            'body' => 'required',
            'excerpt' => 'required'
        ],[
            'title.required' => 'الرجاء إدخال نص المقالة '
        ]);
        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->excerpt = $request->excerpt;
        $post->user_id = $request->user_id;
        $post->is_published = (bool)$request->is_published;
        $post->save();
        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $archives = $this->getArchives();
        return view('post.show', compact('post', 'archives'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $archives = $this->getArchives();
        $method = 'put';
        $action = route('posts.update', $id);
        return view('post.create', compact('post','archives', 'method',
        'action'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Post::find($id)->update($request->all());
        return redirect('posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getAllPosts(){
        return [
          1 => [
              'title' => 'المقالة اﻷولي',
              'body' => 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.',
              'author' => 'أحمد',
              'created_at' => Carbon::createFromDate(2020,12,14)->diffForHumans()
          ],
            2 => [
                'title' => 'المقالة الثانية',
                'body' => 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.',
                'author' => 'أحمد',
                'created_at' => Carbon::createFromDate(2020,12,14)->diffForHumans()
            ],
            3 => [
                'title' => 'المقالة الثالثة',
                'body' => 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.',
                'author' => 'أحمد',
                'created_at' => Carbon::createFromDate(2020,12,14)->diffForHumans()
            ],
        ];
    }
    private function getArchives(){
        return Post::selectRaw('MONTHNAME(created_at) month, MONTH(created_at) month_number, YEAR(created_at) year, COUNT(*) posts_count')->groupBy('month', 'month_number', 'year')->orderBy('created_at')->get();
    }
}

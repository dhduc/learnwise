<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCourseRequest;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class TeacherController extends Controller
{

    public function index(Request $request)
    {
        return view('teachers.index', [
            'courses' => Course::where('user_id', $request->user()->id)->get(),
        ]);
    }

    public function create()
    {
        return view('teachers.course.create');
    }

    public function store(Request $request)
    {
        $request['slug'] = Str::of($request->title)->slug("-");
        $formFields = $request->validate([
            'title' => 'required',
            'slug' => ['required', Rule::unique('courses', 'slug')],
            'user_id' => 'required'
        ]);

        $course = Course::create($formFields);
        return redirect(route('course.setup', $course->slug));
    }

    public function edit($slug)
    {

        $course = Course::where('slug', $slug)->firstOrFail();
        $categories = Category::all();
        $chapterTitles = $course->chapters->pluck('title')->all();

        return view('teachers.course.setup', [
            'course' => $course,
            'categories' => $categories,
            'chapterTitles' => $chapterTitles,
        ]);
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->validated());

        return redirect("/teacher/course/setup/" . $course->slug);
    }

    public function updatethumbnail(Request $request, Course $course)
    {
        /*
         * TODO: remove thumbnail stored when user upload a new one, we don't want them to just pile up our storage
         * We also might want to put this function inside `update` above
         **/

        $formFields = null;
        if ($request->hasFile('thumbnail')) {
            $formFields['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course->update($formFields);
        return redirect()->back();
    }
}

<x-course-layout :title="$course->title">
    <div class="layout-sidebar">
        <div class="sidenav show border-end">
            <div class="menu accordion">
                <ul class="menu-list">
                    {{--
                        <li>
                            <a class="menu-item p-4 {{ $isFree ? 'active rounded-0 border-blue-100 border-4 border-end' : '' }}" href="/courses/{{$chapter->slug}}">
                    <x-lucide-play-circle class="w-4 h-4 me-2" />
                    {{ $course->chapters[0]->title }}
                    </a>
                    </li>
                    --}}
                    @foreach($course->chapters as $item)
                    <li>
                        <a class="menu-item p-4 {{ $item->position == $chapterPosition ? 'active rounded-0 border-blue-100 border-4 border-end' : '' }}" href="/courses/{{$slug}}/chapter/{{$item->position}}">
                            @if($item->is_free)
                            <x-lucide-play-circle class="w-4 h-4 me-2" />
                            @else
                            <x-lucide-lock-keyhole class="w-4 h-4 me-2" />
                            <!-- Use play circle once the data coming from db -->
                            <!-- <x-lucide-play-circle class="w-4 h-4 me-2" /> -->
                            @endif
                            <span class="text-truncate" style="width:220px;">{{$item->title}}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <main class="bg-neutral-10">
        <div class="p-5">
            <div class="pb-2">
                @if($isFree)
                <video src="/videos/video-in-bootstrap-card.mp4" class="card-img-top rounded" controls></video>
                @else
                <div class="card-img-top rounded bg-neutral-800 ratio-16x9" style="height: 600px;">
                    <div class="text-center text-white" style="padding-top: 280px;">
                        <x-lucide-lock-keyhole width="60" height="60" />
                        <div class="py-2">This chapter is locked</div>
                    </div>
                </div>
                @endif
            </div>
            <div class=" py-2 d-flex justify-content-between align-items-center border-bottom border-2 rounded">
                <h1>{{$chapter->title}}</h1>
                <div>
                    @if(!Auth::user())
                    <button class="btn btn-primary">Start course</button>
                    @else
                    @if($isLocked)
                    <button class="btn btn-primary">Enrol course</button>
                    @else
                    <button class="btn btn-success">Mark as complete <x-lucide-check-circle class="w-4 h-4 ms-2" /></button>
                    @endif
                    @endif
                </div>
            </div>
            <div class="py-2">
                <p>{{$chapter->description}}</p>
            </div>
        </div>
    </main>
</x-course-layout>

<x-guest-layout>
    <div class="relative py-16 bg-white overflow-hidden">
        <div class="hidden lg:block lg:absolute lg:inset-y-0 lg:h-full lg:w-full">
            <div class="relative h-full text-lg max-w-prose mx-auto" aria-hidden="true">
                <svg class="absolute top-12 left-full transform translate-x-32" width="404" height="384" fill="none" viewBox="0 0 404 384">
                    <defs>
                        <pattern id="74b3fd99-0a6f-4271-bef2-e80eeafdf357" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="404" height="384" fill="url(#74b3fd99-0a6f-4271-bef2-e80eeafdf357)" />
                </svg>
                <svg class="absolute top-1/2 right-full transform -translate-y-1/2 -translate-x-32" width="404" height="384" fill="none" viewBox="0 0 404 384">
                    <defs>
                        <pattern id="f210dbf6-a58d-4871-961e-36d5016a0f49" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="404" height="384" fill="url(#f210dbf6-a58d-4871-961e-36d5016a0f49)" />
                </svg>
                <svg class="absolute bottom-12 left-full transform translate-x-32" width="404" height="384" fill="none" viewBox="0 0 404 384">
                    <defs>
                        <pattern id="d3eb07ae-5182-43e6-857d-35c643af9034" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="404" height="384" fill="url(#d3eb07ae-5182-43e6-857d-35c643af9034)" />
                </svg>
            </div>
        </div>
        <div class="relative px-4 sm:px-6 lg:px-8">
            <div class="text-lg max-w-prose mx-auto">
                <span class="block text-base text-center text-indigo-600 font-semibold tracking-wide uppercase">Article</span>
                <h1>
                    <span class="mt-2 block text-3xl text-center leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{ $article->title }}</span>
                </h1>
            </div>
            <div class="mt-6 prose prose-indigo prose-lg text-gray-500 mx-auto">
                <p>{!! nl2br(e($article->content)) !!}</p>
            </div>
            <div class="mt-6 prose prose-indigo prose-lg text-gray-500 mx-auto">
                <hr>
                <p class="font-sans">Comments:</p>
                <form action="{{route('comments.store')}}" method="POST">
                    @csrf
                    <div class="flex justify-between gap-3">
                        <span class="w-1/2">
                            <input type="hidden" value="{{$article->id}}" name="news_id">
                          
                            <label for="email">Name:</label>
                            <input class=" block w-full focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4  appearance-none leading-normal" type="text" name="name" placeholder="John Doe">
                        </span>
                        <span class="w-1/2">
                            <label for="email">Email:</label>
                            <input class="block focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4  appearance-none leading-normal" type="email" name="email" placeholder="email@example.com">
                        </span>
                    </div>
                    <div class="">
                        <label for="content">Content:</label>
                        <textarea name="content" rows="5" class="resize-y border rounded-md w-full"></textarea>
                    </div>
                    <div>
                        <button class="float-right h-10 px-5 m-2 text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-lg focus:shadow-outline hover:bg-indigo-800">Post a comment</button>
                    </div>
                </form>

                <div id="comments" class="block mt-20">
                    @forelse($article->comments as $newsComment)
                    <div class="bg-gray-80 border-b pb-6">
                        <p class="font-bold">{{ $newsComment->name }}</p>
                        <div class="py-3 px-4 bg-gray-100 border-l-2 border-indigo-600">
                            <param>{{$newsComment->content}}</p>
                            <span class="italic font-semibold text-sm">14.07.2020 u 21:30</span>
                        </div>
                        <div id="replies-container" class="mt-2 ml-8">
                         @foreach($newsComment->replies as $reply)
                            @if($reply->approved)
                            <div id="replies">
                                <div class="py-3 px-4 border-b">
                                    <p class="font-bold">{{ $reply->name }}</p>
                                    <div class="py-3 px-4 bg-gray-100 border-l-2 border-red-600 bg-gray-100">
                                        <param>{{$reply->content}}</p>
                                        <span class="italic font-semibold text-sm">14.07.2020 u 21:30</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                     
                         @endforeach
                            <div id="reply-box" class="mt-4 mb-10">
                                <form action="{{route("comment_replies.store",$newsComment->id)}}" method="POST">
                                    @csrf
                                    <div class="flex justify-between gap-3">
                                        <span class="w-1/2">
                                            <input type="hidden" value="{{$newsComment->id}}" name="comment_id">
                                            <label for="email">Name:</label>
                                            <input class=" block w-full focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4  appearance-none leading-normal" type="text" name="name" placeholder="John Doe">
                                        </span>
                                        <span class="w-1/2">
                                            <label for="email">Email:</label>
                                            <input class="block focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4  appearance-none leading-normal" type="email" name="email" placeholder="email@example.com">
                                        </span>
                                    </div>
                                    <div class="">
                                        <label for="content">Content:</label>
                                        <textarea name="content" rows="5" class="resize-y border rounded-md w-full"></textarea>
                                    </div>
                                    <div>
                                        <button class="float-right h-10 px-5 m-2 text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-lg focus:shadow-outline hover:bg-indigo-800">Post a comment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty

                    Be first to comment!

                    @endforelse
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>
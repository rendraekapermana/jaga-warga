<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community - Jaga Warga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { 'custom-blue': '#222E85' } } }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
        .avatar-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .shadow-card {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .shadow-card-hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .transition-all-custom {
            transition: all 0.3s ease;
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Ikon Komentar Kustom */
        .comment-icon {
            width: 20px;
            height: 20px;
            position: relative;
        }
        .comment-icon-bubble {
            width: 16px;
            height: 12px;
            background: currentColor;
            border-radius: 2px 8px 8px 8px;
            position: absolute;
            top: 4px;
            left: 2px;
        }
        .comment-icon-bubble::before {
            content: '';
            position: absolute;
            width: 0;
            height: 0;
            border-left: 3px solid transparent;
            border-right: 3px solid currentColor;
            border-bottom: 3px solid currentColor;
            border-top: 3px solid transparent;
            top: -4px;
            left: 0;
        }
        
        /* Ikon Komentar Alternatif */
        .comment-icon-2 {
            width: 20px;
            height: 20px;
        }
        .comment-icon-2-bubble {
            width: 16px;
            height: 12px;
            background: currentColor;
            border-radius: 2px 6px 6px 6px;
            position: relative;
        }
        .comment-icon-2-bubble::after {
            content: '';
            position: absolute;
            width: 6px;
            height: 6px;
            background: currentColor;
            border-radius: 50%;
            bottom: -8px;
            left: 2px;
        }
        .comment-icon-2-bubble::before {
            content: '';
            position: absolute;
            width: 4px;
            height: 4px;
            background: currentColor;
            border-radius: 50%;
            bottom: -13px;
            left: 7px;
        }
        
        /* Ikon Komentar Modern */
        .comment-icon-modern {
            width: 20px;
            height: 20px;
        }
        .comment-icon-modern-bubble {
            width: 16px;
            height: 10px;
            background: currentColor;
            border-radius: 4px 4px 8px 4px;
            position: relative;
            transform: rotate(-2deg);
        }
        .comment-icon-modern-bubble::before {
            content: '';
            position: absolute;
            width: 6px;
            height: 6px;
            border: 2px solid currentColor;
            border-radius: 50%;
            top: -8px;
            right: 2px;
        }
        
        /* Ikon Komentar dengan Dots */
        .comment-icon-dots {
            width: 20px;
            height: 20px;
        }
        .comment-icon-dots-bubble {
            width: 14px;
            height: 10px;
            background: currentColor;
            border-radius: 3px 8px 8px 3px;
            position: relative;
        }
        .comment-icon-dots-bubble::before {
            content: '';
            position: absolute;
            width: 3px;
            height: 3px;
            background: white;
            border-radius: 50%;
            top: 2px;
            left: 3px;
            box-shadow: 4px 0 0 white, 8px 0 0 white;
        }
    </style>
</head>
<body class="bg-gray-50">

    <x-navbar />

    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-8 fade-in">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Community</h1>
            <p class="text-gray-600">Connect, share, and engage with your neighbors</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md mb-6 fade-in">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">There were {{ count($errors) }} errors with your submission</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error) 
                                    <li>{{ $error }}</li> 
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md mb-6 fade-in">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Feed Postingan --}}
            <div class="lg:col-span-2 space-y-6">
                @forelse ($posts as $post)
                    <article x-data="{ commentOpen: false, isEditing: false, editContent: `{{ $post->content }}` }" 
                             class="bg-white rounded-xl shadow-card hover:shadow-card-hover transition-all-custom overflow-hidden fade-in">
                        
                        {{-- Header --}}
                        <div class="px-6 pt-6 pb-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="h-10 w-10 rounded-full avatar-gradient flex items-center justify-center text-white font-bold uppercase">
                                        {{ substr($post->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $post->user->name }}</p>
                                        <p class="text-xs text-gray-500 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $post->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>

                                @if (Auth::id() === $post->user_id)
                                    <div x-data="{ openMenu: false }" class="relative">
                                        <button @click="openMenu = !openMenu" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 3a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM10 8.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM11.5 15.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                                            </svg>
                                        </button>
                                        <div x-show="openMenu" @click.outside="openMenu = false" style="display: none;" 
                                             class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg py-1 z-50 border border-gray-200">
                                            <button @click="isEditing = true; openMenu = false" 
                                                    class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </button>
                                            <form action="{{ route('community.post.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="flex items-center w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 transition-colors">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Konten Teks --}}
                        <div class="px-6 pb-4">
                            <div x-show="!isEditing">
                                <div class="text-gray-800 whitespace-pre-wrap text-sm leading-relaxed">{!! nl2br(e($post->content)) !!}</div>
                            </div>
                            <div x-show="isEditing" style="display: none;" class="fade-in">
                                <form action="{{ route('community.post.update', $post) }}" method="POST">
                                    @csrf @method('PUT')
                                    <textarea name="content" x-model="editContent" rows="3" 
                                              class="w-full border-gray-300 rounded-lg shadow-sm text-sm p-3 focus:ring-custom-blue focus:border-custom-blue transition-colors"></textarea>
                                    <div class="flex justify-end space-x-2 mt-2">
                                        <button type="button" @click="isEditing = false" 
                                                class="text-sm text-gray-500 hover:text-gray-700 px-3 py-1 rounded-md transition-colors">Cancel</button>
                                        <button type="submit" 
                                                class="text-sm bg-custom-blue text-white px-4 py-1 rounded-md hover:bg-opacity-90 transition-colors">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="px-6 py-3 bg-gray-50 border-t border-gray-100">
                            <div class="flex items-center space-x-6">
                                <form action="{{ route('community.like', $post) }}" method="POST" class="flex items-center">
                                    @csrf
                                    <button type="submit" class="flex items-center space-x-2 text-gray-500 hover:text-red-600 transition-colors">
                                        @if($post->likes->where('user_id', Auth::id())->count() > 0)
                                            <svg class="h-5 w-5 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="m9.653 16.915-.005-.003-.019-.01a20.759 20.759 0 0 1-1.162-.682 22.045 22.045 0 0 1-6.68-7.388l-.001-.002a11.962 11.962 0 0 1-2.008-3.418c0-2.61.855-4.5 2.433-5.625 1.291-.896 2.836-1.11 4.417-1.11 1.58 0 3.126.213 4.418 1.11 1.578 1.125 2.433 3.015 2.433 5.625 0 1.342-.32 2.58-.888 3.655a11.964 11.964 0 0 1-2.008 3.418l-.001.002a22.049 22.049 0 0 1-6.68 7.388 20.753 20.753 0 0 1-1.162.682l-.02.01-.005.003Z" />
                                            </svg>
                                        @else
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                            </svg>
                                        @endif
                                        <span class="text-sm font-medium">{{ $post->likes->count() }}</span>
                                    </button>
                                </form>
                                
                                {{-- Ikon Komentar Baru --}}
                                <button @click="commentOpen = !commentOpen" 
                                        class="flex items-center space-x-2 text-gray-500 hover:text-custom-blue transition-colors">
                                    
                                    {{-- Pilih salah satu ikon komentar di bawah ini --}}
                                    
                                    {{-- Ikon 1: Simple Chat Bubble --}}
                                    <div class="comment-icon">
                                        <div class="comment-icon-bubble"></div>
                                    </div>
                                    
                                    {{-- Ikon 2: Chat dengan Dots --}}
                                    <!--
                                    <div class="comment-icon-2">
                                        <div class="comment-icon-2-bubble"></div>
                                    </div>
                                    -->
                                    
                                    {{-- Ikon 3: Modern Chat --}}
                                    <!--
                                    <div class="comment-icon-modern">
                                        <div class="comment-icon-modern-bubble"></div>
                                    </div>
                                    -->
                                    
                                    {{-- Ikon 4: Chat dengan Tiga Dots --}}
                                    <!--
                                    <div class="comment-icon-dots">
                                        <div class="comment-icon-dots-bubble"></div>
                                    </div>
                                    -->
                                    
                                    <span class="text-sm font-medium">{{ $post->comments->count() }}</span>
                                </button>
                            </div>
                        </div>

                        {{-- Komentar --}}
                        <div x-show="commentOpen" x-transition class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                            <form action="{{ route('community.comment.store', $post) }}" method="POST" class="flex items-center space-x-3 mb-4">
                                @csrf
                                <div class="h-8 w-8 rounded-full avatar-gradient flex items-center justify-center text-xs text-white font-bold uppercase">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <input type="text" name="content" 
                                       class="flex-1 border-gray-300 rounded-full shadow-sm focus:ring-custom-blue focus:border-custom-blue text-sm px-4 py-2 transition-colors" 
                                       placeholder="Write a comment...">
                                <button type="submit" 
                                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-custom-blue hover:bg-opacity-90 transition-colors">
                                    Post
                                </button>
                            </form>
                            <div class="space-y-4">
                                @forelse ($post->comments as $comment)
                                    <div class="flex items-start space-x-3 fade-in">
                                        <div class="h-8 w-8 rounded-full avatar-gradient flex items-center justify-center text-xs text-white font-bold uppercase shrink-0">
                                            {{ substr($comment->user->name, 0, 1) }}
                                        </div>
                                        <div class="flex-1 bg-white rounded-xl px-4 py-3 shadow-sm">
                                            <div class="flex items-center space-x-2 mb-1">
                                                <span class="text-sm font-semibold text-gray-900">{{ $comment->user->name }}</span>
                                                <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-sm text-gray-700">{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4">
                                        <div class="comment-icon mx-auto text-gray-400 mb-2" style="transform: scale(1.5);">
                                            <div class="comment-icon-bubble"></div>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">No comments yet. Be the first to comment!</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="bg-white rounded-xl shadow-card p-8 text-center fade-in">
                        <div class="comment-icon mx-auto text-gray-400 mb-4" style="transform: scale(2);">
                            <div class="comment-icon-bubble"></div>
                        </div>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No posts yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating your first post!</p>
                    </div>
                @endforelse
                
                {{-- Pagination --}}
                <div class="mt-6 fade-in">
                    {{ $posts->links() }}
                </div>
            </div>

            {{-- Form Create Post (Kanan) --}}
            <aside class="lg:col-span-1">
                <div class="sticky top-24 space-y-6">
                    <div class="bg-white rounded-xl shadow-card p-6 fade-in">
                        <div class="flex items-center mb-4">
                            <div class="h-8 w-8 rounded-full avatar-gradient flex items-center justify-center text-white font-bold mr-2">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Create Post</h3>
                        </div>
                        <p class="text-sm text-gray-500 mb-4">Share your thoughts with the community.</p>
                        <form action="{{ route('community.post.store') }}" method="POST">
                            @csrf
                            <textarea name="content" rows="4" 
                                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-custom-blue focus:border-custom-blue text-sm p-3 transition-colors" 
                                      placeholder="What's on your mind?"></textarea>
                            <button type="submit" 
                                    class="mt-4 w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-custom-blue hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-blue transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Post to Community
                            </button>
                        </form>
                    </div>
                    
                    {{-- Community Guidelines --}}
                    <div class="bg-white rounded-xl shadow-card p-6 fade-in">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Community Guidelines</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Be respectful and kind to all members</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Share relevant and helpful information</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Keep discussions constructive and positive</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>
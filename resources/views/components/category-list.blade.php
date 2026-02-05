@props(['categoryList', 'isChild' => false, 'level' => 0])

<div class="relative">
    <!-- Mobile toggle button - only for root level -->
    @if($level === 0)
    <button onclick="toggleMainMenu()" class="md:hidden bg-slate-800 text-white p-3 w-full text-left flex justify-between items-center">
        Categories
        <span id="mainMenuIcon">▼</span>
    </button>
    @endif

    <!-- Category list container -->
    <div id="{{ $isChild ? 'childMenu-'.$level : 'mainMenu' }}" 
         class="{{ $isChild ? 'child-menu' : 'main-menu' }} 
                {{ !$isChild && $level === 0 ? 'hidden md:flex' : '' }} 
                {{ $isChild ? 'hidden md:group-hover:flex' : '' }}
                bg-slate-700 text-white">
        @if (!empty($categoryList))
            <div class="{{ $isChild ? 'pl-4' : '' }} {{ $level === 0 ? 'flex flex-col md:flex-row' : '' }}">
                @foreach ($categoryList as $category)
                    <div class="category-item relative group" 
                         onmouseenter="handleHover(this, {{ !empty($category->children) ? 'true' : 'false' }})"
                         onmouseleave="handleLeave(this, {{ !empty($category->children) ? 'true' : 'false' }})">
                        <a href="{{ route('byCategory', $category->id) }}" 
                           class="block cursor-pointer py-3 px-6 hover:bg-black/10 transition flex justify-between items-center"
                           onclick="handleClick(event, {{ !empty($category->children) ? 'true' : 'false' }})">
                            {{ $category->name }}
                            @if(!empty($category->children))
                                <span class="arrow-icon transform transition-transform duration-200">›</span>
                            @endif
                        </a>
                        @if(!empty($category->children))
                            <x-category-list 
                                :categoryList="$category->children" 
                                :isChild="true"
                                :level="$level + 1"
                                class="absolute md:top-full left-0 z-50 bg-slate-700 w-full md:w-48 shadow-md" 
                            />
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-gray-400 py-4 px-6">
                No categories available
            </div>
        @endif
    </div>
</div>
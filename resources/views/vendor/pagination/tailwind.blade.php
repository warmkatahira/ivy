@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex justify-between">
            <!-- 前のページに移動する矢印リンク -->
            <!-- 現在が最初のページではなかったら生成 -->
            @if(!$paginator->onFirstPage())
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 hover:bg-lime-200" aria-label="{{ __('pagination.previous') }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @endif
            <!-- リンクを生成する開始と終了のページ番号を取得し、URLを生成 -->
            <?php 
                $start = $paginator->onFirstPage() ? 1 : ($paginator->currentPage() - 3 <= 1 ? 1 : $paginator->currentPage() - 3);
                $end = $paginator->onLastPage() ? $paginator->lastPage() : ($paginator->currentPage() + 3 >= $paginator->lastPage() ? $paginator->lastPage() : $paginator->currentPage() + 3);
                $paginate_info = $paginator->getUrlRange($start, $end);
            ?>
            <!-- ページ番号毎のリンクを生成 -->
            @foreach ($paginate_info as $page => $url)
                <!-- 現在のページである場合 -->
                @if ($page == $paginator->currentPage())
                    <span aria-current="page">
                        <span class="relative inline-flex items-center px-2 py-2 xl:px-4 -ml-px text-sm font-medium text-gray-500 bg-teal-200 border border-gray-300 cursor-default leading-5">{{ $page }}</span>
                    </span>
                @else
                    <a href="{{ $url }}" class="relative inline-flex items-center px-2 py-2 xl:px-4 -ml-px text-sm font-medium text-gray-700 border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 bg-white hover:bg-lime-200" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                        {{ $page }}
                    </a>
                @endif
            @endforeach
            <!-- 次のページに移動する矢印リンク -->
            <!-- 現在が最後のページではなかったら生成 -->
            @if(!$paginator->onLastPage())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 hover:bg-lime-200" aria-label="{{ __('pagination.next') }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @endif
        </div>
    </nav>
    <!-- 件数を表示 -->
    <div class="mt-3">
        <p class="text-sm text-gray-700 leading-5">
            @if ($paginator->firstItem())
                <span>{{ $paginator->total() }}件中</span>
                <span>{{ $paginator->firstItem() }}～</span>
                <span>{{ $paginator->lastItem() }}件目を表示</span>
            @else
                {{ $paginator->count() }}
            @endif
        </p>
    </div>
@else
    <span class="text-sm">全{{ $paginator->total() }}件</span>
@endif

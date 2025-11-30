<style>
    /* ===============================
       Aesthetic Pagination - Primary
    =============================== */

    .pagination-wrapper {
        display: flex;
        gap: 18px;
        align-items: center;
        justify-content: center;
        padding: 14px 0;
    }

    .pagination-pill {
        display: flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #eaf3ff, #d9e9ff);
        padding: 8px 18px;
        border-radius: 50px;
        box-shadow: 0 3px 10px rgba(0, 86, 179, 0.20);
    }

    .pagination-pill .page-link {
        border: none;
        background: transparent;
        padding: 8px 14px;
        border-radius: 10px;
        font-weight: 600;
        color: #0d6efd;
        transition: all 0.25s ease;
    }

    .pagination-pill .page-link:hover {
        background: #cfe2ff;
        color: #084298;
        box-shadow: 0 2px 6px rgba(0, 86, 179, 0.25);
    }

    .pagination-pill .active .page-link {
        background: #0d6efd;
        color: white;
        box-shadow: 0 3px 10px rgba(13, 110, 253, 0.4);
    }

    /* “Sebelumnya“ / “Selanjutnya“ buttons */
    .pagination-info-cakep {
        font-size: 0.9rem;
        background: #e7f0ff;
        padding: 8px 20px;
        border-radius: 30px;
        box-shadow: 0 2px 8px rgba(0, 86, 179, 0.2);
        font-weight: 500;
        color: #0d6efd;
        white-space: nowrap;
        transition: 0.25s;
    }

    .pagination-info-cakep:hover {
        background: #cfe2ff;
        color: #084298;
        box-shadow: 0 3px 10px rgba(0, 86, 179, 0.3);
        text-decoration: none;
    }

    .pagination-wrapper a {
        text-decoration: none !important;
    }

    .text-muted {
        opacity: .6;
    }
</style>

@if ($paginator->hasPages())
    <div class="pagination-wrapper">

        {{-- Button Previous --}}
        @if ($paginator->onFirstPage())
            <span class="pagination-info-cakep text-muted">← Sebelumnya</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pagination-info-cakep">← Sebelumnya</a>
        @endif

        {{-- Number Pagination (in pill) --}}
        <ul class="pagination pagination-pill mb-0">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>

        {{-- Button Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pagination-info-cakep">Selanjutnya →</a>
        @else
            <span class="pagination-info-cakep text-muted">Selanjutnya →</span>
        @endif

    </div>
@endif

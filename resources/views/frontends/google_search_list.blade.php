<style>
    .google-search-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding: 20px 0;
    }
    .google-result-item {
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: 0.3s;
    }
    .google-result-item:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    .google-result-item h3 {
        font-size: 18px;
        margin-bottom: 5px;
    }
    .google-result-item h3 a {
        color: #d9121f;
        text-decoration: none;
        font-weight: 600;
    }
    .google-result-item h3 a:hover {
        text-decoration: underline;
    }
    .google-result-item .link {
        color: #006621;
        font-size: 14px;
        margin-bottom: 5px;
        display: block;
        word-break: break-all;
    }
    .google-result-item .snippet {
        color: #555;
        font-size: 15px;
        line-height: 1.5;
    }
    .no-results {
        text-align: center;
        padding: 50px;
        color: #888;
        font-style: italic;
    }
</style>

<div class="google-search-container">
    @forelse($items as $item)
        <div class="google-result-item">
            <h3><a href="{{ $item['link'] }}" target="_blank">{{ $item['title'] }}</a></h3>
            <span class="link">{{ $item['displayLink'] }}</span>
            <p class="snippet">{!! $item['htmlSnippet'] !!}</p>
        </div>
    @empty
        <div class="no-results">
            No results found for your search.
        </div>
    @endforelse
</div>

<!-- Search form -->
<div class="row tm-row">
    <div class="col-12">
        <form method="GET" action="{{ route('index') }}" class="form-inline tm-mb-80 tm-search-form">
            <input class="form-control tm-search-input" name="query" type="text" placeholder="Search..." aria-label="Search" value="@if(isset($_GET['query'])) {{ $_GET['query'] }} @endif">
            <button class="tm-search-button" type="submit">
                <i class="fas fa-search tm-search-icon" aria-hidden="true"></i>
            </button>
        </form>
    </div>
</div>

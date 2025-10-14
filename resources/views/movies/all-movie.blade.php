@extends('layouts.app')

@section('content')
    <h3 class="category-title">Movies</h3>
    <div class="row card-movie-list" id="movie-list">
        @foreach ($movies as $movie)
            <div class="col-md-20 col-6">
                <a href="{{ route('movies.show', $movie->slug) }}">
                    <div class="mb-4 card">
                        <img src="{{ $movie->poster }}" class="card-image-movie-list" alt="...">
                        <span class="badge rounded-pill text-bg-dark badge-rating">
                            <img class="star-rating" src="assets/img/star-rating.png" alt="">
                            ({{ $movie->average_rating }})
                        </span>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    <div class="text-center">
        <button type="button" class="mb-4 btn btn-outline-success load-more" id="load-more" data-page="2">
            <i class="fa-solid fa-rotate-right rotate-right"></i>
            Lebih Banyak
        </button>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let loadMoreBtn = document.querySelector('#load-more');
            loadMoreBtn.addEventListener('click', function() {
                let page = loadMoreBtn.getAttribute('data-page');
                fetch(`/movies?page=${page}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        let movieList = document.querySelector('#movie-list');
                        movieList.insertAdjacentHTML('beforeend', data.html);
                        // Update page for next load
                        loadMoreBtn.setAttribute('data-page', parseInt(page) + 1);
                        // Hide button if no more pages
                        if (!data.next_page) {
                            loadMoreBtn.style.display = 'none';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
@endpush

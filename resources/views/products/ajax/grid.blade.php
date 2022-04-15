@foreach($products as $product)
    <div class="col">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $product->price }}</h6>
                <p class="card-text">{{ $product->description }}</p>
            </div>
            <div class="card-footer">
                <a href="#" class="card-link">Add to Cart</a>
                <a href="#" class="card-link">Detail</a>
            </div>
        </div>
    </div>
@endforeach
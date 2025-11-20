 <div style="width: 220px; min-height: 100vh; border-right: 1px solid #dee2e6; padding: 20px; position: sticky; top: 0;">
        <h6 class="fw-bold mb-4">Menu</h6>

        <ul class="list-unstyled">

            <li class="mb-3">
                <a href="{{ route('shop.index') }}" 
                   class="text-decoration-none d-block py-2 px-3 rounded 
                   {{ request()->is('shop*') ? 'bg-success text-white' : 'text-dark' }}">
                    🪵 Produk
                </a>
            </li>

            <li class="mb-3">
                <a href="{{ route('shop.services') }}" 
                   class="text-decoration-none d-block py-2 px-3 rounded 
                   {{ request()->is('service*') ? 'bg-success text-white' : 'text-dark' }}">
                    🔧 Service
                </a>
            </li>

        </ul>
    </div>

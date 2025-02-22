<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{ route('dashboard.index') }}" class="navbar-brand mx-4 mb-3">
            <img src="{{ asset('client/img/logo1.webp') }}" width="170" alt="">
        </a>
        <div class="navbar-nav w-100">
            <a href="{{ route('dashboard.index') }}"
                class="nav-item nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}"><i
                    class="fa fa-tachometer-alt"></i> Dashboard</a>
            <div class="nav-item dropdown">
                <a href="#"
                    class="nav-link dropdown-toggle {{ request()->routeIs('admin-category.index') || request()->routeIs('admin-category.create') || request()->routeIs('admin-category.edit') ? 'active' : '' }}"
                    data-bs-toggle="dropdown"><i class="fas fa-list-ul"></i> Danh mục</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('admin-category.index') }}"
                        class="dropdown-item {{ request()->routeIs('admin-category.index') ? 'active' : '' }}">Danh
                        sách</a>
                    <a href="{{ route('admin-category.create') }}"
                        class="dropdown-item {{ request()->routeIs('admin-category.create') ? 'active' : '' }}">Thêm
                        mới</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#"
                    class="nav-link dropdown-toggle {{ request()->routeIs('admin-brand.index') || request()->routeIs('admin-brand.create') || request()->routeIs('admin-brand.edit') ? 'active' : '' }}"
                    data-bs-toggle="dropdown"><i class="fas fa-tag"></i> Thương
                    hiệu</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('admin-brand.index') }}"
                        class="dropdown-item {{ request()->routeIs('admin-brand.index') ? 'active' : '' }}">Danh
                        sách</a>
                    <a href="{{ route('admin-brand.create') }}" class="dropdown-item {{ request()->routeIs('admin-brand.create') ? 'active' : '' }}">Thêm mới</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#"
                    class="nav-link dropdown-toggle {{ request()->routeIs('admin-product.index') || request()->routeIs('admin-product.create') || request()->routeIs('admin-product.detail') || request()->routeIs('admin-product.edit') ? 'active' : '' }}"
                    data-bs-toggle="dropdown"><i class="fas fa-box"></i></i> Sản
                    phẩm</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('admin-product.index') }}"
                        class="dropdown-item {{ request()->routeIs('admin-product.index') ? 'active' : '' }}">Danh
                        sách</a>
                    <a href="{{ route('admin-product.create') }}"
                        class="dropdown-item {{ request()->routeIs('admin-product.create') ? 'active' : '' }}">Thêm
                        mới</a>
                </div>
            </div>
            <a href="widget.html" class="nav-item nav-link"><i class="fas fa-receipt"></i> Đơn hàng</a>
            <a href="form.html" class="nav-item nav-link"><i class="fas fa-user"></i> Người dùng</a>
            <a href="table.html" class="nav-item nav-link"><i class="fas fa-comments"></i> Đánh giá</a>
        </div>
    </nav>
</div>
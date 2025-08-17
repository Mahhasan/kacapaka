<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{asset('admin/images/faces/face1.jpg')}}" alt="profile" />
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">David Grey. H</span>
                    <span class="text-secondary text-small">Project Manager</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
            <span class="menu-title">Dashboard</span>
            <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
<li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#user-management" aria-expanded="false" aria-controls="user-management">
        <span class="menu-title">User Management</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-account-group menu-icon"></i>
    </a>
    <div class="collapse" id="user-management">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.employees.index') }}">Employees</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.customers.index') }}">Customers</a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#catalog-management" aria-expanded="false" aria-controls="catalog-management">
        <span class="menu-title">Catalog Management</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-store menu-icon"></i>
    </a>
    <div class="collapse" id="catalog-management">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.products.index') }}">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.categories.index') }}">Categories</a>
            </li>
             <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.sub-categories.index') }}">Sub-Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.brands.index') }}">Brands</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.tags.index') }}">Tags</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.reviews.index') }}">Product Reviews</a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#inventory-management" aria-expanded="false" aria-controls="inventory-management">
        <span class="menu-title">Inventory & Sourcing</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-archive menu-icon"></i>
    </a>
    <div class="collapse" id="inventory-management">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.vendor.index') }}">Vendors</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.purchase-orders.index') }}">Purchase Orders</a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#sales-management" aria-expanded="false" aria-controls="sales-management">
        <span class="menu-title">Sales & Promotions</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-cart menu-icon"></i>
    </a>
    <div class="collapse" id="sales-management">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.orders.index') }}">Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.promotions.index') }}">Promotions</a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#finance-management" aria-expanded="false" aria-controls="finance-management">
        <span class="menu-title">Finance Management</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-currency-bdt menu-icon"></i>
    </a>
    <div class="collapse" id="finance-management">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.expense-categories.index') }}">Expense Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.expenses.index') }}">Expenses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.transactions.index') }}">Transactions</a>
            </li>
        </ul>
    </div>
</li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Catalog</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.categories.index') }}">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.sub-categories.index') }}">Sub-Categories</a>
                    </li>
                </ul>
            </div>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                <span class="menu-title">Icons</span>
                <i class="mdi mdi-contacts menu-icon"></i>
            </a>
            <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="pages/icons/font-awesome.html">Font Awesome</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#forms" aria-expanded="false" aria-controls="forms">
                <span class="menu-title">Forms</span>
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            </a>
            <div class="collapse" id="forms">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="pages/forms/basic_elements.html">Form Elements</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                <span class="menu-title">Charts</span>
                <i class="mdi mdi-chart-bar menu-icon"></i>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="pages/charts/chartjs.html">ChartJs</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <span class="menu-title">Tables</span>
                <i class="mdi mdi-table-large menu-icon"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="pages/tables/basic-table.html">Basic table</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <span class="menu-title">User Pages</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-lock menu-icon"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/samples/login.html"> Login </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/samples/register.html"> Register </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/samples/error-404.html"> 404 </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/samples/error-500.html"> 500 </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="docs/documentation.html" target="_blank">
                <span class="menu-title">Documentation</span>
                <i class="mdi mdi-file-document-box menu-icon"></i>
            </a>
        </li> -->
    </ul>
</nav>
